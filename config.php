<?PHP
//MYSQL PARAMETERS

$host= 'localhost';
$user = 'root';
$pass = 'st3f4n0';
$dbname = 'gim1';
$mdbFilename = "c:\gim1.mdb";

$sql_strade="SELECT CASE strade.name
WHEN NULL
THEN 'Nessun nome'
WHEN ' '
THEN 'Nessun nome'
ELSE strade.name
END AS NomeTrattoStradale, strade.CoordinateOrdinateWKT AS CoordinateTrattoStradale,
idno as ID, sdir as Direzione
FROM strade " ;

$sql_rilevamento="SELECT CASE strade.name
WHEN NULL
THEN 'Nessun nome'
WHEN ' '
THEN 'Nessun nome'
ELSE strade.name
END AS NomeTrattoStradale,
strade.CoordinateOrdinateWKT AS CoordinateTrattoStradale,
ultimorilevamento.strt as ID,
ultimorilevamento.sdir AS Direzione,
date_format( ultimorilevamento.inst, '%d-%m-%Y %H:%i:%s' )  AS DataOraRilevamento,
ultimorilevamento.Sped AS VelocitaRilevataChilometriOrari,
ultimorilevamento.flow AS FlussoVeicoliPerOra,
strade.CoordinateOrdinateWKT as Coordinate
FROM ultimorilevamento INNER JOIN strade ON (ultimorilevamento.strt = strade.idno) AND (ultimorilevamento.sdir = strade.sdir)
WHERE (((ultimorilevamento.Sped) Is Not Null))
" ;
//ACCESS PARAMETERS
$mdbFilename = "c:\gim1.mdb";
$sql_rilevamento_mdb=
"SELECT TOP 10
IIf(IsNull(strade.name) Or strade.name='','[nessun nome]',strade.name) AS NomeTrattoStradale,
strade.CoordinateOrdinateWKT AS CoordinateTrattoStradale,
ultimorilevamento.strt as ID,
ultimorilevamento.sdir AS Direzione,
ultimorilevamento.inst AS DataOraRilevamento,
ultimorilevamento.Sped AS VelocitaRilevataChilometriOrari,
ultimorilevamento.flow AS FlussoVeicoliPerOra,
strade.CoordinateOrdinateWKT
FROM ultimorilevamento
INNER JOIN strade ON (ultimorilevamento.strt = strade.idno) AND (ultimorilevamento.sdir = strade.sdir)
WHERE (((ultimorilevamento.Sped) Is Not Null))
ORDER BY ultimorilevamento.inst DESC" ;

$sql_strade_mdb="SELECT TOP 10
strade.name AS NomeTrattoStradale,
strade.CoordinateOrdinateWKT AS CoordinateTrattoStradale,
idno as ID,
sdir as Direzione
FROM strade " ;
?>