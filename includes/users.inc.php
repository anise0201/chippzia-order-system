<?php

require_once("functions.inc.php");
/* USER RELATED */
//create customer/admin
function createUser($username, $password, $email, $user_type) {
    if (!($user_type == "customer" || $user_type == "admin")) {
        die("Invalid user type");
    }

    $conn = OpenConn();
    $sql = "INSERT INTO users(username, password, user_email, user_type) 
            VALUES (?, ?, ?, ?)";

    try {
        if ($conn->execute_query($sql, [$username, password_hash($password, PASSWORD_DEFAULT), $email, $user_type])){
            CloseConn($conn);
            return true;
        }
    }
    catch (mysqli_sql_exception){
        createLog($conn->error);
        header("Location: /index.php");
        die();
    }

    return false;
}
//check user exists
function checkUser($username): bool
{
    $sql = "SELECT * FROM users WHERE username = ?";
    $conn = OpenConn();

    $result = $conn->execute_query($sql, [$username]);
    CloseConn($conn);

    if (mysqli_num_rows($result) > 0) {
        return true;
    }
    return false;
}

function returnUserType($userID){
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $conn = OpenConn();

    $result = $conn->execute_query($sql, [$userID]);
    CloseConn($conn);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row["user_type"];
    }
    return null;
}

//verify user (return customer/admin)
function verifyUser($username, $password) {
    $sql = "SELECT us.* FROM users us WHERE us.username = ?";

    $conn = OpenConn();

    try{
        $result = $conn->execute_query($sql, [$username]);
        CloseConn($conn);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            //check password
            if (password_verify($password, $row["password"])){
                return $row;
            }
        }
    }
    catch (mysqli_sql_exception) {
        createLog($conn->error);
        die("Error: cannot get the user!");
    }

    return null;
}

function retrieveStates() {
    $sql = "SELECT * FROM states";
    $conn = OpenConn();

    $result = $conn->execute_query($sql);
    CloseConn($conn);

    if (mysqli_num_rows($result) > 0) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return null;
}

function retrieveUser($userID) {
    $sql = "SELECT us.*, s.* FROM users us 
            INNER JOIN states s on us.state_code = s.state_code
            WHERE us.user_id = ?";

    $conn = OpenConn();

    try{
        $result = $conn->execute_query($sql, [$userID]);
        CloseConn($conn);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
    }
    catch (mysqli_sql_exception) {
        createLog($conn->error);
        die("Error: cannot get the user!");
    }

    makeToast("error", "User doesn't exist or was removed!", "Error");
    header("Location: /logout.php");
    die();
}

function updateContact($userID, $contact){
    $sql = "UPDATE users SET user_address = ?, user_city = ?, user_postcode = ?, state_code = ?, user_phone = ?
            WHERE user_id = ?";

    $conn = OpenConn();

    try{
        $result = $conn->execute_query($sql, [$contact["address"], $contact["city"], $contact["postcode"],
                                                $contact["state_code"], $contact["phone"], $userID]);
        CloseConn($conn);

        if ($result) {
            return true;
        }
    }
    catch (mysqli_sql_exception) {
        createLog($conn->error);
        die("Error: cannot update user contact!");
    }

    return false;
}