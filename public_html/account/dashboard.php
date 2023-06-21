<?php

require("../../includes/functions.inc.php");

session_start();

customer_login_required();



$user = retrieveUser($_SESSION["user_data"]["user_id"]);
$name = $user["user_fname"] ?? "";
$today = date_create("now");
$date = date_format($today, "D, d M Y");

$ordersCount = retrieveOrderCountUser($user["user_id"])["count"];
$totalSpend = retrieveUserTotalSpend($user["user_id"])["sum"];
$ordersLineSum = retrieveOrderLineSumQuantityUser($user["user_id"])["sum"] ?? 0;

$orders = retrieveAllUserOrders5LIMIT($user["user_id"]);
$totalSpendDecimal = number_format((float)$totalSpend, 2, ".", ",");
?>
<!DOCTYPE html>
<html>

<head>
    <?php head_tag_content(); ?>
    <title>Kerepek Funz | User Dashboard</title>
</head>
<body>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto px-0">
            <?php side_bar() ?>
        </div>
        <main class="col ps-md-2 pt-2">
            <?php header_bar("Dashboard") ?>

            <!-- todo DASHBOARD here  -->
            <div class="container">
                <div class="row mt-4 gx-4 ms-3">
                    <div class="row">
                        <span class="h3">Hello there, <?= $name ?? "-" ?></span>
                        <span class="lead">Today is <?= $date ?></span>
                    </div>
                    <div class="row mt-2 h-100">
                        <!-- ORDERS-->
                        <div class="col">
                            <div class="shadow p-3 mb-5 bg-body rounded row gx-3">
                                <div class="col">
                                    <div class="row">
                                        <span class="fs-2"><?= $ordersCount; ?></span>
                                    </div>
                                    <div class="row">
                                        <span class="text-muted">Orders</span>
                                    </div>
                                </div>
                                <div class="col text-end">
                                    <i class="bi bi-people-fill icon-yellow-dark h2"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ORDERS LINE-->
                        <div class="col">
                            <div class="shadow p-3 mb-5 bg-body rounded row gx-3">
                                <div class="col">
                                    <div class="row">
                                        <span class="fs-2"><?= $ordersLineSum; ?></span>
                                    </div>
                                    <div class="row">
                                        <span class="text-muted">Products Ordered</span>
                                    </div>
                                </div>
                                <div class="col text-end">
                                    <i class="bi bi-people-fill icon-yellow-dark h2"></i>
                                </div>
                            </div>
                        </div>
                        <!-- TOTAL SPENT-->
                        <div class="col w-100">
                            <div class="shadow p-3 gradient-primary rounded row gx-3">
                                <div class="col">
                                    <div class="row">
                                        <span class="fs-2 text-white">RM<?= $totalSpendDecimal ?></span>
                                    </div>
                                    <div class="row">
                                        <span class="text-white">Total Spent</span>
                                    </div>
                                </div>
                                <div class="col text-end">
                                    <i class="bi bi-people-fill h2 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row mt-4 gx-4 ms-3">
                    <div class="col">
                        <div class="shadow p-3 mb-5 bg-body rounded row gx-3">
                            <div class="row">
                                <span class="h3">Recent Orders</span>
                            </div>
                            <div class="row">
                                <?php
                                if ($orders != null){
                                    orders_userOrders($orders);
                                }
                                else {
                                    echo "<span class='fs-4'>No orders yet.</span>";
                                }
                                ?>
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