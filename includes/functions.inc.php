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
    if (!(returnUserType($_SESSION["user_data"]["user_id"]) == "customer")){
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
    if (!(returnUserType($_SESSION["user_data"]["user_id"]) == "admin")){
        header("Location: /index.php");
        die();
    }
}

//special function to prevent admin from bookings flights & customer from creating flights
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

