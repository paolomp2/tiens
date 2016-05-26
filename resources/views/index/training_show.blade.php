<!DOCTYPE html>
<html lang="es">
	@include('layouts.head')
	<body>
  
  <div class="container">
    @include('layouts.container')
  </div>

  <section class="main-content">
    <div class="container">
      <div class="wrapper-content bg-transparent small-space">
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <div class="sidebar-inverse">
              <div class="box-sidebar">
                <div class="top-sidebar text-center">
                  <h3>AMPLIA TUS CONOCIMIENTOS</h3>
                </div>
                <div class="body-sidebar">
                  <h4>{!!$data['training_category_show']->name!!}</h4>
                  <ul>
                  	@foreach($data['trainings_category'] as $training_category)
              			<li>
                  		<?php $url ="capacitaciones/".$training_category['id_encode']  ?>
                      	{!!HTML::link($url,$training_category->name)!!}
                      	</li>
                  	@endforeach
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="wrap-medium">
            	
              <div class="cover-medium" style=background-image:url({!!asset("images/training/training_".$data['training_show']->id.".".$data['training_show']->extension)!!})></div>
              <div class="content-medium">
                <h2 class="title-green-line lg-title">
                  {!!$data['training_show']->name!!}
                </h2>
                <p></p>
                {!!$data['training_show']->description!!}
              </div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-3">
            <aside class="sidebar">
              <div class="box-sidebar">
                <div class="top-sidebar">
                  <h2 class="title-green-line md-title">Banco de materiales</h2>
                </div>
                <div class="body-sidebar md-sidebar">
                  <ul class="links-resources">
                  	@foreach($data['documents'] as $document)
                    <?php $document->original_name=mb_strimwidth($document->original_name, 0, 22, "...");?>
                  	<li><a href={!!asset("documentos/".$document->id.".".$document->extension)!!} download={!!$document->original_name!!} class="bg bg-png">{!!$document->original_name!!}</a></li>
                  	@endforeach                                  
                  </ul>
                </div>
              </div>
              <div class="box-sidebar">
                <div class="top-sidebar">
                  <h2 class="title-green-line md-title">Últimas capacitaciones</h2>
                </div>
                <div class="body-sidebar md-sidebar no-space">
                  <ul class="links-resources">

                  	@foreach($data['trainings'] as $training)
                  	<li>
                  		<?php $url ="capacitaciones/".$training['id_encode']  ?>
                      	{!!HTML::link($url,$training->name)!!}
                  	</li>
                  	@endforeach                    
                  </ul>
                </div>
              </div>
            </aside>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="container">
  @include('layouts.footer')
  </div>

	@include('layouts.scripts')

	</body>
</html>