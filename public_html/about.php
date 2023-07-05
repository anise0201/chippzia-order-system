<?php
session_start();
require("../includes/functions.inc.php");

displayToast();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php head_tag_content(); ?>
    <title>Kerepek Funz | About Us</title>
</head>
<body>
<?php nav_menu(); ?>
<section id="billboard" class="position-relative overflow-hidden bg-body">
</section>

<div class="container mt-5 py-5">
    <div class="row pt-5">
        <h1>About Kerepek Funz</h1>
        <p class="text-body-secondary">Kerepek Funz is an ecommerce platform dedicated to providing the finest selection of kerepek/snacks from around the world. Our mission is to satisfy your snack cravings with a diverse range of delicious and high-quality kerepek products.</p>
        <p class="text-body-secondary">At Kerepek Funz, we understand the joy of snacking and believe that great snacks can bring people together. That's why we source our kerepek from trusted suppliers, ensuring that each product meets our strict quality standards.</p>
        <p class="text-body-secondary">Whether you're a fan of traditional kerepek or looking to explore new flavors and textures, we have something for everyone. Browse our extensive collection and indulge in the ultimate snacking experience with Kerepek Funz!</p>
    </div>
</div>
<div class=" bg-white">
    <div class="container mt-5 py-5">
        <div class="">
            <h1>Group Members</h1>
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th scope="col">PICTURE</th>
                        <th scope="col">NAME</th>
                        <th scope="col">MATRIC</th>
                        <th scope="col">PHONE</th>
                        <th scope="col">PROGRAM</th>
                        <th scope="col">GROUP</th>
                        <th scope="col">EMAIL</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td><img src="/assets/images/suffian.jpg" alt="" class="img-fluid"></td>
                    <td>MUHAMMAD SUFFIAN BIN ABU BAKAR</td>
                    <td>2021894286</td>
                    <td>011-1156 2807</td>
                    <td>CS110 - DIPLOMA IN COMPUTER SCIENCE</td>
                    <td>A4CS1104A</td>
                    <td>2021894286@student.uitm.edu.my</td>
                </tr>

                <tr>
                    <td><img src="/assets/images/shafiq.jpg" alt="" class="img-fluid" ></td>
                    <td>MUHAMMAD SHAFIQ HAIKAL BIN MOHD SAZALI</td>
                    <td>2021854624</td>
                    <td>013-534 3776</td>
                    <td>CS110 - DIPLOMA IN COMPUTER SCIENCE</td>
                    <td>A4CS1104A</td>
                    <td>2021854624@student.uitm.edu.my</td>
                </tr>

                <tr>
                    <td><img src="/assets/images/aiman.jpg" alt="" class="profileImg"></td>
                    <td>MUHAMMAD AIMAN AKMAL BIN SAMSURI </td>
                    <td>2021462982</td>
                    <td>011-6151 8005</td>
                    <td>CS110 - DIPLOMA IN COMPUTER SCIENCE</td>
                    <td>A4CS1104A</td>
                    <td>2021854624@student.uitm.edu.my</td>
                </tr>

                <tr>
                    <td><img src="/assets/images/yasmin.jpg" alt="" class="img-fluid" ></td>
                    <td>YASMIN SHAZWANI BINTI SOMAD</td>
                    <td>2021848746</td>
                    <td>017-405 8196 </td>
                    <td>CS110 - DIPLOMA IN COMPUTER SCIENCE</td>
                    <td>A4CS1104A</td>
                    <td>202184874@student.uitm.edu.my</td>
                </tr>
                <tr>
                    <td><img src="/assets/images/wafi.jpg" alt="" class="img-fluid" ></td>
                    <td>ABDUL WAFI BIN CHE AB. RAHIM </td>
                    <td>2021828502</td>
                    <td>010-885 7639</td>
                    <td>CS110 - DIPLOMA IN COMPUTER SCIENCE</td>
                    <td>A4CS1104A</td>
                    <td>2021828502@student.uitm.edu.my</td>
                </tr>
                </tbody>


            </table>
        </div>

    </div>
</div>

<?php footer(); ?>


<?php body_script_tag_content(); ?>
</body>
</html>

