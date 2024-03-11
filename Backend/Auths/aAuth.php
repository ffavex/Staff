<?php
include("../database.php");

// Function to get the user's IP address
function getUserIP() {
    // Check if Cloudflare's connecting IP is available
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }

    // Retrieve IP addresses from different sources
    $client = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote = $_SERVER['REMOTE_ADDR'];

    // Determine the correct IP address
    if (filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }

    return $ip; // Return the IP address
}

// Check if the 'exp' index exists before accessing it
if (isset($_GET["exp"])) {
    $exp = $_GET["exp"];
} else {
    $exp = null;
}

$fn = "https://efial.wtf/Backend/Auths//" . basename($_SERVER['PHP_SELF']);
$fnn = basename($_SERVER['PHP_SELF']);

if(!$exp){
  echo("_G.L='$fn';".file_get_contents('./Test.lua')); // This Isnt Obfuscated So Yuh
  return;
}

$hwid = "";
if($exp){
    if (isset(getallheaders()["$exp-Fingerprint"])) {
        $hwid = getallheaders()["$exp-Fingerprint"];
    } else {
        echo "return game.Players.LocalPlayer:Kick('ERR: $exp-Fingerprint header not found!')";
        return;
    }
}

// Get the user's IP address
$IP = getUserIP();

$check = explode("-", $fnn)[0];

$found = false;
$entry;
for ($i = 0; $i < count($dataBase); $i++) {
    if ($check == $dataBase[$i]["Discord"]) {
        $found = true;
        $entry = $i;
        break;
    }
}

if (!$found) {
    echo "return game.Players.LocalPlayer:Kick('ERR 2!')";
    return;
}

$date = "2023/08/10";

$dataBase[$entry]["HWID"] = $hwid;
$dataBase[$entry]["lastHwidChange"] = $date;
$dataBase[$entry]["Exploit"] = $exp;

// Add the user's IP address to the database
$dataBase[$entry]["ip"] = $IP;

// Update the database file with the new data
$towrite = var_export($dataBase, true);
$write = '<?php $dataBase = ' . $towrite . '; ?>';
file_put_contents("../database.php", $write);
echo "return game.Players.LocalPlayer:Kick('HWID has been set!')";
unlink("./$fnn");
?>
