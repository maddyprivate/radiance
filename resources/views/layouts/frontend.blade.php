<!DOCTYPE html>
<html lang="zxx">
<head>
	<title>Radiance LPG Petrochem Private Limited | HTML Template</title>
	<meta charset="UTF-8">
	<meta name="description" content="Industry.INC HTML Template">
	<meta name="keywords" content="industry, html">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- Favicon -->
	<link href="img/favicon.ico" rel="shortcut icon"/>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i&display=swap" rel="stylesheet">

	<!-- Stylesheets -->
	<link rel="stylesheet" href="{{ asset('fw/css/bootstrap.min.css')}}"/>
	<link rel="stylesheet" href="{{ asset('fw/css/font-awesome.min.css')}}"/>
	<link rel="stylesheet" href="{{ asset('fw/css/magnific-popup.css')}}"/>
	<link rel="stylesheet" href="{{ asset('fw/css/slicknav.min.css')}}"/>
	<link rel="stylesheet" href="{{ asset('fw/css/owl.carousel.min.css')}}"/>

	<!-- Main Stylesheets -->
	<link rel="stylesheet" href="{{ asset('fw/css/style.css')}}"/>


	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>
<body>
	<!-- Page Preloder -->
	<div id="preloder">
		<div class="loader"></div>
	</div>

	<!-- Header section  -->
	<header class="header-section clearfix">
		<div class="header-top">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-6">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
					</div>
					<div class="col-md-6 text-md-right">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="site-navbar">
			<!-- Logo -->
			<a href="{{url('/')}}" class="site-logo">
				<img src="{{ asset('fw/img')}}/logo.png" alt="" style="max-width:80%">
			</a>
			<div class="header-right">
				<div class="header-info-box">
					<div class="hib-icon">
						<img src="{{ asset('fw/img/icons/phone.png')}}" alt="" class="">
					</div>
					<div class="hib-text">
						<h6>+91 90282 93637</h6>
						<p>info@radiancelpg.in</p>
					</div>
				</div>
				<div class="header-info-box">
					<div class="hib-icon">
						<img src="{{ asset('fw/img/icons/map-marker.png')}}" alt="" class="">
					</div>
					<div class="hib-text">
						<h6>Royal Empress Building, Near Aryan</h6>
						<p>Suzuki Showroom, Baner, Pune -411045</p>
					</div>
				</div>
				<!-- <button class="search-switch"><i class="fa fa-search"></i></button> -->
			</div>
			<!-- Menu -->
			<nav class="site-nav-menu">
				<ul>
					<li class="active"><a href="{{url('/')}}">Home</a></li>
					<li><a href="{{url('about')}}">About us</a></li>
					<li><a href="{{url('solutions')}}">Solutions</a>
						<ul class="sub-menu">
							<li><a href="{{url('elements')}}">Elements</a></li>
						</ul>
					</li>
					<li><a href="{{url('blog')}}">Blog</a></li>
					<li><a href="{{url('contact')}}">Contact</a></li>
				</ul>
			</nav>

		</div>
	</header>
	<!-- Header section end  -->
	<main class="">
        @yield('content')
    </main>
	<!-- Hero section  -->
	

	<!-- Footer section -->
		<footer class="footer-section spad">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6">
					<div class="footer-widget about-widget">
						<img src="img/logo-light.png" alt="">
						<p>Lorem ipsum dolor sit amet, consec-tetur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin est. Nam ornare ipsum ac accumsan auctor. Donec consequat arcu et commodo interdum. </p>
						<div class="footer-social">
							<a href=""><i class="fa fa-facebook"></i></a>
							<a href=""><i class="fa fa-twitter"></i></a>
							<a href=""><i class="fa fa-dribbble"></i></a>
							<a href=""><i class="fa fa-behance"></i></a>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="footer-widget">
						<h2 class="fw-title">Useful Resources</h2>
						<ul>
							<li><a href="">Jobs Vacancies</a></li>
							<li><a href="">Client Testimonials</a></li>
							<li><a href="">Green  Energy</a></li>
							<li><a href="">Chemical Research</a></li>
							<li><a href="">Oil Extractions</a></li>
							<li><a href="">About our Work</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="footer-widget">
						<h2 class="fw-title">Our Solutions</h2>
						<ul>
							<li><a href="">Metal Industry</a></li>
							<li><a href="">Agricultural Engineering</a></li>
							<li><a href="">Green  Energy</a></li>
							<li><a href="">Chemical Research</a></li>
							<li><a href="">Oil Extractions</a></li>
							<li><a href="">Manufactoring</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-7">
					<div class="footer-widget">
						<h2 class="fw-title">Contact Us</h2>
						<div class="footer-info-box">
							<div class="fib-icon">
								<img src="img/icons/map-marker.png" alt="" class="">
							</div>
							<div class="fib-text">
								<p>Main Str, no 23 NY,<br>New York PK 23589</p>
							</div>
						</div>
						<div class="footer-info-box">
							<div class="fib-icon">
								<img src="img/icons/phone.png" alt="" class="">
							</div>
							<div class="fib-text">
								<p>+546 990221 123<br>contact@industryalinc.com</p>
							</div>
						</div>
						<form class="footer-search">
							<input type="text" placeholder="Search">
							<button><i class="fa fa-search"></i></button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="footer-buttom">
			<div class="container">
				<div class="row">
					<div class="col-lg-4 order-2 order-lg-1 p-0">
						<div class="copyright"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
							Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></div>
						</div>
						<div class="col-lg-7 order-1 order-lg-2 p-0">
							<ul class="footer-menu">
								<li class="active"><a href="index.html">Home</a></li>
								<li><a href="about.html">About us</a></li>
								<li><a href="solutions.html">Solutions</a></li>
								<li><a href="blog.html">Blog</a></li>
								<li><a href="contact.html">Contact</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</footer>

	<!-- Footer section end -->

	<!-- Search model -->
	<div class="search-model">
		<div class="h-100 d-flex align-items-center justify-content-center">
			<div class="search-close-switch">+</div>
			<form class="search-model-form">
				<input type="text" id="search-input" placeholder="Search here.....">
			</form>
		</div>
	</div>
	<!-- Search model end -->
	
	<!--====== Javascripts & Jquery ======-->
	<script src="{{ asset('fw/js/jquery-3.2.1.min.js')}}"></script>
	<script src="{{ asset('fw/js/bootstrap.min.js')}}"></script>
	<script src="{{ asset('fw/js/jquery.slicknav.min.js')}}"></script>
	<script src="{{ asset('fw/js/owl.carousel.min.js')}}"></script>
	<script src="{{ asset('fw/js/circle-progress.min.js')}}"></script>
	<script src="{{ asset('fw/js/jquery.magnific-popup.min.js')}}"></script>
	<script src="{{ asset('fw/js/main.js')}}"></script>

	</body>
</html>
