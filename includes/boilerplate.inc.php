<?php
function head_tag_content(): void
{
    //bootstrap,boxicons, jquery, toastr
    echo "
    <meta charset='UTF-8'>
    <meta content='width=device-width, initial-scale=1, maximum-scale=5,minimum-scale=1, viewport-fit=cover' name='viewport'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ' crossorigin='anonymous'>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe' crossorigin='anonymous'></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.css' integrity='sha512-oe8OpYjBaDWPt2VmSFR+qYOdnTjeV9QPLJUeqZyprDEQvQLJ9C5PCFclxwNuvb/GQgQngdCXzKSFltuHD3eCxA==' crossorigin='anonymous' referrerpolicy='no-referrer' />
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css'>
    <link rel='stylesheet' href='/assets/css/style.css'>
    <link rel='stylesheet' href='/assets/css/main.css'>
     ";
}

function body_script_tag_content() {
    echo "
    <script src='https://code.jquery.com/jquery-3.7.0.min.js' integrity='sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=' crossorigin='anonymous'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js' integrity='sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==' crossorigin='anonymous' referrerpolicy='no-referrer'></script>
    <script src='https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js'></script>
    <script src='/assets/js/main.js'></script>
    ";
}


//This header is specifically for side_bar(), so it is  only to be used in conjunction with side_bar
function header_bar($pageName){
    echo "<div class='navbar navbar-expand-lg shadow bg-white sticky-top'>
        <div class='container-fluid w-100'>
            <div class='d-flex'>
                <span class='navbar-brand order-first mb-4'>
                    <a data-bs-target='#sidebar' data-bs-toggle='collapse' class='border rounded-3 p-3 text-decoration-none'><i class='bi bi-list bi-lg py-2 p-1 text-black'></i></a>
                    <span class='fs-2 ms-3'>{$pageName}</span>
                </span>
            </div>
            <div class='navbar-nav ms-auto order-las'>
                <form class='d-flex' role='search'>
                    <input class='form-control me-2' type='search' name='q' placeholder='Search' aria-label='Search'>
                    <button class='btn btn-outline-success' type='submit'>Search</button>
                </form>
            </div>
        </div>
    </div>";
}

function side_bar() {
    $iconSize = "h4";
    echo "<div id='sidebar' class='collapse collapse-horizontal show border-end sticky-top'>
    <div class='d-flex flex-column flex-shrink-0 p-3 bg-light vh-100 sidebar mx-w-100'>
        <div class='row gx-3'>
            <div class='col-5'>
                <a href='/' class='d-flex align-items-center me-md-auto link-dark text-decoration-none'>
                    <img class='me-2' width='150' height='73' src='/assets/images/icon2.jpg'>
                </a>
            </div>
            <div class='col d-sm-none'>
                <button data-bs-target='#sidebar' data-bs-toggle='collapse' type='button' class='btn-close'></button>
            </div>
        </div>
        
        <hr>
        <ul class='nav nav-pills flex-column mb-auto'>
            <li class='nav-item'>
                <a href='/' class='nav-link link-dark'>
                    <i class='bi bi-house-door me-2 $iconSize'></i>
                    Home
                </a>
            </li>
            <li>
                <a href='/account/dashboard.php' class='nav-link link-dark'>
                    <i class='bi bi-speedometer2 me-2 $iconSize'></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href='/account/orders.php' class='nav-link link-dark'>
                    <i class='bi bi-basket2 me-2 $iconSize'></i>
                    Orders
                </a>
            </li>
            <li>
                <a href='/account/shop.php' class='nav-link link-dark'>
                    <i class='bi bi-cart me-2 $iconSize'></i>
                    Shop
                </a>
            </li>
            <li>
                <a href='/account/profile.php' class='nav-link link-dark'>
                    <i class='bi bi-people me-2 $iconSize'></i>
                    Profile
                </a>
            </li>
        </ul>
        <hr>
        <div class='dropdown'>
            <a href='#' class='d-flex align-items-center link-dark text-decoration-none dropdown-toggle' id='dropdownUser2' data-bs-toggle='dropdown' aria-expanded='false'>
                <img src='/assets/images/default-profile.svg' alt='' width='32' height='32' class='rounded-circle me-2'>
                <strong>{$_SESSION["user_data"]["username"]}</strong>
            </a>
            <ul class='dropdown-menu text-small shadow' aria-labelledby='dropdownUser2'>
                <li><a class='dropdown-item' href='/account/profile.php'>Profile</a></li>
                <li><hr class='dropdown-divider'></li>
                <li><a class='dropdown-item' href='/logout.php'>Log out</a></li>
            </ul>
            
        </div>
    </div>
</div>";
}

//This header is specifically for admin (same thing just for admins)
function admin_header_bar($pageName){
    echo "<div class='navbar navbar-expand-lg shadow navbar-white bg-white sticky-top'>
        <div class='container-fluid w-100'>
            <div class='d-flex align-middle'>
                <span class='navbar-brand order-first mb-4'>
                    <a data-bs-target='#sidebar' data-bs-toggle='collapse' class='border rounded-3 p-3 text-decoration-none'><i class='bi bi-list bi-lg py-2 p-1 text-black'></i></a>
                    <span class='fs-2 ms-3 pt-2'>{$pageName}</span>
                </span>
            </div>
            <div class='navbar-nav ms-auto order-las'>
                <form class='d-flex' role='search' action='/admin/search.php'>
                    <input class='form-control me-2' type='search' name='q' placeholder='Search' aria-label='Search'>
                    <button class='btn btn-outline-success' type='submit'>Search</button>
                </form>
            </div>
        </div>
    </div>";
}

function admin_side_bar() {
    $iconSize = "h4";
    echo "
<div id='sidebar' class='collapse collapse-horizontal show border-end sticky-top'>
    <div class='d-flex flex-column flex-shrink-0 p-3 bg-light vh-100 sidebar mx-w-100'>
        <div class='row gx-3'>
            <div class='col-5'>
                <a href='/' class='d-flex align-items-center me-md-auto link-dark text-decoration-none'>
                    <img class='me-2' width='150' height='73' src='/assets/images/icon2.jpg'>
                </a>
            </div>
            <div class='col d-sm-none'>
                <button data-bs-target='#sidebar' data-bs-toggle='collapse' type='button' class='btn-close'></button>
            </div>
        </div>
        
        <hr>
        <ul class='nav nav-pills flex-column mb-auto'>
            <li class='nav-item'>
                <a href='/' class='nav-link link-dark'>
                    <i class='bi bi-house-door me-2 $iconSize'></i>
                    Home
                </a>
            </li>
            <li>
                <a href='/admin/dashboard.php' class='nav-link link-dark'>
                    <i class='bi bi-speedometer2 me-2 $iconSize'></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href='/admin/manage-orders.php' class='nav-link link-dark'>
                    <i class='bi bi-cart-check me-2 $iconSize'></i>
                    Orders
                </a>
            </li>
            <li>
                <a href='/admin/manage-products.php' class='nav-link link-dark'>
                    <i class='bi bi-box-seam me-2 $iconSize'></i>
                    Products
                </a>
            </li>
            <li>
                <a href='/admin/manage-users.php' class='nav-link link-dark'>
                    <i class='bi bi-people me-2 $iconSize'></i>
                    Users
                </a>
            </li>
        </ul>
        <hr>
        <div class='dropdown'>
            <a href='#' class='d-flex align-items-center link-dark text-decoration-none dropdown-toggle' id='dropdownUser2' data-bs-toggle='dropdown' aria-expanded='false'>
                <img src='/assets/images/default-profile.svg' alt='' width='32' height='32' class='rounded-circle me-2'>
                <strong>{$_SESSION["user_data"]["username"]}</strong>
            </a>
            <ul class='dropdown-menu text-small shadow' aria-labelledby='dropdownUser2'>
                <li><a class='dropdown-item' href='/logout.php'>Log out</a></li>
            </ul>
        </div>
    </div>
</div>";
}


function footer(){
    $date = date("Y");
    echo "
    <footer id='footer' class='overflow-hidden d-flex flex-wrap justify-content-between align-items-center py-5 border-top'>
      <div class='container'>
        <div class='row'>
          <div class='footer-top-area'>
            <div class='row d-flex flex-wrap justify-content-between'>
              <div class='col-lg-3 col-sm-6 pb-3'>
                <div class='footer-menu'>
                  <p>Kerepek FUNZ</p>
                  <p>MORE KEREPEK, MORE FUNZ!</p>
                  <div class='social-links'>
                    <ul class='d-flex list-unstyled'>
                      <li>
                        <a href='#'>
                          <svg class='facebook'>
                            <use xlink:href='#facebook' />
                          </svg>
                        </a>
                      </li>
                      <li>
                        <a href='#'>
                          <svg class='instagram'>
                            <use xlink:href='#instagram' />
                          </svg>
                        </a>
                      </li>
                      <li>
                        <a href='#'>
                          <svg class='twitter'>
                            <use xlink:href='#twitter' />
                          </svg>
                        </a>
                      </li>
                      <li>
                        <a href='#'>
                          <svg class='linkedin'>
                            <use xlink:href='#linkedin' />
                          </svg>
                        </a>
                      </li>
                      <li>
                        <a href='#'>
                          <svg class='youtube'>
                            <use xlink:href='#youtube' />
                          </svg>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class='col-lg-2 col-sm-6 pb-3'>
                <div class='footer-menu text-uppercase'>
                  <h5 class='widget-title pb-2'>Quick Links</h5>
                  <ul class='menu-list list-unstyled text-uppercase'>
                    <li class='menu-item pb-2'>
                      <a href='#'>Home</a>
                    </li>
                    <li class='menu-item pb-2'>
                      <a href='#'>About</a>
                    </li>
                    <li class='menu-item pb-2'>
                      <a href='#'>Shop</a>
                    </li>
                    <li class='menu-item pb-2'>
                      <a href='#'>Blogs</a>
                    </li>
                    <li class='menu-item pb-2'>
                      <a href='#'>Contact</a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class='col-lg-3 col-sm-6 pb-3'>
                <div class='footer-menu text-uppercase'>
                  <h5 class='widget-title pb-2'>Help & Info Help</h5>
                  <ul class='menu-list list-unstyled'>
                    <li class='menu-item pb-2'>
                      <a href='#'>Track Your Order</a>
                    </li>
                    <li class='menu-item pb-2'>
                      <a href='#'>Returns Policies</a>
                    </li>
                    <li class='menu-item pb-2'>
                      <a href='#'>Shipping + Delivery</a>
                    </li>
                    <li class='menu-item pb-2'>
                      <a href='#'>Contact Us</a>
                    </li>
                    <li class='menu-item pb-2'>
                      <a href='#'>Faqs</a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class='col-lg-3 col-sm-6 pb-3'>
                <div class='footer-menu contact-item'>
                  <h5 class='widget-title text-uppercase pb-2'>Contact Us</h5>
                  <p>Do you have any queries or suggestions? <a href='mailto:'>kerepekfunz@gmail.com</a>
                  </p>
                  <p>If you need support? Just give us a call. <a href=''>+6012 534 56789</a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr>
    </footer>
    <div id='footer-bottom'>
      <div class='container'>
        <div class='row d-flex flex-wrap justify-content-between'>
          <div class='col-md-4 col-sm-6'>
            <div class='Shipping d-flex'>
              <p>We ship with:</p>
              <div class='card-wrap ps-2'>
                <img src='/assets/images/dhl.png' alt='visa'>
              </div>
            </div>
          </div>
          <div class='col-md-4 col-sm-6'>
            <div class='payment-method d-flex'>
              <p>Payment options:</p>
              <div class='card-wrap ps-2'>
                <img src='/assets/images/visa.jpg' alt='visa'>
                <img src='/assets/images/mastercard.jpg' alt='mastercard'>
                <img src='/assets/images/paypal.jpg' alt='paypal'>
              </div>
            </div>
          </div>
          <div class='col-md-4 col-sm-6'>
            <div class='copyright'>
              <p>© Copyright {$date} Kerepek FUNZ.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    ";
}

