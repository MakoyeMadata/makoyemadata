<?php
include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstname = strtoupper($_POST['firstname']);
    $lastname = strtoupper($_POST['lastname']);
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $location = strtoupper($_POST['location']);
    $date = $_POST['date'];
    $service = $_POST['service_name'];

    // Prepare SQL query
    $sql = "INSERT INTO booking_details (firstname, lastname, phone, email, location, date, service_name)
            VALUES ('$firstname', '$lastname', '$phone', '$email', '$location', '$date', '$service')";

    if ($conn->query($sql) === TRUE) {
        // Retrieve the last inserted booking_id
        $booking_id = $conn->insert_id;

        // Generate booking number based on booking date
        $booking_number = 'NOVA' . str_pad($booking_id, 3, '0', STR_PAD_LEFT) . date('md', strtotime($date)) . date('Y', strtotime($date));

        // Update the booking record with the generated booking number
        $update_sql = "UPDATE booking_details SET booking_number = '$booking_number' WHERE booking_id = $booking_id";
        $conn->query($update_sql);

        // Retrieve the receiver's email address from booking details
        $receiver_email_sql = "SELECT email FROM booking_details WHERE booking_id = $booking_id";
        $result = $conn->query($receiver_email_sql);
        $row = $result->fetch_assoc();
        $receiver_email = $row['email'];

        // Update sendmail.ini with the receiver's email address
        $sendmail_ini_path = 'C:\xampp\sendmail\sendmail.ini'; // Update the path to sendmail.ini
        $sendmail_ini_contents = file_get_contents($sendmail_ini_path);
        $updated_sendmail_ini_contents = preg_replace('/auth_username=(.+)/', 'auth_username=' . $receiver_email, $sendmail_ini_contents);
        
        // Write the updated contents back to sendmail.ini file
        file_put_contents($sendmail_ini_path, $updated_sendmail_ini_contents);

        ?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <!-- Google tag (gtag.js) -->
        <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-NDXR2FZQ');
        </script>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" href="image/nova-logo/favicon-16x16.png" type="image/png">
        <link rel="manifest" href="image/nova-logo/site.webmanifest">
        <title>Novapoint Booking Successful page</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="vendors/linericon/style.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css">
        <link rel="stylesheet" href="vendors/bootstrap-datepicker/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" href="vendors/nice-select/css/nice-select.css">
        <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css">
        <!-- main css -->
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/responsive.css">
      <style>
            .whatsapp-button {
                position: fixed;
                bottom: 20px; /* Adjust as needed */
                right: 20px; /* Adjust as needed */
                z-index: 9999; /* Ensure it appears above other content */
            }

            .whatsapp-button i {
                font-size: 50px; /* Adjust the size of the WhatsApp icon */
                color: green;
                }
                 /* Additional CSS styles can be added here */

        </style>
    </head>
    <body>
        <!--================Header Area =================-->
        <header class="header_area">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <a class="navbar-brand logo_h" href="index.html"><img src="image/nova-logo/nova.png" width="75" height="60" alt="Novapoint"><b><strong> NOVAPOINT CONSULT</strong></b></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                     <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                        <ul class="nav navbar-nav menu_nav ml-auto">
                            <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li> 
                            <li class="nav-item"><a class="nav-link" href="about.html">About us</a></li>

                            <li class="nav-item submenu dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Our Services</a>
                                <ul class="dropdown-menu">
                                    <li class="nav-item"><a class="nav-link" href="MarketingConsultancy.html">Marketing Consultancy</a></li>
                                    <li class="nav-item"><a class="nav-link" href="BusinessConsultancy.html">Business Consultancy</a></li>
                                    <li class="nav-item"><a class="nav-link" href="IctServices.html">ICT Services</a></li>
                                    <li class="nav-item"><a class="nav-link" href="ProjectPlanning.html">Project Planning& Management</a></li>
                                    <li class="nav-item"><a class="nav-link" href="AgriculturalConsultancy.html">Agricultural Consultancy</a></li>
                                    <li class="nav-item"><a class="nav-link" href="Procurement.html">Procurement & Supply Consultancy</a></li>
                                    <li class="nav-item"><a class="nav-link" href="AccountingConsultancy.html">AccountingConsultancy</a></li>
                                     <li class="nav-item"><a class="nav-link" href="TaxConsultancy.html">Tax Consultancy</a></li>
                                </ul>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="gallery.html">Gallery</a></li>
                            <li class="nav-item submenu dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Blog</a>
                                <ul class="dropdown-menu">
                                    <li class="nav-item"><a class="nav-link" href="#blog.html">Blog</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#blog-single.html">Blog Details</a></li>
                                </ul>
                            </li> 
                            <li class="nav-item submenu dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Our Products</a>
                                <ul class="dropdown-menu">
                                    <li class="nav-item"><a class="nav-link" href="##https://play.google.com/store/apps/details?id=your.package.name">Nova Sale</a></li>
                                </ul>
                            </li>
                            <li class="nav-item active"><a class="nav-link" href="contact.html">Contact</a></li>
                            <li class="nav-item submenu dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Find Us</a>
                                <ul class="dropdown-menu">
                                    <li class="nav-item"><a class="nav-link" href="https://www.youtube.com/channel/UCQjs4dlpvNayCJWCQJ9u4gA">Youtube</a></li>
                                    <li class="nav-item"><a class="nav-link" href="https://www.instagram.com/novapointconsult_ltd">Instagram</a></li>
                                    <li class="nav-item"><a class="nav-link" href="https://tiktok.com/@novapoint.consult">Tik Tok</a></li>
                                    <li class="nav-item"><a class="nav-link" href="https://facebook.com/Novapoint.Consult">Facebook</a></li>
                                    <li class="nav-item"><a class="nav-link" href="https://www.linkedin.com/company/novapoint-consult">Linkedin</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#">Twitter</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div> 
                </nav>
            </div>
        </header>
        <!--================Header Area =================-->
         <!--================Breadcrumb Area =================-->
        <section class="breadcrumb_area">
            <div class="overlay bg-parallax" data-stellar-ratio="0.8" data-stellar-vertical-offset="0" data-background=""></div>
            <div class="container">
                <div class="page-cover text-center">
                    <h2 class="page-cover-tittle">Booking Details</h2>
                    <ol class="breadcrumb">
                        <li><a href="index.html">Home</a></li>
                        <li class="active">Services</li>
                    </ol>
                </div>
            </div>
        </section>
        <body>
            <hr><br>
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Booking Details:</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>First Name:</strong> <?php echo $firstname; ?></p>
                                <p><strong>Last Name:</strong> <?php echo $lastname; ?></p>
                                <p><strong>Phone:</strong> <?php echo $phone; ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Email:</strong> <?php echo $email; ?></p>
                                <p><strong>Location:</strong> <?php echo $location; ?></p>
                                <p><strong>Date:</strong> <?php echo $date; ?></p>
                                <p><strong>Service:</strong> <?php echo $service; ?></p>
                                <p><strong>Booking Number:</strong> <?php echo $booking_number; ?></p>
                            </div>
                        </div>
                        <p>Booking successfully submitted.</p>
                        <p><em><i>Dear <?php echo $firstname . ' ' . $lastname; ?>, wait for your details to be processed. You will be notified within one day.</i></em></p>
                        <div><a href="index.html" class="btn btn-primary">Back to Home</a></div><hr><br>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    // Redirect or display an error message if the form was not submitted properly
    echo "Error: Form was not submitted.";
}

// Close connection
$conn->close();
?>
<html>
    <head>
            <!-- Required meta tags -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="icon" href="image/favicon-16x16.png" type="image/png">
            <title>Nova point</title>
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="css/bootstrap.css">
            <link rel="stylesheet" href="vendors/linericon/style.css">
            <link rel="stylesheet" href="css/font-awesome.min.css">
            <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css">
            <link rel="stylesheet" href="vendors/bootstrap-datepicker/bootstrap-datetimepicker.min.css">
            <link rel="stylesheet" href="vendors/nice-select/css/nice-select.css">
            <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css">
            <!-- main css -->
            <link rel="stylesheet" href="css/style.css">
            <link rel="stylesheet" href="css/responsive.css">
    </head>
    <body>

    




       <div class="whatsapp-button">
            <a href="https://api.whatsapp.com/send?phone=255742808022" target="_blank">Quick Reply
                <i class="fa fa-whatsapp" style="font-size:48px;color: green"></i>
            </a>
        </div>


                 <!--================ start footer Area  =================-->   
                 <footer class="footer-area section_gap">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3  col-md-6 col-sm-6">
                                <div class="single-footer-widget">
                                    <h6 class="footer_title">About Company</h6>
                                    <p>"Today's business landscape moves at an unprecedented pace, demanding concise and impactful communication. People no longer have the patience for lengthy texts; they seek clarity and insight that resonate instantly."</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="single-footer-widget">
                                    <h6 class="footer_title">Navigation Links</h6>
                                    <div class="row">
                                        <div class="col-4">
                                            <ul class="list_style">
                                                <li><a href="index.html">Home</a></li>
                                                <li><a href="about.html">About us</a></li>
                                                <li><a href="MarketingConsultancy.html">Services</a></li>
                                                <li><a href="gallery.html">Gallery</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-4">
                                            <ul class="list_style">
                                                <li><a href="about.html">Team</a></li>
                                                <li><a href="#">Products</a></li>
                                                <li><a href="#">Blog</a></li>
                                                <li><a href="contact.html">Contact</a></li>
                                            </ul>
                                        </div>                                      
                                    </div>                          
                                </div>
                            </div>                          
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <h6 class="footer_title">Services Delivered</h6>
                                <marquee behavior="scroll" direction="left" scrollamount="5">
                                    <canvas id="myCanvas" width="400" height="100"></canvas>
                                </marquee>
                            </div>                 
                                                                  
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="single-footer-widget instafeed">
                                <h6 class="footer_title">InstaFeed</h6>
                                <ul class="list_style instafeed d-flex flex-wrap">
                                    <li><img src="image/instagram/image-01.jpg" width="50" height="50" alt="Feeds1"></li>
                                    <li><img src="image/instagram/image-02.jpg" width="50" height="50" alt="Feeds2"></li>
                                    <li><img src="image/instagram/image-03.jpg" width="50" height="50" alt="Feeds3"></li>
                                    <li><img src="image/instagram/image-04.jpg" width="50" height="50" alt="Feeds4"></li>
                                    <li><img src="image/instagram/image-05.jpg" width="50" height="50" alt="Feeds5"></li>
                                    <li><img src="image/instagram/image-06.jpg" width="50" height="50" alt="Feeds6"></li>
                                    <li><img src="image/instagram/image-07.jpg" width="50" height="50" alt="Feeds7"></li>
                                    <li><img src="image/instagram/image-08.jpg" width="50" height="50" alt="Feeds8"></li>
                                </ul>
                            </div>
                        </div>                      
                    </div>
                    <div class="border_line"></div>
                    <div class="row footer-bottom d-flex justify-content-between align-items-center">
                        <p class="col-lg-8 col-sm-12 footer-text m-0"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                       Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This Website is made <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://mailto:madata@novapointconsult.com" target="_blank">NOVAPOINT IT UNITS</a>
                       <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                        <div class="col-lg-4 col-sm-12 footer-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="https://www.instagram.com/novapointconsult_ltd"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="https://www.linkedin.com/company/novapoint-consult"><i class="fa fa-linkedin"></i></a>
                            <a href="https://www.youtube.com/channel/UCQjs4dlpvNayCJWCQJ9u4gA"><i class="fa fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </footer>
            <!--================ End footer Area  =================-->
               
               <!--================Contact Success and Error message Area =================-->
                <div id="success" class="modal modal-message fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h2>Thank you</h2>
                                <p>Your message is successfully sent...</p>
                            </div>
                        </div>
                    </div>
                </div>
        
                <!-- Modals error -->
        
                <div id="error" class="modal modal-message fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h2>Sorry !</h2>
                                <p> Something went wrong </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--================End Contact Success and Error message Area =================-->
                
                
                <!-- Optional JavaScript -->
                <!-- jQuery first, then Popper.js, then Bootstrap JS -->
                <script src="js/jquery-3.2.1.min.js"></script>
                <script src="js/popper.js"></script>
                <script src="js/bootstrap.min.js"></script>
                <script src="vendors/owl-carousel/owl.carousel.min.js"></script>
                <script src="js/jquery.ajaxchimp.min.js"></script>
                <script src="vendors/bootstrap-datepicker/bootstrap-datetimepicker.min.js"></script>
                <script src="vendors/nice-select/js/jquery.nice-select.js"></script>
                <script src="js/mail-script.js"></script>
                <script src="js/stellar.js"></script>
                <script src="vendors/imagesloaded/imagesloaded.pkgd.min.js"></script>
                <script src="vendors/isotope/isotope-min.js"></script>
                <script src="js/stellar.js"></script>
                <script src="vendors/lightbox/simpleLightbox.min.js"></script>
                <!--gmaps Js-->
                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
                <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

                <script src="js/gmaps.min.js"></script>
                <!-- contact js -->
                <script src="js/jquery.form.js"></script>
                <script src="js/jquery.validate.min.js"></script>
                <script src="js/contact.js"></script>
                <script src="js/custom.js"></script>
                <script>
                    // Function to update all date elements dynamically
                    function updateDates() {
                        // Get all date elements within the specified section
                        var dateElements = document.querySelectorAll('#latest_blog_area .date');
                
                        // Loop through each date element
                        dateElements.forEach(function(dateElement) {
                            // Get the current date
                            var currentDate = new Date();
                
                            // Get the date mentioned in the HTML
                            var dateInHTML = new Date(dateElement.textContent);
                
                            // Check if the current date is different from the date in the HTML
                            if (currentDate.getDate() !== dateInHTML.getDate() ||
                                currentDate.getMonth() !== dateInHTML.getMonth() ||
                                currentDate.getFullYear() !== dateInHTML.getFullYear()) {
                                // If the dates are different, update the content
                                var day = currentDate.getDate();
                                var month = currentDate.toLocaleString('default', { month: 'long' });
                                var year = currentDate.getFullYear();
                                var newDate = day + " " + month + ", " + year;
                
                                // Update the HTML content with the new date
                                dateElement.textContent = newDate;
                            }
                        });
                    }
                
                    // Call the function to update all dates dynamically
                    updateDates();
                         // Function to draw count on canvas
                         function drawCountOnCanvas(count) {
                                var canvas = document.getElementById('myCanvas');
                                var ctx = canvas.getContext('2d');
                                
                                // Clear canvas
                                ctx.clearRect(0, 0, canvas.width, canvas.height);
                                
                                // Style for text
                                ctx.font = 'bold 18px Arial';
                                ctx.fillStyle = '#f79c24'; //  color
                                
                                // Calculate position for the first line of text
                                var text1 = 'Services Delivered:';
                                var text1Width = ctx.measureText(text1).width;
                                var text1X = (canvas.width - text1Width) / 2;
                                var text1Y = 30; // Y position for the first line
                                
                                // Calculate position for the second line of text (count)
                                var text2 = count.toString(); // Convert count to string
                                var text2Width = ctx.measureText(text2).width;
                                var text2X = (canvas.width - text2Width) / 2;
                                var text2Y = text1Y + 20; // Y position for the second line
                                
                                // Draw the first line of text
                                ctx.fillText(text1, text1X, text1Y);
                                
                                // Draw the second line of text (count)
                                ctx.fillText(text2, text2X, text2Y);
                            }
                        
                            // Function to fetch and update count
                            function updateCount() {
                                // Make an AJAX request to your backend API endpoint to get the count
                                $.ajax({
                                    url: 'getServicesCount.php',//backend API
                                    type: 'GET',
                                    success: function(response) {
                                        // Update count on canvas
                                        drawCountOnCanvas(response.count);
                                    },
                                    error: function(error) {
                                        console.error('Error fetching count:', error);
                                    }
                                });
                            }
                        
                            // Call updateCount function initially
                            updateCount();
                        
                            // Call updateCount function every 10 seconds
                            setInterval(updateCount, 10000); // 10 seconds (10 * 1000 milliseconds)
                </script>
            </body>
        </html>