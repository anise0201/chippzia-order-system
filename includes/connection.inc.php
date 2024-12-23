<?php
function OpenConn() 
{
    $username = "chipzzia";
    $password = "chipzzia";
    $connection_string = "localhost:1521/xe";

    // Turn on error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

    // Connect to Oracle Database
    $conn = oci_connect($username, $password, $connection_string);
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