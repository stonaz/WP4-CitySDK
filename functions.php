<?PHP
/*
** Populates $features array with values taken from $row array
** Fields selected are specific for measurement geojson file
 */
function add_feature_measurements($row,&$features)
{
    
    $coordinates=get_coords($row['CoordinateTrattoStradale']) ;
    $features1=      array(
		    "type"=> "Feature",
		    "id"=> ($row['ID']*$row['Direzione']),
		    "properties"=>array(
				  "LOCATION"=> utf8_encode($row['NomeTrattoStradale']),
				  "TIMESTAMP"=> $row['DataOraRilevamento'],
				  "VELOCITY"=> intval($row['VelocitaRilevataChilometriOrari'])
				  
				      ),
		    "geometry"=>array(

				  "type"=> "LineString",
				  "coordinates"=> $coordinates
   
				    )
			      )             
    ;
 
    array_push($features,$features1);
}

/*
** Populates $features array with values taken from $row array
** Fields selected are specific for streets geojson file
 */
function add_feature_streets($row,&$features)
{
                        
    $coordinates=get_coords($row['CoordinateTrattoStradale']) ;
    $features1=      array(
		    "type"=> "Feature",
		    "id"=> ($row['ID']*$row['Direzione']),
		    "properties"=>array(
				  "LOCATION"=> utf8_encode($row['NomeTrattoStradale']),
				  
				      ),
		    "geometry"=>array(

				  "type"=> "LineString",
				  "coordinates"=> $coordinates
   
				    )
			      )             
    ;
 
    array_push($features,$features1);
}

/*
 **creates an array of coords from WKT coordinates
*/
function get_coords($coords) 
    {
    //$coords="MULTILINESTRING((12.5069103240967 41.875659942627,12.5056800842285 41.8761405944824))";
    $coords=substr($coords,17,strlen($coords)-19);
    $coords_array=explode(",",$coords);
    //print_r($coords_array);
    //echo $coords;
    $final_coords_array=array();
    foreach ($coords_array as $x)
        {
            //print    "$coords_couple<br>";
            $coords_couple=explode(" ",$x);
            $count=count($coords_couple);
            for ($i=0; $i <=($count -1); $i++)
                { 
 	
                    $coords_couple[$i]=floatval($coords_couple[$i]);
                    //echo $coords_couple[$i];
 		}
            array_push($final_coords_array, $coords_couple);
        }
    return($final_coords_array);
    }
    
    
/**
 * Indents a flat JSON string to make it more human-readable.
 *
 * @param string $json The original JSON string to process.
 *
 * @return string Indented version of the original JSON string.
 */
function indent($json) {

    $result      = '';
    $pos         = 0;
    $strLen      = strlen($json);
    $indentStr   = '  ';
    $newLine     = "\n";
    $prevChar    = '';
    $outOfQuotes = true;

    for ($i=0; $i<=$strLen; $i++) {

        // Grab the next character in the string.
        $char = substr($json, $i, 1);

        // Are we inside a quoted string?
        if ($char == '"' && $prevChar != '\\') {
            $outOfQuotes = !$outOfQuotes;
        
        // If this character is the end of an element, 
        // output a new line and indent the next line.
        } else if(($char == '}' || $char == ']') && $outOfQuotes) {
            $result .= $newLine;
            $pos --;
            for ($j=0; $j<$pos; $j++) {
                $result .= $indentStr;
            }
        }
        
        // Add the character to the result string.
        $result .= $char;

        // If the last character was the beginning of an element, 
        // output a new line and indent the next line.
        if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
            $result .= $newLine;
            if ($char == '{' || $char == '[') {
                $pos ++;
            }
            
            for ($j = 0; $j < $pos; $j++) {
                $result .= $indentStr;
            }
        }
        
        $prevChar = $char;
    }

    return $result;
}


?>