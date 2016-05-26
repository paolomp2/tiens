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
				<a href="#">Crear categoría de eventos</a>
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

		{!!Form::model($category,['route'=> ['event_category.update', $category->id],'method'=>'PUT','class'=>'form-horizontal'])!!}
		<div class="row-fluid sortable">
			<div class="box span12">
				<div class="box-header" data-original-title>
					<h2><i class="halflings-icon edit"></i><span class="break"></span>Editar categoría de eventos</h2>						
				</div>
				<div class="box-content">
					<form class="form-horizontal">
						<fieldset>
						  
						  <div class="control-group">

							<label class="control-label" for="focusedInput">(*)Nombre de la categoría de eventos</label>
							<div class="controls">							  
							  {!! Form::text('category_name', $category->name, array('id'=>'category_name', 'class'=>'input-xlarge', 'placeholder'=>'Ingrese el nombre de la categoría de eventos')) !!}
							</div>

						  </div>
						  
						  <div class="form-actions">
							<button type="submit" class="btn btn-primary">Guardar Cambios</button>
							<a class="btn" href="/event_category">Cancelar</a></button>
						  </div>
						</fieldset>
					  </form>
				
				</div>
			</div><!--/span-->
		
		</div><!--/row-->
		{!!Form::Close()!!}
	</div>


@endsection