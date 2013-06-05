<?php

//mysql_connect("localhost","root","root");//database connection

 # pdo_testdb_connect.php - function for connecting to the "test" database

   function testdb_connect ()
   {
     $dbh = new PDO("mysql:host=localhost;dbname=test", "testuser", "testpass");
     return ($dbh);
   }

/* $p_type='P';
$sql_sub = "INSERT INTO cocon (P_ID,S_ID,Val) VALUES(:val1,:val2,1)
                           ON DUPLICATE KEY UPDATE Val=Val+1";
$query = $pdo->prepare($sql_sub);

try {
    $conn = new PDO('mysql:host=localhost;dbname=buyingiq', 'root','root');
    $stmt = $conn->prepare('SELECT GROUP_CONCAT(a_prim_ref_id) FROM audits WHERE a_type=:p_type GROUP BY a_sid')
    $stmt->execute(array('p_type' => $p_type));
    $result = $stmt->fetchAll();
    if(!count($result))
    {
      echo "No rows returned";
    }
    $result->setFetchMode(PDO::FECTH_NUM);
    while($row = $result->fetch()){
     echo $row['Value']."<br>\n";
     echo implode(",", $row);
     echo "<br />";
     $pieces = explode(",", $row[0]);
   
         $total_results = count($pieces)-1;
         if($total_results>0)
         {
 	        for ($i=0; $i<$total_results; $i++)
 	        {   
 	            $query->bindParam(':val1', $pieces[$i]);
                $query->bindParam(':val2', $pieces[$i]);
                $query->execute();
                for ($j=$i+1; $j<=$total_results; $j++)
 	       		{
 	       		  $query->bindParam(':val1', $pieces[$j]);
                  $query->bindParam(':val2', $pieces[$i]);
                  $query->execute();
                  $query->bindParam(':val1', $pieces[$i]);
                  $query->bindParam(':val2', $pieces[$j]);
                  $query->execute();
                  $query->bindParam(':val1', $pieces[$j]);
                  $query->bindParam(':val2', $pieces[$j]);
                  $query->execute();
                }
            }
         }
         else
            {
                $query->bindParam(':val1', $pieces[0]);
                $query->bindParam(':val2', $pieces[0]);
                $query->execute();
            }
            }
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
*/

?>

