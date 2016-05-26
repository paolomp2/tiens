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
				<a href="#">Crear Evento</a>
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

		{!!Form::open(['route'=>'event.store','method'=>'POST', 'files' => true,'class'=>'form-horizontal'])!!}
		<div class="row-fluid sortable">
			<div class="box span12">
				<div class="box-header" data-original-title>
					<h2><i class="halflings-icon edit"></i><span class="break"></span>Crear Evento</h2>						
				</div>
				<div class="box-content">
					<form class="form-horizontal">
						<fieldset>
						  
						  <div class="control-group">

							<label class="control-label" for="focusedInput">(*)Título</label>
							<div class="controls">							  
							  {!! Form::text('title', null, array('required'=>'','id'=>'event_name', 'class'=>'input-xlarge', 'placeholder'=>'Ingrese el título del Evento')) !!}
							</div>

						  </div>

						  <div class="control-group">
							  <label class="control-label" for="date01">Fecha</label>
							  <div class="controls">
								{!!Form::date('date', \Carbon\Carbon::now());!!}
							  </div>
							</div>

						<div class="control-group">
						  <label class="control-label" for="date01">Hora</label>
						  <div class="controls">
							<input name="hour" id="single-input" value="" placeholder="Now" style="width:80px;margin-right:20px;" required="">
						  </div>

						</div>
						  
						  <div class="control-group">
							<label class="control-label">(*)Contenido del Evento</label>
							<div class="controls">							  
							  {!! Form::textarea('content', null, array('id'=>'event_content', 'class'=>'input-xlarge', 'placeholder'=>'Ingrese el contenido del Evento')) !!}
							</div>
						  </div>

						  <div class="control-group">
							<label class="control-label">(*)Seleccionar Imagen</label>
							<div class="controls">
							  {!! Form::file('imagen', null) !!}
							</div>
						  </div>

						  @if($rol==1)				  

			  				<div class="control-group">
								<label class="control-label">(*)País</label>
								<div class="controls">
									{!!Form::select('country',$countries_options,null,array('data-rel'=>'chosen'))!!}							  
								</div>
						  </div>
				  			@endif

						  <div class="control-group">

							<label class="control-label" for="focusedInput">(*)Lugar</label>
							<div class="controls">							  
							  {!! Form::text('site', null, array('id'=>'event_name', 'class'=>'input-xlarge', 'placeholder'=>'Ingrese el lugar del evento')) !!}
							</div>

						  </div>						  

						  <div class="control-group">
							<label class="control-label" for="selectError">Categoría</label>
							<div class="controls">
								{!!Form::select('category',$options_selected,null,array('data-rel'=>'chosen'))!!}							  
							</div>
						  </div>
						  
						  <div class="form-actions">
							<button type="submit" class="btn btn-primary">Guardar Cambios</button>
							<a class="btn" href="/event">Cancelar</a></button>
						  </div>
						</fieldset>
					  </form>
				
				</div>
			</div><!--/span-->
		
		</div><!--/row-->
		{!!Form::Close()!!}
	</div>


@endsection