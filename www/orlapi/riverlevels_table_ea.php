<html>
<head>
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

#$sql = "select dat.data_pk, dat.value, cha.units, date_format(dat.insert_date, '%H:%i:%S') insert_time from data dat join channels cha on dat.channel_fk = cha.channel_pk where dat.insert_date > date_sub(now(), interval 1 hour) order by insert_date";
$sql = "select sit.sitename, sit.watercourse, lev.level, date_format(lev.read_dt, '%H:%i %e/%m/%Y') reading_time from ea_levels lev join ea_sites sit on sit.siteid = lev.siteid where sit.siteid='1238TH' order by sit.sitename, read_dt desc";
#$sql = "select sit.sitename, sit.watercourse, lev.level, date_format(lev.time, '%H:%i %e/%m/%Y') reading_time from levels lev join sites sit on sit.siteid = lev.siteid";
$result = mysql_query($sql,$con);
$num = mysql_num_rows($result);

echo "<table id=\"box-table-a\">";
echo "<thead><tr><th scope=\"col\">sitename</th><th scope=\"col\">watercourse</th><th scope=\"col\">level(m)</th><th scope=\"col\">read_datetime</th></tr></thead><tbody>";

$i=0;
while ($i < $num ) {
  $sitename =  mysql_result($result,$i, "sitename");
  $watercourse =  mysql_result($result,$i, "watercourse");
  $level =  mysql_result($result,$i, "level");
  $read_time =  mysql_result($result,$i, "reading_time");
#  $time_dep_sched =  mysql_result($result,$i, "time_dep_sched");
#  $time_dep_exptd =  mysql_result($result,$i, "time_dep_exptd");
#  $last_update =  mysql_result($result,$i, "retrieve_time");

  echo "<tr><td>$sitename</td><td>$watercourse</td><td>$level</td><td>$read_time</td></tr>";
  $i++;
}
echo "</tbody></table>";

echo "<small>Table derived from data obtained from <a href='http://flooddata.alphagov.co.uk/'>http://flooddata.alphagov.co.uk/</a><br>Last page refresh: " . date('Y-m-d H:i:s') . " </small>";

mysql_close($con);
?>
</body>
</html>

