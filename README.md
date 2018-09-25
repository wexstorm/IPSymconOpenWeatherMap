# IPSymconOpenWeatherMap

[![IPS-Version](https://img.shields.io/badge/Symcon_Version-5.0-red.svg)](https://www.symcon.de/service/dokumentation/entwicklerbereich/sdk-tools/sdk-php/)
![Module-Version](https://img.shields.io/badge/Modul_Version-1.0-blue.svg)
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

Übernahme von Daten aus OpenWeatherMap

## 2. Voraussetzungen

 - IP-Symcon ab Version 5

## 3. Installation

Die Konsole von IP-Symcon öffnen. Im Objektbaum unter Kerninstanzen die Instanz __*Modules*__ durch einen doppelten Mausklick öffnen.

In der _Modules_ Instanz rechts oben auf den Button __*Hinzufügen*__ drücken.

In dem sich öffnenden Fenster folgende URL hinzufügen:

`https://github.com/demel42/IPSymconOpenWeatherMap.git`

und mit _OK_ bestätigen.

Anschließend erscheint ein Eintrag für das Modul in der Liste der Instanz _Modules_

### Einrichtung in IPS

In IP-Symcon nun _Instanz hinzufügen_ (_CTRL+1_) auswählen unter der Kategorie, unter der man die Instanz hinzufügen will, und Hersteller _(sonstiges)_ und als Gerät _OpenWeatherMap_ auswählen.

## 4. Funktionsreferenz

### zentrale Funktion

`boolean OpenWeatherMap_xx(integer $InstanzID)`<br>

## 5. Konfiguration:

### Variablen

| Eigenschaft                          | Typ      | Standardwert    | Beschreibung |
| :----------------------------------: | :-----:  | :-------------: | :----------------------------------------------------------------------------------------------------------: |

#### Schaltflächen

| Bezeichnung                  | Beschreibung |
| :--------------------------: | :-------------------------------------------------: |

### Variablenprofile

Es werden folgende Variableprofile angelegt:
* Integer<br>
  - OpenWeatherMap.xxx

## 6. Anhang

GUIDs

- Modul: `{BCAEF996-FC2B-420D-A801-5C0B4A021225}`
- Instanzen:
  - OpenWeatherMap: `{8072158E-53BF-482A-B925-F4FBE522CEF2}`

## 7. Versions-Historie

- 1.0 @ 25.09.2018 17:35<br>
  Initiale Version
