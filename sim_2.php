<?php

ini_set('memory_limit', '64M');

ini_set('max_execution_time', 0);
$start_time = MICROTIME(TRUE);

mysql_connect("localhost","root","root");//database connection
mysql_select_db("buyingiq");


$result_AllValues = mysql_query("SELECT * FROM cocon");
if (!$result_AllValues) { 
$message = 'Invalid query: ' . mysql_error() . "\n"; 
$message .= 'Whole query: ' . $query; 
die($message); 
}

$pid[]=array();
$sid[]=array();
$value[]=array();

$num_entries = mysql_num_rows($result_AllValues);

while ($row = mysql_fetch_row($result_AllValues)) {
       $pid[]=$row[0];
       $sid[]=$row[1];
       $value[]=$row[2];
}


$result_distinct_PID = mysql_query("SELECT DISTINCT P_ID FROM cocon");
if (!$result_distinct_PID) { 
$message = 'Invalid query: ' . mysql_error() . "\n"; 
$message .= 'Whole query: ' . $query; 
die($message); 
}

$U_PID[]=array();

$num_pid=mysql_num_rows($result_distinct_PID);

while($row = mysql_fetch_array($result_distinct_PID)){
       $U_PID[]= $row[0];
}

for($i = 1;$i <= $num_pid;$i++)
{
   $A = $U_PID[$i];                       //Choose one vector and refer it as A
   $denominator_value_A = 0;
   for($pos_A = 1;$pid[$pos_A] != $A;$pos_A++);      //Calculating position of A in pid array
   for($s = $pos_A;$pid[$s] == $A;$s++)              //Calculating absolute value of A
   {
      $denominator_value_A = $denominator_value_A + pow($value[$s],2); 
   }
   $s=$s-1;
   $denominator_value_A_sqrt = pow($denominator_value_A,0.5);           //to calculate square root of vector A
  
   for($j = $i + 1;$j <= $num_pid;$j++)                  //Compare A with every B in pid array
   { 
      $numerator = 0;
      $denominator_value_B = 0;
      $B = $U_PID[$j];
      for($pos_B = 1;$pid[$pos_B] != $B;$pos_B++);                      //Calculating position of B in pid
      for($r=$pos_B;$pid[$r]==$B;$r++)                     //Calculating absolute value of B
      {
         $denominator_value_B = $denominator_value_B + pow($value[$r],2); 
      }
      $r=$r-1;
      $denominator_value_B_sqrt = pow($denominator_value_B,0.5);
      for($u = $pos_A,$v = $pos_B;$u <= $s && $v <= $r;$u++,$v++)     // r and s are the positions where vector A and B ends in pid array
      {
         if($sid[$u] == $sid[$v])
         {
              $numerator = $numerator + ($value[$u] * $value[$v]);
         }
         elseif($sid[$u] < $sid[$v])
         {
              $v = $v - 1;
         }
         elseif($sid[$u] > $sid[$v])
         {
              $u = $u - 1;
         }
      }
      $product_AB = $denominator_value_A_sqrt * $denominator_value_B_sqrt ;
      $final_sim = $numerator / $product_AB; 
      $key1 = $A.'_'.$B;			
	  $key2 = $B.'_'.$A;
			
      $data[$key1] = $final_sim;
	  $data[$key2] = $final_sim;			
				
   }
}

$insertionCount = 0;
$baseQuery = "INSERT INTO similarity_matrix VALUES ";
$queryParts = array();
$insertionCount = 0;
foreach ($data as $key => $Similarity) {
	list($primaryProductId, $secondaryProductId) = explode('_', $key);
	$queryParts[] = "($primaryProductId, $secondaryProductId, $Similarity)"; // This would work because all are integers
	$insertionCount++;
	
	if($insertionCount > 1000) {
		$query = $baseQuery.' '.implode(', ', $queryParts);
		$result = mysql_query($query);
		$queryParts = array();
		$insertionCount = 0;
	}	
}

$query = $baseQuery.' '.implode(', ', $queryParts);
mysql_query($query);

// mark the stop time
$stop_time = MICROTIME(TRUE);
 
// get the difference in seconds
$time = $stop_time - $start_time;
 
PRINT "Elapsed time was $time seconds.";

mysql_close();

?>