<?php

require("../../includes/functions.inc.php");

session_start();

employee_login_required();

if (isset($_GET["q"])){
    $query = htmlspecialchars($_GET["q"]);

    $products = retrieveAllProductLike($query);
    $users = retrieveAllUserLike($query);
}
else {
    makeToast("Warning", "Query was not found!", "Warning");
    header("Location: /admin/dashboard.php");
    die();
}

displayToast();
?>
<!DOCTYPE html>
<html>

<head>
    <?php head_tag_content(); ?>
    <title>Kerepek Funz | Search Result</title>
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
                                if ($products != null){
                                    $productCount = 0;
                                    foreach ($products as $product){
                                        $price = number_format((float)$product["product_price"], 2, ".", ",");
                                        echo "
                                            <tr class='align-middle'>
                                                <th scope='row'>{$product["product_code"]}</th>
                                                <td><img class='img-fluid w-100' src='{$product["product_image"]}' style='max-width: 200px;'></td>
                                                <td>{$product["product_name"]}</td>
                                                <td>RM{$price}</td>
                                                <td class='text-center'>
                                                    <a type='button' class='btn btn-outline-primary' href='/admin/manage-products.php/#{$product["product_id"]}'>
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
                                    <th scope="col">Username</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if ($users != null){
                                    $userCount = 0;
                                    foreach ($users as $user){
                                        $fullName = $user["user_fname"] . " " . $user["user_lname"];

                                        $address = ($user["user_address"] ?? "") . ", " . ($user["user_postcode"] ?? "")
                                            . ", " . ($user["user_city"] ?? "") . ", " . ($user["state_name"] ?? "");
                                        $phone = $user["user_phone"] ?? "-";
                                        $type = $user["user_type"];
                                        $userType = "";

                                        if ($type === "customer"){
                                            $userType = "Customer User";
                                        }
                                        else if ($type === "admin") {
                                            $address = "-";
                                            $phone = "-";
                                            $userType = "Admin User";
                                        }
                                        else {
                                            continue;
                                        }

                                        $count = $userCount + 1;
                                        echo
                                        "<tr class='align-middle'>
                                            <th scope='row'>$count</th>
                                            <td>{$user["username"]}</td>
                                            <td>{$fullName}</td>
                                            <td>{$address}</td>
                                            <td>{$user["user_email"]}</td>
                                            <td>{$phone}</td>
                                            <td>{$userType}</td>
                                            <td class='text-center'>
                                                <a type='button' class='btn btn-outline-primary' href='/admin/manage-users.php/#{$user["user_id"]}'>
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