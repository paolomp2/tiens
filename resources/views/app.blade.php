<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tiens</title>	

	<!-- start: CSS -->
	{!!Html::style('css/bootstrap.min.css')!!}
	{!!Html::style('css/bootstrap-responsive.min.css')!!}
	{!!Html::style('css/style.css')!!}
	{!!Html::style('css/style-responsive.css')!!}
	<!-- start: CSS clock -->
	{!!Html::style('css/bootstrap-clockpicker.min.css')!!}
	{!!Html::style('css/github.min.css')!!}
	<!-- end: CSS clock -->


	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
	<!-- end: CSS -->

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="/"><span>Tiens</span></a>
								
				<!-- start: Header Menu -->
				<div class="nav-no-collapse header-nav">
					<ul class="nav pull-right">
											
						
						@if (Auth::guest())
							<li><a href="{{ url('/auth/login') }}">Login</a></li>
							<li><a href="{{ url('/auth/register') }}">Register</a></li>
						@else
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
								</ul>
							</li>
						@endif
					</ul>
				</div>
				<!-- end: Header Menu -->
				
			</div>
		</div>
	</div>
	<!-- start: Header -->

	@if (!Auth::guest())
	<div class="container-fluid-full">
		<div class="row-fluid">
	<!-- start: Main Menu -->
			<div id="sidebar-left" class="span2">
				<div class="nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li><a href="/banner"><i class="icon-eye-open"></i><span class="hidden-tablet"> Banner</span></a></li>	
						<li><a href="/news"><i class="icon-tasks"></i><span class="hidden-tablet"> Noticias</span></a></li>						
						<li>
							<a class="dropmenu" href="#"><i class="icon-calendar"></i><span class="hidden-tablet"> Eventos</span><span class="label label-important"> 2 </span></a>
							<ul>
								<li><a class="submenu" href="/event_category"><i class="icon-th-large"></i><span class="hidden-tablet"> Categorías</span></a></li>
								<li><a class="submenu" href="/event"><i class="icon-calendar"></i><span class="hidden-tablet"> Eventos</span></a></li>
							</ul>	
						</li>

						<li>
							<a class="dropmenu" href="#"><i class="icon-picture"></i><span class="hidden-tablet"> Galería</span><span class="label label-important"> 2 </span></a>
							<ul>
								<li><a class="submenu" href="/gallery_category"><i class="icon-th-large"></i><span class="hidden-tablet"> Categorías</span></a></li>
								<li><a class="submenu" href="/gallery"><i class="icon-picture"></i><span class="hidden-tablet"> Galería</span></a></li>
							</ul>
							
						</li>
						
						<li>
							
							<a class="dropmenu" href="#"><i class="halflings-icon film"></i><span class="hidden-tablet">Videos</span><span class="label label-important"> 2 </span></a>
							<ul>
								<li><a class="submenu" href="/video_category"><i class="icon-th-large"></i><span class="hidden-tablet"> Categorías</span></a></li>
								<li><a class="submenu" href="/movie"><i class="halflings-icon film"></i><span class="hidden-tablet"> Videos</span></a></li>
							</ul>
						</li>
						<li>
							<a class="dropmenu" href="#"><i class="icon-folder-close-alt"></i><span class="hidden-tablet">Distribuidores</span><span class="label label-important"> 2 </span></a>
							<ul>
								<li><a class="submenu" href="/lion"><i class="icon-file-alt"></i><span class="hidden-tablet"> Leones</span></a></li>
								<li><a class="submenu" href="/trainer"><i class="icon-file-alt"></i><span class="hidden-tablet"> Entrenadores</span></a></li>
							</ul>	
						</li>
						
						<li>
							<a class="dropmenu" href="#"><i class="icon-edit"></i><span class="hidden-tablet">Capacitaciones</span></a>
							<ul>
								<li><a class="submenu" href="/training_category"><i class="icon-file-alt"></i><span class="hidden-tablet"> Categorías</span></a></li>
								<li><a class="submenu" href="/training"><i class="icon-file-alt"></i><span class="hidden-tablet"> Capacitaciones</span></a></li>								
								
							</ul>	
						</li>
						<li>
							<a class="dropmenu" href="#"><i class="icon-folder-close-alt"></i><span class="hidden-tablet">Contenido</span></a>
							<ul>
								<li><a class="submenu" href="/content/1/edit"><i class="icon-file-alt"></i><span class="hidden-tablet"> Misión</span></a></li>
								<li><a class="submenu" href="/content/2/edit"><i class="icon-file-alt"></i><span class="hidden-tablet"> Visión</span></a></li>
								<li><a class="submenu" href="/content/3/edit"><i class="icon-file-alt"></i><span class="hidden-tablet"> Valores</span></a></li>
								<li><a class="submenu" href="/content/4/edit"><i class="icon-file-alt"></i><span class="hidden-tablet"> Quienes somos</span></a></li>
								
							</ul>	
						</li>					
					</ul>
				</div>
			</div>
			<!-- end: Main Menu -->


	@endif


	@yield('content')
	<!-- start: JavaScript-->

	<script src="{{ asset('/js/jquery-1.9.1.min.js') }}"></script>
	<script src="{{ asset('/js/jquery-migrate-1.0.0.min.js') }}"></script>	
	<script src="{{ asset('/js/jquery-ui-1.10.0.custom.min.js') }}"></script>	
		<script src="{{ asset('/js/jquery.ui.touch-punch.js') }}"></script>
		<script src="{{ asset('/js/modernizr.js') }}"></script>	
		<script src="{{ asset('/js/bootstrap.min.js') }}"></script>	
		<script src="{{ asset('/js/jquery.cookie.js') }}"></script>	
		<script src="{{ asset('/js/fullcalendar.min.js') }}"></script>	
		<script src="{{ asset('/js/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('/js/excanvas.js') }}"></script>
	<script src="{{ asset('/js/jquery.flot.js') }}"></script>
	<script src="{{ asset('/js/jquery.flot.pie.js') }}"></script>
	<script src="{{ asset('/js/jquery.flot.stack.js') }}"></script>
	<script src="{{ asset('/js/jquery.flot.resize.min.js') }}"></script>	
		<script src="{{ asset('/js/jquery.chosen.min.js') }}"></script>	
		<script src="{{ asset('/js/jquery.uniform.min.js') }}"></script>		
		<script src="{{ asset('/js/jquery.cleditor.min.js') }}"></script>	
		<script src="{{ asset('/js/jquery.noty.js') }}"></script>	
		<script src="{{ asset('/js/jquery.elfinder.min.js') }}"></script>	
		<script src="{{ asset('/js/jquery.raty.min.js') }}"></script>	
		<script src="{{ asset('/js/jquery.iphone.toggle.js') }}"></script>	
		<script src="{{ asset('/js/jquery.uploadify-3.1.min.js') }}"></script>	
		<script src="{{ asset('/js/jquery.gritter.min.js') }}"></script>	
		<script src="{{ asset('/js/jquery.imagesloaded.js') }}"></script>	
		<script src="{{ asset('/js/jquery.masonry.min.js') }}"></script>	
		<script src="{{ asset('/js/jquery.knob.modified.js') }}"></script>	
		<script src="{{ asset('/js/jquery.sparkline.min.js') }}"></script>	
		<script src="{{ asset('/js/counter.js') }}"></script>	
		<script src="{{ asset('/js/retina.js') }}"></script>
		<script src="{{ asset('/js/custom.js') }}"></script>
	<!-- begin: JavaScript - Clock -->
		<script src="{{ asset('/js/highlight.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('/js/bootstrap-clockpicker.min.js') }}"></script>
		<script src="{{ asset('/js/clockfunctions.js') }}"></script>
		<script src="{{ asset('/js/fileupdater.js') }}"></script>
	<!-- end: JavaScript-->

</body>
</html>
