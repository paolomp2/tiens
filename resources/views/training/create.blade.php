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
				<a href="/">Home</a>
				<i class="icon-angle-right"></i> 
			</li>
			<li>
				<i class="icon-edit"></i>
				<a href="#">Crear Capacitación</a>
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

		{!!Form::open(['route'=>'training.store','method'=>'POST', 'files' => true, 'class'=>'form-horizontal'])!!}		<div class="row-fluid sortable">
			<div class="box span12">
				<div class="box-header" data-original-title>
					<h2><i class="halflings-icon edit"></i><span class="break"></span>Crear Capacitación</h2>						
				</div>
				<div class="box-content">
					<form class="form-horizontal">
						<fieldset>
						  {!! Form::hidden('sessionMath', $sessionMath, array('id'=>'sessionMath', 'type' => 'hidden' )) !!}
						  {!! Form::hidden('model', $model, array('id'=>'model')) !!}
						  <div class="control-group">

							<label class="control-label" for="focusedInput">(*)Título</label>
							<div class="controls">							  
							  {!! Form::text('title', null, array('id'=>'training_name', 'class'=>'input-xlarge', 'placeholder'=>'Ingrese el título de la Capacitación')) !!}
							</div>

						  </div>
						  
						  <div class="control-group">
							<label class="control-label">(*)Contenido de la Capacitación</label>
							<div class="controls">							  
							  {!! Form::textarea('content', null, array('id'=>'training_content', 'class'=>'input-xlarge', 'placeholder'=>'Ingrese el contenido de la Capacitación')) !!}
							</div>
						  </div>

						  <div class="control-group">
							<label class="control-label">(*)Seleccionar Imagen</label>
							<div class="controls">
							  {!! Form::file('imagen', null) !!}
							</div>
						  </div>

						  @if($rol == 1)
						  <div class="control-group">
							<label class="control-label" for="selectError1">(*)Seleccione Países</label>
							<div class="controls">
								{!!Form::select('countries',$options_countries,null,array('data-rel'=>'chosen', 'multiple'=>'multiple','name'=>'countries[]'))!!}							  
							</div>
						  </div>
						  @endif

						  <div class="control-group">
							<label class="control-label" for="selectError">(*)Categoría</label>
							<div class="controls">
								{!!Form::select('category',$options_selected,null,array('data-rel'=>'chosen'))!!}							  
							</div>
						  </div>

					    	
						  	
						  	<div class="control-group">
								<label class="control-label">(*)Seleccionar Archivos</label>
								<div id="files">
								{!! Form::hidden('numFiles', 0, array('id'=>'numFiles', 'type' => 'hidden' )) !!}	
									<div class='controls'><input name='file_document' type='file' id='file_document'></div>
									<div class="controls">
										<span></span>
										<ul id='file_list'>
										</ul>
									</div>
							    </div>
						    </div>


						  <div class="form-actions">
							<button type="submit" class="btn btn-primary">Guardar Cambios</button>
							<a class="btn" href="/training">Cancelar</a></button>
						  </div>
						</fieldset>
					  </form>
				
				</div>
			</div><!--/span-->
		
		</div><!--/row-->
		{!!Form::Close()!!}
	</div>


@endsection