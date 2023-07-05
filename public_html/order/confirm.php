<?php
session_start();
require("../../includes/functions.inc.php");


customer_login_required();

displayToast();
//cart no longer need
unset($_SESSION["cart"]);

$user = $_SESSION["user_data"];
$totalCost = $_SESSION["totalCost"];
$orderID = $_SESSION["orderID"];

$orderCode = sprintf('%08d', $orderID);
$date = date("d M Y");

$subTotal = number_format(($totalCost - 5), 2, ".", ",");
$total = number_format(($totalCost), 2, ".", ",");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php head_tag_content(); ?>
    <link rel="stylesheet" href="/assets/css/progress.css">
    <link rel="stylesheet" href="/assets/css/invoice.css">
    <title>Kerepek Funz | Order Completed</title>
</head>
<body>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto px-0">
            <?php side_bar() ?>
        </div>
        <main class="col ps-md-2 pt-2">
            <?php header_bar("Complete") ?>

            <!-- todo DASHBOARD here  -->
            <div class="container mt-3">
                <div class="row justify-content-center">
                    <div class="col-lg-12 me-3 mt-3 mb-5">
                        <h2><strong>Thanks for shopping with Kerepek Funz</strong></h2>
                        <p>We hope you'll order again from us!</p>
                        <div class="row">
                            <div class="col-md-12 mx-0">
                                <div id="msform">
                                    <!-- progressbar -->
                                    <ul id="progressbar">
                                        <li class="active"><strong>Cart</strong></li>
                                        <li class="active"><strong>Checkout</strong></li>
                                        <li class="active"><strong>Finish</strong></li>
                                    </ul>
                                    <!--  invoice-->
                                    <div class="invoice-box bg-white">
                                        <table>
                                            <tr class="top">
                                                <td colspan="2">
                                                    <table>
                                                        <tr>
                                                            <td class="title">
                                                                <img src="/assets/images/icon2.jpg" style="width: 100%; max-width: 200px; object-fit: contain;" />
                                                            </td>

                                                            <td>
                                                                Invoice: #<?= $orderCode; ?><br />
                                                                Created: <?= $date; ?><br />
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                            <tr class="information">
                                                <td colspan="2">
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                AIRASIA BERHAD<br />
                                                                RedQ Jalan Pekeliling 5<br />
                                                                Lapangan Terbang Antarabangsa Kuala Lumpur<br/>
                                                                Selangor, 64000 Malaysia<br />
                                                                +60-3-86604333
                                                            </td>

                                                            <td>
                                                                <?= ($user["user_fname"] . " " . $user["user_lname"]) ?><br />
                                                                <?= $user["user_email"] ?><br />
                                                                <?= $user["user_phone"] ?? "-" ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                            <tr class="heading">
                                                <td>Payment Method</td>
                                                <td></td>
                                            </tr>

                                            <tr class="details">
                                                <td>Debit/Credit Card</td>
                                                <td></td>
                                            </tr>

                                            <tr class="heading">
                                                <td>Item</td>

                                                <td>Price</td>
                                            </tr>

                                            <tr class="item">
                                                <td>Subtotal</td>

                                                <td>RM<?= $subTotal ?></td>
                                            </tr>

                                            <tr class="item last">
                                                <td>Delivery Cost</td>

                                                <td>RM5.00</td>
                                            </tr>

                                            <tr class="total">
                                                <td></td>

                                                <td>Total: RM<?= $total ?></td>
                                            </tr>
                                        </table>
                                    </div>
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