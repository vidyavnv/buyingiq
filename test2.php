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
         echo $row['Value']."<br>\n";
         echo implode(",", $row);
         echo "<br />";
         $pieces = explode(",", $row[0]);
   
         $total_results = count($pieces)-1;
         if($total_results>0)
         {
 	        for ($i=0; $i<$total_results; $i++)
 	        {
 	       		$find_val1 = mysql_query("SELECT * FROM cocon WHERE cocon.P_ID={$pieces[$i]} AND cocon.S_ID={$pieces[$i]};"); 
           		if (mysql_num_rows($find_val1) == 0) 
           		{ 
		          	$inserting_values1 = mysql_query("INSERT INTO cocon (P_ID,S_ID) VALUES('$pieces[$i]','$pieces[$i]')");
		          	$update_val1 = mysql_query("UPDATE cocon SET Val=Val+1 WHERE cocon.P_ID={$pieces[$i]} AND cocon.S_ID={$pieces[$i]};");
		   		}
		   		else
		   		{
		   		    $update_val1 = mysql_query("UPDATE cocon SET Val=Val+1 WHERE cocon.P_ID={$pieces[$i]} AND cocon.S_ID={$pieces[$i]};");
		   		}
 	        	for ($j=$i+1; $j<=$total_results; $j++)
 	       		{
 	       		    $find_val2 = mysql_query("SELECT * FROM cocon WHERE cocon.P_ID={$pieces[$i]} AND cocon.S_ID={$pieces[$j]};"); 
              		if (mysql_num_rows($find_val2) == 0) 
              		{ 
		          		$inserting_values2 = mysql_query("INSERT INTO cocon (P_ID,S_ID) VALUES('$pieces[$i]','$pieces[$j]')");
		          		$update_val2 = mysql_query("UPDATE cocon SET Val=Val+1 WHERE cocon.P_ID={$pieces[$i]} AND cocon.S_ID={$pieces[$j]};");
		      		}
		      		else
		      		{   
              		   
		      			   $update_val2 = mysql_query("UPDATE cocon SET Val=Val+1 WHERE cocon.P_ID={$pieces[$i]} AND cocon.S_ID={$pieces[$j]};");
                        
                    }
 	       		    $find_val3 = mysql_query("SELECT * FROM cocon WHERE cocon.P_ID={$pieces[$j]} AND cocon.S_ID={$pieces[$i]};"); 
              		if (mysql_num_rows($find_val3) == 0) 
              		{ 
		          		$inserting_values3 = mysql_query("INSERT INTO cocon (P_ID,S_ID) VALUES('$pieces[$j]','$pieces[$i]')");
		          		$update_val3 = mysql_query("UPDATE cocon SET Val=Val+1 WHERE cocon.P_ID={$pieces[$j]} AND cocon.S_ID={$pieces[$i]};");

		      		}
		      		else
		      		{
              		     if ($pieces[j]!=$pieces[i]) 
              		     { 
		      			   $update_val3 = mysql_query("UPDATE cocon SET Val=Val+1 WHERE cocon.P_ID={$pieces[$j]} AND cocon.S_ID={$pieces[$i]};");
		      		     }
		      		 }
 	       		    $find_val4 = mysql_query("SELECT * FROM cocon WHERE cocon.P_ID={$pieces[$j]} AND cocon.S_ID={$pieces[$j]};"); 
              		if (mysql_num_rows($find_val4) == 0) 
              		{ 
		          		$inserting_values4 = mysql_query("INSERT INTO cocon (P_ID,S_ID) VALUES('$pieces[$j]','$pieces[$j]')");
		          		$update_val4 = mysql_query("UPDATE cocon SET Val=Val+1 WHERE cocon.P_ID={$pieces[$j]} AND cocon.S_ID={$pieces[$j]};");
              		}
              		else
              		{
              		     if ($pieces[j]!=$pieces[j]) 
              		     { 
		          		    $update_val4 = mysql_query("UPDATE cocon SET Val=Val+1 WHERE cocon.P_ID={$pieces[$j]} AND cocon.S_ID={$pieces[$j]};");
              		     }
              		}
            	}
          }
          }
          else
          {
 	       		$find_val5 = mysql_query("SELECT * FROM cocon WHERE cocon.P_ID={$pieces[0]} AND cocon.S_ID={$pieces[0]};"); 
              	if (mysql_num_rows($find_val5) == 0) 
              		{ 
		          		$inserting_values5 = mysql_query("INSERT INTO cocon (P_ID,S_ID) VALUES('$pieces[0]','$pieces[0]')");
		          		$update_val5 = mysql_query("UPDATE cocon SET Val=Val+1 WHERE cocon.P_ID={$pieces[0]} AND cocon.S_ID={$pieces[0]};");

              		}
              	else
              	{
              	        $update_val5 = mysql_query("UPDATE cocon SET Val=Val+1 WHERE cocon.P_ID={$pieces[0]} AND cocon.S_ID={$pieces[0]};");
              	}
          }
          

  }



mysql_free_result($result); 


?>