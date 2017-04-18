<?php
/**
 * api.php?q=last
 *          - return last 5 entries by ID (assoc array)
 *         q=listDest
 *          - return every destination (array)
 *         q=listDestSearch&dest=STRING
 *          - return matching destinations (array) // for async search
 *         q=listDestAvail&dest=STRING
 *          - return dates matching destinations (array)
 *         q=listDestAvailSearch&dest=STRING
 *          - return matching dates (array)
 *         q=dataDest&dest=STRING
 *          - return all data of selected dest
 *         q=dataDestSearch&dest=STRING
 *          - return all data of matching dest
 *         q=dataDestAvail&dest=STRING&avail=STRING
 *          - return all data of selected dest and avail
 *         q=dataDestAvailSearch&dest=STRING&avail=STRING
 *          - return all data of matching dest and selected avail
 */

// return last 6 trips by default
$sel = "last";
$x = 0;
$ret=array();
// sleep(0.5);

if(isset($_GET["dest"])) $sel_dest = $_GET["dest"];
if(isset($_GET["avail"])) $sel_avail = $_GET["avail"];
if(isset($_GET["q"])) $sel = $_GET["q"];

$db = new SQLite3('temp.db');

if ($sel=="last")
{
    $stmnt = $db->prepare('SELECT * FROM travels ORDER BY id DESC LIMIT 9;');
    $result = $stmnt->execute();
    while ($row = $result->fetchArray(1)) {
        $ret[$x]= $row;
        $x++;
    }
}

if ($sel=="listDest")
{
    $stmnt = $db->prepare('SELECT DISTINCT dest FROM travels;');
    $result = $stmnt->execute();
    while ($row = $result->fetchArray()) {
        $ret[$x]= $row[dest];
        $x++;
    }
}

if ($sel=="listDestSearch")
{
    $sel_dest = '%'.$sel_dest.'%';
    $stmnt = $db->prepare('SELECT DISTINCT dest FROM travels WHERE dest LIKE ?');
    $stmnt->bindValue(1, $sel_dest);
    $result = $stmnt->execute();
    while ($row = $result->fetchArray()) {
        $ret[$x]= $row[dest];
        $x++;
    }
}

if ($sel=="listDestAvail")
{
    $stmnt = $db->prepare('SELECT DISTINCT avail FROM travels WHERE dest = :dest;');
    $stmnt->bindValue(':dest', $sel_dest);
    $result = $stmnt->execute();
    while ($row = $result->fetchArray()) {
        $ret[$x]= $row[avail];
        $x++;
    }
}

if ($sel=="listDestAvailSearch")
{
    $sel_dest = '%'.$sel_dest.'%';
    $stmnt = $db->prepare('SELECT DISTINCT avail FROM travels WHERE dest LIKE ?');
    $stmnt->bindValue(1, $sel_dest);
    $result = $stmnt->execute();
    while ($row = $result->fetchArray()) {
        $ret[$x]= $row[avail];
        $x++;
    }
}

if ($sel=="dataDest")
{
    $stmnt = $db->prepare('SELECT * FROM travels WHERE dest = :dest;');
    $stmnt->bindValue(':dest', $sel_dest);
    $result = $stmnt->execute();
    while ($row = $result->fetchArray(1)) {
        $ret[$x]= $row;
        $x++;
    }
}

if ($sel=="dataDestSearch")
{
    $sel_dest = '%'.$sel_dest.'%';
    $stmnt = $db->prepare('SELECT * FROM travels WHERE dest LIKE ?');
    $stmnt->bindValue(1, $sel_dest);
    $result = $stmnt->execute();
    while ($row = $result->fetchArray(1)) {
        $ret[$x]= $row;
        $x++;
    }
}

if ($sel=="dataDestAvail")
{
    $stmnt = $db->prepare('SELECT * FROM travels WHERE dest = :dest AND avail = :avail;');
    $stmnt->bindValue(':dest', $sel_dest);
    $stmnt->bindValue(':avail', $sel_avail);
    $result = $stmnt->execute();
    while ($row = $result->fetchArray(1)) {
        $ret[$x]= $row;
        $x++;
    }
}

if ($sel=="dataDestAvailSearch")
{
    $sel_dest = '%'.$sel_dest.'%';
    $stmnt = $db->prepare('SELECT * FROM travels WHERE dest LIKE ? AND avail =:avail;');
    $stmnt->bindValue(1, $sel_dest);
    $stmnt->bindValue(':avail', $sel_avail);
    $result = $stmnt->execute();
    while ($row = $result->fetchArray(1)) {
        $ret[$x]= $row;
        $x++;
    }
}

$db->close();
header('Content-Type: application/json');
echo json_encode($ret);

?>