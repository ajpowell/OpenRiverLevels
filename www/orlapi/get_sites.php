<?php
// get_sites.php
//
// A simple php page to connect to a MySQL database and pull back
// json array of the water level measuring stations.
//
// The json array is manually built - the format of the output is:
//
// [{"id":"0","siteid":"0130TH","sitename":"Ewen","river":"Thames","lat":"51.6742760548","lon":"-1.9890079753","level":"0.424","excess":"0","read_time":"04:30 01/03/2014","status":"normal"},
//  {"id":"1","siteid":"0144TH","sitename":"Somerford Keynes","river":"Thames","lat":"51.6502637870","lon":"-1.9716671269","level":"1.033","excess":"0","read_time":"10:30 01/03/2014","status":"normal"}]
//
// Note the [] around the json output (required as processed as a json array by javascript)
//

// Pull in the include file, this holds the $database, $username, $password and $hostname details 
include '../../../orlapi.inc.php';

header("Content-Type:application/json"); // Set Content Type JSON

// Create connection to the database
$con = mysql_connect($hostname,$username,$password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

// Select the correct database (in case not default)
mysql_select_db($database);

// Create the SQL statement
$sql = "select rloi.wiski_river_name,
       rloi.location,
       lev.level,
       case
         when lev.level > norm_level_max then lev.level - norm_level_max
         else 0
       end excess,
       case
         when lev.level > norm_level_max * 1.3 then 'high'
         when lev.level >= norm_level_max then 'warning'
         else 'normal'
       end status,
       DATE_FORMAT(lev.read_dt,'%H:%i %d/%m/%Y') read_dt,
       sit.lat,
       sit.lon,
       sit.siteid
  from ea_rloi rloi
  join ea_levels lev on lev.siteid = rloi.telemetry_id
  join (select max(read_dt) read_dt, siteid
          from ea_levels
         group by siteid ) latest on latest.read_dt = lev.read_dt and latest.siteid = lev.siteid
  join ea_sites sit on sit.siteid = lev.siteid
 where sit.lat is not null;";

// Execute the SQL query against the database...
$result = mysql_query($sql,$con);
$num = mysql_num_rows($result);

echo "[";

$i=0;
while ($i < $num ) {
  $sitename =  mysql_result($result,$i, "location");
  $watercourse =  mysql_result($result,$i, "wiski_river_name");
  $level =  mysql_result($result,$i, "level");
  $read_time =  mysql_result($result,$i, "read_dt");
  $excess =  mysql_result($result,$i, "excess");
  $status =  mysql_result($result,$i, "status");
  $lat =  mysql_result($result,$i, "lat");
  $lon =  mysql_result($result,$i, "lon");
  $siteid =  mysql_result($result,$i, "siteid");
 
  if ($i>0) 
    echo ",";
 
  // Dump out the json data for each row
  echo "{\"id\":\"".$i.
       "\",\"siteid\":\"".$siteid.
       "\",\"sitename\":\"".$sitename.
       "\",\"river\":\"".$watercourse.
       "\",\"lat\":\"".$lat.
       "\",\"lon\":\"".$lon.
       "\",\"level\":\"".$level.
       "\",\"excess\":\"".$excess.
       "\",\"read_time\":\"".$read_time.
       "\",\"status\":\"".$status.
       "\"}";

  
  $i++;
}
echo "]";

// Close the DB connection
mysql_close($con);
?>

