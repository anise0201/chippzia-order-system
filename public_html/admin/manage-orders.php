<?php

require("../../includes/functions.inc.php");

session_start();

employee_login_required();

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

                    //notify user here via mail
                    require_once("../../mail.inc.php");
                    $order = retrieveOrderSpecific($orderID);
                    $fullName = $order["user_fname"]." ".$order["user_lname"];

                    $orderCode = sprintf("%08d", $order["order_id"]);
                    $date = date_create($order["date_created"]);
                    $dateFormatted = date_format($date, "d M Y");

                    $subject = "";
                    $content = "";
                    if ($orderStatus === "PENDING"){
                        $subject = "Your Order #{$orderCode} is Pending Confirmation";
                        $content = "
                        <p>Thank you for choosing Kerepek Funz for your snack cravings! We have received your order and it is currently being processed. Please note that your payment is pending verification.</p>
                        <p><strong>Order Details:</strong></p>
                        <ul>
                            <li>Order Code: #{$orderCode}</li>
                            <li>Order Date: {$dateFormatted}</li>
                        </ul>
                        <p>We are working diligently to confirm your payment and process your order. Once the payment is verified, we will proceed with packing and shipping your delicious snacks. You will receive a confirmation email with the shipment details.</p>
                        <p>If you have any questions or need further assistance, please feel free to reach out to our customer support team at <a href='mailto:kerepekfunz5@gmail.com'>Kerepek Funz Customer Support Team</a>.</p>
                        <p>Thank you for your patience!</p>";
                    }
                    else if ($orderStatus === "COMPLETED") {
                        $estimatedDeliveryDate = date('d M Y', strtotime("+10 day"));
                        $subject = "Your Order #{$orderCode} is Complete - Enjoy Your Snacks!";
                        $content = "
                        <p>Hooray! Your order from Kerepek Funz has been successfully processed and shipped. Your delicious snacks are on their way to you!</p>
                        <p><strong>Order Details:</strong></p>
                        <ul>
                            <li>Order Code: #{$orderCode}</li>
                            <li>Order Date: {$dateFormatted}</li>
                            <li>Estimated Delivery Date: {$estimatedDeliveryDate}</li>
                        </ul>
                        <p>We want you to have the best snacking experience, so please make sure to keep an eye out for your package. Once it arrives, indulge in the mouthwatering flavors of our premium snacks.</p>
                        <p>We hope you enjoy every bite! If you have any feedback or questions about your order, please don't hesitate to contact our friendly customer support team at <a href='mailto:kerepekfunz5@gmail.com'>Kerepek Funz Customer Support Team</a>.</p>
                        <p>Thank you for choosing Kerepek Funz!</p>";
                    }
                    else if ($orderStatus === "CANCELLED") {
                        $subject = "Important: Your Order #{$orderCode} has been Cancelled";
                        $content = "
                         <p>We regret to inform you that your order with Kerepek Funz has been cancelled. We apologize for any inconvenience caused.</p>
                        <p><strong>Order Details:</strong></p>
                        <ul>
                            <li>Order Code: #{$orderCode}</li>
                            <li>Order Date: {$dateFormatted}</li>
                        </ul>
                        <p>Due to unforeseen circumstances, we were unable to fulfill your order as requested. Rest assured that any payment made for the cancelled order will be refunded to your original payment method.</p>
        <p>If you have any questions or concerns about the cancellation, please reach out to our customer support team at <a href='mailto:kerepekfunz5@gmail.com'>Kerepek Funz Customer Support Team</a>. We value your satisfaction and would be happy to assist you.</p>
        <p>Once again, we apologize for the cancellation and any inconvenience caused. We hope to have the opportunity to serve you better in the future.</p>";
                    }
                    else {
                        throw new Exception("Order status does not exist!");
                    }

                    $body = "<h1>Dear {$fullName},</h1>
                             {$content}
                             <p>Sincerely,</p>
                             <p>Kerepek Funz Team</p>";

                    sendMail($order["user_email"], $subject, $body) or throw new Exception("Message wasn't sent!");;

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
                            <h5 class='modal-title'>Update order transaction?</h5>
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