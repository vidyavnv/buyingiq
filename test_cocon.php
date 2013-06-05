<?php

// mark the start time
$start_time = MICROTIME(TRUE);
 

mysql_connect("localhost","root","root");//database connection


mysql_select_db("buyingiq");


$result = mysql_query("SELECT GROUP_CONCAT(a_prim_ref_id) FROM audits WHERE a_type='P' GROUP BY a_sid");
if (!$result) { 
$message = 'Invalid query: ' . mysql_error() . "\n"; 
$message .= 'Whole query: ' . $query; 
die($message); 
} 

while ($row = mysql_fetch_row($result)) {
         echo $row['Value']."<br>\n";
         echo implode(",", $row);
         echo "<br />";
         $pieces = explode(",", $row[0]);
   
         $total_results = count($pieces)-1;
         if($total_results>0)
         {
 	        for ($i=0; $i<$total_results; $i++)
 	        {   
 	          for ($j=$i+1; $j<=$total_results; $j++)
 	       		{
 	       		    mysql_query("INSERT INTO cocon (P_ID,S_ID,Val) VALUES('$pieces[$i]','$pieces[$j]',1)
                                 ON DUPLICATE KEY UPDATE Val=Val+1");
 	       		   if($pieces[$i]!=$pieces[$j])
 	       		   {
 	       		   mysql_query("INSERT INTO cocon (P_ID,S_ID,Val) VALUES('$pieces[$j]','$pieces[$i]',1)
                                 ON DUPLICATE KEY UPDATE Val=Val+1");
 	       		   }
            	}
            }
          }
}

mysql_free_result($result); 

// mark the stop time
$stop_time = MICROTIME(TRUE);
 
// get the difference in seconds
$time = $stop_time - $start_time;
 
PRINT "Elapsed time was $time seconds.";

?>

