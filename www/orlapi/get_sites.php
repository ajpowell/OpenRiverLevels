<?php
header("Content-Type:application/json"); // Set Content Type JSON

$con = mysql_connect("localhost","apmfcouk_river1","12341qaz");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

// some code
mysql_select_db('apmfcouk_riverlevels');

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
         when lev.level < norm_level_min then 'low'
         else 'normal'
       end status,
       case
         when lev.level > norm_level_max * 1.3 then 'Ol_icon_red_example.png'
         when lev.level >= norm_level_max then 'Ol_icon_amber_example.png'
         when lev.level < norm_level_max then 'Ol_icon_black_example.png'
         else 'Ol_icon_blue_example.png'
       end icon,
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
  $icon =  mysql_result($result,$i, "icon");
  $lat =  mysql_result($result,$i, "lat");
  $lon =  mysql_result($result,$i, "lon");
  $siteid =  mysql_result($result,$i, "siteid");

  #echo "<tr><td>$sitename</td><td>$watercourse</td><td>$level</td><td>$read_time</td></tr>";
  
  if ($i>0) 
    echo ",";
 
  echo "{\"id\":\"".$i.
       "\",\"siteid\":\"".$siteid.
       "\",\"sitename\":\"".$sitename.
       "\",\"river\":\"".$watercourse.
       "\",\"lat\":\"".$lat.
       "\",\"lon\":\"".$lon.
       "\"}";

  
  $i++;
}
echo "]";
#echo "</tbody></table>";

#echo "<small>Table derived from data obtained from <a href='http://flooddata.alphagov.co.uk/'>http://flooddata.alphagov.co.uk/</a><br>Last page refresh: " . date('Y-m-d H:i:s') . " </small>";

mysql_close($con);
?>

