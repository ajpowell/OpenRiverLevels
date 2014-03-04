<html>
<head>
<meta http-equiv="refresh" content="600">
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="HandheldFriendly" content="True">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">
<style type="text/css">
<!--
@import url("style.css");
-->
</style>
</head>
<body>
<?php
$con = mysql_connect("localhost","apmfcouk_river1","12341qaz");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

// some code
mysql_select_db('apmfcouk_riverlevels');

$sql = "select sit.siteid, sit.regionid,  sit.sitename, sit.watercourse, sit.sitedatum,
       sit.norm_max, lev.level, (lev.level - sit.norm_max) excess, date_format(lev.read_dt, '%H:%i %e-%m-%Y') read_dt, lev.insert_dt 
  from sites sit 
  join (select max(id) id, siteid 
          from levels
         where HOUR(TIMEDIFF(NOW(), insert_dt)) <= 24
         group by siteid) latest_lev on latest_lev.siteid = sit.siteid
  join levels lev on lev.id = latest_lev.id
 where lev.level >= sit.norm_max
 order by (lev.level - sit.norm_max) desc, sit.sitename, lev.read_dt;";


$result = mysql_query($sql,$con);
$num = mysql_num_rows($result);

echo "<table id=\"box-table-a\">";
echo "<thead><tr><th scope=\"col\">sitename</th><th scope=\"col\">watercourse</th><th scope=\"col\">nom max (m)</th><th scope=\"col\">level (m)</th><th scope=\"col\">excess (m)</th><th scope=\"col\">read_datetime</th></tr></thead><tbody>";

$i=0;
while ($i < $num ) {
  $sitename =  mysql_result($result,$i, "sitename");
  $watercourse =  mysql_result($result,$i, "watercourse");
  $nom_max =  mysql_result($result,$i, "norm_max");
  $level =  mysql_result($result,$i, "level");
  $excess =  mysql_result($result,$i, "excess");
  $read_time =  mysql_result($result,$i, "read_dt");
#  $time_dep_sched =  mysql_result($result,$i, "time_dep_sched");
#  $time_dep_exptd =  mysql_result($result,$i, "time_dep_exptd");
#  $last_update =  mysql_result($result,$i, "retrieve_time");

  echo "<tr><td>$sitename</td><td>$watercourse</td><td>$nom_max</td><td>$level</td><td>$excess</td><td>$read_time</td></tr>";
  $i++;
}
echo "</tbody></table>";

echo "<small>Last refresh: " . date('Y-m-d H:i:s') . " </small>";

mysql_close($con);
?>
</body>
</html>

