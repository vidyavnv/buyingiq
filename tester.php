<?php

mysql_connect("localhost","root","root");//database connection


mysql_select_db("buyingiq");


$result = mysql_query("SELECT GROUP_CONCAT(S_ID ORDER BY S_ID) FROM test GROUP BY P_ID");
if (!$result) { 
$message = 'Invalid query: ' . mysql_error() . "\n"; 
$message .= 'Whole query: ' . $query; 
die($message); 
} 
while ($row = mysql_fetch_row($result)) {
         //echo $row[0]."<br>\n";
         echo implode(",", $row);
         echo "<br />";
         }
      /*   $pieces = explode(",", $row[0]);
         $total_results = count($pieces)-1;
         if($total_results>0)
         {
 	        for ($i=0; $i<$total_results; $i++)
 	        {   
 	        
              mysql_query("INSERT INTO cocon (P_ID,S_ID,Val) VALUES('$pieces[$i]','$pieces[$i]',1)
                           ON DUPLICATE KEY UPDATE Val=Val+1");
 	          for ($j=$i+1; $j<=$total_results; $j++)
         
         */
         mysql_free_result($result); 
         
?>