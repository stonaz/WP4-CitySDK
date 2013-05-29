<?php
require 'simple_html_dom.php';
$file="provincia.htm";
$html = file_get_html($file);
$fp = fopen('strade_provincia.txt', 'w');
$search=array(" ", "/");

foreach($html->find('td b') as $element)
{
   
   $strada= $element->plaintext;
   $strada=str_replace($search,"",$strada);
   if ($strada <> "PortaleRoma" and $strada <> "PortaleTrasporti")
   {
      echo strtoupper($strada)."<br>";
      fwrite($fp, strtoupper($strada)."\n");
   }
}
fclose($fp);
?>