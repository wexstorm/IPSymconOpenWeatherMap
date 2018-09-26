<?php

require_once __DIR__ . '/../libs/common.php';  // globale Funktionen

if (!defined('vtBoolean')) {
    define('vtBoolean', 0);
    define('vtInteger', 1);
    define('vtFloat', 2);
    define('vtString', 3);
    define('vtArray', 8);
    define('vtObject', 9);
}

class OpenWeatherData extends IPSModule
{
    use OpenWeatherMapCommon;

    public function Create()
    {
        parent::Create();

        $this->RegisterPropertyString('appid', '');
		$this->RegisterPropertyFloat('longitude', 0);
		$this->RegisterPropertyFloat('latitude', 0);

		$this->RegisterPropertyInteger('update_interval', 5);

        // $this->CreateVarProfile('OpenWeatherMap.Duration', vtInteger, ' sec', 0, 0, 0, 0, '');

		$this->RegisterTimer('UpdateData', 0, 'OpenWeatherData_UpdateData(' . $this->InstanceID . ');');

		$this->RegisterMessage(0, IPS_KERNELMESSAGE);
    }

    public function ApplyChanges()
    {
        parent::ApplyChanges();

        $vpos = 0;
        $this->MaintainVariable('LastMeasurement', $this->Translate('Timestamp of last measurement'), vtInteger, '~UnixTimestamp', $vpos++, true);

		$appid = $this->ReadPropertyString('appid');
		if ($appid == '') {
			$this->SetStatus(201);
		} else {
			$this->SetStatus(102);
		}

		$this->SetUpdateInterval();
    }

    public function GetConfigurationForm()
    {
        $formElements = [];
        $formElements[] = ['type' => 'Label', 'label' => 'OpenWeatherMap'];
        $formElements[] = ['type' => 'ValidationTextBox', 'name' => 'appid', 'caption' => 'API-Key'];
        $formElements[] = ['type' => 'Label', 'label' => 'Position (if not set, Location is used)'];
		$formElements[] = ['type' => 'NumberSpinner', 'digits' => 5, 'name' => 'longitude', 'caption' => 'Longitude'];
		$formElements[] = ['type' => 'NumberSpinner', 'digits' => 5, 'name' => 'latitude', 'caption' => 'Latitude'];

		$formElements[] = ['type' => 'Label', 'label' => 'Update data every X minutes'];
		$formElements[] = ['type' => 'IntervalBox', 'name' => 'update_interval', 'caption' => 'Minutes'];

        $formActions = [];
        $formActions[] = ['type' => 'Button', 'label' => 'Update data', 'onClick' => 'OpenWeatherData_UpdateData($id);'];
        $formActions[] = ['type' => 'Label', 'label' => '____________________________________________________________________________________________________'];
        $formActions[] = [
                            'type'    => 'Button',
                            'caption' => 'Module description',
                            'onClick' => 'echo "https://github.com/demel42/IPSymconOpenWeatherMap/blob/master/README.md";'
                        ];

        $formStatus = [];
        $formStatus[] = ['code' => '101', 'icon' => 'inactive', 'caption' => 'Instance getting created'];
        $formStatus[] = ['code' => '102', 'icon' => 'active', 'caption' => 'Instance is active'];
        $formStatus[] = ['code' => '104', 'icon' => 'inactive', 'caption' => 'Instance is inactive'];
        $formStatus[] = ['code' => '201', 'icon' => 'error', 'caption' => 'Instance is inactive (invalid configuration)'];
        $formStatus[] = ['code' => '202', 'icon' => 'error', 'caption' => 'Instance is inactive (server error)'];
        $formStatus[] = ['code' => '203', 'icon' => 'error', 'caption' => 'Instance is inactive (http error)'];
        $formStatus[] = ['code' => '204', 'icon' => 'error', 'caption' => 'Instance is inactive (invalid data)'];
        return json_encode(['elements' => $formElements, 'actions' => $formActions, 'status' => $formStatus]);
    }

	protected function SetUpdateInterval()
	{
		$min = $this->ReadPropertyInteger('update_interval');
		$msec = $min > 0 ? $min * 1000 * 60 : 0;
		$this->SetTimerInterval('UpdateData', $msec);
	}

	public function UpdateData()
	{
		$lat = $this->ReadPropertyFloat('latitude');
		$lng = $this->ReadPropertyFloat('longitude');
		if ($lat == 0 || $lng == 0) {
			$id = IPS_GetObjectIDByName('Location', 0);
			$loc = json_decode(IPS_GetProperty($id, 'Location'), true);
			$lat = $loc['latitude'];
			$lng = $loc['longitude'];
		}

		$args = [
				'lat'   => number_format($lat, 6, '.', ''),
				'lon'   => number_format($lng, 6, '.', ''),
				'units' => 'metric'
			];
		$jdata = $this->do_HttpRequest('data/2.5/weather', $args);
		$this->SendDebug(__FUNCTION__, 'jdata=' . print_r($jdata, true), 0);
		$weather = $jdata['weather'];
		$main = $jdata['main'];
		$visibility = $jdata['visibility'];
		$wind = $jdata['wind'];
		$rain = $jdata['rain'];
		// rain.3h Rain volume for the last 3 hours
		$snow = $jdata['snow'];
		// snow.3h Snow volume for the last 3 hours
		$clouds = $jdata['clouds'];
		$dt = $jdata['dt'];
		$this->SetValue('LastMeasurement', $dt);

/*
jdata=Array
(
    [weather] => Array
        (
            [0] => Array
                (
                    [id] => 800
                    [main] => Clear
                    [description] => clear sky
                    [icon] => 01n
                )

        )

    [main] => Array
        (
            [temp] => 11,73
            [pressure] => 1031
            [humidity] => 62
            [temp_min] => 10
            [temp_max] => 14
        )

    [visibility] => 10000
    [wind] => Array
        (
            [speed] => 3,6
            [deg] => 210
        )

    [clouds] => Array
        (
            [all] => 0
        )
)

*/

		$this->SetStatus(102);
	}

    private function do_HttpRequest($cmd, $args)
    {
        $appid = $this->ReadPropertyString('appid');

        $url = 'https://api.openweathermap.org/' . $cmd . '?appid=' . $appid;

        if ($args != '') {
            foreach ($args as $arg => $value) {
                $url .= '&' . $arg;
                if ($value != '') {
                    $url .= '=' . rawurlencode($value);
                }
            }
        }

        $this->SendDebug(__FUNCTION__, 'http-get: url=' . $url, 0);

        $time_start = microtime(true);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $cdata = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $duration = round(microtime(true) - $time_start, 2);
        $this->SendDebug(__FUNCTION__, ' => httpcode=' . $httpcode . ', duration=' . $duration . 's', 0);

        $statuscode = 0;
        $err = '';
        $jdata = '';
        if ($httpcode != 200) {
			if ($httpcode >= 500 && $httpcode <= 599) {
				$statuscode = 202;
				$err = "got http-code $httpcode (server error)";
			} else {
				$err = "got http-code $httpcode";
				$statuscode = 203;
			}
		} elseif ($cdata == '') {
            $statuscode = 204;
            $err = 'no data';
        } else {
            $jdata = json_decode($cdata, true);
            if ($jdata == '') {
                $statuscode = 204;
                $err = 'malformed response';
            }
        }

        if ($statuscode) {
            echo "url=$url => statuscode=$statuscode, err=$err";
            $this->SendDebug(__FUNCTION__, ' => statuscode=' . $statuscode . ', err=' . $err, 0);
            $this->SetStatus($statuscode);
        }

        return $jdata;
	}
}
