<?php
mysql_connect("localhost","root","root");//database connection
mysql_select_db("buyingiq");


$result1 = mysql_query("SELECT * FROM cocon");
if (!$result1) { 
$message = 'Invalid query: ' . mysql_error() . "\n"; 
$message .= 'Whole query: ' . $query; 
die($message); 
}

$pid[]=array();
$sid[]=array();
$value[]=array();


while ($row = mysql_fetch_row($result1)) {
$pid[]=$row[1];
$sid[]=$row[2];
$value[]=$row[3];
}


$result = mysql_query("SELECT DISTINCT P_ID FROM cocon");
if (!$result) { 
$message = 'Invalid query: ' . mysql_error() . "\n"; 
$message .= 'Whole query: ' . $query; 
die($message); 
}

$num_pid=mysql_num_rows($result);
$U_PID[]=array();

while($row = mysql_fetch_array($result)){
$U_PID[]= $row[0];
}

for($i=1;$i<$num_pid;$i++)
{
  A=$U_PID[$i];
  $num = 0;
  $den1 = 0;
  $den2 = 0;
  for($j=$i+1;$j<=$num_pid;$j++)
  { 
      B = $U_PID[$j];
      
       $num = $num + (  *  ) ;
       $den1 = $den1 + ^ 2;
       $den2 = $den2 + ^ 2;
  }
  $sim=
}
         
  

/*for($i=1;$i<=$num;$i++)
{ echo "$U_PID[$i]<br>";
}*/

mysql_close();

?>