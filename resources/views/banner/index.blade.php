@extends('app')


@section('content')

	

	<noscript>
		<div class="alert alert-block span10">
			<h4 class="alert-heading">Warning!</h4>
			<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
		</div>
	</noscript>

	<div id="content" class="span10">
		<ul class="breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="index.html">Home</a>
				<i class="icon-angle-right"></i> 
			</li>
			<li>
				<i class="icon-edit"></i>
				<a href="#">Mostrar Banner</a>
			</li>
		</ul>

		
			<a class="btn btn-primary" href="banner/create">Agregar Banner</a></button>
			<p></p>

		@if (count($errors) > 0)
		    <div class="alert alert-block span10">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif

		<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon user"></i><span class="break"></span>Banners</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
							  	  <th>#</th>
								  <th>Nombre</th>
								  <th>Contenido</th>
								  <th>Imagen</th>
								  <th>Creado por</th>
								  <th>Países asociados</th>
								  <th>Fecha de Creación</th>
								  <th>Estado</th>
								  <th>Opciones</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php $i=1;?>
						  	@foreach($banners as $banner)
								<tr>
									<td>{!!$i!!}</td>
									<td>{!!$banner->name!!}</td>
									<td class="center">{!!$banner->description!!}</td>
									<td class="center">
										<?php $image_name = "images/banner/banner_".$banner->id.".".$banner->extension ?>
										{!! Html::image($image_name,'a picture', array('width' => '800')) !!}
									</td>
									<td class="center">{!! $banner->Created_by->name !!}</td>
									<td class="center">
										<?php
											$Countries = $banner->countries;
										?>
										
										@foreach($Countries as $country)
											{!! $country->name !!},
										@endforeach
									</td>
									<td class="center">{!! $banner->created_at !!}</td>
										<?php 
											if (is_null($banner->deleted_at)) {
												$route_edit = "/banner/".$banner->id."/edit";
												$route_destroy = "/banner/".$banner->id."/inactive";

												$status = "active";
											}else{

												$route_untrashed = "/banner/".$banner->id."/untrashed";
												$status = "inactive";
											}
										?>
									<td class="center">

										@if($status == "active")
											<span class="label label-success">Activo</span>
										@else
											<span class="label">Inactivo</span>
										@endif

									</td>
									<td class="center">

										@if($status == "active")											
											<a class="btn btn-info" href= <?php echo $route_edit;?> >
												<i class='halflings-icon white edit'></i>  
											</a>
											<a class="btn btn-danger" href= <?php echo $route_destroy;?>>
												<i class="halflings-icon white trash"></i> 
											</a>
										@else
											<a class="btn btn-danger" href= <?php echo $route_untrashed;?>>
												<i class="halflings-icon white share-alt"></i> 
											</a>
										@endif


										

										



									</td>
								</tr>
								<?php $i++;?>
							@endforeach
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->

		</div>

@endsection