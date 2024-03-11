<?php
// Modules
date_default_timezone_set('America/Chicago');
include_once("./database.php"); // Database
include_once("./Modules/randomString.php"); // randomString(Number)
include_once("./Modules/isWithin.php"); // isWithin(Number)
include_once("./Modules/getUserIp.php"); // getUserIp()

$fakeReturn = randomString(rand(10, 80));

// Variables
$req = $_GET["req"];

// Check if request parameter exists
if (!$req) {
    echo $fakeReturn;
    exit();
}

// Split the request parameter to get key and exploit values
$reqParts = explode("=", $req);
if (count($reqParts) != 2) {
    echo $fakeReturn;
    exit();
}

$Exploit = $reqParts[0];
$Key = $reqParts[1];

if (!$Key || !$Exploit) {
    echo $fakeReturn;
    exit();
}

// Assuming $dataBase is your database array
$HWID = getallheaders()["Krampus-Fingerprint"];
$IP = getUserIp();

if (!$HWID || !$IP) {
    echo $fakeReturn;
    exit();
}

$KeyFound = false;
foreach ($dataBase as $index => $entry) {
    if ($entry["Key"] === $Key) { // Use strict comparison here
        $KeyFound = true;
        $dbEntry = $index;
        break;
    }
}


if (!$KeyFound) {
    echo("AuthFailed");
    exit();
}

$dataBase[$dbEntry]["ip"] = $IP;

if ($dataBase[$dbEntry]["HWID"] !== $HWID) {
    echo("HwidMatch");
    exit();
}

if ($dataBase[$dbEntry]["isBlacklisted"] == true) {
    echo("Black");
    exit();
}

if ($dataBase[$dbEntry]["isFrozen"] == true) {
    echo("Froze");
    exit();
}

$returnKey = $Key;
$returnValue = "Continue+$returnKey";

// Construct the link with the parameter
$link = "https://monkeyys.000webhostapp.com/test-auth.php?req=$Exploit=$Key";

echo "<a href='$link'>$returnValue</a>";
?>