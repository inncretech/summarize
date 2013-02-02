<?
/*
include "include/database.php";
$query=$_GET['query'];
$counter='0';
echo "{";
echo "query:'$query',";
echo "suggestions:[";
$res = mysql_query("select name from product where name like '%$query%' ORDER BY name desc");
while ($row = mysql_fetch_array($res)) {
$counter++;
if ($counter > 1) {
echo ",";
}
$name=$row["name"];
echo "'$name'";
}
echo "],}";
*/
$term = trim(strip_tags($_GET['term']));//retrieve the search term that autocomplete sends
include "include/database.php";
$qstring = "SELECT * FROM product WHERE name LIKE '%".$term."%' or tags like '%".$term."%'";
$result = $database->query($qstring);//query the database for entries containing the term

while ($row = mysql_fetch_array($result))//loop through the retrieved values
{
		if ($row['tags']!=""){
		$row2['value']=htmlentities(stripslashes($row['name'].", ".$row['tags']));
		}else{
		$row2['value']=htmlentities(stripslashes($row['name']));
		}
		$row_set[] = $row2;//build an array
}
echo json_encode($row_set);//format the array into json data
?>