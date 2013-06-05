<?php
ini_set('max_execution_time', 0);
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
	$ids = explode(',', $row[0]);
	$length = count($ids);
	if($length == 1)
		continue;
		
	for ($primaryIndex=0; $primaryIndex<$length; $primaryIndex++) {
		$primaryId = $ids[$primaryIndex];
		for ($secondaryIndex=$primaryIndex+1; $secondaryIndex<$length; $secondaryIndex++) {
			$secondaryId = $ids[$secondaryIndex];
			if($primaryId == $secondaryId)
				continue;
				
			$key1 = $primaryId.'_'.$secondaryId;			
			$key2 = $secondaryId.'_'.$primaryId;
			
			if(!isset($data[$key1]))
				$data[$key1] = 0;
			
			if(!isset($data[$key2]))
				$data[$key2] = 0;			
				
			$data[$key1]++;
			$data[$key2]++;
		}	
	}		
};

$insertionCount = 0;
$baseQuery = "INSERT INTO cocon VALUES ";
$queryParts = array();
$insertionCount = 0;
foreach ($data as $key => $value) {
	list($primaryProductId, $secondaryProductId) = explode('_', $key);
	$queryParts[] = "($primaryProductId, $secondaryProductId, $value)"; // This would work because all are integers
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
