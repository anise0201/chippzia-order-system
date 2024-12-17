<?php
function OpenConn() 
{
    $username = "chipzzia";                   // Your Oracle username
    $password = "chipzzia";                   // Your Oracle password
    $database = "localhost:1521/xe";    // Oracle connection string: host:port/service_name

    // Turn on error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

    // Create connection

    // Connect to Oracle Database
    $conn = oci_connect($username, $password, $database);
    if (!$conn) {
        $m = oci_error();
        die("Oracle Connection failed: " . $m['message']);
    }

    return $conn;
}

function CloseConn($conn): void
{
    oci_close($conn);
}