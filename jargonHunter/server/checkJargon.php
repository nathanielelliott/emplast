<?php

require_once('php/utils.php');

header('Content-type: text/html; charset=utf-8');
//expect param as YYYYMMDD which is last updated date

if (empty($_GET))
{
   //ERR1 - "No date given"
   die("ERR1");
   
}
else
{
   $checkDate = validateAndConvertInputDate($_GET['date']);
   
   if (!is_string($checkDate))
   {
      die($checkDate[1]);
   }
   else
   {
      require_once('php/db.php');
      $query = "SELECT * FROM jgnGeneric WHERE ModifiedDate > '$checkDate'";
      $result = mysql_query($query, $link);
      if (!$result) { die(mysql_error()); }
      //$hasUpdate =  (mysql_num_rows($result) > 0) ? true : false;
      $p =  (mysql_num_rows($result) > 0) ? "Yes" : "No";
      print $p;
      
   }
   
}

?>
