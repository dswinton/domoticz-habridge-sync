# domoticz-habridge-sync
Domoticz to HA-Bridge Device Sync

A simple PHP script to pull your favourites/dashboard devices from Domoticz and write them into the devices configuration file for ha-bridge.


Important notes:
* You should only run this script while ha-bridge is not running
* This will replace all current devices in ha-bridge.  If you're not sure you want this, back up first!


Dependencies:
* PHP (5)
* PHP JSON extensions


Ubuntu / Debian:
apt-get install php5-cli php5-json


Instructions:
1. Install dependencies
2. git clone https://github.com/dswinton/domoticz-habridge-sync.git
3. Edit the configuration lines at the top of sync.php
4. Stop ha-bridge
5. Run sync.php
6. Restart ha-bridge
7. Tell Alexa to re-discover devices
8. ...?
9. PROFIT!


