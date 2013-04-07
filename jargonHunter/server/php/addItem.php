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


?>
<html>
<head>
   <link rel="stylesheet" href="../css/jargon.css" type="text/css" />
   <script src="js/functions.js" type="text/javascript"></script>
</head>
<body>
<h2>Add Item to: <?php print "$thisTable" ?></h2>
<br>
	<table border=1 cellspacing='0' cellpadding='5'>
		<tr>
	   	<th>ID</th>
		   <th>Item</th>
		   <th>Definition</th>
		   <th>Description</th>
		   <th>Category</th>
         <th>Similar</th>
		   <th>Company</th>
		   <th>Type</th>
		</tr>
		<tr>
		   <td>0000</td>
		   <td><input type="text" id="newItem"></td>
		   <td><input type="text" id="newDef"></td>
		   <td><input type="text" id="newDesc"></td>
		   <td><input type="text" id="newCat"></td>
		   <td><input type="text" id="newSim"></td>
		   <td><input type="text" id="newCo"></td>
		   <td><input type="text" id="newType"></td>
		</td>
   </table>
   <form>
      <input type="button" value="Submit" onClick=doAddItem()>
      <input type="button" value="Cancel" onClick=doCancelAdd()>
</body>
</html> 
