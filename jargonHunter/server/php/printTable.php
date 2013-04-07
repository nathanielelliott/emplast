<?php
global $limit, $offset, $totalRows, $thisTable, $thisPage;
  	print "<table border=1 cellspacing='0' cellpadding='5'>";
		print "<tr>";
			print "<th>ID</th>";
			print "<th>Item</th>";
			print "<th>Definition</th>";
			print "<th>Description</th>";
			print "<th>Category</th>";
			print "<th>Similar</th>";
			print "<th>Company</th>";
			print "<th>Type</th>";
			print "<th>Edit</th>";
		print "</tr>";

      //$limit = 5;
      //$offset = 0;

		$query = "SELECT * FROM $thisTable WHERE Active = 1 ORDER BY ID LIMIT $offset, $limit";
		//print "$query";
		$result = mysql_query($query, $link);
		$r = 0;
		
	   while ($row = mysql_fetch_assoc($result))
	   {
	   	print "<tr id='row_" . $r . "'>";
			print "<td id='id_" . $r . "'>" . $row['ID'] . "</td>";
			print "<td id='ji_" . $r . "'>" . $row['JargonItem'] . "</td>";
			print "<td id='df_" . $r . "'>" . $row['Definition'] . "</td>";
			print "<td id='ds_" . $r . "'>" . $row['Description'] . "</td>";
			print "<td id='ct_" . $r . "'>" . $row['Category'] . "</td>";
			print "<td id='sm_" . $r . "'>" . $row['Similiar'] . "</td>";
			print "<td id='co_" . $r . "'>" . $row['Company'] . "</td>";
			print "<td id='ty_" . $r . "'>" . $row['Type'] . "</td>";
			print "<td>";
			print "<input type='button' value='Edit' onClick=doEdit(" . $r . "," . $thisPage . ")>";
			print "<input type='button' value ='Delete' onClick=doDelete(" . $r . "," . $thisPage . ")>";
			print "</td>";
	   	print "</tr>";
	   	
	   	$r++;
	  }
	print "</table>";


?>
