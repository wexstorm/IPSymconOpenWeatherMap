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

if (!defined('otCategory')) {
    define('otCategory', 0);
    define('otInstance', 1);
    define('otVariable', 2);
    define('otScript', 3);
    define('otEvent', 4);
    define('otMedia', 5);
    define('otLink', 6);
}

class OpenWeatherMap extends IPSModule
{
    use OpenWeatherMapCommon;

    public function Create()
    {
        parent::Create();

        $this->RegisterPropertyString('api', '');
        $this->RegisterPropertyString('lng', '');
        $this->RegisterPropertyString('lat', '');

        // $this->CreateVarProfile('OpenWeatherMap.Duration', vtInteger, ' sec', 0, 0, 0, 0, '');
    }

    public function ApplyChanges()
    {
        parent::ApplyChanges();

        $vpos = 0;
        $this->MaintainVariable('Timestamp', $this->Translate('Timestamp of last adjustment'), vtInteger, '~UnixTimestamp', $vpos++, true);

        $this->SetStatus(102);
    }

    public function GetConfigurationForm()
    {
        $formElements = [];
        $formElements[] = ['type' => 'Label', 'label' => 'OpenWeatherMap'];
        $formElements[] = ['type' => 'ValidationTextBox', 'name' => 'api', 'caption' => 'API-Key'];

        $formActions = [];
        $formActions[] = ['type' => 'Button', 'label' => 'Update data', 'onClick' => 'OpenWeatherMap_UpdateData($id);'];
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
        $formStatus[] = ['code' => '201', 'icon' => 'inactive (invalid configuration)', 'caption' => 'Instance is inactive (invalid configuration)'];

        return json_encode(['elements' => $formElements, 'actions' => $formActions, 'status' => $formStatus]);
    }

    public function UpdateData()
    {
    }

}
