<?php

ini_set('max_execution_time', 0);
$start_time = MICROTIME(TRUE);

mysql_connect("localhost","root","root");//database connection
mysql_select_db("buyingiq");


$result = mysql_query("SELECT * FROM test");
if (!$result) { 
$message = 'Invalid query: ' . mysql_error() . "\n"; 
$message .= 'Whole query: ' . $query; 
die($message); 
}

$pid[]=array();
$sid[]=array();
$value[]=array();


while ($row = mysql_fetch_row($result)) {
$pid[]=$row[0];
$sid[]=$row[1];
$value[]=$row[2];
}

$num = mysql_num_rows($result);

$result1 = mysql_query("SELECT DISTINCT P_ID FROM test");
if (!$result1) { 
$message = 'Invalid query: ' . mysql_error() . "\n"; 
$message .= 'Whole query: ' . $query; 
die($message); 
}

$num_pid=mysql_num_rows($result1);
$U_PID[]=array();

while($row = mysql_fetch_array($result1)){
$U_PID[]= $row[0];
}

for($i=1;$i<=$num_pid;$i++)
{
$A=$U_PID[$i];
//echo "<br>$A<br>";
$den1 = 0;
for($k=1;$pid[$k]!=$A;$k++);
//echo "$k<br>";
for($s=$k;$pid[$s]==$A;$s++) {
$den1 = $den1 + pow($value[$s],2); 
}
//    echo "$s";
//echo "$den1<br>";
$s=$s-1;
$den1_sqrt = pow($den1,0.5);   
//echo  "$den1_sqrt<br>";


for($j=$i+1;$j<=$num_pid;$j++)
{ 
$num = 0;
$den2 = 0;
$B = $U_PID[$j];
//echo "<br>$j $B";
for($l=1;$pid[$l]!=$B;$l++);
//echo "<br>$l<br>";
for($r=$l;$pid[$r]==$B;$r++)
{
$den2 = $den2 + pow($value[$r],2); 
}
//echo "$den2<br>";
$r=$r-1;
$den2_sqrt = pow($den2,0.5);
//echo "$den2_sqrt<br>";
// echo "k = $k,l=$l,s=$s,r=$r";
for($u=$k,$v=$l;$u<=$s && $v<=$r;$u++,$v++)
{
if($sid[$u]==$sid[$v])
{
$num = $num + ($value[$u] * $value[$v]);
}
elseif($sid[$u]<$sid[$v])
{
//echo "condition where u< v";
$v=$v-1;
//echo "$v";
}
elseif($sid[$u]>$sid[$v])
{
$u=$u-1;
}
}
//echo "<br>$num<br>";
$prod = $den1_sqrt * $den2_sqrt ;
// echo "prod = $prod<br>";
$final_sim = $num / $prod; 
//echo "final_sim = $final_sim<br>";
$result3 = mysql_query("INSERT INTO similarity_matrix (Primary_Product,Secondary_Product,Similarity) VALUES ('$A','$B','$final_sim') ");
$result4 = mysql_query("INSERT INTO similarity_matrix (Primary_Product,Secondary_Product,Similarity) VALUES ('$B','$A','$final_sim') ");

if (!$result3) { 
$message = 'Invalid query: ' . mysql_error() . "\n"; 
$message .= 'Whole query: ' . $query; 
die($message); 
}

if (!$result4) { 
$message = 'Invalid query: ' . mysql_error() . "\n"; 
$message .= 'Whole query: ' . $query; 
die($message); 
}
}

}




// mark the stop time
$stop_time = MICROTIME(TRUE);
 
// get the difference in seconds
$time = $stop_time - $start_time;
 
PRINT "Elapsed time was $time seconds.";




/*$a=8;
$a=sqrt($a);
echo "$a";*/

/*for($i=1;$i<=$num_pid;$i++)
{ echo "$U_PID[$i]<br>";
}*/

/*for($i=1;$i<=$num;$i++)
{ echo "$pid[$i]  $sid[$i]  $value[$i]<br>";
}*/

mysql_close();
?>'