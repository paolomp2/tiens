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
				<a href="#">Mostrar Videos</a>
			</li>
		</ul>

		
			<a class="btn btn-primary" href="movie/create">Agregar Videos</a></button>
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
						<h2><i class="halflings-icon user"></i><span class="break"></span>Videos</h2>
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
								  <th>Descripción</th>
								  <th>Creado por</th>
								  @if($rol==1)
								  	<th>País asociado</th>
							  	  @endif
								  <th>Fecha de Creación</th>
								  <th>Estado</th>
								  <th>Opciones</th>
							  </tr>
						  </thead>   
						  <tbody>

						  	<?php $i=1;?>
						  	@foreach($movies as $movie)
								<tr>
									<td>{!!$i!!}</td>
									<td>{!!$movie->name!!}</td>
									<td>{!!$movie->description!!}</td>								
									<td class="center">{!! $movie->User->name !!}</td>
									@if($rol==1)
									<td class="center">
										{!! $movie->Country->name !!}
									</td>
									@endif
									<td class="center">{!! $movie->created_at !!}</td>
										<?php 
											if (is_null($movie->deleted_at)) {
												$route_edit = "/movie/".$movie->id."/edit";
												$route_destroy = "/movie/".$movie->id."/inactive";

												$status = "active";
											}else{

												$route_untrashed = "/movie/".$movie->id."/untrashed";
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