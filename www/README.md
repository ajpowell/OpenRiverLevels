www
===

Uses Leafletjs as a layer over OpenStreetMap
Extra Leafletjs plugins used to provide markers (awesome-markers) and clustering (markerclusters)
Additional js libraries added for awesome-markers (Bootstrap and Font-Awesome)
Uses Flight to provide RESTFul style API capability (under orlapi directory)

Todo
----

For index.htm

- Call to get sites - extend API to provide this i.e. orlapi/level/all/
- Initial load gets all data (so we can colour code the markers)
- clicks on markers dynamically get latest level via API call i.e. orlapi/level/<siteid>/latest/

Some ideas from OxFlood Google group:

- Look at river network layer from OS
- Precipitation layer
- Extend API to provide data for site for last n hours
