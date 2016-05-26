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
				<a href="#">Editar Noticia</a>
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

		

		{!!Form::model($news,['route'=> ['news.update', $news->id],'method'=>'PUT', 'files' => true,'class'=>'form-horizontal'])!!}
		<div class="row-fluid sortable">
			<div class="box span12">
				<div class="box-header" data-original-title>
					<h2><i class="halflings-icon edit"></i><span class="break"></span>Editar Noticia</h2>						
				</div>
				<div class="box-content">
					<form class="form-horizontal">
						<fieldset>
						  
						  <div class="control-group">

							<label class="control-label" for="focusedInput">(*)Título</label>
							<div class="controls">							  
							  {!! Form::text('news_name', $news->name, array('id'=>'news_name', 'class'=>'input-xlarge')) !!}
							</div>

						  </div>
						  
						  <div class="control-group">
							<label class="control-label">(*)Contenido de la Noticia</label>
							<div class="controls">							  
							  {!! Form::textarea('news_content', $news->description, array('id'=>'news_content', 'class'=>'input-xlarge', 'placeholder'=>'Ingrese el contenido del Noticia')) !!}
							</div>
						  </div>

						  <div class="control-group">
							<label class="control-label">(*)Seleccione una nueva imagen para reemplazar a la anterior</label>
							<div class="controls">
							  {!! Form::file('imagen', null) !!}
							</div>
						  </div>
						  @if($rol==1)
						  <div class="control-group">
							<label class="control-label" for="selectError1">(*)Seleccione Países</label>
							<div class="controls">
								<?php
									$i=0;
									foreach ($news->countries as $country) {
										$id_countries_selected_less_one[$i++] = $country->id-1;
									}
								?>
								{!!Form::select('countries',$options,$id_countries_selected_less_one,array('data-rel'=>'chosen', 'multiple'=>'multiple','name'=>'countries[]'))!!}							  
							</div>
						  </div>
						  @endif
						  <div class="form-actions">
							<button type="submit" class="btn btn-primary">Guardar Cambios</button>
							<a class="btn" href="/news">Cancelar</a></button>
						  </div>
						</fieldset>
					  </form>
				
				</div>
			</div><!--/span-->
		
		</div><!--/row-->
		{!!Form::Close()!!}
	</div>


@endsection