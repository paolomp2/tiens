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
				<a href="#">Insertar Video</a>
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

		{!! Form::Hidden('url', $url, array('id'=>'url')) !!}
		{!! Form::Hidden('movie_folder', $movie_folder, array('id'=>'movie_folder')) !!}
		
		{!!Form::open(['route'=>'movie.store','method'=>'POST', 'files' => true, 'class'=>'form-horizontal'])!!}		<div class="row-fluid sortable">
			{!! Form::Hidden('Video', '-1', array('id'=>'id_movie')) !!}
			{!! Form::Hidden('id_youtube', null, array('id'=>'id_youtube')) !!}
			{!! Form::Hidden('form_type','create', array('id'=>'form_type')) !!}
			<div class="box span12">
				<div class="box-header" data-original-title>
					<h2><i class="halflings-icon edit"></i><span class="break"></span>Insertar Video</h2>						
				</div>
				<div class="box-content">
					<form class="form-horizontal">
						<fieldset>

						  <div class="control-group">

							<label class="control-label" for="focusedInput">(*)Título</label>
							<div class="controls">							  
							  {!! Form::text('title', null, array('id'=>'video_name', 'class'=>'input-xlarge', 'placeholder'=>'Ingrese el título del Video')) !!}
							</div>

						  </div>
						  
						  <div class="control-group">
							<label class="control-label">(*)Seleccionar Imagen</label>
							<div class="controls">
							  {!! Form::file('imagen', null) !!}
							</div>
						  </div>
						  
						  <div class="control-group">
							<label class="control-label">(*)Contenido de la Video</label>
							<div class="controls">							  
							  {!! Form::textarea('content', null, array('id'=>'video_content', 'class'=>'input-xlarge', 'placeholder'=>'Ingrese el contenido de la Video')) !!}
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
							<label class="control-label" for="selectError">(*)Categoría</label>
							<div class="controls">
								{!!Form::select('category',$categories_option,null,array('data-rel'=>'chosen'))!!}							  
							</div>
						  </div>

						  <div class="control-group">

							<label class="control-label" for="focusedInput">(*)Enlace a YouTube</label>
							<div class="controls">							  
							  {!! Form::text('youtube_link', null, array('id'=>'youtube_link', 'class'=>'input-xlarge', 'placeholder'=>'Ingrese el título del Video')) !!}
								<a href="#" id='youtube_verify' class="btn btn-success">Verificar</a>
							</div>

						  </div>
						  <div class="control-group" id = 'youtube_video_preview'>							
						  </div>

						  <div class="control-group" id = 'youtube_video_message'>							
						  </div>

						  <div class="control-group" id='video_file_group_low'>
							<label class="control-label">(*)Seleccionar Video en baja calidad</label>
							<div class="controls">
							  <input name='video_file_low' type='file' id='video_file_low'>
							</div>
						  </div>

						  <div class="control-group" id = 'video_updating_low'>							
						  </div>

						  <div class="control-group" id = 'video_preview_low'>							
						  </div>

						  <div class="control-group" id='video_file_group_hight'>
							<label class="control-label">(*)Seleccionar Video en alta calidad</label>
							<div class="controls">
							  <input name='video_file_hight' type='file' id='video_file_hight'>
							</div>
						  </div>

						  <div class="control-group" id = 'video_updating_hight'>							
						  </div>

						  <div class="control-group" id = 'video_preview_hight'>							
						  </div>

						  <div class="form-actions">
							<button id="btn_submit" type="submit" class="btn btn-primary">Guardar Cambios</button>
							<a class="btn" href="/movie">Cancelar</a></button>
						  </div>
						</fieldset>
					  </form>
				
				</div>
			</div><!--/span-->
		
		</div><!--/row-->
		{!!Form::Close()!!}
	</div>


@endsection