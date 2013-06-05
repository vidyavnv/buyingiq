<?php

mysql_connect("localhost","root","root");//database connection


mysql_select_db("buyingiq");


$result = mysql_query("SELECT GROUP_CONCAT(a_prim_ref_id) FROM audits WHERE a_type='P' GROUP BY a_sid");
if (!$result) { 
$message = 'Invalid query: ' . mysql_error() . "\n"; 
$message .= 'Whole query: ' . $query; 
die($message); 
} 

while ($row = mysql_fetch_row($result)) {
   // echo $row['Value']."<br>\n";
    echo implode(",", $row);
        echo "<br />";
$pieces = explode(",", $row[0]);
/*echo $pieces[0]; // piece1
    echo "<br />";
echo $pieces[1]; // piece2
    //echo "$row[0]";
    echo "<br />";    
*/
for ($i=0; $i<count($pieces); $i++) {
echo $pieces[$i];
echo "<br />";
$find_val1 = mysql_query("SELECT * FROM cocon WHERE cocon.P_ID={$pieces[$i]} AND cocon.S_ID={$pieces[$i]};"); 
           		if (mysql_num_rows($find_val1) == 0) 
           		{ 
           				          	$inserting_values1 = mysql_query("INSERT INTO cocon (P_ID,S_ID) VALUES('$pieces[0]','$pieces[0]')");

		   		}
		   		else
		   		{
		   				          	echo "hello";
		   				          	echo "<br />";


		   		}
}
}



mysql_free_result($result); 


?>