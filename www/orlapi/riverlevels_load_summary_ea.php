<html>
<head>
<meta http-equiv="refresh" content="60">
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

$sql = "select date_format(read_dt, '%Y-%m-%d') date, count(1) count from ea_levels group by date_format(read_dt, '%Y-%m-%d') order by date_format(read_dt, '%Y-%m-%d') desc;";

$result = mysql_query($sql,$con);
$num = mysql_num_rows($result);

echo "<table id=\"box-table-a\">";
echo "<thead><tr><th scope=\"col\">date</th><th scope=\"col\">count</th></tr></thead><tbody>";


$i=0;
while ($i < $num ) {
  $date =  mysql_result($result,$i, "date");
  $count =  mysql_result($result,$i, "count");

  echo "<tr><td>$date</td><td>$count</td></tr>";
  $i++;
}
echo "</tbody></table>";

echo "<small>Table derived from data obtained from <a href='http://flooddata.alphagov.co.uk/'>http://flooddata.alphagov.co.uk/</a><br>Last page refresh: " . date('Y-m-d H:i:s') . " </small>";

mysql_close($con);
?>
</body>
</html>

