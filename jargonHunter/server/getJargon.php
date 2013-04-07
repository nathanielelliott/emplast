<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

require_once('php/utils.php');
require_once('php/db.php');

if (!$link) {
    die('Could not connect: ' . mysql_error());
}

//expect param as YYYYMMDD
if (empty($_GET))
{
   //TODO: Change this to be current date OR just return all values....?
   $pDate = "20130101";
}
else
{
   $pDate = $_GET['date'];
}
   //$pDate = $_GET["date"];
   $checkDate = validateAndConvertInputDate($pDate);
   
   
   if (!is_string($checkDate))
   {
      die($checkDate[1]);
   }
   else
   {
      $query = "SELECT * FROM jgnGeneric WHERE ModifiedDate > '$checkDate' and Active = 1";
      $result = mysql_query($query, $link);

      $query2 = "SELECT ID FROM jgnGeneric WHERE ModifiedDate > '$checkDate' and Active = 0";
      $result2 = mysql_query($query2, $link);
      
      if (!$result or !$result2) { die(mysql_error()); }
      //$hasUpdate =  (mysql_num_rows($result) > 0) ? true : false;
      if (mysql_num_rows($result) > 0 or mysql_num_rows($result2) > 0)
      {
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
                 //DateModified
            	 
            	 $xml->startElement('jargonItem');
                 //$xml->writeAttribute('udid', $row['ID']);

                 $xml->startElement('udid');
                 $xml->writeCData($row['ID']);
                 $xml->endElement();
         
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
         
              $xml->startElement('modifiedDate');
              $xml->writeCData($row['ModifiedDate']);
              $xml->endElement();
             
            	 $xml->endElement();
            }
                
         
         
         
         $xml->startElement('deletedItems');

            while ($row2 = mysql_fetch_assoc($result2))
            {
               $xml->startElement('deletedItem');
               $xml->writeCData($row2['ID']);
               $xml->endElement();
            }         

         $xml->endElement();
         $xml->endElement();
         $xml->endDocument();
         header('Content-type: text/xml');
         //$xml->flush();
         
         mysql_close($link);
         
         echo $xml->outputMemory();
         //$myMD5 = $xml->outputMemory()
      }
   }


?>
