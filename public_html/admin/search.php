<?php

require("../../includes/functions.inc.php");

session_start();

employee_login_required();

if (isset($_GET["q"])){
    $query = htmlspecialchars($_GET["q"]);

    $products = retrieveAllProductLike($query);
    $customers = retrieveAllCustomers();
}
else {
    makeToast("Warning", "Query was not found!", "Warning");
    header("Location: ".BASE_URL."admin/dashboard.php");
    die();
}

displayToast();
?>
<!DOCTYPE html>
<html>

<head>
    <?php head_tag_content(); ?>
    <title><?= WEBSITE_NAME ?> | Search Result</title>
</head>
<body>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto px-0">
            <?php admin_side_bar() ?>
        </div>
        <main class="col ps-md-2 pt-2">
            <?php admin_header_bar("Search Result") ?>

            <!-- todo users here  -->
            <div class="container">
                <div class="row mt-4 gx-4 ms-3">
                    <div class="p-3 mb-5 bg-body rounded row gx-3">
                        <div class="row">
                            <span class="h3"><span id="product-count">0</span> products found</span>
                        </div>
                        <div class="shadow p-3 mb-3 mt-3 bg-body rounded row gx-3 mx-1">
                            <div class="col">
                                <span class="fs-1 mb-3">Products</span>
                            </div>
                            <table class="table table-responsive table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">Code</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $base_url = BASE_URL;
                                if ($products != null){
                                    $productCount = 0;
                                    foreach ($products as $product){
                                        $price = number_format((float)$product["PRODUCT_PRICE"], 2, ".", ",");
                                        echo "
                                            <tr class='align-middle'>
                                                <th scope='row'>{$product["PRODUCT_ID"]}</th>
                                                <td><img class='img-fluid w-100' src='{$product["PRODUCT_IMAGE"]}' style='max-width: 200px;'></td>
                                                <td>{$product["PRODUCT_NAME"]}</td>
                                                <td>RM{$price}</td>
                                                <td class='text-center'>
                                                    <a type='button' class='btn btn-outline-primary' href='{$base_url}admin/manage-products.php/#{$product["PRODUCT_ID"]}'>
                                                        See More
                                                    </a>                                       
                                                </td>
                                            </tr>";
                                        $productCount++;
                                    }
                                    echo "<script>$('#product-count').text(\"{$productCount}\");</script>";
                                }
                                else {
                                    echo "<tr><td colspan='5' class='text-center'>No products found</td></tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-5">
                            <span class="h3"><span id="user-count">0</span> users found</span>
                        </div>
                        <div class="shadow p-3 mb-3 mt-3 bg-body rounded row gx-3 mx-1">
                            <div class="col">
                                <span class="fs-1 mb-3">Users</span>
                            </div>

                            <table class="table table-responsive table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $base_url = BASE_URL;
                                if ($customers != null){
                                    $userCount = 0;
                                    foreach ($customers as $customer){
                                        $fullName = $customer["FIRST_NAME"] . " " . $customer["LAST_NAME"];

                                        $address = ($customer["ADDRESS"] ?? "") . ", " . ($customer["POSTCODE"] ?? "")
                                            . ", " . ($customer["CITY"] ?? "") . ", " . ($customer["STATE"] ?? "");
                                        $phone = $customer["PHONE"] ?? "-";

                                        $count = $userCount + 1;
                                        echo
                                        "<tr class='align-middle'>
                                            <th scope='row'>$count</th>
                                            <td>{$fullName}</td>
                                            <td>{$address}</td>
                                            <td>{$customer["EMAIL"]}</td>
                                            <td>{$phone}</td>
                                            <td class='text-center'>
                                                <a type='button' class='btn btn-outline-primary' href='{$base_url}admin/manage-users.php/#{$customer["CUSTOMER_ID"]}'>
                                                    See More
                                                </a>                                       
                                            </td>
                                        </tr>";
                                        $userCount++;
                                    }
                                    echo "<script>$('#user-count').text(\"{$userCount}\");</script>";
                                }
                                else {
                                    echo "<tr><td colspan='8' class='text-center'>No user found</td></tr>";
                                }
                                ?>
                                </tbody>
                            </table>
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