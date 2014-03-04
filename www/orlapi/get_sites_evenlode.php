<?php
// get_sites_evenlode.php
//
// A simple php page to connect to a MySQL database and pull back
// json array of the water level measuring stations.
//
// This version limited to stations on the Evenlode river in Oxfordshire for testing purposes.
//
// The json array is manually built - the format of the output is:
//
// [{"id":"0","siteid":"1208TH","sitename":"MORETON IN MARSH FLOODWARNING","ngr":"SP2084132313","lat":"51.9884476623","lon":"-1.6964676002"},
//  {"id":"1","siteid":"1210TH","sitename":"River Evenlode at Evenlode","ngr":"SP22102810","lat":"51.9505165857","lon":"-1.6784028614"}]
//
// Note the [] around the json output (required as processed as a json array
//

// Pull in the include file, this holds the $database, $username, $password and $hostname details 
include '../../orlapi.inc.php';

// Create connection to the database
$con = mysql_connect($hostname,$username,$password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

// Select the correct database (in case not default)
mysql_select_db($database);

// Create the SQL statement
$sql = "select * from ea_sites where siteid in ('1208TH','1210TH','1238TH','1290_w1TH');";

// Execute the SQL query against the database...
$result = mysql_query($sql,$con);
$num = mysql_num_rows($result);

// Set header to application/json
header("Content-Type:application/json"); // Set Content Type JSON

echo "["; 

$i=0;
while ($i < $num ) {
  $sitename =  mysql_result($result,$i, "sitename");
  $lat =  mysql_result($result,$i, "lat");
  $lon =  mysql_result($result,$i, "lon");
  $siteid =  mysql_result($result,$i, "siteid");
  $ngr =  mysql_result($result,$i, "ngr");

  if ($i>0) 
    echo ",";
 
  // Dump out the json data
  echo "{\"id\":\"".$i.
       "\",\"siteid\":\"".$siteid.
       "\",\"sitename\":\"".$sitename.
       "\",\"ngr\":\"".$ngr.
       "\",\"lat\":\"".$lat.
       "\",\"lon\":\"".$lon.
       "\"}";

  
  $i++;
}

echo "]";

// Close the DB connection
mysql_close($con);
?>

