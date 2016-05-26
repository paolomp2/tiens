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
				<a href="#">Editar Evento</a>
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

		

		{!!Form::model($event,['route'=> ['event.update', $event->id],'method'=>'PUT', 'files' => true,'class'=>'form-horizontal'])!!}
		<div class="row-fluid sortable">
			<div class="box span12">
				<div class="box-header" data-original-title>
					<h2><i class="halflings-icon edit"></i><span class="break"></span>Editar Evento</h2>						
				</div>
				<div class="box-content">
					<form class="form-horizontal">
						<fieldset>
						  
						  <div class="control-group">

							<label class="control-label" for="focusedInput">(*)Título</label>
							<div class="controls">							  
							  {!! Form::text('title', $event->name, array('required'=>'','id'=>'event_name', 'class'=>'input-xlarge')) !!}
							</div>

						  </div>

						  <div class="control-group">
							  <label class="control-label" for="date01">Fecha</label>
							  <div class="controls">
								{!!Form::date('date', $event->date_celebration);!!}
							  </div>
							</div>

							<div class="control-group">
							  <label class="control-label" for="date01">Hora</label>
							  <div class="controls">
								<input name="hour" id="single-input" value=<?php echo $event->hour_celebration;?> placeholder= "Now" style="width:80px;margin-right:20px;" required="">
							  </div>

							</div>
						  
						  <div class="control-group">
							<label class="control-label">(*)Contenido del Evento</label>
							<div class="controls">							  
							  {!! Form::textarea('content', $event->description, array('id'=>'event_content', 'class'=>'input-xlarge', 'placeholder'=>'Ingrese el contenido del Evento')) !!}
							</div>
						  </div>

						  <div class="control-group">
							<label class="control-label">(*)Seleccione una nueva imagen para reemplazar a la anterior</label>
							<div class="controls">
							  {!! Form::file('imagen', null) !!}
							</div>
						  </div>

						  <div class="control-group">

							<label class="control-label" for="focusedInput">(*)Lugar</label>
							<div class="controls">							  
							  {!! Form::text('site', $event->site, array('id'=>'event_name', 'class'=>'input-xlarge', 'placeholder'=>'Ingrese el lugar del evento')) !!}
							</div>

						  </div>

						  

						  <div class="control-group">
							<label class="control-label" for="selectError">Categoría</label>
							<div class="controls">
								{!!Form::select('category',$options_category,$option_selected,array('data-rel'=>'chosen'))!!}							  
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