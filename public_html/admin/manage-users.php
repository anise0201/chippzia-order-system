<?php

require("../../includes/functions.inc.php");

session_start();

employee_login_required();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postedToken = $_POST["token"];
    try{
        if(!empty($postedToken)){
            if(isTokenValid($postedToken)){
                //delete member todo
//                if (isset($_POST["delete"])) {
//                    $userID = htmlspecialchars($_POST["user_id"]);
//                    deleteUser($userID) or throw new Exception("User wasn't able to be deleted!");
//                    makeToast("success", "Account successfully deleted!", "Success");
//                }
                if (isset($_POST["delete_member"])) {
                    $customerID = htmlspecialchars($_POST["customer_id"]);
                    deleteCustomer($customerID) or throw new Exception("Customer wasn't able to be deleted!");
                    makeToast("success", "Account successfully deleted!", "Success");
                }
                else if (isset($_POST["delete_employee"])) {
                    $employeeID = htmlspecialchars($_POST["employee_id"]);
                    deleteEmployees($employeeID) or throw new Exception("Employee wasn't able to be deleted!");
                    makeToast("success", "Employee successfully deleted!", "Success");
                }
                //create admin todo
                else if (isset($_POST["admin"])) {
                    $fname = htmlspecialchars($_POST["fname"]);
                    $lname = htmlspecialchars($_POST["lname"]);
                    $username = htmlspecialchars($_POST["username"]);
                    $email = htmlspecialchars($_POST["email"]);
                    $password = htmlspecialchars($_POST["password"]);
                    $managerID = htmlspecialchars($_POST["manager_id"]);

                    createEmployee($fname, $lname, $email, null, $username, $password, $managerID) or throw new Exception("Employee account wasn't able to be created!");
                    makeToast("success", "Admin account successfully created!", "Success");
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

    header("Location: ".BASE_URL."admin/manage-users.php");
    die();
}

$membersCount = retrieveCountMembers()['COUNT'] ?? 0;
$employeeCount = retrieveCountEmployees()['COUNT'] ?? 0;

$userCount = $membersCount + $employeeCount;

$employees = retrieveAllEmployees();
$members = retrieveAllMembers();

displayToast();
$token = getToken();
?>
<!DOCTYPE html>
<html>

<head>
    <?php head_tag_content(); ?>
    <title><?= WEBSITE_NAME ?> | Manage Users</title>
</head>
<body>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto px-0">
            <?php admin_side_bar() ?>
        </div>
        <main class="col ps-md-2 pt-2">
            <?php admin_header_bar("Manage User") ?>

            <!-- todo users here  -->
            <div class="container">
                <div class="row mt-4 gx-4 ms-3">
                    <div class="p-3 mb-5 bg-body rounded row gx-3">
                        <div class="row">
                            <span class="h3"><?= $userCount ?> users found</span>
                        </div>
                        <div class="shadow p-3 mb-5 mt-3 bg-body rounded row gx-3 mx-1">
                            <!-- ADMIN-->
                            <div class="row mb-1">
                                <div class="col">
                                    <span class="h3"><?= $employeeCount ?> employees found</span>
                                </div>
                                <div class="col text-end ">
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#adminStatic">
                                        <span class="h5"><i class="bi bi-plus-circle"> </i>Add</span>
                                    </button>
                                </div>
                            </div>
                            <div class="row mt-3 px-3 table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Full Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Registration</th>
                                        <th scope="col" class="text-center col-1">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        admin_displayEmployeeUsers($employees);
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="shadow p-3 mb-5 bg-body rounded row gx-3 mx-1">
                            <!-- CUSTOMER -->
                            <div class="row">
                                <span class="h3"><?= $membersCount ?> members found</span>
                            </div>
                            <div class="row mt-3 px-3 table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Username</th>
                                        <th scope="col" class="col-2">Full Name</th>
                                        <th scope="col" class="col-2">Address</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Registration</th>
                                        <th scope="col" class="text-center" style="width: 10%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    admin_displayMemberUsers($members);
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- modal create admin -->
                    <div class='modal fade' id='adminStatic' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1' aria-labelledby='staticBackdropLabel' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header bg-light-subtle'>
                                    <h5 class='modal-title' id='staticBackdropLabel'>Create Admin Account</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                </div>
                                <div class='modal-body'>
                                    <form id="admin" action="<?= BASE_URL ?>admin/manage-users.php" method="post">
                                        <div class="row mb-1">
                                            <div class="col" id="name">
                                                <label for="first-name" class="form-label">First Name</label>
                                                <input type="text" class="form-control" id="first-name" name="fname" placeholder="First name">
                                            </div>
                                            <div class="col">
                                                <label for="last-name" class="form-label">Last Name</label>
                                                <input type="text" class="form-control" id="last-name" name="lname" placeholder="Last name">
                                            </div>
                                        </div>
                                        <div class="row px-2 mb-1">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username here" required>
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email here" required>
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password here" required>
                                        </div>
                                        <input type="hidden" name="token" value="<?= $token ?>">
                                    </form>

                                </div>
                                <div class='modal-footer bg-light-subtle'>
                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>

                                    <button type='submit' id="modal-btn-admin" form="admin" name="admin" value="1" class='btn btn-danger'>Create Account</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- modal delete -->
                    <div class='modal fade' id='static' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1' aria-labelledby='staticBackdropLabel' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header bg-light-subtle'>
                                    <h5 class='modal-title' id='staticBackdropLabel'>Delete user?</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                </div>
                                <div class='modal-body bg-danger-subtle'>
                                    <div class="px-3">
                                        <div class="mb-1">
                                            <span class="fw-bolder">Warning</span>
                                        </div>
                                        <span class="text-black mt-3">This action cannot be reversed!<br>Proceed with caution.</span>
                                    </div>

                                </div>
                                <div class='modal-footer bg-light-subtle'>
                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                    <button type='submit' id="modal-btn" form="" name="delete" value="1" class='btn btn-danger'>I understand</button>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>




            <?php footer(); ?>
        </main>

    </div>
</div>
<?php body_script_tag_content();?>
<script type="text/javascript" src="<?= BASE_URL ?>assets/js/modal.js"></script>
</body>

</html>