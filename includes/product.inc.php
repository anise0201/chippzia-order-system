<?php

require_once("functions.inc.php");
/* PRODUCT RELATED */


//todo create, delete select products


function retrieveAllProduct() {
    $sql = "SELECT * FROM products p";

    $conn = OpenConn();

    try {
        $result = $conn->execute_query($sql);
        CloseConn($conn);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    }
    catch (mysqli_sql_exception){
        createLog($conn->error);
        die("Error: unable to retrieve products!");
    }

    return null;
}

function retrieveProductCount() {
    $sql = "SELECT COUNT(p.product_id) as 'count' FROM products p";

    $conn = OpenConn();

    try {
        $result = $conn->execute_query($sql);
        CloseConn($conn);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
    }
    catch (mysqli_sql_exception){
        createLog($conn->error);
        die("Error: unable to retrieve product count!");
    }

    return null;
}

function retrieveProduct($productID) {
    $sql = "SELECT p.* FROM products p WHERE p.product_id = ?";

    $conn = OpenConn();

    try {
        $result = $conn->execute_query($sql, [$productID]);
        CloseConn($conn);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
    }
    catch (mysqli_sql_exception){
        createLog($conn->error);
        die("Error: unable to retrieve product!");
    }

    return null;
}