<?php
session_start();
require("../includes/functions.inc.php");

admin_forbidden();
customer_forbidden();
// check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = filter_var($_POST["email"], FILTER_SANITIZE_SPECIAL_CHARS);
    $username = filter_var($_POST["username"], FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_var($_POST["password"], FILTER_SANITIZE_SPECIAL_CHARS);

    //check if exists
    $user = checkUser($username);
    //create account
    if (empty($user)) {
        if (createUser($username, $password, $email, "customer")){
            makeToast("info", "Success", "Account successfully created!");
        }
    }
    else {
        makeToast("error", "Error", "Another account with the same username exists!");
    }

}

displayToast();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php head_tag_content(); ?>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
    </style>
    <title>Login</title>
</head>
<body>
<?php ?>
<div class="container-fluid">
    <div style="width: 100%; height: 500px;"></div>
    <div class="row overflow-x-auto">
        <div class="container my-4">
            <div class="row mt-5">
                <div class="col-md-6 offset-md-3">
                    <h2 class="text-center mb-4">Registration</h2>
                    <form action="<?php current_page();?>" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                        </div>
                        <div class="mb-3">
                            <label for="confirm-password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm-password" placeholder="Confirm your password">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php footer(); ?>
</div>



<?php body_script_tag_content(); ?>
</body>
</html>

