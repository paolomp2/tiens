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
				<a href="#">Registrar León</a>
			</li>
		</ul>

		@if (count($errors) > 0)
		    <div class="alert alert-block span10">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif

		{!!Form::open(['route'=>'lion.store','method'=>'POST', 'files' => true,'class'=>'form-horizontal'])!!}
		<div class="row-fluid sortable">
			<div class="box span12">
				<div class="box-header" data-original-title>
					<h2><i class="halflings-icon edit"></i><span class="break"></span>Registrar León</h2>						
				</div>
				<div class="box-content">
					<form class="form-horizontal">
						<fieldset>
						  
						  <div class="control-group">

							<label class="control-label" for="focusedInput">(*)Nombre</label>
							<div class="controls">							  
							  {!! Form::text('name', null, array('id'=>'lion_name', 'class'=>'input-xlarge', 'placeholder'=>'Ingrese el nombre')) !!}
							</div>

						  </div>
						  
						  <div class="control-group">
							<label class="control-label">(*)Descripción</label>
							<div class="controls">							  
							  {!! Form::textarea('content', null, array('id'=>'lion_content', 'class'=>'input-xlarge', 'placeholder'=>'Ingrese la descripción')) !!}
							</div>
						  </div>

						  <div class="control-group">
							<label class="control-label">(*)Seleccionar Imagen</label>
							<div class="controls">
							  {!! Form::file('imagen', null) !!}
							</div>
						  </div>						  
						  
						  <div class="form-actions">
							<button type="submit" class="btn btn-primary">Guardar Cambios</button>
							<a class="btn" href="/lion">Cancelar</a></button>
						  </div>
						</fieldset>
					  </form>
				
				</div>
			</div><!--/span-->
		
		</div><!--/row-->
		{!!Form::Close()!!}
	</div>


@endsection