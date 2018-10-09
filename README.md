# IPSymconOpenWeatherMap

[![IPS-Version](https://img.shields.io/badge/Symcon_Version-5.0-red.svg)](https://www.symcon.de/service/dokumentation/entwicklerbereich/sdk-tools/sdk-php/)
![Module-Version](https://img.shields.io/badge/Modul_Version-1.3-blue.svg)
![Code](https://img.shields.io/badge/Code-PHP-blue.svg)
[![License](https://img.shields.io/badge/License-CC%20BY--NC--SA%204.0-green.svg)](https://creativecommons.org/licenses/by-nc-sa/4.0/)
[![StyleCI](https://github.styleci.io/repos/126683101/shield?branch=master)](https://github.styleci.io/repos/146979798)

## Dokumentation

**Inhaltsverzeichnis**

1. [Funktionsumfang](#1-funktionsumfang)
2. [Voraussetzungen](#2-voraussetzungen)
3. [Installation](#3-installation)
4. [Funktionsreferenz](#4-funktionsreferenz)
5. [Konfiguration](#5-konfiguration)
6. [Anhang](#6-anhang)
7. [Versions-Historie](#7-versions-historie)

## 1. Funktionsumfang

_OpenWeatherMap_ (https://openweathermap.org) ist eine Web-Seite, die Wetterdaten bereit stellt. Es gibt eine API, die sowohl einen kostenlosen Zugriff erlaubt als auch komerzielle Angebote beinhaltet.

Das Modul behandelt nur die kostenlosen Zugriffe:
- aktuellen Daten (_Current weather data_)
- stündlichen Vorhersagen (_5 day / 3 hour forecast_)

In Vorbereitung ist die Möglichkeit, die Daten einer eigenen Wetterstation _OpenWeatherMap_ zur Verfügung zu stellen.

## 2. Voraussetzungen

 - IP-Symcon ab Version 5

## 3. Installation

Die Konsole von IP-Symcon öffnen. Im Objektbaum unter Kerninstanzen die Instanz __*Modules*__ durch einen doppelten Mausklick öffnen.

In der _Modules_ Instanz rechts oben auf den Button __*Hinzufügen*__ drücken.

In dem sich öffnenden Fenster folgende URL hinzufügen:

`https://github.com/demel42/IPSymconOpenWeatherMap.git`

und mit _OK_ bestätigen.

Anschließend erscheint ein Eintrag für das Modul in der Liste der Instanz _Modules_

### Anmeldung bei __OpenWeatherMap_
oEs muss ein Account erstellt werden (_https://home.openweathermap.org/users/sign_up_). Nach Anmeldung kann man in dem Punkt _API keys_ einen API erzeugen bzw. diese verwalten.

### Einrichtung in IPS

In IP-Symcon nun _Instanz hinzufügen_ (_CTRL+1_) auswählen unter der Kategorie, unter der man die Instanz hinzufügen will, und Hersteller _(sonstiges)_ und als Gerät _OpenWeatherData_ auswählen.

## 4. Funktionsreferenz

### zentrale Funktion

`OpenWeatherData_UpdateData(int $InstanzID)`

ruft die Daten von _OpenWeatherMap_ ab. Wird automatisch zyklisch durch die Instanz durchgeführt im Abstand wie in der Konfiguration angegeben.

### Hilfsfunktionen

`float OpenWeatherData_CalcAbsoluteHumidity(int $InstanzID, float $Temperatur, float $Humidity)`

berechnet aus der Temperatur (in °C) und der relativen Luftfeuchtigkeit (in %) die absulte Feuchte (in g/m³)


`float OpenWeatherData_CalcAbsolutePressure(int $InstanzID, float $Pressure, $Temperatur, int $Altitude)`

berechnet aus dem relativen Luftdruck (in mbar) und der Temperatur (in °C) und Höhe (in m) der absoluten Luftdruck (in mbar)
ist die Höhe nicht angegeben, wird die Höhe der Netatmo-Wettersttaion verwendet


`float OpenWeatherData_CalcDewpoint(int $InstanzID, float $Temperatur, float $Humidity)`

berechnet aus der Temperatur (in °C) und der relativen Luftfeuchtigkeit (in %) den Taupunkt (in °C)


`float OpenWeatherData_CalcHeatindex(int $InstanzID, float $Temperatur, float $Humidity)`

berechnet aus der Temperatur (in °C) und der relativen Luftfeuchtigkeit (in %) den Hitzeindex (in °C)


`float OpenWeatherData_CalcWindchill(int $InstanzID, float $Temperatur, float $WindSpeed)`

berechnet aus der Temperatur (in °C) und der Windgeschwindigkeit (in km/h) den Windchill (Windkühle) (in °C)


`string OpenWeatherData_ConvertWindDirection2Text(int $InstanzID, int $WindDirection)`

ermittelt aus der Windrichtung (in °) die korespondierende Bezeichnung auf der Windrose


`int OpenWeatherData_ConvertWindSpeed2Strength(int $InstanzID, float $WindSpeed)`

berechnet aus der Windgeschwindigkeit (in km/h) die Windstärke (in bft)


`string OpenWeatherData_ConvertWindStrength2Text(int $InstanzID, int $WindStrength)`

ermittelt aus der Windstärke (in bft) die korespondierende Bezeichnung gemäß Beaufortskala


## 5. Konfiguration:

### Variablen

| Eigenschaft               | Typ     | Standardwert | Beschreibung                               |
| :-----------------------: | :-----: | :----------: | :----------------------------------------: |
| appid                     | string  |              | API-Schlüssel von _OpenWeatherMap_         |
|                           |         |              |                                            |
| longitude                 | float   |              | Längengrad der Station                     |
| latitude                  | float   |              | Breitengrad der Station                    |
| altitude                  | float   |              | Höhe der Station über dem Meeresspiegel in Metern |
|                           |         |              |                                            |
| lang                      | string  |              | Spracheinstellung für textuelle Angaben    |
|                           |         |              |                                            |
| with_absolute_humidity    | boolean | false        | absolute Luftfeuchtigkeit                  |
| with_absolute_pressure    | boolean | false        | absoluter Luftdruck                        |
| with_dewpoint             | boolean | false        | Taupunkt                                   |
| with_heatindex            | boolean | false        | Hitzeindex                                 |
| with_windchill            | boolean | false        | Windchill (Windkühle)                      |
| with_windstrength         | boolean | false        | Windstärke                                 |
| with_windstrength2text    | boolean | false        | Windstärke                                 |
| with_windangle            | boolean | true         | Windrichtung in Grad                       |
| with_cloudiness           | boolean | false        | Bewölkung                                  |
| with_conditions           | boolean | false        | Wetterbedingungen                          |
| with_icons                | boolean | false        | Wetterbedingung-Symbole                    |
|                           |         |              |                                            |
| with_summary              | boolean | false        | HTML-Box mit einer Zusammenfassung         |
| summary_script            | integer | 0            | ID eines Scriptes zur alternative Erstellung der HTML-Box |
|                           |         |              |                                            |
| hourly_forecast_count     | integer | 0            | Anzahl der Vorhersagen (max. 5 Tage alle 3 Stunden) |
|                           |         |              |                                            |
| update_interval           | integer | 60           | Aktualisierungsintervall in Minuten        |

Wenn _longitude_ und _latitude_ auf **0** stehen, werden die Daten aus dem Modul _Location_ verwendet. Die Angabe von _altitude_ ist nur erforderlich zur Berechnung des absoluten Luftdrucks.

Die unterstützen Spracheinstellung finden sich in der API-Dokumentatin unter der Überschrift _Multilingual support_ und sind z.B. (_de_, _en_, _fr_ ...).


Erläuterung zu _summary_script_:
mit diesem Scripten kann man eine alternative Darstellung realisieren.

Ein passendes Code-Fragment für ein Script:

```
$instID = $_IPS['InstanceID'];

$temperatur = OpenWeatherData_GetData($instID, 'Temperature');

$html = 'Temperatur: ' . $temperatur . ' °C<br>';

echo $html;

```


#### Schaltflächen

| Bezeichnung                  | Beschreibung |
| :--------------------------: | :-------------------------------------------------: |
| Aktualiseren                 | Wetterdaten aktualisieren |

### Variablenprofile

Es werden folgende Variableprofile angelegt:
* Integer<br>
OpenWeatherMap.WindStrength, OpenWeatherMap.WindAngle

* Float<br>
OpenWeatherMap.Temperatur, OpenWeatherMap.Humidity, OpenWeatherMap.absHumidity, OpenWeatherMap.Dewpoint, OpenWeatherMap.Heatindex, OpenWeatherMap.Pressure, OpenWeatherMap.WindSpeed, OpenWeatherMap.Rainfall, OpenWeatherMap.Snowfall, OpenWeatherMap.Cloudiness

* String<br>
OpenWeatherMap.WindDirection

## 6. Anhang

GUIDs

- Modul: `{BCAEF996-FC2B-420D-A801-5C0B4A021225}`
- Instanzen:
  - OpenWeatherData: `{8072158E-53BF-482A-B925-F4FBE522CEF2}`

Verweise:
- https://openweathermap.org/api


## 7. Versions-Historie

- 1.3 @ 09.10.2018 17:38<br>
  - optische Aufbereitung der Wetterinformationen

- 1.2 @ 08.10.2018 22:21<br>
  - Korrektur des Zugriffs auf _Location_

- 1.1 @ 07.10.2018 10:27<br>
  - Sprache der texuellen Informationen per Konfigurationsdialog einstellbar
  - Angabe der Einheiten bestimmer Felder im Konfigurationsdialog

- 1.0 @ 25.09.2018 17:35<br>
  Initiale Version
