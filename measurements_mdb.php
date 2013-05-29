<?php
set_time_limit ( 0 );
ini_set('memory_limit','-1');
require 'config.php'; // db conf and sql queries
require 'functions.php'; // functions used in the script
require 'get_streets.php'; //loads array for filtering streets
header('Content-Type: application/json'); //for correct output in browsers
$street_filter=0; //set to 0 to disable filtering
//connection to DB
$connection = odbc_connect("Driver={Microsoft Access Driver (*.mdb)};Dbq=$mdbFilename", "", "");
/* check connection 
if ($connection)
    {
        print "Connection ok" ;
    }
else
    {
        print "Connection failed" ;
    }
*/
//load query defined in config.php
$sql=$sql_rilevamento_mdb;
//echo $sql.'<br>';
$result = odbc_exec (  $connection , $sql  );
//initialize geojson array
$features=array();
//cycle query results
while($row = odbc_fetch_array($result))

        {
        
        if ($street_filter) //Filter active
                {
                    foreach ($streets_provincia as $street)
                    {
                         $test=stristr($row['NomeTrattoStradale'],rtrim($street));
                         if (is_string($test)) //Street found in search list
                             {
                                add_feature_measurements($row,$features);
                             }
                    }
                }
            else
                {
                    add_feature_measurements($row,$features);
                }
        }

 //Final geojson array       
$feat_coll=array("type"=>"FeatureCollection",
"features"=>$features);
//Uncomment for browser output
echo indent(json_encode($feat_coll));
//Writes to file
$fp = fopen('measurements.json', 'w');
fwrite($fp, indent(json_encode($feat_coll)));
fclose($fp);
?>
