<?php
function validateAndConvertInputDate($dString)
{
   $testDate = htmlentities($dString);
   if ($testDate == "")
   {
      //ERR2 = "Invalid characters in date"
      //die("ERR2");
      $ret = array(false, "ERR2");
   }
   elseif (strlen($testDate) != 8)
   {
      //ERR3 = "Date must be 8 characters, in the format YYYYMMDD"
      //die("ERR3");
      $ret = array(false, "ERR3");
   }
   else
   {
      $date = strtotime($testDate);
      
      if (!$date)
      {
         //ERR4 = "Error converting string to time"
         //die("ERR4");
         $ret = array(false, "ERR4");
      }
      else
      {
         $ret = substr($testDate,0,4) . "-" . substr($testDate,4,2) . "-" . substr($testDate,6,2) . " 12:00:00";
      }
   }
   
   return $ret;
}

function buildPageRow($pageCount, $currentPage, $flankers, $href, $maxButtons = 9)
{
   //calc now so we don't have to inside of strings
   $prev = $currentPage - 1 ;
   $next = $currentPage + 1;
   $lastPage = $pageCount;
   
   $result = "";
   
   //Previous button
   $result .= ($currentPage > 1) ? "<span class=\"previous\"><a href=\"$href?page=$prev\">Previous</a></span>" : "<span class=\"disabled\">Previous</span>";
   
   //less or equal to maxButtons, then just show em all
   if ($pageCount <= $maxButtons)
   {
      for ($i = 1; $i <= $pageCount; $i++)
      {
         $result .= ($i == $currentPage) ? "<span class=\"current\">$currentPage</span>"
                                         : "<a href=$href?page=$i>$i</a>";
      }
   }
   else //need to break up links
   {
      //early pages
      $n1 = $maxButtons - ($flankers*2) + 1;
      if ($currentPage < $n1)
      {
         //build first pages
         for ($i = 1; $i <= $n1; $i++)
         {
            $result .= ($i == $currentPage) ? "<span class=\"current\">$currentPage</span>"
                                            : "<a href=$href?page=$i>$i</a>";
            
         }
         
         //set the dots
         $result .= "<span class=\"dots\">...</span>";         
         
         //set last pages
         for ($i = ($flankers - 1); $i >= 0; $i--)
         {
            $pg = $pageCount - $i;
            $result .= "<a href=$href?page=$pg>$pg</a>";
         }
      }
      //middle pages
      elseif ($lastPage - ($flankers *2) - 1 >= $currentPage && $currentPage > (($flankers*2)+1))
      {
         //first x pages
         for ($i = 1; $i <= $flankers; $i++)
         {
            $result .= "<a href=$href?page=$i>$i</a>";
         }
         
         //dots
          $result .= "<span class=\"dots\">...</span>";   
          
         //middle set
         $n3 = $maxButtons - ($flankers*2) - 1;
         $n4 = ceil($n3 / 2); //find the middle button
         for ($i = ($n4-1); $i > 0; $i--)
         {
             $pg = $currentPage - $i ;
             $result .= "<a href=$href?page=$pg>$pg</a>";
         }
         
          $result .= "<span class=\"current\">$currentPage</span>";
          
         //for ($i = ($n4-1); $i > 0; $i--)
         for ($i = 1; $i < ($n4); $i++)
         {
            $pg = $currentPage + $i ;
             $result .= "<a href=$href?page=$pg>$pg</a>";
         }
          
          //$result .= "$$$";
                
         //end middle
         
         //dots
         $result .= "<span class=\"dots\">...</span>";   
         
         //last x pages 
         for ($i = $flankers-1; $i >= 0; $i--)
         {
            $pg = $pageCount - $i;
            $result .= ($currentPage == $pg) ? "<span class=\"current\">$currentPage</span>"
                                             : "<a href=$href?page=$pg>$pg</a>";
         }//for
      }//if
      //end pages
      else
      {
         //set first pages
         for ($i = 1; $i <= $flankers; $i++)
         {
            //$pg = $pageCount - $i;
            $result .= "<a href=$href?page=$i>$i</a>";
         } //for
         
         //set the dots
         $result .= "<span class=\"dots\">...</span>";         

         //build the end
         $n2 = $maxButtons - ($flankers * 2);
         for ($i = $n2; $i >=0; $i--)
         {
            $pg = $pageCount - $i;
            $result .= ($currentPage == $pg) ? "<span class=\"current\">$currentPage</span>"
                                             : "<a href=$href?page=$pg>$pg</a>";
            
         }//for
      }//if
   }//if
   
   
   
   //Next button
   $result .= ($currentPage != $pageCount) ? "<span class=\"next\"><a href=\"$href?page=$next\">Next</a></span>" 
                                           : "<span class=\"disabled\">Next</span>";
   
   return $result;
}

?>
