<?php
// uncomment to avoid script timeout 
set_time_limit ( 0 );
ini_set('memory_limit','-1');
require 'config.php'; // db conf and sql queries
require 'functions.php'; // functions used in the script
require 'get_streets.php'; //loads array for filtering streets
header('Content-Type: application/json'); //for correct output in browsers
$street_filter=0; //set to 0 to disable filtering
//connection to DB
$mysqli = new mysqli($host, $user, $pass, $dbname);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
//load query defined in config.php
$sql=$sql_rilevamento;
//echo $sql.'<br>';
$result = $mysqli->query($sql);
//initialize geojson array
$features=array();
//cycle query results
while($row = $result->fetch_array())

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
