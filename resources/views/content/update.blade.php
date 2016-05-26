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
				@if($content->id==1)
					<a href="#">Editar Misión</a>
				@elseif($content->id==2)
					<a href="#">Editar Visión</a>
				@elseif($content->id==3)
					<a href="#">Editar Valores</a>
				@elseif($content->id==4)
					<a href="#">Editar Quienes somos</a>
				@endif
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

		

		{!!Form::model($content,['route'=> ['content.update', $content->id],'method'=>'PUT', 'files' => true,'class'=>'form-horizontal'])!!}
		<div class="row-fluid sortable">
			<div class="box span12">
				<div class="box-header" data-original-title>
					<h2><i class="halflings-icon edit"></i><span class="break"></span>Editar contento</h2>						
				</div>
				<div class="box-content">
					<form class="form-horizontal">
						<fieldset>
						  
						  <div class="control-group">
							<label class="control-label">(*)Contenido</label>
							<div class="controls">							  
							  {!! Form::textarea('content', $content->description, array('id'=>'content_content', 'class'=>'input-xlarge', 'placeholder'=>'Ingrese el contenido')) !!}
							</div>
						  </div>
						  					  
						  <div class="form-actions">
							<button type="submit" class="btn btn-primary">Guardar Cambios</button>
							<a class="btn" href="/content">Cancelar</a></button>
						  </div>
						</fieldset>
					  </form>
				
				</div>
			</div><!--/span-->
		
		</div><!--/row-->
		{!!Form::Close()!!}
	</div>


@endsection