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
    <title>Kerepek Funz | Shopping Cart</title>
</head>
<body>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto px-0">
            <?php side_bar() ?>
        </div>
        <main class="col ps-md-2 pt-2">
            <?php header_bar("Check-out") ?>

            <!-- todo DASHBOARD here  -->
            <div class="container mt-3">
                <div class="row justify-content-center">
                    <div class="col-lg-8 me-3 mt-3 mb-5">
                        <h2><strong>Complete your order</strong></h2>
                        <p>Fill all form field to go to next step</p>
                        <div class="row">
                            <div class="col-md-12 mx-0">
                                <form id="msform">
                                    <!-- progressbar -->
                                    <ul id="progressbar">
                                        <li class="active"><strong>Cart</strong></li>
                                        <li class="active"><strong>Checkout</strong></li>
                                        <li><strong>Finish</strong></li>
                                    </ul>
                                    <fieldset>
                                        <div class="form-card">
                                            <h2 class="fs-title">Payment Information</h2>

                                        </div>
                                        <input type="button" class="action-button float-end" value="Proceed"/>
                                    </fieldset>
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