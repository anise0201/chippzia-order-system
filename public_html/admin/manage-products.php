<?php

require("../../includes/functions.inc.php");

session_start();

employee_login_required();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postedToken = $_POST["token"];
    try{
        if(!empty($postedToken)){
            if(isTokenValid($postedToken)){
                //delete product todo
                if (isset($_POST["delete"])) {
                    $productID = htmlspecialchars($_POST["product_id"]);

                    deleteProduct($productID) or throw new Exception("Couldn't delete product");
                    makeToast("success", "Product successfully deleted!", "Success");
                }
                //create product todo
                else if (isset($_POST["product"])) {
                    $productName = htmlspecialchars($_POST["product_name"]);
                    $productCode = htmlspecialchars($_POST["product_code"]);
                    $productPrice = htmlspecialchars($_POST["product_price"]);

                    //create image
                    $file = $_FILES['product_image'];

                    $fileName = $file['name'];
                    $fileTmpName = $file['tmp_name'];
                    $fileSize = $file['size'];

                    $fileArr = explode('.', $fileName);
                    $fileExt = strtolower(end($fileArr));

                    $allowed = ['jpg','jpeg','png'];

                    if ($file["error"]) {
                        throw new Exception($file["error"]);
                    }

                    $fileNameTrue = str_replace(" ", "-", reset($fileArr));
                    $fileNameNew = $fileNameTrue . "." . $fileExt;
                    $fileDestinationRelative = '/assets/images/' . $fileNameNew;
                    $fileDestination = $_SERVER['DOCUMENT_ROOT'] . $fileDestinationRelative;


                    if (in_array($fileExt, $allowed)) {
                        if ($fileSize < 10485760) {
                            move_uploaded_file($fileTmpName, $fileDestination);
                        }
                        else {
                            throw new Exception("File too big");
                        }
                    }
                    else{
                        throw new Exception("Filetype not allowed");
                    }

                    //create product
                    createProduct($productName, $productCode, $fileDestinationRelative, $productPrice) or throw new Exception("Couldn't create product");

                    makeToast("success", "Product successfully created!", "Success");
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

    header("Location: /admin/manage-products.php");
    die();
}

$productCount = retrieveProductCount()["COUNT"] ?? 0;

$products = retrieveAllProduct();

displayToast();
$token = getToken();
?>
<!DOCTYPE html>
<html>

<head>
    <?php head_tag_content(); ?>
    <title>Kerepek Funz | Manage Products</title>
</head>
<body>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto px-0">
            <?php admin_side_bar() ?>
        </div>
        <main class="col ps-md-2 pt-2">
            <?php admin_header_bar("Manage Products") ?>

            <!-- todo users here  -->
            <div class="container">
                <div class="row mt-4 gx-4 ms-3">
                    <div class="p-3 mb-5 bg-body rounded row gx-3">
                        <div class="row">
                            <span class="h3"><?= $productCount ?> products found</span>
                        </div>

                        <div class="shadow p-3 mb-5 mt-3 bg-body rounded row gx-3 mx-1">
                            <div class="col">
                                <span class="fs-1 mb-3">Products</span>
                            </div>
                            <div class="col text-end">
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#productStatic">
                                    <span class="h5"><i class="bi bi-plus-circle"> </i>Add</span>
                                </button>
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
                                    foreach ($products as $product){
                                        $price = number_format((float)$product["PRODUCT_PRICE"], 2, ".", ",");
                                        echo "
                                            <tr class='align-middle'>
                                                <th scope='row'>{$product["PRODUCT_ID"]}</th>
                                                <td><img class='img-fluid w-100' src='{$product["PRODUCT_IMAGE"]}' style='max-width: 200px;'></td>
                                                <td>{$product["PRODUCT_NAME"]}</td>
                                                <td>RM{$price}</td>
                                                <td class='text-center'>
                                                     <form action='{$base_url}admin/manage-products.php' id='{$product["PRODUCT_ID"]}' method='post'>
                                                        <input type='hidden' name='product_id' value='{$product["PRODUCT_ID"]}'>
                                                        <input type='hidden' name='token' value='{$_SESSION["token"]}'>
                                                        <a type='button' data-bs-toggle='modal' data-bs-target='#static' onclick='updateModal({$product["PRODUCT_ID"]}, \"modal-btn-delete\");' class='h4'> 
                                                        <i class='bi bi-trash'></i></a>
                                                    </form>   
                                                </td>
                                            </tr>";
                                    }
                                }
                                else {
                                    echo "
                                        <tr class='align-middle'>
                                        <td class='text-center' colspan='5'>No products</td> 
                                        </tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- modal create product -->
                    <div class='modal fade' id='productStatic' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1' aria-labelledby='staticBackdropLabel' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header bg-light-subtle'>
                                    <h5 class='modal-title' id='staticBackdropLabel'>Create new Product</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                </div>
                                <div class='modal-body'>
                                    <form id="product" action="<?= BASE_URL ?>admin/manage-products.php" method="post" enctype="multipart/form-data">
                                        <div class="row px-2 mb-1">
                                            <label for="product-name" class="form-label">Product Name:</label>
                                            <input type="text" class="form-control" id="product-name" name="product_name" placeholder="Enter product name here" required>

                                            <label for="product-code" class="form-label">Product Code:</label>
                                            <input type="text" class="form-control" id="product-code" name="product_code" placeholder="Enter product code here" required>

                                            <label for="product-price" class="form-label">Product Price:</label>
                                            <input type="text" class="form-control" id="product-price" name="product_price" placeholder="Enter product price here" required>

                                            <label for="product-image" class="form-label">Product Image:</label>
                                            <input type="file" class="form-control" id="product-image" name="product_image" required>
                                        </div>
                                        <input type="hidden" name="token" value="<?= $token ?>">
                                    </form>

                                </div>
                                <div class='modal-footer bg-light-subtle'>
                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                    <button type='submit' form="product" name="product" value="1" class='btn btn-danger'>Create Product</button>
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
                                    <button type='submit' id="modal-btn-delete" form="" name="delete" value="1" class='btn btn-danger'>I understand</button>
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