<?php

require("../../includes/functions.inc.php");

session_start();

customer_login_required();

$user = retrieveUser($_SESSION["user_data"]["user_id"]);
$states = retrieveStates();
$optionStates = "";

foreach ($states as $state){
    $optionStates .= "<option value='{$state["state_code"]}'>{$state["state_name"]}</option>";
}
?>
<!DOCTYPE html>
<html>

<head>
    <?php head_tag_content(); ?>
    <title>Kerepek Funz | Profile</title>
</head>
<body>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto px-0">
            <?php side_bar() ?>
        </div>
        <main class="col ps-md-2 pt-2">
            <?php header_bar("Profile") ?>

            <!-- todo DASHBOARD here  -->
            <div class="container">
                <div class="row mt-4 gx-4 ms-3">
                    <div class="col-5">
                        <div class="shadow p-3 mb-5 bg-body rounded row gx-3" style="height: 300px">
                            <span class="fs-2">Contact Update</span>
                            <div class="mt-2">
                                <form method="post" action="<?php current_page(); ?>">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col">
                                                <input type="text" class="form-control" name="address" placeholder="Address">
                                            </div>
                                            </div>
                                        <div class="row my-2">
                                            <div class="col">
                                                <input type="text" class="form-control" name="postcode" placeholder="Postcode">
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" name="city" placeholder="City">
                                            </div>
                                            <div class="col">
                                                <select name="state" class="form-select">
                                                    <?= $optionStates; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col">
                                                <input type="tel" class="form-control" name="phone" placeholder="Phone Number">
                                            </div>
                                            </div>
                                        <button type="submit" class="btn btn-secondary mt-2 float-end text-center">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="shadow p-3 bg-body rounded row gx-3">
                            <span class="fs-2">Account Details</span>
                            <div class="col mt-2">
                                <div class="row">
                                    <span class="fw-bold">Username</span>
                                </div>
                                <div class="row">
                                    <span class="fw-bold">First Name</span>
                                </div>
                                <div class="row">
                                    <span class="fw-bold">Last Name</span>
                                </div>
                                <div class="row">
                                    <span class="fw-bold">Email</span>
                                </div>
                            </div>
                            <div class="col mt-2">
                                <div class="row">
                                    <span class="fw-bold"><?= $user["username"]  ?? "-" ?></span>
                                </div>
                                <div class="row">
                                    <span class="fw-bold"><?= $user["user_fname"]  ?? "-" ?></span>
                                </div>
                                <div class="row">
                                    <span class="fw-bold"><?= $user["user_lname"]  ?? "-" ?></span>
                                </div>
                                <div class="row">
                                    <span class="fw-bold"><?= $user["user_email"]  ?? "-" ?></span>
                                </div>

                            </div>
                        </div>
                        <div class="shadow p-3 mt-4 mb-4 bg-body rounded row gx-3">
                            <span class="fs-2">Contact Details</span>
                            <div class="col mt-2">
                                <div class="row">
                                    <span class="fw-bold">Address</span>
                                </div>
                                <div class="row">
                                    <span class="fw-bold">Postcode</span>
                                </div>
                                <div class="row">
                                    <span class="fw-bold">City</span>
                                </div>
                                <div class="row">
                                    <span class="fw-bold">State</span>
                                </div>
                                <div class="row">
                                    <span class="fw-bold">Phone Number</span>
                                </div>

                            </div>
                            <div class="col mt-2">
                                <div class="row">
                                    <span class="fw-bold"><?= $user["user_address"] ?? "-" ?></span>
                                </div>
                                <div class="row">
                                    <span class="fw-bold"><?= $user["user_postcode"]  ?? "-"  ?></span>
                                </div>
                                <div class="row">
                                    <span class="fw-bold"><?= $user["user_city"]  ?? "-" ?></span>
                                </div>
                                <div class="row">
                                    <span class="fw-bold"><?= $user["status_code"] ?? "-"  ?></span>
                                </div>
                                <div class="row">
                                    <span class="fw-bold"><?= $user["user_phone"]  ?? "-" ?></span>
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
</body>

</html>