<?php
session_start();
require("../../includes/functions.inc.php");


customer_login_required();

displayToast();
$cart = $_SESSION["cart"] ?? [];

$token = getToken();
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
                    <div class="col-lg-8 me-3 mt-3 mb-5">
                        <h2><strong>Thanks for shopping with Kerepek Funz</strong></h2>
                        <p>We hope you'll order again from us!</p>
                        <div class="row">
                            <div class="col-md-12 mx-0">
                                <form id="msform">
                                    <!-- progressbar -->
                                    <ul id="progressbar">
                                        <li class="active"><strong>Cart</strong></li>
                                        <li class="active"><strong>Checkout</strong></li>
                                        <li class="active"><strong>Finish</strong></li>
                                    </ul>
                                    <div class="invoice-box bg-white">
                                        <table>
                                            <tr class="top">
                                                <td colspan="2">
                                                    <table>
                                                        <tr>
                                                            <td class="title">
                                                                <img src="/assets/images/icon2.jpg" style="width: 100%; max-width: 200px" />
                                                            </td>

                                                            <td>
                                                                Invoice #: <br />
                                                                Booking Reference #:
                                                                Created: <br />
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
                                                                name<br />
                                                                email<br />
                                                                phone
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
                                                <td>Direct Bank Transfer</td>
                                                <td></td>
                                            </tr>

                                            <tr class="heading">
                                                <td>Item</td>

                                                <td>Price</td>
                                            </tr>

                                            <tr class="item">
                                                <td>Website design</td>

                                                <td>$300.00</td>
                                            </tr>

                                            <tr class="item">
                                                <td>Hosting (3 months)</td>

                                                <td>$75.00</td>
                                            </tr>

                                            <tr class="item last">
                                                <td>Domain name (1 year)</td>

                                                <td>$10.00</td>
                                            </tr>

                                            <tr class="total">
                                                <td></td>

                                                <td>Total: $385.00</td>
                                            </tr>
                                        </table>
                                    </div>
                                </form>
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