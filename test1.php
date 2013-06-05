<php

mysql_connect("localhost","root","root");//database connection

mysql_select_db("buyingiq");
/*
This code simulates the results of a GROUP_CONCAT SQL query.
It was created by Tony Boyd (www.outshine.com) but this code
is freely released into the public domain.
*/
$html = "<table>\n";
$html .= "<tr>\n<th>name</th>\n<th>downloads</th>\n</tr>\n";
$names = array();
$query = 'SELECT a_sid, a_prim_ref_id FROM audits';
$result = mysql_query($query);
$got_rows = mysql_num_rows($result);
if ($got_rows) {
	while ($row = mysql_fetch_array($result)) {
		array_push($names[$row['a_sid']], $row['a_prim_ref_id']);
	}
	foreach ($names as $name => $a_prim_ref_id) {
		$html .= "<tr>\n";
		$html .= '<td>' . $name . "</td>\n";
		$html .= '<td>' . implode(', ', array_unique($a_prim_ref_id)) . "</td>\n";
		$html .= "</tr>\n";
	}
}
else {
	$html .= '<td colspan="2">No results</td>' . "\n";
}
$html .= "</table>\n";
echo $html;
?>