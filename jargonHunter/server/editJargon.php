<?php
header('Content-type: text/html; charset=utf-8');
ini_set('display_errors',1);
error_reporting(E_ALL);

require_once('php/db.php');
include_once('php/utils.php');

if (!$link) {
    die('Could not connect: ' . mysql_error());
}

global $limit, $offset, $totalRows, $thisTable, $thisPage;

//$thisTable = "jgnImport";
$thisTable = "jgnGeneric";
$limit = 200;

if (!isset($_GET['page']) or !is_numeric($_GET['page']))
{
   $offset = 0;
   $thisPage = 1;
   //print "fail";
}
else
{
   $thisPage = intval($_GET['page']);
   $offset = ($thisPage-1) * $limit;
}

//$offset = 5;

//print "<br>offset = $offset, limit = $limit";

$query = "SELECT COUNT(*) FROM `$thisTable`";
$result = mysql_query($query, $link);
list($totalRows) = mysql_fetch_row($result);
//echo "Total records is = ". $number; 

?>
<html>
<head>
   <link rel="stylesheet" href="css/jargon.css" type="text/css" />
   <script src="js/functions.js" type="text/javascript"></script>
</head>
<body>
<h2>Modify Data: <?php print "$thisTable" ?></h2>
<br>
<!-- Import CSV data:
<form action="upload_file.php" method="post" enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file"><br>
<input type="submit" name="submit" value="Submit">
</form>
-->
<!--
<input type='button' value='Test Ajax' onClick='doAjax()' >
<div id="testajax">ajax response</div>-->
<div class="pagination">
   <?php
      global $limit, $offset, $totalRows, $thisPage;
      global $navrow;
      $numPages = ceil($totalRows / $limit);
      $navrow =  buildPageRow($numPages,$thisPage,2,"editJargon.php",20);
      print "$navrow";
   ?>
</div>
<div class="dataTable">
   <br>
  <?php include 'php/printTable.php';	?>
	<br>
</div>
<div class="pagination">
   <?php
      print "$navrow";
   ?>
</div>
</body>
</html> 
