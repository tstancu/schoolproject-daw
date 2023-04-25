<?php
require_once __DIR__ . '/../../vendor/autoload.php'; // Path to autoload.php
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();
//var_dump($dotenv);
// var_dump($_ENV);
// putenv('JAWSDB_MARIA_URL=mysql://i8u51n5m6szbap6y:pfoittzoc880kt28@f80b6byii2vwv8cx.chr7pe7iynqr.eu-west-1.rds.amazonaws.com:3306/vpctx8nxzxydiz73');

//$db_url = getenv('JAWSDB_MARIA_URL');
$db_url = $_ENV['JAWSDB_MARIA_URL'];

if ($db_url === false) {
    die('JAWSDB_MARIA_URL not found in environment variables');
}

$dbparts = parse_url($db_url);
if ($dbparts === false) {
    die('Failed to parse database URL');
}

//var_dump($dbparts);
//var_dump($_SERVER['HTTP_HOST']);

if ($_SERVER['HTTP_HOST'] == 'localhost:8080') {
    $hostname = 'localhost';
    $username = 'root';
    $password = 'root';
    $database = 'revista';
} else {
    $hostname = $dbparts['host'];
    $username = $dbparts['user'];
    $password = $dbparts['pass'];
    $database = ltrim($dbparts['path'], '/');
}

// Create connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>