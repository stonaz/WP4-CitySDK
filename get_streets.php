<?PHP

$file='html_parser/strade_provincia.txt';
$streets1 = file($file);
$file2='html_parser/strade_provincia2.txt';
$streets2= file($file2);
$streets1_unique = array_unique($streets1);
$streets_provincia=array_merge($streets1_unique,$streets2);
//print_r($streets_provincia);
//echo "test";
?>