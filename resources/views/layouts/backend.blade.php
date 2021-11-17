<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<script type="text/javascript">
		window.baseURL = {!! json_encode(url('/')) !!}
	</script>

	<title>Radiance Gas</title>
	<link rel='icon' type='image/png' href="{{ asset('img/favicon.png') }}" />

	<!-- Bootstrap CSS-->
	<link rel="stylesheet" href="{{ asset('/fw/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/css/skeleton.css') }}">
	<!-- Font Awesome CSS-->
	<link rel="stylesheet" href="{{ asset('/fw/font-awesome/css/all.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/fw/font-awesome/4.7/css/font-awesome.min.css') }}">
	<!-- Custom Element's CSS -->
	<link rel="stylesheet" href="{{ asset('/css/customstyles.css') }}">
	<link rel="stylesheet" href="{{ asset('/css/adminstyle/custom.css') }}">
	<!-- Google fonts - Poppins -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
	<!-- theme stylesheet-->
	<link rel="stylesheet" href="{{ asset('css/adminstyle/style.default.css') }}" id="theme-stylesheet">
	<!-- Pace - Top Loading Bar Theme stylesheet-->
	<link rel="stylesheet" href="{{ asset('fw/pace/themes/blue/pace-theme-minimal.css') }}" id="theme-stylesheet">
	<!-- BFH CSS -->
	<link rel="stylesheet" href="{{ asset('fw/bfh/bootstrap-formhelpers.css') }}">
	<!-- Pure Checkbox for Invoice CSS -->
	<link rel="stylesheet" href="{{ asset('css/pure-checkbox.css') }}">
	<!--	Remodal CSS-->
	<link rel="stylesheet" href="{{ asset('fw/remodal/remodal.css') }}">
	<link rel="stylesheet" href="{{ asset('fw/remodal/remodal-default-theme.css') }}">
	<!--	Autocomplete CSS	-->
	<link rel="stylesheet" href="{{ asset('fw/autocomplete/jquery.autocomplete.css') }}">
	<!-- Dev Sign -->
	<link rel="stylesheet" href="{{ asset('css/dev-sign/style.css') }}">
	<link rel="stylesheet" href="{{ asset('css/invoice-table.css') }}">
	<link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

	<!-- Favicon-->
	<link rel="shortcut icon" href="img/favicon.ico">

	<script src="{{ asset('fw/jquery/jquery.min.js') }}"></script>
	<script src="{{ asset('fw/bfh/bootstrap-formhelpers.js') }}"></script>  	
	<script src="{{ asset('fw/pace/pace.min.js') }}"></script>
	<script src="{{ asset('fw/moment/moment.js') }}"></script>
	<script src="{{ asset('fw/sweetalert/sweetalert2.all.js') }}"></script>
	<!--	Autocomplete JS-->
	<script src="{{ asset('fw/autocomplete/jquery.autocomplete.js') }}"></script>	

	<!-- Tweaks for older IEs-->
	<!--[if lt IE 9]>
				<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
				<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
					@yield('header')
	<body>
		<div class="page">
			<!-- Main Navbar-->
			<header class="header">
				<nav class="navbar">
					<div class="container-fluid">
						<div class="navbar-holder d-flex align-items-center justify-content-between">
							<!-- Navbar Header-->
							<div class="navbar-header">
								<!-- Navbar Brand -->
								<a href="{{ Route('Dashboard') }}" class="navbar-brand">
									<div class="brand-text brand-big">
										<span>Radiance</span>
										<strong>Gas</strong>
									</div>
									<div class="brand-text brand-small">
										<strong>RGP</strong>
									</div>
								</a>
								<!-- Toggle Button-->
								<a id="toggle-btn" href="javascript:;" class="menu-btn active">
									<span></span>
									<span></span>
									<span></span>
								</a>
							</div>
							<!-- Navbar Menu -->
							<ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
								<!-- Logout    -->
								<li class="nav-item">
									<a href="{{ route('logout') }}" onclick="event.preventDefault();
									document.getElementById('logout-form').submit();" class="nav-link logout">Logout
										<i class="fa fa-sign-out"></i>
									</a>
									<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
										@csrf
									</form>
								</li>
							</ul>
						</div>
					</div>
				</nav>
			</header>
			<div class="page-content d-flex align-items-stretch">
				<!-- Side Navbar -->
				<nav class="side-navbar">
					<!-- Sidebar Header-->
					<div class="sidebar-header d-flex align-items-center">
						<div class="avatar">
							<img src="{{ asset('img/backend/user-icon.png') }}" alt="..." class="img-fluid rounded-circle">
						</div>
						<div class="title">
							<h1 class="h4">{{ Auth::user()->name}} </h1>
							<p>{{ Auth::user()->email}}</p>
						</div>
					</div>
					<!-- Sidebar Navidation Menus-->
					<ul class="list-unstyled">
						<li class="{{ isActiveRoute('Dashboard') }}">
							<a class="nav-link" href="{{ route('Dashboard') }}">
								<i class="fas fa-home"></i>Dashboard</a>
						</li>
						@if(Auth::user()->hasAnyRole(['admin', 'user']))
						<li class="{{ isActiveRoute('Products.*') }}">
							<a class="nav-link" href="{{ route('Products.products.index') }}">
								<i class="fas fa-cookie-bite"></i>Products </a>
						</li>
						<li class="{{ isActiveRoute('Contacts.*') }}">
							<a href="#condown" aria-expanded="false" data-toggle="collapse">
								<i class="fas fa-file-invoice-dollar"></i>Contacts
							</a>
							<ul id="condown" class="collapse list-unstyled ">
								<li>
									<a href="{{ url('customers') }}">Customers</a>
								</li>
								<li>
									<a href="{{ url('dealers') }}">Dealers</a>
								</li>
							</ul>
						</li>
						<li class="{{ isActiveRoute('Purchases.*') }}">
							<a href="#purdown" aria-expanded="false" data-toggle="collapse">
								<i class="fas fa-file-invoice-dollar"></i>Purchases
							</a>
							<ul id="purdown" class="collapse list-unstyled ">
								<li>
									<a href="{{ route('Purchases.purchases.create') }}">Create Purchase</a>
								</li>
								<li>
									<a href="{{ route('Purchases.purchases.index') }}">List Purchase</a>
								</li>
							</ul>
						</li>
						<li class="{{ isActiveRoute('Invoices.*') }}">
							<a href="#invdown" aria-expanded="false" data-toggle="collapse">
								<i class="fas fa-file-invoice-dollar"></i>Invoices
							</a>
							<ul id="invdown" class="collapse list-unstyled ">
								<li>
									<a href="{{ route('Invoices.invoices.create') }}">Create Invoice</a>
								</li>
								<li>
									<a href="{{ route('Invoices.invoices.index') }}">List Invoice</a>
								</li>
							</ul>
						</li>
						<li class="{{ isActiveRoute('DebitNotes.*') }}">
							<a href="#debitenotedown" aria-expanded="false" data-toggle="collapse">
								<i class="fas fa-file-invoice-dollar"></i>Debit Notes
							</a>
							<ul id="debitenotedown" class="collapse list-unstyled ">
								<li>
									<a href="{{ route('DebitNotes.debitNotes.create') }}">Create Debit Note</a>
								</li>
								<li>
									<a href="{{ route('DebitNotes.debitNotes.index') }}">List Debit Note</a>
								</li>
							</ul>
						</li>
						<li class="{{ isActiveRoute('CreditNotes.*') }}">
							<a href="#creditenotedown" aria-expanded="false" data-toggle="collapse">
								<i class="fas fa-file-invoice-dollar"></i>Credit Notes
							</a>
							<ul id="creditenotedown" class="collapse list-unstyled ">
								<li>
									<a href="{{ route('CreditNotes.creditNotes.create') }}">Create Credit Note</a>
								</li>
								<li>
									<a href="{{ route('CreditNotes.creditNotes.index') }}">List Credit Note</a>
								</li>
							</ul>
						</li>
						<!-- <li class="{{ isActiveRoute('Dcs.*') }}">
							<a href="#dcdown" aria-expanded="false" data-toggle="collapse">
								<i class="fas fa-file-invoice-dollar"></i>Dcs
							</a>
							<ul id="dcdown" class="collapse list-unstyled ">
								<li>
									<a href="{{ route('Dcs.dcs.create') }}">Create Dc</a>
								</li>
								<li>
									<a href="{{ route('Dcs.dcs.index') }}">List Dc</a>
								</li>
							</ul>
						</li>	 -->					
						<li class="{{ isActiveRoute('Settings.*') }}">
							<a href="#deedown" aria-expanded="false" data-toggle="collapse">
								<i class="fa fa-cog"></i>Settings</a>
							<ul id="deedown" class="collapse list-unstyled ">
								<li>
									<a href="{{ route('Settings.profile.index') }}">Profile Settings</a>
								</li>
								<li>
									<a href="{{ route('Settings.invoice.index') }}">Invoice Settings</a>
								</li>
								<li>
									<a href="{{ route('Settings.account.index') }}">Accounts</a>
								</li>
							</ul>
						</li>
						<li class="{{ isActiveRoute('Transactions.*') }}">
							<a href="#transdown" aria-expanded="false" data-toggle="collapse">
								<i class="far fa-money-bill-alt"></i>Transaction
							</a>
							<ul id="transdown" class="collapse list-unstyled ">
								<li>
									<a href="{{ route('Expenses.expenses.index') }}">Expenses</a>
								</li>
								<li>
									<a href="{{ route('Deposits.deposits.index') }}">Deposits</a>
								</li>
								<li>
									<a href="{{ route('Transfers.transfers.index') }}">Transfers</a>
								</li>
								<li>
									<a href="{{ route('Transactions.transactions.index') }}">View Transactions</a>
								</li>
								<li>
									<a href="{{ route('BalanceSheet.balancesheet.index') }}">Balance Sheet</a>
								</li>
							</ul>
						</li>
						@endif
						@if(Auth::user()->hasRole('admin'))
						<li class="{{ isActiveRoute('Users.*') }}">
							<a href="{{ route('Users.users.index') }}"><i class="fa fa-user-secret"></i>User Management </a>
						</li>
						@endif
					</ul>
				</nav>
				<div class="content-inner">
					<!-- Page Header-->
					<header class="page-header">
						<div class="container-fluid">
							<h2 class="no-margin-bottom">{{ request()->route()->parameter('page-heading') }}</h2>
						</div>
					</header>

					@yield('content')

					<!-- Page Footer-->
					<footer class="main-footer">
						<div class="container-fluid">
							<div class="row">
								<div class="col-sm-6">
									<p>Radiance Gas. © 
										<a class="designer" href="http://RadianceLPG.com" target=_blank>
											<!-- <span class="icon-designer">
												<span class="path2"></span>
												<span class="path4"></span>
												<span class="path5"></span>
												<span class="path6"></span>
											</span> -->
										</a>
									</p>
								</div>
								<div class="col-sm-6 text-right align-items-center">
									
								</div>
							</div>
						</div>
					</footer>
				</div>
			</div>
		</div>
		<!-- JavaScript files-->		
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
		<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" ></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" ></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" ></script>
		<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js" ></script>
		<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js" ></script>
		<script src="{{ asset('fw/popper.js/umd/popper.min.js') }}"></script>
		<script src="{{ asset('fw/bootstrap/js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('fw/numeric/jquery-numeric-1.3.1.js') }}"></script>
		<script src="{{ asset('fw/autosize/autosize.js') }}"></script>  
		<!--    Remodal JS-->
		<script src="{{ asset('fw/remodal/remodal.js') }}"></script>
		<script src="{{ asset('js/form-constraints.js') }}"></script>
		<!-- Main File-->
		<script src="{{ asset('js/adminscript/front.js') }}"></script>
		<script src="{{ asset('js/bfh-datepicker-assist.js') }}"></script>
		<script src="{{ asset('js/round-off.js') }}"></script>
		@yield('footer')
	</body>
</html>