<?php

require './flight/Flight.php';

Flight::route('/', function(){
    echo '<h2>Flight</h2><br>hello world!';
});

Flight::route('/too', function(){
    echo '<h2>Flight</h2><br>hello world too!';
});

Flight::route('/level/@siteid/latest', function($siteid){
    // Pull in the include file, this holds the $database, $username, $password and $hostname details 
    include '../../../orlapi.inc.php';
    
    if (!$link = mysql_connect($hostname,$username,$password)) {
      echo 'Could not connect to mysql';
      exit;
    }

    if (!mysql_select_db($database, $link)) {
        echo 'Could not select database';
        exit;
    }

    $sql    = 'SELECT sitename, level, date_format(lev.read_dt, \'%H:%i %e/%m/%Y\') last_read FROM levels lev join sites sit on sit.siteid = lev.siteid WHERE lev.siteid = "' . $siteid . '" order by read_dt desc limit 1;';
    $result = mysql_query($sql, $link);

    if (!$result) {
        echo "DB Error, could not query the database\n";
        echo 'MySQL Error: ' . mysql_error();
        exit;
    }

    while ($row = mysql_fetch_assoc($result)) {
        #echo $row['level'];
        return Flight::json(array('siteid' => $siteid,
                                  'level' => $row['level'],
                                  'sitename' => $row['sitename'],
                                  'read_dt' => $row['last_read']));
    }

    mysql_free_result($result);
});

Flight::route('/template', function(){
    #echo '<h2>Flight</h2><br>hello world too!';

    Flight::view()->set('name', 'Bob');

    Flight::render('templatetest');
});

Flight::route('/json/', function(){
    return Flight::json(array('siteid' => 7051,
                              'sitename' => 'Shipton',
                              'watercourse' => 'Evenlode',
                              'level' => 1.42));
});

# Catch anything not matched...
Flight::route('*', function($route){
    echo '<h1>Flight</h1><br><h2>404 Error - ' . $_SERVER['REQUEST_URI'] . ' - Page not found</h2>';
});


Flight::start();
?>
