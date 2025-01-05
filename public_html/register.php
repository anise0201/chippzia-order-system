<?php
session_start();
require("../includes/functions.inc.php");

employee_forbidden();
member_forbidden();

// check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //This function will specifically create members
    $postedToken = $_POST["token"];
    try{
        if(!empty($postedToken)){
            if(isTokenValid($postedToken)){
                $firstname = htmlspecialchars($_POST["fname"]);
                $lastname = htmlspecialchars($_POST["lname"]);
                $email = filter_var($_POST["email"], FILTER_SANITIZE_SPECIAL_CHARS);
                $username = filter_var($_POST["username"], FILTER_SANITIZE_SPECIAL_CHARS);
                $password = filter_var($_POST["password"], FILTER_SANITIZE_SPECIAL_CHARS);

//                //check if exists
//                $user = checkUser($username, $email);
//                if (!$user) {
//                    if (createUser($firstname, $lastname, $username, $password, $email, "customer")){
//                        makeToast("info", "Success", "Account successfully created!");
//                    }
//                }
                $member = checkMember($username, $email);
                if(!$member){
                    if (createMember($firstname, $lastname, $email, null, null, null, null, $username, $password)){
                        makeToast("info", "Success", "Account successfully created!");
                    }
                }
                else {
                    throw new exception("Another account with the same username or email exists!");
                }
            }
            else{
                makeToast("warning", "Please refrain from attempting to resubmit previous form", "Warning");
            }
        }
        else {
            throw new exception("Token not found");
        }
    }
    catch (exception $e){
        makeToast("error", $e->getMessage(), "Error");
    }

    header("Location: ". BASE_URL . "register.php");
    die();

}

displayToast();

$token = getToken();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php head_tag_content(); ?>
    <style>

    </style>
    <title>Login</title>
</head>
<body>
<?php nav_menu(); ?>
<section id="billboard" class="position-relative overflow-hidden bg-body">
</section>
<div class="container-fluid my-5">
    <div class="row overflow-x-auto">
        <div class="container my-5">
            <div class="row mt-5">
                <div class="col-md-6 offset-md-3">
                    <h2 class="text-center mb-4">Member Registration</h2>
                    <form action="<?php current_page();?>" method="post">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="fname" class="form-label">First Name:</label>
                                <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name"  required>
                            </div>
                            <div class="col">
                                <label for="lname" class="form-label">Last name:</label>
                                <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name"  required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password"  required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm-password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm-password" placeholder="Confirm your password"  required>
                            <h5 id="conpasscheck"></h5>
                        </div>
                        <div class="text-center">
                            <input type="hidden" name="token" value="<?= $token?>">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                        <div class="text-center mt-2">
                            <span>Already have an account? <a class="text-decoration-none" href="<?= BASE_URL ?>login.php">Login here!</a></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php footer(); ?>
</div>
<?php body_script_tag_content(); ?>
<script type="text/javascript" src="assets/js/register.js"></script>
</body>
</html>

