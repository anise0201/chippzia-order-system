<?php

require_once("functions.inc.php");
/* PRODUCT RELATED */


//todo create, delete select orders


function retrieveAllUserOrders($userID) {
    $sql = "SELECT * FROM orders WHERE user_id = ?";

    $conn = OpenConn();

    try {
        $result = $conn->execute_query($sql, [$userID]);
        CloseConn($conn);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    }
    catch (mysqli_sql_exception){
        createLog($conn->error);
        die("Error: unable to retrieve orders!");
    }

    return null;
}

function retrieveAllUserOrders5LIMIT($userID) {
    $sql = "SELECT * FROM orders WHERE user_id = ? LIMIT 5";

    $conn = OpenConn();

    try {
        $result = $conn->execute_query($sql, [$userID]);
        CloseConn($conn);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    }
    catch (mysqli_sql_exception){
        createLog($conn->error);
        die("Error: unable to retrieve orders!");
    }

    return null;
}


function retrieveOrderCount() {
    $sql = "SELECT COUNT(o.order_id) as 'count' FROM orders o";

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
        die("Error: unable to retrieve orders count!");
    }

    return null;
}

function retrieveOrderCountUser($userID) {
    $sql = "SELECT COUNT(o.order_id) as 'count' FROM orders o WHERE o.user_id = ?";

    $conn = OpenConn();

    try {
        $result = $conn->execute_query($sql, [$userID]);
        CloseConn($conn);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
    }
    catch (mysqli_sql_exception){
        createLog($conn->error);
        die("Error: unable to retrieve orders count!");
    }

    return null;
}

function retrieveOrderLineSumQuantityUser($userID) {
    $sql = "SELECT SUM(ol.quantity) as 'sum' 
            FROM order_lines ol
            INNER JOIN orders o on ol.order_id = o.order_id 
                                       AND o.user_id = ?";

    $conn = OpenConn();

    try {
        $result = $conn->execute_query($sql, [$userID]);
        CloseConn($conn);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
    }
    catch (mysqli_sql_exception){
        createLog($conn->error);
        die("Error: unable to retrieve orders count!");
    }

    return null;
}

function retrieveUserTotalSpend($userID) {
    $sql = "SELECT sum(order_price) as 'sum' FROM orders
            WHERE order_status = 'COMPLETED' and user_id = ?";

    $conn = OpenConn();

    try {
        $result = $conn->execute_query($sql, [$userID]);
        CloseConn($conn);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
    }
    catch (mysqli_sql_exception){
        createLog($conn->error);
        die("Error: unable to retrieve orders count!");
    }

    return null;
}
function retrieveAllOrderLines($orderID) {
    $sql = "SELECT o.*, p.* FROM order_lines o
         INNER JOIN products p on o.product_id = p.product_id
         WHERE o.order_id = ?";

    $conn = OpenConn();

    try {
        $result = $conn->execute_query($sql, [$orderID]);
        CloseConn($conn);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    }
    catch (mysqli_sql_exception){
        createLog($conn->error);
        die("Error: unable to retrieve order lines!");
    }

    return null;
}

function retrieveOrderLineCount($orderID) {
    $sql = "SELECT COUNT(o.order_line_id) as 'count' FROM order_lines o";

    $conn = OpenConn();

    try {
        $result = $conn->execute_query($sql, [$orderID]);
        CloseConn($conn);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
    }
    catch (mysqli_sql_exception){
        createLog($conn->error);
        die("Error: unable to retrieve orders lines count!");
    }

    return null;
}
