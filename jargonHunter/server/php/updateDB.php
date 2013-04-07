<?php
global $limit, $offset, $totalRows, $thisTable;
$thisTable = "jgnImport";

if (!$link) {
  require_once('db.php');
	if (!$link) 
	{
    die('Could not connect: ' . mysql_error());
   }
}

//print $_GET['method'];
$m = $_GET['method'];

if ($m == 'update')
{
   $offset = $_GET['pg'];
   $myIndex = rawurldecode($_GET['idx']);
   $newJI = rawurldecode($_GET['ji']);
   $newDF = rawurldecode($_GET['df']);
   $newDS = rawurldecode($_GET['ds']);
   $newCT = rawurldecode($_GET['ct']);
   $newSM = rawurldecode($_GET['sm']);
   $newCO = rawurldecode($_GET['co']);
   $newTY = rawurldecode($_GET['ty']);
      
   updateItem($offset, $myIndex, $newJI, $newDF, $newDS, $newCT, $newSM, $newCO, $newTY);
}
elseif ($m == "remove")
{
   $myPage = rawurldecode($_GET['pg']);
   $myIndex = rawurldecode($_GET['idx']);
   deleteItem($myIndex);
}

function deleteItem($myIndex)
{
   global $link, $thisTable;
   
   //Old method, deleted actual row
   //$query2 = "DELETE FROM `$thisTable` WHERE ID = $myIndex";
   //New method, just set 'Active' Col to 0
   $query2 = "UPDATE `$thisTable` SET Active = '0' WHERE ID = $myIndex";
   $result2 = mysql_query($query2, $link);
   
   if (!result2)
   {
       $message  = 'Invalid query: ' . mysql_error() . "\n";
       $message .= 'Whole query: ' . $query1;
       die($message);      
   }


   include 'printTable.php';
}

function updateItem($offset, $myIndex, $newJI, $newDF, $newDS, $newCT, $newSM, $newCO, $newTY)
{
   global $link, $thisTable;
   
   $query1 = "SELECT * FROM `$thisTable` WHERE ID = $myIndex";
   $result1 = mysql_query($query1, $link);
   
   if (!$result1) {
       $message  = 'Invalid query: ' . mysql_error() . "\n";
       $message .= 'Whole query: ' . $query1;
       die($message);
   }
   
   $newCols = array();
   $newVals = array();
   
   while ($row = mysql_fetch_assoc($result1))
   {
   //	print $row['ID'] . "<br>";
   //	print $row['JargonItem'] . " = " . $newJI . "<br>";
   //	print $row['Definition'] . " = " . $newDF . "<br>";
   //	print $row['Description'] . " = " . $newDS . "<br>";
   //	print $row['Category'] . " = " . $newCT . "<br>";
   //	print $row['Similiar'] . " = " . $newSM . "<br>";
   //	print $row['Company'] . " = " . $newCO . "<br>";
   //	print $row['Type'] . " = " . $newTY . "<br>";
   
   	//print $row['ID'];
   	if ($row['Definition'] != $newDF)
   	{
   		array_push($newCols, 'Definition');
   		array_push($newVals, $newDF);
   	}
   	if ($row['Description'] != $newDS)
   	{
   		array_push($newCols, 'Description');
   		array_push($newVals, $newDS);
   	}
   	if ($row['Category'] != $newCT)
   	{
   		array_push($newCols, 'Category');
   		array_push($newVals, $newCT);
   	}
   	if ($row['Similiar'] != $newSM)
   	{
   		array_push($newCols, 'Similiar');
   		array_push($newVals, $newSM);
   	}
   	if ($row['Company'] != $newCO)
   	{
   		array_push($newCols, 'Company');
   		array_push($newVals, $newCO);
   	}
   	if ($row['Type'] != $newTY)
   	{
   		array_push($newCols, 'Type');
   		array_push($newVals, $newTY);
   	}
   }
   
   $delta = sizeof($newCols);
   print "delta = " . $delta;
   if ($delta > 0)
   {
   	//UPDATE `djakata_jargon_hunter`.`jgnGeneric` SET `Description` = 'A day of the week (Sunday, Monday, etc.)', `Category` = 'Technical ' WHERE `jgnGeneric`.`ID` =2;
   	$query2 = "UPDATE $thisTable SET"; //"SELECT * FROM jgnGeneric WHERE ID = " . $myIndex;
   	
   	for ($i = 0; $i <= $delta - 1; $i++)
   	{
   		$query2 .= " " . $newCols[$i] . " = '" . mysql_real_escape_string($newVals[$i]) . "',";
   	}
   	
   	$query2 = rtrim($query2, ",");
   	$query2 .= " WHERE ID = " . $myIndex ;
   	
   	print "<br>" . $query2 . "<br>";
   	
   	$result2 = mysql_query($query2, $link);
   
   	if ($result2)
   	{
   		print "Update success";
   	}
   	else
   	{
   		print "Update failed "  . mysql_error();
   	}
   }
}			   	

?>
