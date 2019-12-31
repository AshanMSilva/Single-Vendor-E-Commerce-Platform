<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Favicon-->
	<link rel="shortcut icon" href="<?=PROOT?>img/fav.png">
	<!-- Author Meta -->
	<meta name="author" content="3-idiots+kaveesha">
	<!-- Meta Description -->
	<meta name="description" content="">
	<!-- Meta Keyword -->
	<meta name="keywords" content="">
	<!-- meta character set -->
	<meta charset="UTF-8">
	<!-- Site Title -->
	<title><?= $this->siteTitle()?></title>
	<?php
		$root_categories = Category::get_root_categories();
	?>
	<!--
		CSS
		============================================= -->
	<link rel="stylesheet" href="<?=PROOT?>css/linearicons.css">
	<link rel="stylesheet" href="">
	<link rel="stylesheet" href="<?=PROOT?>css/font-awesome.min.css">
	<link rel="stylesheet" href="<?=PROOT?>css/themify-icons.css">
	<link rel="stylesheet" href="<?=PROOT?>css/bootstrap.css">
	<link rel="stylesheet" href="<?=PROOT?>css/owl.carousel.css">
	<link rel="stylesheet" href="<?=PROOT?>css/nice-select.css">
	<link rel="stylesheet" href="<?=PROOT?>css/nouislider.min.css">
	<link rel="stylesheet" href="<?=PROOT?>css/ion.rangeSlider.css" />
	<link rel="stylesheet" href="<?=PROOT?>css/ion.rangeSlider.skinFlat.css" />
	<link rel="stylesheet" href="<?=PROOT?>css/magnific-popup.css">
    <link rel="stylesheet" href="<?=PROOT?>css/main.css">
    <?= $this->content('head');?>
	
</head>

<body>
    <!-- Start Header Area -->
	<header class="header_area sticky-header">
		<div class="main_menu">
			<nav class="navbar navbar-expand-lg navbar-light main_box">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<a class="navbar-brand logo_h" href="<?=PROOT?>home"><img src="<?=PROOT?>img/fav.png" alt=""> <Strong> IDIOTS </Strong></a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
						<ul class="nav navbar-nav menu_nav ml-auto">
							<li class="nav-item active"><a class="nav-link" href="<?=PROOT?>home"><span class="fa fa-home"></span> Home</a></li>
							<li class="nav-item"><a class="nav-link" href="<?=PROOT?>/tracking"><span class="fa fa-truck"></span> Tracking</a></li>
							<!--<li class="nav-item submenu dropdown">
								<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
								 aria-expanded="false">Shop</a>
								<ul class="dropdown-menu">
									<li class="nav-item"><a class="nav-link" href="category.html">Shop Category</a></li>
									<li class="nav-item"><a class="nav-link" href="single-product.html">Product Details</a></li>
									<li class="nav-item"><a class="nav-link" href="checkout.html">Product Checkout</a></li>
									<li class="nav-item"><a class="nav-link" href="cart.html">Shopping Cart</a></li>
									<li class="nav-item"><a class="nav-link" href="confirmation.html">Confirmation</a></li>
								</ul>
							</li>-->
							<!--<li class="nav-item submenu dropdown">
								<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
								 aria-expanded="false">Blog</a>
								<ul class="dropdown-menu">
									<li class="nav-item"><a class="nav-link" href="blog.html">Blog</a></li>
									<li class="nav-item"><a class="nav-link" href="single-blog.html">Blog Details</a></li>
								</ul>
							</li>-->
							<li class="nav-item submenu dropdown">
								<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
								 aria-expanded="false"><span class="fa fa-list"></span> Category</a>
								<ul class="dropdown-menu">
									<?php foreach($root_categories as $cat): ?>
										<li class="nav-item"><a class="nav-link" href="<?=PROOT?>browse/loadCategories/<?=$cat->get_category_id()?>"> <?=$cat->get_title()?></a></li>
									<?php endforeach; ?>									
									<!--<li class="nav-item"><a class="nav-link" href="">Category1</a></li>
									<li class="nav-item"><a class="nav-link" href="">Category2</a></li>
									<li class="nav-item"><a class="nav-link" href="">Category3</a></li>-->
									<!--<li class="nav-item"><a class="nav-link" href="tracking.html">Tracking</a></li>
									<li class="nav-item"><a class="nav-link" href="elements.html">Elements</a></li>-->
								</ul>
							</li>
							<li class="nav-item"><a class="nav-link" href="<?=PROOT?>/contact"><span class="fa fa-comments"></span> Contact</a></li>
							<li class="nav-item"><a href="" class="account nav-link" data-target="#loginModal" data-toggle="modal"><span class="ti-user"></span></a></li>
							<li class="nav-item"><a href="<?=PROOT?>myCart" class="cart  nav-link"><span class="ti-shopping-cart"></span></a></li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
							
							<li class="nav-item">
								<button class="search"><span class="lnr lnr-magnifier" id="search"></span></button>
							</li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
		<div class="search_input" id="search_input_box">
			<div class="container">
				<form class="d-flex justify-content-between" action="<?=PROOT?>search/searchResult" method="GET">
					<input type="text" class="form-control" id="key" name="key" placeholder="Search For Anything.." required> 
					<button type="submit" class="btn"></button>
					<span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
				</form>
			</div>
		</div>
	</header>
	<!-- End Header Area -->
	<!--start login modal
	<div id="loginModal1" class="modal fade" role="dialog">
		<div class="modal-dialog modal-md" role="content">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Log In</h4>
					<button class="close" type="buttton" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form class="row login_form" action="contact_process.php" method="post" id="contactForm" novalidate="novalidate">
						<div class="col-md-12 form-group">
							<input type="email" class="form-control" id="email" name="email" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address'">
						</div>
						<div class="col-md-12 form-group">
							<input type="password" class="form-control" id="password" name="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
						</div>
						<div class="col-md-12 form-group">
							<div class="creat_account">
								<input type="checkbox" id="f-option2" name="selector">
								<label for="f-option2">Keep me logged in</label>
							</div>
						</div>
						<div class="col-md-12 form-group">
							<button type="submit" value="submit" class="primary-btn">Log In</button>
							<a href="#">Forgot Password?</a>
							<a href="">Create an Account</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>-->
	<!--start login signup modal-->
	<div id="loginModal" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg" role="content">
			<div class="modal-content">
				<div class="modal-header">
					<ul class="nav nav-tabs">
						<li class="nav-item">
							<a href="#login" class="nav-link active" role="tab" data-toggle="tab">Log In</a>
						</li>
						<li class="nav-item">
							<a href="#signup" class="nav-link" role="tab" data-toggle="tab">SignUp</a>
						</li>
					</ul>
					<button class="close" type="buttton" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="tab-content">
						<!--start login panel-->
						<div role="tabpanel" class="tab-pane fade show active" id="login">
							<div class="row">
							
								<div class="col-lg-6">
									<form class="row login_form" action="<?=PROOT?>register/login" method="post" id="loginForm">
										<div class="col-md-12 form-group">
											<input type="email" class="form-control" id="email" name="email" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address'" required>
										</div>
										<div class="col-md-12 form-group">
											<input type="password" class="form-control" id="password" name="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'" required>
										</div>
										<!--<div class="col-md-12 form-group">
											<div class="creat_account">
												<input type="checkbox" id="f-option2" name="selector">
												<label for="f-option2">Keep me logged in</label>
											</div>
										</div>-->
										<div class="col-md-12 form-group">
											<button type="submit" name="submit" class="primary-btn">Log In</button>
											<a href="" data-target="#forgotPasswordModal" data-toggle="modal"data-dismiss="modal">Forgot Password?</a>
											<!--<a href="<?//=PROOT?>register/guest">Continue as a Guest</a>
											<a href="">Create an Account</a>-->
										</div>
									</form>
								</div>
								<div class="col-lg-6 d-none d-lg-block">
									<img class="img-fluid" src="<?=PROOT?>img/shopping-online.jpg" alt="">
								</div>
							</div>
						</div>
						<!--end login panel-->
						<!--start signup panel-->
						<div role="tabpanel" class="tab-pane fade" id="signup">
							<form class="row login_form" action="<?=PROOT?>register/signup" method="post" onsubmit="return validate()" id="contactForm">
								<div class="col-md-6 form-group">
									<input type="text" class="form-control" id="firstName" name="first_name" placeholder="First Name" pattern="[A-Za-z\s]{1,}" title="Allowed alphabetic characters only" onfocus="this.placeholder = ''" onblur="this.placeholder = 'First Name'" required>
								</div>
								<div class="col-md-6 form-group">
									<input type="text" class="form-control" id="lastName" name="last_name" placeholder="Last Name" pattern="[A-Za-z\s]{1,}" title="Allowed alphabetic characters only" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Last Name'" required>
								</div>
								<div class="col-md-12 form-group">
									<input type="email" class="form-control" id="email" name="email" placeholder="Email Address" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address'" required>
								</div>
								<div class="col-md-6 form-group">
									<input type="password" class="form-control" id="password" name="password" placeholder="Password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[$@#!%*?&]).{6,20}" 
									title="Must contain at least one number and one uppercase and lowercase letter, at least one special character and at least 6 or more characters without spaces" 
									onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'" required>
								</div>
								<div class="col-md-6 form-group">
									<input type="password" class="form-control" id="re-password" name="re-password" placeholder="Re-Password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[$@#!%*?&]).{6,20}" 
									title="Must contain at least one number and one uppercase and lowercase letter, at least one special character and at least 6 or more characters without spaces" 
									onfocus="this.placeholder = ''" onblur="this.placeholder = 'Re-Password'" required>
								</div>
								<div class="col-md-6 form-group">
									<input type="text" class="form-control" id="contact1" name="contact1" placeholder="Contact Number" pattern="[0-9]{10}" title="10 digit phone number" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Contact Number'" required>
								</div>
								<div class="col-md-6 form-group">
									<input type="text" class="form-control" id="contact2" name="contact2" placeholder="Contact Number(Optional)" pattern="[0-9]{10}" title="10 digit phone number" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Contact Number(Optional)'" >
								</div>
								<div class="col-md-6 col-lg-4 form-group">
									<input type="number" class="form-control" id="houseNumber" name="house_number" placeholder="House Number" min="1" onfocus="this.placeholder = ''" onblur="this.placeholder = 'House Number'" required>
								</div>
								<div class="col-md-6 col-lg-4 form-group">
									<input type="text" class="form-control" id="street" name="street" placeholder="Street" pattern="[A-Za-z0-9\s]{1,}" title="Should contain only alphanumeric characters" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Street'" required>
								</div>
								<div class="col-md-6 col-lg-4 form-group">
									<input type="text" class="form-control" id="city" name="city" placeholder="City" pattern="[A-Za-z\s]{1,}" title="Allowed alphabetic characters only" onfocus="this.placeholder = ''" onblur="this.placeholder = 'City'" required>
								</div>
								<div class="col-md-6 col-lg-4 form-group">
									<input type="text" class="form-control" id="state" name="state" placeholder="State" pattern="[A-Za-z\s]{1,}" title="Allowed alphabetic characters only" onfocus="this.placeholder = ''" onblur="this.placeholder = 'State'" required>
								</div>
								<div class="col-md-6 col-lg-4 form-group">
									<input type="text" class="form-control" id="zipCode" name="zip_code" placeholder="Zip Code" pattern="[0-9]{5}" title="Should contain only 5 numbers" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Zip Code'" required>
								</div>
								<div class="col-md-6 col-lg-4 form-group">
									
								</div>
								
								<div class="col-md-12 col-lg-6 offset-lg-3 form-group">
									<button type="submit" value="submit" class="primary-btn" name="submit" id="submit">SignUp</button>
									<!--<a href="">Already have an Account?</a>-->
								</div>
							</form>
						</div>
						<!--end signup panel-->

					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
	function validate(){
		var form = document.getElementById('contactForm');
		var password = form.elements.namedItem("password").value;
		var re_password = form.elements.namedItem("re-password").value;		
		if(password != re_password){
			alert("Password and Re-Password fields should be same");
			return false;
		}
		else{				
			return true;
		}		
	}
	</script>

    <!--end login signup modal-->
    <!--start forgot password modal--> 
    <div id="forgotPasswordModal" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg" role="content">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-warning">Forgot Password</h4>
					<button class="close" type="buttton" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form class="login_form" action="<?=PROOT?>forgotpassword" method="post">
						<div class="form-group">
							<input type="email" class="form-control" id="email" name="email" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address'" required>
						</div>
                        <div class="form-group">
							<button type="submit" value="submit" name="submit" class="primary-btn col-md-3">Submit</button>
							
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
    <?= $this->content('body');?>

    <!-- start footer Area -->
	<footer class="footer-area section_gap">
		<div class="container">
			<div class="row">
				<div class="col-lg-3  col-md-6 col-sm-6">
					<div class="single-footer-widget">
						<h6>About Us</h6>
						<p>
							Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore dolore
							magna aliqua.
						</p>
					</div>
				</div>
				<div class="col-lg-4  col-md-6 col-sm-6">
					<!--<div class="single-footer-widget">
						<h6>Newsletter</h6>
						<p>Stay update with our latest</p>
						<div class="" id="mc_embed_signup">

							<form target="_blank" novalidate="true" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01"
							 method="get" class="form-inline">

								<div class="d-flex flex-row">

									<input class="form-control" name="EMAIL" placeholder="Enter Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Email '"
									 required="" type="email">


									<button class="click-btn btn btn-default"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>
									<div style="position: absolute; left: -5000px;">
										<input name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1" value="" type="text">
									</div>-->

									<!-- <div class="col-lg-4 col-md-4">
												<button class="bb-btn btn"><span class="lnr lnr-arrow-right"></span></button>
											</div>  -->
								<!--</div>
								<div class="info"></div>
							</form>
						</div>
					</div>-->
				</div>
				<div class="col-lg-3  col-md-6 col-sm-6">
					<div class="single-footer-widget mail-chimp">
						<h6 class="mb-20">Instragram Feed</h6>
						<ul class="instafeed d-flex flex-wrap">
							<li><img src="../../img/i1.jpg" alt=""></li>
							<li><img src="../../img/i2.jpg" alt=""></li>
							<li><img src="../../img/i3.jpg" alt=""></li>
							<li><img src="../../img/i4.jpg" alt=""></li>
							<li><img src="../../img/i5.jpg" alt=""></li>
							<li><img src="../../img/i6.jpg" alt=""></li>
							<li><img src="../../img/i7.jpg" alt=""></li>
							<li><img src="../../img/i8.jpg" alt=""></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-2 col-md-6 col-sm-6">
					<div class="single-footer-widget">
						<h6>Follow Us</h6>
						<p>Let us be social</p>
						<div class="footer-social d-flex align-items-center">
							<a href="#"><i class="fa fa-facebook"></i></a>
							<a href="#"><i class="fa fa-twitter"></i></a>
							<a href="#"><i class="fa fa-dribbble"></i></a>
							<a href="#"><i class="fa fa-behance"></i></a>
						</div>
					</div>
				</div>
			</div>
			<div class="footer-bottom d-flex justify-content-center align-items-center flex-wrap">
				<p class="footer-text m-0"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
</p>
			</div>
		</div>
	</footer>
    <!-- End footer Area -->
    
    <script src="<?=PROOT?>js/vendor/jquery-2.2.4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
	 crossorigin="anonymous"></script>
	<script src="<?=PROOT?>js/vendor/bootstrap.min.js"></script>
	<script src="<?=PROOT?>js/jquery.ajaxchimp.min.js"></script>
	<script src="<?=PROOT?>js/jquery.nice-select.min.js"></script>
	<script src="<?=PROOT?>js/jquery.sticky.js"></script>
	<script src="<?=PROOT?>js/nouislider.min.js"></script>
	<script src="<?=PROOT?>js/countdown.js"></script>
	<script src="<?=PROOT?>js/jquery.magnific-popup.min.js"></script>
	<script src="<?=PROOT?>js/owl.carousel.min.js"></script>
	<!--gmaps Js-->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
	<script src="<?=PROOT?>js/gmaps.min.js"></script>
    <script src="<?=PROOT?>js/main.js"></script>
	<?php Script::displayscript();
?>
    
</body>

</html>