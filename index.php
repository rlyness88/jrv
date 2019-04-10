<?
require 'inc/inc.funcs.php';
$db = new db(); //new database connection
session_start();
$token = new token();

$portfolioitems = $db->select('spGetAllPortfolioItems');

$about1 = $db->select('spGetSettingByCode', array('ABT1'));
$a1 = $about1[0]['settingValue'];

$about2 = $db->select('spGetSettingByCode', array('ABT2'));
$a2 = $about2[0]['settingValue'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <? incFavIcon(); ?>
    <title><?=Constants::SITENAME ?></title>

    <!--INCLUDES-->
    <link href="res/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="res/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="res/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <link href='res/full-calendar/css/fullcalendar.css' rel='stylesheet' />
    <link href='res/full-calendar/css/fullcalendar.print.css' rel='stylesheet' media='print' />
</head>

<body id="page-top">

    <!--prevent CSRF-->
    <? $token->field(); ?>

    <!--main navigation bar-->
    <nav class="navbar navbar-expand-lg bg-secondary fixed-top text-uppercase" id="mainNav">
        <div class="container">
            <img class="img-fluid mb-0" style="width: 20%; height 20%" src="img/logo.png" alt="">
            <button class="text-uppercase navbar-toggler navbar-toggler-right bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponse" aria-controls="navbarResponse" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#about">About Me</a>
                    </li>
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#portfolio">Portfolio</a>
                    </li><li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#book">Book</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="masthead bg-primary text-white text-center">
        <div class="container">
            <img class="img-fluid mb-5 d-block mx-auto" src="img/newlogo.png" alt="">
            <h1 class="text-uppercase mb-0">Jake Russell Valet</h1>
            <hr class="star-light">
            <h2 class="font-weight-light mb-0">Covering Greater Surrey</h2>
        </div>
    </header>

    <!-- About Section -->
    <section class="mb-0" id="about">
        <div class="container">
            <h2 class="text-center text-secondary text-uppercase">About Me</h2>
            <hr class="star-dark mb-5">
            <img class="img-fluid mb-5 d-block mx-auto" src="img/jake.png" alt="" />
            <div class="row">
                <div class="col-lg-4 ml-auto">
                    <p class="lead"><?=$a1 ?></p>
                </div>
                <div class="col-lg-4 mr-auto">
                    <p class="lead"><?=$a2 ?></p>
                </div>
            </div>
            <div class="text-center mt-4">
                <a class="btn bg-primary btn-xl btn-outline-light js-scroll-trigger" href="#contact">
                    <i class="fas fa-download mr-2"></i>
                    Contact Me
                </a>
            </div>
        </div>
    </section>

    <!--portfolio grid-->
    <section class="portfolio bg-primary" id="portfolio">
        <div class="container">
            <h2 class="text-center text-white text-uppercase mb-0">Portfolio</h2>
            <hr class="star-light mb-5">
            <div class="row">
                <?
                foreach ($portfolioitems as $i) {
                    ?>
                    <div class="col-md-6 col-lg-4">
                        <a class="portfolio-item d-block mx-auto" href="#portfolio-modal-<?=$i['id'] ?>">
                            <div class="portfolio-item-caption d-flex position-absolute h-100 w-100">
                                <div class="portfolio-item-caption-content my-auto w-100 text-center text-white">
                                    <i class="fas fa-search-plus fa-3x"></i>
                                </div>
                            </div>
                            <img class="img-fluid" src="img/portfolio/<?=$i['thumbnail'] ?>" alt="">
                        </a>
                    </div>
                    <?
                }
                ?>
            </div>
        </div>
    </section>

    <!--contact section-->
    <section id="contact">
        <div class="container">
            <h2 class="text-center text-secondary text-uppercase mb-0">Contact Me</h2>
            <hr class="star-dark mb-5">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <form name="sentMessage" id="contactForm" novalidate="novalidate">
                        <div class="control-group">
                            <div class="form-group floating-label-form-group controls mb-0 pb-2">
                                <label>Name</label>
                                <input class="form-control" id="name" type="text" placeholder="Name" required="required" data-validation-required-message="Please enter your name.">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="form-group floating-label-form-group controls mb-0 pb-2">
                                <label>Email Address</label>
                                <input class="form-control" id="email" type="email" placeholder="Email Address" required="required" data-validation-required-message="Please enter your email address.">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="form-group floating-label-form-group controls mb-0 pb-2">
                                <label>Phone Number</label>
                                <input class="form-control" id="phone" type="tel" placeholder="Phone Number" required="required" data-validation-required-message="Please enter your phone number.">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="form-group floating-label-form-group controls mb-0 pb-2">
                                <label>Message</label>
                                <textarea class="form-control" id="message" rows="5" placeholder="Message" required="required" data-validation-required-message="Please enter a message."></textarea>
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <br>
                        <div id="success"></div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-xl" id="sendMessageButton">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!--make a booking-->
    <section id="book" class="bg-primary">
        <div class="container">
            <h2 class="text-center text-white text-uppercase mb-0">Check My Availability</h2>
            <hr class="star-light mb-5">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!-- Portfolio Modals -->
    <?
    foreach ($portfolioitems as $i) {
        ?>
        <div class="portfolio-modal mfp-hide" id="portfolio-modal-<?=$i['id'] ?>">
            <div class="portfolio-modal-dialog bg-white">
                <a class="close-button d-none d-md-block portfolio-modal-dismiss" href="#">
                    <i class="fa fa-3x fa-times"></i>
                </a>
                <div class="container text-center">
                    <div class="row">
                        <div class="col-lg-8 mx-auto">
                            <h2 class="text-secondary text-uppercase mb-0"><?=$i['title'] ?></h2>
                            <hr class="star-dark mb-5">
                            <img class="img-fluid mb-5" src="img/cars/<?=$i['mainImage'] ?>" alt="">
                            <p class="mb-5"><?=$i['body'] ?></p>
                            <a class="btn btn-primary btn-lg rounded-pill portfolio-modal-dismiss" href="#">
                                <i class="fa fa-close"></i>
                                Close</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?
    }
    ?>
    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-5 mb-lg-0">
                    <h4 class="text-uppercase mb-4">Location</h4>
                    <p class="lead mb-0">Walton-On-Thames, Surrey</p>
                </div>
                <?
                $instagram = $db->select('spGetSettingByCode', array('SMIN'));
                $in = $instagram[0]['settingValue'];

                $twitter = $db->select('spGetSettingByCode', array('SMTW'));
                $tw = $twitter[0]['settingValue'];

                $facebook = $db->select('spGetSettingByCode', array('SMFB'));
                $fb = $facebook[0]['settingValue'];

                $linkedin = $db->select('spGetSettingByCode', array('SMLI'));
                $li = $linkedin[0]['settingValue'];

                $other = $db->select('spGetSettingByCode', array('SMOT'));
                $ot = $other[0]['settingValue'];

                $othericon = $db->select('spGetSettingByCode', array('SMOI'));
                $oti = $othericon[0]['settingValue'];

                $othl = $db->select('spGetSettingByCode', array('OTHL'))[0]['settingValue'];
                $otht = $db->select('spGetSettingByCode', array('OTHT'))[0]['settingValue'];
                ?>
                <div class="col-md-4 mb-5 mb-lg-0">
                    <h4 class="text-uppercase mb-4">Around the Web</h4>
                    <ul class="list-inline mb-0">
                        <? if (!empty($fb)) { ?>
                        <li class="list-inline-item">
                            <a class="btn btn-outline-light btn-social text-center rounded-circle" href="<?=$fb ?>" target="_blank">
                                <i class="fab fa-fw fa-facebook-f"></i>
                            </a>
                        </li>
                        <? } ?>
                        <? if (!empty($in)) { ?>
                        <li class="list-inline-item">
                            <a class="btn btn-outline-light btn-social text-center rounded-circle" href="<?=$in ?>" target="_blank">
                                <i class="fab fa-fw fa-instagram"></i>
                            </a>
                        </li>
                        <? } ?>
                        <? if (!empty($tw)) { ?>
                        <li class="list-inline-item">
                            <a class="btn btn-outline-light btn-social text-center rounded-circle" href="<?=$tw ?>" target="_blank">
                                <i class="fab fa-fw fa-twitter"></i>
                            </a>
                        </li>
                        <? } ?>
                        <? if (!empty($li)) { ?>
                        <li class="list-inline-item">
                            <a class="btn btn-outline-light btn-social text-center rounded-circle" href="<?=$li ?>" target="_blank">
                                <i class="fab fa-fw fa-linkedin-in"></i>
                            </a>
                        </li>
                        <? } ?>
                        <? if (!empty($ot)) { ?>
                        <li class="list-inline-item">
                            <a class="btn btn-outline-light btn-social text-center rounded-circle" href="<?=$ot ?>" target="_blank">
                                <i class="fab fa-fw <?=$oti ?>"></i>
                            </a>
                        </li>
                        <? } ?>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h4 class="text-uppercase mb-4"><?=$othl ?></h4>
                    <p class="lead mb-0"><?=$otht ?></p>
                </div>
            </div>
        </div>
    </footer>

    <div class="copyright py-4 text-center text-white">
        <div class="container">
            <small>Copyright &copy; JAKE 2019 (<?=Constants::VERSION ?>)</small>
        </div>
    </div>

    <!-- Booking Modal -->
    <div class="modal fade bd-example-modal-sm" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="bookingModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Make a Booking</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="card">
                        <input type="hidden" id="booking-id" />
                        <input type="hidden" id="booking-date" />
                        <h3 class="card-header" id="bookingTitle">Text Details</h3>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="booking-custName" class="col-form-label">Full Name</label>
                                <input id="booking-custName" name="booking-custName" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="booking-number" class="col-form-label">Phone Number</label>
                                <input id="booking-number" name="booking-number" type="text" class="form-control" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="booking-email" class="col-form-label">Email Address</label>
                                <input id="booking-email" name="booking-email" type="email" class="form-control" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="booking-time" class="col-form-label">Preferred Time</label>
                                <input id="booking-time" name="booking-time" type="text" class="form-control" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="make-booking-save" class="btn btn-primary">Book</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
    <div class="scroll-to-top d-lg-none position-fixed ">
        <a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top">
            <i class="fa fa-chevron-up"></i>
        </a>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="res/jquery/jquery.min.js"></script>
    <script src="res/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="res/jquery-easing/jquery.easing.min.js"></script>
    <script src="res/magnific-popup/jquery.magnific-popup.min.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>

    <!-- Custom scripts -->
    <script src="js/custom.js"></script>

    <!--calendar stuffs-->
    <script src='res/full-calendar/js/moment.min.js'></script>
    <script src='res/full-calendar/js/fullcalendar.js'></script>
    <script src='res/full-calendar/js/jquery-ui.min.js'></script>
    <script src='res/full-calendar/js/calendar.js'></script>

</body>
</html>