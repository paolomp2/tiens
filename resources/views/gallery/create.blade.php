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
				<a href="#">Crear Gallería</a>
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

		{!!Form::open(['route'=>'gallery.store','method'=>'POST', 'files' => true, 'class'=>'form-horizontal'])!!}		<div class="row-fluid sortable">
			<div class="box span12">
				<div class="box-header" data-original-title>
					<h2><i class="halflings-icon edit"></i><span class="break"></span>Crear Gallería</h2>						
				</div>
				<div class="box-content">
					<form class="form-horizontal">
						<fieldset>
						  {!! Form::hidden('sessionMath', $sessionMath, array('id'=>'sessionMath', 'type' => 'hidden' )) !!}
						  {!! Form::hidden('model', $model, array('id'=>'model')) !!}
						  {!! Form::hidden('edit_flag', $edit_flag, array('id'=>'edit_flag')) !!}
						  <div class="control-group">

							<label class="control-label" for="focusedInput">(*)Título</label>
							<div class="controls">							  
							  {!! Form::text('title', null, array('required'=>'','id'=>'gallery_name', 'class'=>'input-xlarge', 'placeholder'=>'Ingrese el título del Gallería')) !!}
							</div>

						  </div>
						  
						  <div class="control-group">
							<label class="control-label">(*)Contenido de la Gallería</label>
							<div class="controls">							  
							  {!! Form::textarea('content', null, array('id'=>'gallery_content', 'class'=>'input-xlarge', 'placeholder'=>'Ingrese el contenido de la Gallería')) !!}
							</div>
						  </div>

						  <div class="control-group">
							<label class="control-label">(*)Seleccionar Imagen</label>
							<div class="controls">
								<input type="file" name="imagen" accept="image/*" multiple >
							  
							</div>
						  </div>

						  @if($rol == 1)
						  <div class="control-group">
							<label class="control-label" for="selectError1">(*)Seleccione Países</label>
							<div class="controls">
								{!!Form::select('countries',$options_countries,null,array('required'=>'','data-rel'=>'chosen', 'multiple'=>'multiple','name'=>'countries[]'))!!}							  
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
								<div>
								{!! Form::hidden('numFiles', 0, array('id'=>'numFiles', 'type' => 'hidden' )) !!}	
									<div class='controls'>
										<input type="file" id='file_document' name="file_document" accept="image/*" multiple>
									</div>
									
							    </div>
						    </div>

						    <div class="control-group">
								
								<div >
									<div class="controls" >
										<span></span>
										<table id='files' class='table table-striped table-bordered bootstrap-datatable'>
											<thead>
												<tr>
													<th>Imagen</th>
													<th>Estado</th>
													<th>Opciones</th>
												</tr>
											</thead>
											<tbody id='file_list'>
											</tbody>
										</table>
									</div>
							    </div>
						    </div>

						  <div class="form-actions">
							<button id="btn_submit" type="submit" class="btn btn-primary">Guardar Cambios</button>
							<a class="btn" href="/gallery">Cancelar</a></button>
						  </div>
						</fieldset>
					  </form>
				
				</div>
			</div><!--/span-->
		
		</div><!--/row-->
		{!!Form::Close()!!}
	</div>


@endsection