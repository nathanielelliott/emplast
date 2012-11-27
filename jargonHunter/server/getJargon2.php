<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

require_once('php/db.php');


if (!$link) 
{
    die('Could not connect: ' . mysql_error());
}
//echo 'Connected successfully';



$query = "SELECT * FROM jgnEmpTest1";
$result = mysql_query($query, $link);

$xml = new XMLWriter();
//$xml->openURI("php://output");
$xml->openMemory();

$xml->startDocument();
$xml->setIndent(true);

$xml->startElement('jargonItems');

   while ($row = mysql_fetch_assoc($result))
   {
   	 //echo $row[1];
   	 
		//ID
		//JargonItem
		//Definition
		//Description
		//Category
		//Similiar
		//Company
		//Type   	 
   	 
   	 $xml->startElement('jargonItem');
   	 $xml->writeAttribute('udid', $row['ID']);

   	 $xml->startElement('item');
   	 $xml->writeCData($row['JargonItem']);
   	 $xml->endElement();

   	 $xml->startElement('definition');
   	 $xml->writeCData($row['Definition']);
   	 $xml->endElement();

   	 $xml->startElement('description');
   	 $xml->writeCData($row['Description']);
   	 $xml->endElement();

   	 $xml->startElement('category');
   	 $xml->writeCData($row['Category']);
   	 $xml->endElement();

   	 $xml->startElement('similiar');
   	 $xml->writeCData($row['Similiar']);
   	 $xml->endElement();

   	 $xml->startElement('company');
   	 $xml->writeCData($row['Company']);
   	 $xml->endElement();

   	 $xml->startElement('type');
   	 $xml->writeCData($row['Type']);
   	 $xml->endElement();


   	 $xml->endElement();
   }

$xml->endElement();
$xml->endDocument();
header('Content-type: text/xml');
//$xml->flush();

mysql_close($link);

echo $xml->outputMemory();
//$myMD5 = $xml->outputMemory()


?>