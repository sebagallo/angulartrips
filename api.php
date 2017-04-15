<?php
// $sel_dest = "Maldive";
// $sel_avail = "2017-07-11";

// return last 5 trips by default
$selector = "last";
$ret=array();

if(isset($_GET["dest"])) $sel_dest = $_GET["dest"];
if(isset($_GET["avail"])) $sel_avail = $_GET["avail"];
if(isset($_GET["q"])) {
	$sel = $_GET["q"];
	//array, no keys, unique destinations
	if ($sel == "dl") $selector = "dest_list";
	//array, no keys, unique dates relative to chosen dest
	if ($sel == "dal") $selector = "dest_avail_list";
	//associative array, all destination data
	if ($sel == "d") $selector = "dest";
	//ass array, all destination data only relative to chose date
	if ($sel == "da") $selector = "dest_avail";
	//destination search (matching letter(s))
	if ($sel == "dls") $selector = "dest_list_search";
}

if ($selector=="last")
{
	$db = new SQLite3('temp.db');
	$stmnt = $db->prepare('SELECT * FROM travels ORDER BY id DESC LIMIT 5;');
	$result = $stmnt->execute();
	$x=0;
	while ($row = $result->fetchArray(1)) {
    	$ret[$x]= $row;
    	$x++;
	}
	$db->close();
	header('Content-Type: application/json');
	echo json_encode($ret);
}

if ($selector=="dest_list")
{
	$db = new SQLite3('temp.db');
	$stmnt = $db->prepare('SELECT DISTINCT dest FROM travels;');
	$result = $stmnt->execute();
	$x=0;
	while ($row = $result->fetchArray()) {
    	$ret[$x]= $row[dest];
    	$x++;
	}
	$db->close();
	header('Content-Type: application/json');
	echo json_encode($ret);
}

if ($selector=="dest_list_search")
{
	$sel_dest = '%'.$sel_dest.'%';
	$db = new SQLite3('temp.db');
	$stmnt = $db->prepare('SELECT DISTINCT dest FROM travels WHERE dest LIKE ?');
	$stmnt->bindValue(1, $sel_dest);
	$result = $stmnt->execute();
	$x=0;
	while ($row = $result->fetchArray()) {
    	$ret[$x]= $row[dest];
    	$x++;
	}
	$db->close();
	header('Content-Type: application/json');
	echo json_encode($ret);
}

if ($selector=="dest_avail_list")
{
	$db = new SQLite3('temp.db');
	$stmnt = $db->prepare('SELECT DISTINCT avail FROM travels WHERE dest = :dest;');
	$stmnt->bindValue(':dest', $sel_dest);
	$result = $stmnt->execute();
	$x=0;
	while ($row = $result->fetchArray()) {
    	$ret[$x]= $row[avail];
    	$x++;
	}
	$db->close();
	header('Content-Type: application/json');
	echo json_encode($ret);
}

if ($selector=="dest")
{
	$db = new SQLite3('temp.db');
	$stmnt = $db->prepare('SELECT * FROM travels WHERE dest = :dest;');
	$stmnt->bindValue(':dest', $sel_dest);
	$result = $stmnt->execute();
	$x=0;
	while ($row = $result->fetchArray(1)) {
    	$ret[$x]= $row;
    	$x++;
	}
	$db->close();
	header('Content-Type: application/json');
	echo json_encode($ret);
}

if ($selector=="dest_avail")
{
	$db = new SQLite3('temp.db');
	$stmnt = $db->prepare('SELECT * FROM travels WHERE dest = :dest AND avail = :avail;');
	$stmnt->bindValue(':dest', $sel_dest);
	$stmnt->bindValue(':avail', $sel_avail);
	$result = $stmnt->execute();
	$x=0;
	while ($row = $result->fetchArray(1)) {
    	$ret[$x]= $row;
    	$x++;
	}
	$db->close();
	header('Content-Type: application/json');
	echo json_encode($ret);
}

?>