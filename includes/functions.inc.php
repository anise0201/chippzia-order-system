<?php
require('connection.inc.php');
require('boilerplate.inc.php');
require('users.inc.php');
require('orders.inc.php');
require('product.inc.php');

//functions
function current_page(): void
{
    echo htmlspecialchars($_SERVER["PHP_SELF"]);
}

function makeToast($type, $message, $title) {
    $_SESSION["alert"] = ["type"=>$type, "message"=>$message, "title"=>$title];
}
// TOASTS
function displayToast() {
    if (isset($_SESSION["alert"])){
        showToastr($_SESSION["alert"]);
        unset($_SESSION["alert"]);
    }
}

//TOASTS
function showToastr($alert): void
{
    echo ("<script>
window.onload = function() {
    toastr.options = {
      \"closeButton\": false,
      \"debug\": false,
      \"newestOnTop\": false,
      \"progressBar\": false,
      \"positionClass\": \"toast-top-right\",
      \"preventDuplicates\": false,
      \"onclick\": null,
      \"showDuration\": \"300\",
      \"hideDuration\": \"1000\",
      \"timeOut\": \"5000\",
      \"extendedTimeOut\": \"1000\",
      \"showEasing\": \"swing\",
      \"hideEasing\": \"linear\",
      \"showMethod\": \"fadeIn\",
      \"hideMethod\": \"fadeOut\"
    }
    toastr[\"{$alert["type"]}\"](\"{$alert["message"]}\", \"{$alert["title"]}\");
}
</script>");
}


//Requires login to access the site
function customer_login_required(): void
{
    if (empty($_SESSION["user_data"])){
        header("Location: /login.php");
        die();
    }
    $_SESSION["user_data"] = retrieveUser($_SESSION["user_data"]["user_id"]);
    if (returnUserType($_SESSION["user_data"]["user_id"]) != "customer"){
        header("Location: /index.php");
        die();
    }
}


//Requires user to not be logged in to access the site (For instance, like Login page or Register page)
function admin_login_required() {
    if (empty($_SESSION["user_data"])){
        header("Location: /login.php");
        die();
    }
    $_SESSION["user_data"] = retrieveUserSimple($_SESSION["user_data"]["user_id"]);
    if (returnUserType($_SESSION["user_data"]["user_id"]) != "admin"){
        header("Location: /index.php");
        die();
    }
}

//special function to prevent admin from purchase products & customer from adding producst
function admin_forbidden(): void
{
    if (isset($_SESSION["user_data"])){
        if (returnUserType($_SESSION["user_data"]["user_id"]) === "admin"){
            header("Location: /admin/dashboard.php");
            die();
        }
    }
}
function customer_forbidden(): void
{
    if (isset($_SESSION["user_data"])){
        if (returnUserType($_SESSION["user_data"]["user_id"]) === "customer"){
            makeToast("warning", "You are forbidden from going to that page", "Warning");
            header("Location: /account/dashboard.php");
            die();
        }
    }
}

function getToken(){
    $token = sha1(mt_rand());
    $_SESSION['token'] = $token;

    return $token;
}

function isTokenValid($token){
    if(!empty($_SESSION['token'])){
        if ($_SESSION['token'] === $token){
            unset($_SESSION['token']);
            return true;
        }
    }
    return false;
}


//check array keys is set
function array_keys_isset_or_not($keys, $array): bool
{
    foreach ($keys as $key) {
        if (!isset($array[$key])) {
            return false;
        }
    }
    return true;
}

//check array keys is set
function array_keys_isempty_or_not($keys, $array): bool
{
    foreach ($keys as $key) {
        if (empty($array[$key])) {
            return false;
        }
    }
    return true;
}



function createLog($data): void
{
    $file = $_SERVER['DOCUMENT_ROOT']."/logs/log_".date("j.n.Y").".txt";
    $fh = fopen($file, 'a');
    fwrite($fh,"\n".$data);
    fclose($fh);
}


function orders_userOrders($orders){
    foreach ($orders as $order) {
        $count = 1;
        //date
        $date = date_create($order["date_created"]);
        $dateFormatted = date_format($date, "d M Y");

        $orderLines = retrieveAllOrderLines($order["order_id"]);
        $orderLineStr = "";
        foreach ($orderLines as $orderLine) {
            $price = number_format((float)$orderLine["product_price"], 2, ".", ",");

            $orderLineStr .=
                "<tr class='align-middle'>
<th scope='row'>$count</th>
<td><img class='img-fluid w-100' src='{$orderLine["product_image"]}' style='max-width: 200px;'></td>
<td>{$orderLine["product_name"]}</td>
<td class='text-center'>{$orderLine["quantity"]}</td>
<td>$dateFormatted</td>
<td>RM{$price}</td>
                                    </tr>";
            $count++;
        }


        //code
        $orderCode = sprintf('%08d', $order["order_id"]);
        $total = number_format((float)$order["order_price"], 2, ".", ",");
        $statusSmall = strtolower($order["order_status"]);
        echo "
<div class='row mt-3'>
    <div class='col'><span class='h4'>Order #{$orderCode}</span></div>
    <div class='col text-end'>
        <span class='{$statusSmall}'>{$order["order_status"]}</span>
    </div>
</div>
<div class='row'>
    <table class='table'>
    <caption>Delivery Fee: RM5.00</caption>
    <thead>
        <tr>
            <th scope='col'>#</th>
            <th scope='col'>Product</th>
            <th scope='col'>Name</th>
            <th scope='col'>Quantity</th>
            <th scope='col'>Date Ordered</th>
            <th scope='col'>Price</th>
        </tr>
    </thead>
    <tbody>
        {$orderLineStr}
    </tbody>
    <tfoot>
    <td colspan='5'><span class='fw-bold'>Total:</span></td>
    <td>RM{$total}</td>
    </tfoot>
    </table>
</div>
";
    }
}
function orders_adminOrders($orders) {
    if ($orders != null){
        $statusOptions = "
        <option value='PENDING'>Pending</option>
        <option value='COMPLETED'>Completed</option>
        <option value='CANCELLED'>Cancelled</option>";
        foreach ($orders as $order) {
            $count = 1;
            //date
            $date = date_create($order["date_created"]);
            $dateFormatted = date_format($date, "d M Y");

            $orderLines = retrieveAllOrderLines($order["order_id"]);
            $orderLineStr = "";
            foreach ($orderLines as $orderLine) {
                $price = number_format((float)$orderLine["product_price"], 2, ".", ",");

                $orderLineStr .=
                    "<tr class='align-middle'>
    <th scope='row'>$count</th>
    <td><img class='img-fluid w-100' src='{$orderLine["product_image"]}' style='max-width: 200px;'></td>
    <td>{$orderLine["product_name"]}</td>
    <td class='text-center'>{$orderLine["quantity"]}</td>
    <td>$dateFormatted</td>
    <td>RM{$price}</td>
</tr>";
                $count++;
            }
            //code
            $orderCode = sprintf('%08d', $order["order_id"]);
            $total = number_format((float)$order["order_price"], 2, ".", ",");
            $statusSmall = strtolower($order["order_status"]);
            echo "
<div>
<div class='row mt-3 mb-3'>
    <div class='col-5'>
        <span class='h4'>Order #{$orderCode}</span><span class='text-muted h4'> by {$order["username"]}</span>
    </div>
    <div class='col'>
        <div class='row'>
            <div class='col-3 text-end mt-2'>
                <span class='{$statusSmall}'>{$order["order_status"]}</span>
            </div>
            <div class='col'>
               <form method='post' id='{$order["order_id"]}' action='/admin/manage-orders.php'>
               <div class='row offset-1'>
                    <div class='col'>
                        <input type='hidden' name='order_id' value='{$order["order_id"]}'>
                        <select name='status' class='form-select'>$statusOptions</select>      
                    </div>
                    <div class='col'>
                        <input type='hidden' name='token' value='{$_SESSION["token"]}'>
                        <a type='button' data-bs-toggle='modal' data-bs-target='#updateStatic' onclick='updateModal({$order["order_id"]}, \"modal-btn-update\");' class='btn btn-outline-primary'>
                        Update</a>
                    </div>
                </div>
                </form>  
                          
            </div>
            <div class='col-1 mt-2'>
                <form action='/admin/manage-orders.php' id='{$order["order_id"]}' method='post'>
                    <input type='hidden' name='order_id' value='{$order["order_id"]}'>
                    <input type='hidden' name='token' value='{$_SESSION["token"]}'>
                    <a type='button' data-bs-toggle='modal' data-bs-target='#deleteStatic' onclick='updateModal({$order["order_id"]}, \"modal-btn-delete\");' class='h4'>
                    <i class='bi bi-trash'></i></a>
                </form>    
            </div> 
        </div>      
    </div>
</div>
<hr>
<div class='row mb-4'>
    <table class='table'>
    <caption>Delivery Fee: RM5.00</caption>
    <thead>
        <tr>
            <th scope='col'>#</th>
            <th scope='col'>Product</th>
            <th scope='col'>Name</th>
            <th scope='col'>Quantity</th>
            <th scope='col'>Date Ordered</th>
            <th scope='col'>Price</th>
        </tr>
    </thead>
    <tbody>
        {$orderLineStr}
    </tbody>
    <tfoot>
    <td colspan='5'><span class='fw-bold'>Total:</span></td>
    <td>RM{$total}</td>
    </tfoot>
    </table>
</div>
</div>

";
        }
    }
}

//for dashboard admin
function orders_adminOrdersLite($orders) {
    if ($orders != null){
        foreach ($orders as $order) {
            $count = 1;
            //date
            $date = date_create($order["date_created"]);
            $dateFormatted = date_format($date, "d M Y");

            //code
            $orderCode = sprintf('%08d', $order["order_id"]);
            $total = number_format((float)$order["order_price"], 2, ".", ",");
            $statusSmall = strtolower($order["order_status"]);
            echo "
<div>
<div class='row mt-3 mb-1'>
    <div class='col-5'>
        <span class='h4'>Order #{$orderCode}</span><span class='text-muted h4'> by {$order["username"]}</span>
    </div>
    <div class='col'>
        <div class='row'>
            <div class='col-3 text-end mt-2'>
                <span class='{$statusSmall}'>{$order["order_status"]}</span>
            </div>
            <div class='col'>
            <a class='btn btn-outline-primary float-end' href='/admin/manage-orders.php'>See More Options..</a>  
            </div>
        </div>      
    </div>
    
</div>
<div class='row'>
    <div class='col-2 text-end mt-2'>
        <span class='fw-bold'>Total:</span>
    </div>
    <div class='col'>
    <span class='fs-4'>RM{$total}</span>
    </div>
</div>

<hr>
";
        }
    }
}
function admin_displayAdminUsers($adminUsers) {
    if ($adminUsers != null) {
        $count = 1;
        // OKAY, FOR DELETING, I need to use a modal so the user can be sure to remove it
        foreach ($adminUsers as $user) {
            $fullName = $user["user_fname"] . " " . $user["user_lname"];
            $date = date_create($user["registration_date"]);
            $dateFormatted = date_format($date, "d M Y");
            echo
            "<tr class='align-middle'>
                <th scope='row'>$count</th>
                <td>{$user["username"]}</td>
                <td>{$fullName}</td>
                <td>{$user["user_email"]}</td>
                <td>{$dateFormatted}</td>
                <td class='position-relative text-center align-middle'>
                    <div class='position-absolute top-50 start-0 translate-middle-y'>
                        <a type='button' class='h4' href='mailto:{$user["user_email"]}'>
                        <i class='bi bi-envelope'></i></a>
                    </div>
                    <div class='position-absolute top-50 end-0 translate-middle-y'>
                        <form action='/admin/manage-users.php' id='{$user["user_id"]}' method='post'>
                            <input type='hidden' name='user_id' value='{$user["user_id"]}'>
                            <a type='button' data-bs-toggle='modal' data-bs-target='#static' 
                            onclick='updateModal({$user["user_id"]}, \"modal-btn\");' class='h4'>
                            <input type='hidden' name='token' value='{$_SESSION["token"]}'>
                            <i class='bi bi-trash'></i></a>
                        </form> 
                    </div>
                    
                </td>
            </tr>";
            $count++;
        }
    }
}

function admin_displayCustomerUsers($customerUsers) {
    if ($customerUsers != null) {
        $count = 1;
        // OKAY, FOR DELETING, I need to use a modal so the user can be sure to remove it
        foreach ($customerUsers as $user) {
            $fullName = $user["user_fname"] . " " . $user["user_lname"];
            $date = date_create($user["registration_date"]);
            $dateFormatted = date_format($date, "d M Y");

            $address = ($user["user_address"] ?? "") . ", " . ($user["user_postcode"] ?? "")
                        . ", " . ($user["user_city"] ?? "") . ", " . ($user["state_name"] ?? "");
            $phone = $user["user_phone"] ?? "-";
            echo
            "<tr class='align-middle'>
                <th scope='row'>$count</th>
                <td>{$user["username"]}</td>
                <td>{$fullName}</td>
                <td>{$address}</td>
                <td>{$user["user_email"]}</td>
                <td>{$phone}</td>
                <td>{$dateFormatted}</td>
                <td class='position-relative text-center align-middle'>
                    <div class='position-absolute top-50 start-0 translate-middle-y'>
                        <a type='button' class='h4' href='mailto:{$user["user_email"]}'>
                        <i class='bi bi-envelope'></i></a>
                    </div>
                    <div class='position-absolute top-50 start-50 translate-middle'>
                        <a type='button' class='h5' href='https://wa.me/{$phone}'>
                        <i class='bi bi-whatsapp'></i></a>
                    </div>
                    <div class='position-absolute top-50 end-0 translate-middle-y'>
                        <form action='/admin/manage-users.php' id='{$user["user_id"]}' method='post'>
                            <input type='hidden' name='user_id' value='{$user["user_id"]}'>
                            <a type='button' data-bs-toggle='modal' data-bs-target='#static' onclick='updateModal({$user["user_id"]}, \"modal-btn\");' class='h4'>
                            <i class='bi bi-trash'></i></a>
                            <input type='hidden' name='token' value='{$_SESSION["token"]}'>
                        </form> 
                    </div>
                       
                </td>
            </tr>";
            $count++;
        }
    }
}



