<?php
session_start();
require("../includes/functions.inc.php");

employee_forbidden();
member_forbidden();

// check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = filter_var($_POST["username"], FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_var($_POST["password"], FILTER_SANITIZE_SPECIAL_CHARS);
    $userType = filter_var($_POST["usertype"], FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($username) || empty($password)) {
        makeToast("error", "Either username or password is empty", "Error");
    }

    $userData = null;
    if ($userType == "member") {
        $userData = verifyMember($username, $password);
    }
    else if ($userType == "employee") {
        $userData = verifyEmployee($username, $password);
    }

    if (isset($userData)) {
        $userData["user_type"] = $userType;
        $_SESSION["user_data"] = $userData;
        makeToast("success", "You are now logged in!", "Success");
        header("Location: ". BASE_URL . "index.php");
    }
    else {
        makeToast("error", "Either username or password is incorrect.", "Error");
    }
}
displayToast();
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
    <div class="container-fluid">
        <div class="container my-5 py-5">
            <form action="<?php current_page(); ?>" method="post">
                <div class="row pt-5">
                    <div class="col-md-6 offset-md-3">
                        <h2 class="text-center mb-4">Login</h2>
                        <form>
                            <div class="mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="usertype" id="usertype1" value="member" checked>
                                    <label class="form-check-label" for="usertype1">Member</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="usertype" id="usertype2" value="employee">
                                    <label class="form-check-label" for="usertype2">Employee</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                            <div class="text-center mt-2">
                                <span>Don't have an account? <a class="text-decoration-none" href="<?= BASE_URL ?>register.php">Register now!</a></span>
                            </div>
                        </form>
                    </div>
                </div>
            </form>
        </div>
        <?php footer(); ?>
    </div>


    <?php body_script_tag_content(); ?>
</body>
</html>

