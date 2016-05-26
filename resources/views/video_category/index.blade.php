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
				<a href="#">Home</a>
				<i class="icon-angle-right"></i> 
			</li>
			<li>
				<i class="icon-edit"></i>
				<a href="#">Categoría de Videos</a>
			</li>
		</ul>

		
			<a class="btn btn-primary" href="video_category/create">Agregar Categoría</a></button>
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
						<h2><i class="halflings-icon user"></i><span class="break"></span>Categoría de videos</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>Nombre</th>
								  <th>Creado por</th>
								  <th>Fecha de Creación</th>
								  <th>Estado</th>
								  <th>Opciones</th>
							  </tr>
						  </thead>   
						  <tbody>

						  	@foreach($Categories as $category)
								<tr>
									<td>{!!$category->name!!}</td>																		
									<td class="center">{!! $category->Created_by->name !!}</td>									
									
									<td class="center">{!! $category->created_at !!}</td>
										<?php 
											if (is_null($category->deleted_at)) {
												$route_edit = "/video_category/".$category->id."/edit";
												$route_destroy = "/video_category/".$category->id."/inactive";

												$status = "active";
											}else{

												$route_untrashed = "/video_category/".$category->id."/untrashed";
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
							@endforeach
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->

		</div>

@endsection