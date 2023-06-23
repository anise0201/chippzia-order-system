<?php

require("../../includes/functions.inc.php");

session_start();

admin_login_required();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postedToken = $_POST["token"];
    try{
        if(!empty($postedToken)){
            if(isTokenValid($postedToken)){
                //todo update transaction
                if (isset($_POST["update"])) {
                    $orderID = htmlspecialchars($_POST["order_id"]);
                    $orderStatus = htmlspecialchars($_POST["status"]);

                    updateOrder($orderID, $orderStatus) or throw new Exception("Couldn't update transaction status");
                    makeToast("success", "Order successfully updated!", "Success");
                }

                //todo delete booking
                if (isset($_POST["delete"])) {
                    $orderID = htmlspecialchars($_POST["order_id"]);

                    deleteOrder($orderID) or throw new Exception("Couldn't delete order");
                    makeToast("success", "Order successfully deleted!", "Success");
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

    header("Location: /admin/manage-orders.php");
    die();
}

$orderCount = retrieveOrderCount()["count"] ?? 0;
$orders = retrieveAllOrders();

displayToast();
$token = getToken();
?>
<!DOCTYPE html>
<html>

<head>
    <?php head_tag_content(); ?>
    <title>Kerepek Funz | Manage Orders</title>
</head>
<body>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto px-0">
            <?php admin_side_bar() ?>
        </div>
        <main class="col ps-md-2 pt-2">
            <?php admin_header_bar("Manage Orders") ?>

            <!-- todo users here  -->
            <div class="container">
                <div class="row mt-4 gx-4 ms-3">
                    <div class="p-3 mb-5 bg-body rounded row gx-3">
                        <div class="row">
                            <span class="h3"><?= $orderCount ?> orders found</span>
                        </div>
                        <div class="shadow p-3 mb-5 mt-3 bg-body rounded row gx-3 mx-1">
                            <?php
                            orders_adminOrders($orders);
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- modal delete -->
            <div class='modal fade' id='deleteStatic' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1' aria-labelledby='staticBackdropLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header bg-light-subtle'>
                            <h5 class='modal-title'>Delete user?</h5>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body bg-danger-subtle'>
                            <div class="px-3">
                                <div class="mb-1">
                                    <span class="fw-bolder">Danger</span>
                                </div>
                                <span class="text-black mt-3">This action cannot be reversed!<br>Proceed with caution.</span>
                            </div>

                        </div>
                        <div class='modal-footer bg-light-subtle'>
                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                            <button type='submit' id="modal-btn-delete" form="" name="delete" value="1" class='btn btn-danger'>I understand</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- modal update -->
            <div class='modal fade' id='updateStatic' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1' aria-labelledby='staticBackdropLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header bg-light-subtle'>
                            <h5 class='modal-title'>Update bookings transaction?</h5>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body bg-warning-subtle'>
                            <div class="px-3">
                                <div class="mb-1">
                                    <span class="fw-bolder">Warning</span>
                                </div>
                                <span class="text-black mt-3">The customer will be notified by the change if you proceed.
                                            <br>Proceed with caution.</span>
                            </div>

                        </div>
                        <div class='modal-footer bg-light-subtle'>
                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                            <button type='submit' id="modal-btn-update" form="" name="update" value="1" class='btn btn-danger'>I understand</button>
                        </div>
                    </div>
                </div>
            </div>

            <?php footer(); ?>
        </main>

    </div>
</div>
<?php body_script_tag_content();?>
<script type="text/javascript" src="/assets/js/modal.js"></script>
</body>

</html>