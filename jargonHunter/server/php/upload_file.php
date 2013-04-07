<?php
ini_set('auto_detect_line_endings', 1);

if ($_FILES["file"]["error"] > 0)
{
    echo "Error: " . $_FILES["file"]["error"] . "<br>";
}
else
{
    //echo "print bitch";
    //echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    //echo "Type: " . $_FILES["file"]["type"] . "<br>";
    //echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    //echo "Stored in: " . $_FILES["file"]["tmp_name"];
  
    //$ext = strtolower(end(explode('.', $_FILES["file"]['name'])));
    
    echo "Ping";
    
    //Only process CSV files
    if($_FILES["file"]["type"] === 'text/csv')
    {        
        $csv = array();
        $tmpName = $_FILES["file"]["tmp_name"];
        
        if(($handle = fopen($tmpName, 'r')) !== FALSE) {
            // necessary if a large csv file
            set_time_limit(0);

            $row = 0;
            $n = 0;
            echo "<table border='1'>\n";
            
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
            {
                echo "<tr>\n";
                $num = count($data);
                //echo "<p> $num fields in line $row: <br /></p>\n";
                $row++;
                echo "<td>" . ++$n . "<td />\n";
                for ($c=0; $c <= $num; $c++) 
                {
                    
                    echo "<td>" . $data[$c] . "<td />\n";
                }
                echo "</tr>\n";
            }
            
            echo "</table>\n";
            
            fclose($handle);
        }
        else
        {
            //echo "Error 1";
        }
    }
    else
    {
        //echo "Error 2";
    }

}
?>
