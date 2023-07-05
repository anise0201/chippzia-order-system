<?php
session_start();
require("../includes/functions.inc.php");

displayToast();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php head_tag_content(); ?>
    <title>Kerepek Funz | Frequently Asked Question</title>
</head>
<body>
<?php nav_menu(); ?>
<section id="billboard" class="position-relative overflow-hidden bg-body">
</section>

<div class="container mt-5 py-5">
    <div class="row pt-5">
        <h1>Frequently Asked Questions</h1>

        <div class="accordion mt-4" id="faqAccordion">
            <!-- FAQ Item 1 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqHeading1">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1" aria-expanded="true" aria-controls="faqCollapse1">
                        How can I place an order?
                    </button>
                </h2>
                <div id="faqCollapse1" class="accordion-collapse collapse show" aria-labelledby="faqHeading1" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        To place an order, simply visit our website and browse through our selection of kerepek/snacks. Once you have found the items you wish to purchase, add them to your cart and proceed to the checkout page. Follow the instructions to complete your order and make the payment.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqHeading2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2" aria-expanded="false" aria-controls="faqCollapse2">
                        What are the available payment options?
                    </button>
                </h2>
                <div id="faqCollapse2" class="accordion-collapse collapse" aria-labelledby="faqHeading2" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        We accept various payment methods, including credit/debit cards and PayPal. During the checkout process, you will be able to choose your preferred payment option and proceed with the payment securely.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqHeading3">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3" aria-expanded="false" aria-controls="faqCollapse3">
                        How long does shipping take?
                    </button>
                </h2>
                <div id="faqCollapse3" class="accordion-collapse collapse" aria-labelledby="faqHeading3" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Shipping times may vary depending on your location. We strive to process and ship orders within 1-3 business days. Once your order is shipped, the estimated delivery time will be provided to you. Please note that international shipments may take longer due to customs clearance procedures.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqHeading4">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse4" aria-expanded="false" aria-controls="faqCollapse4">
                        What is your return policy?
                    </button>
                </h2>
                <div id="faqCollapse4" class="accordion-collapse collapse" aria-labelledby="faqHeading4" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        We accept returns within 14 days of delivery. If you are not satisfied with your purchase, please contact our customer support team for assistance. Please note that returned items must be in their original condition and packaging. Refunds will be issued once the returned items are received and inspected.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 5 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqHeading5">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse5" aria-expanded="false" aria-controls="faqCollapse5">
                        Can I track my order?
                    </button>
                </h2>
                <div id="faqCollapse5" class="accordion-collapse collapse" aria-labelledby="faqHeading5" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Yes, once your order is shipped, you will receive a tracking number via email. You can use this tracking number to track the progress of your shipment on our website or the shipping carrier's website.
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php footer(); ?>


<?php body_script_tag_content(); ?>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe' crossorigin='anonymous'></script>
<script>
    // Check URL hash and open corresponding accordion item
    const urlHash = window.location.hash;
    if (urlHash) {
        const targetCollapse = document.querySelector(urlHash);
        if (targetCollapse) {
            const accordion = targetCollapse.closest('.accordion');
            const accordionInstance = new bootstrap.Collapse(targetCollapse);
            if (accordion && accordionInstance) {
                accordionInstance.show();
                accordion.scrollIntoView({ behavior: 'smooth' });
                console.log("SHOW!");
            }
        }
    }
</script>
</body>
</html>

