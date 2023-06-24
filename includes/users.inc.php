<?php

require_once("functions.inc.php");
/* USER RELATED */
//create customer/admin
function createUser($fname, $lname, $username, $password, $email, $user_type) {
    if (!($user_type == "customer" || $user_type == "admin")) {
        die("Invalid user type");
    }

    $conn = OpenConn();
    $sql = "INSERT INTO users(username, password, user_fname, user_lname, user_email, user_type) 
            VALUES (?, ?, ?, ?, ?, ?)";

    try {
        if ($conn->execute_query($sql, [$username, password_hash($password, PASSWORD_DEFAULT), $fname, $lname,
                                        $email, $user_type])){
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
function checkUser($username, $email): bool
{
    $sql = "SELECT * FROM users WHERE username = ? OR user_email = ?";
    $conn = OpenConn();

    try {
        $result = $conn->execute_query($sql, [$username, $email]);
        CloseConn($conn);

        if (mysqli_num_rows($result) > 0) {
            return true;
        }
    }
    catch(mysqli_sql_exception){
        createLog($conn->error);
        die("Error: cannot get the user!");
    }
    return false;
}

function returnUserType($userID){
    $user = $_SESSION["user_data"];
    return $user["user_type"];
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

function retrieveUserSimple($userID) {
    $sql = "SELECT us.* FROM users us 
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

//admin
function retrieveCountUsers() {
    $sql = "SELECT COUNT(user_id) as 'count' FROM users";

    $conn = OpenConn();

    try{
        $result = $conn->execute_query($sql);
        CloseConn($conn);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
    }
    catch (mysqli_sql_exception) {
        createLog($conn->error);
        die("Error: cannot get the user count!");
    }
    return null;
}
function retrieveCountAdminUsers() {
    $sql = "SELECT COUNT(user_id) as 'count' FROM users  WHERE user_type = 'admin'";

    $conn = OpenConn();

    try{
        $result = $conn->execute_query($sql);
        CloseConn($conn);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
    }
    catch (mysqli_sql_exception) {
        createLog($conn->error);
        die("Error: cannot get the user admin count!");
    }
    return null;
}
function retrieveCountCustomerUsers() {
    $sql = "SELECT COUNT(user_id) as 'count' FROM users WHERE user_type = 'customer'";

    $conn = OpenConn();

    try{
        $result = $conn->execute_query($sql);
        CloseConn($conn);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
    }
    catch (mysqli_sql_exception) {
        createLog($conn->error);
        die("Error: cannot get the user customer count!");
    }
    return null;
}
function retrieveAllAdminUsers() {
    $sql = "SELECT * FROM users WHERE user_type = 'admin'";

    $conn = OpenConn();

    try{
        $result = $conn->execute_query($sql);
        CloseConn($conn);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    }
    catch (mysqli_sql_exception) {
        createLog($conn->error);
        die("Error: cannot get the user admins!");
    }
    return null;
}

function retrieveAllCustomerUsers() {
    $sql = "SELECT u.*, s.state_name FROM users u 
         INNER JOIN states s on u.state_code = s.state_code
         WHERE user_type = 'customer'";

    $conn = OpenConn();

    try{
        $result = $conn->execute_query($sql);
        CloseConn($conn);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    }
    catch (mysqli_sql_exception) {
        createLog($conn->error);
        die("Error: cannot get the user customers!");
    }
    return null;
}

function deleteUser($userID) {
    $sql = "DELETE FROM users WHERE user_id = ?";

    $conn = OpenConn();

    try{
        $result = $conn->execute_query($sql, [$userID]);
        CloseConn($conn);

        if ($result) {
            return true;
        }
    }
    catch (mysqli_sql_exception) {
        createLog($conn->error);
        die("Error: cannot get the user customers!");
    }
    return false;
}

function retrieveAllUserLike($query) {
    $sql = "SELECT * FROM users u WHERE u.user_fname LIKE ? OR u.user_lname LIKE ? OR u.username LIKE ?";
    $query = "%{$query}%";

    $conn = OpenConn();

    try {
        $result = $conn->execute_query($sql, [$query, $query, $query]);
        CloseConn($conn);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    }
    catch (mysqli_sql_exception){
        createLog($conn->error);
        die("Error: unable to retrieve users like!");
    }

    return null;
}
