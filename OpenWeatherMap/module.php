<?php

require_once __DIR__ . '/../libs/common.php';  // globale Funktionen

if (!defined('VARIABLETYPE_BOOLEAN')) {
    define('VARIABLETYPE_BOOLEAN', 0);
    define('VARIABLETYPE_INTEGER', 1);
    define('VARIABLETYPE_FLOAT', 2);
    define('VARIABLETYPE_STRING', 3);
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

        // $this->CreateVarProfile('OpenWeatherMap.Duration', VARIABLETYPE_INTEGER, ' sec', 0, 0, 0, 0, '');
    }

    public function ApplyChanges()
    {
        parent::ApplyChanges();

        $vpos = 0;
        $this->MaintainVariable('Timestamp', $this->Translate('Timestamp of last adjustment'), VARIABLETYPE_INTEGER, '~UnixTimestamp', $vpos++, true);

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
