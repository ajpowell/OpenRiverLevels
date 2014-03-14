OpenRiverLevels
===============

This is a site that displays data downloaded from the UK Environment Agency website (http://flooddata.alphagov.co.uk/) - the data was made available during FloodHack held February 2014 (https://hackpad.com/UK-Flood-Help-February-2014-QFpKPE5Wy6s) - initial plans are that the data files will be made available until May 2014 and an API will be available shortly, though this site may need to be adapted once the API is defined.

Currently, this github repository contains only the website - but I will migrate the details for the MySQL database and the scripts that pull the data from the EA website and push that data into the DB.

The live version of this site can be found at http://apmf.co.uk/OpenRiverLevels/

I am making a simple API for this data, mainly to support the mapping page, but could be useful elsewhere - current API calls are:

## Latest level for a site:

```
/level/SITEID/latest
```

e.g.: http://apmf.co.uk/OpenRiverLevels/orlapi/level/1238TH/latest

This returns the latest data for siteid (telemetry_id) 1238TH - in this case my local site at Shipton-under-Wychwood as a json object:

```
{"siteid":"1238TH","level":"0.822","location":"Shipton Under Wychwood","read_dt":"04:30 14\/03\/2014"}
```

To find the siteid, click on the markers displayed on the OpenRiverLevels map at http://apmf.co.uk/OpenRiverLevels/
