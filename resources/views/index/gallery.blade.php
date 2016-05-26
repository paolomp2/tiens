<!DOCTYPE html>
<html lang="es">
	@include('layouts.head')
	<body>
  
  <div class="container">
    @include('layouts.container')
  </div>

  <section class="main-content">
    <div class="container">
      <div class="wrapper-content bg-transparent">
        <div class="box-gallery">
          <h2 class="title-orange-line">Últimas Galerías</h2>
          <div class="gallery-events gallery-190">
            <div class="row">
            	@foreach($data['last_galleries'] as $last_gallery)

              <div class="col-xs-12 col-sm-1-5">
                <div class="box-gallery-orange">
                  <div class="wrap-box-hover">
                    <div class="box-img-hover">
                      <div class="bg-img-hover" style=background-image:url({!!asset("images/gallery/gallery_".$last_gallery->id.".".$last_gallery->extension)!!})></div>
                      <div class="body-box-img">
                        <div class="table-view">
                          	<?php $url ="galeria/".$last_gallery['id_encode'] ?>
                  			{!!HTML::link($url,$last_gallery->description, array('class'=>'vertical-align'))!!}
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="cont-box-hover">
                    <p>{!!$last_gallery->name!!}</p>
                  </div>
                </div>
              </div>

              	@endforeach
              
            </div>
          </div>
        </div>
        <div class="box-gallery main-gallery">
          <h2 class="title-orange-line">Galerías Eventos</h2>
          <div class="gallery-events gallery-190">
            <div class="row">

            	@foreach($data['galleries_event'] as $gallery_event)
        		<div class="col-xs-12 col-sm-4">
	                <div class="box-gallery-orange">
	                  <div class="wrap-box-hover">
	                    <div class="box-img-hover">
	                      <div class="bg-img-hover" style=background-image:url({!!asset("images/gallery/gallery_".$gallery_event->id.".".$gallery_event->extension)!!})></div>
	                      <div class="body-box-img">
	                        <div class="table-view">
	                          <?php $url ="galeria/".$gallery_event['id_encode'] ?>
                      			{!!HTML::link($url,$gallery_event->description, array('class'=>'vertical-align'))!!}
	                        </div>
	                      </div>
	                    </div>
	                  </div>
	                  <div class="cont-box-hover">
	                    <p>{!!$gallery_event->name!!}</p>
	                  </div>
	                </div>
              	</div>
            	@endforeach

              
              

            </div>
          </div>
          <div class="row">
            <div class="col-xs-offset-0-5 col-xs-12 col-sm-offset-2-5 col-sm-1-5 cont-buttom">
              <button type="button" id="more-gallery" class="btn btn-green btn-block">Ver más</button>
            </div>
          </div>
        </div>
        <div class="box-gallery">
          <h2 class="title-orange-line">Otras Galerías</h2>
          <div class="gallery-events gallery-190">
            <div class="row">

              @foreach($data['galleries_other'] as $gallery_event)
        		<div class="col-xs-12 col-sm-4">
	                <div class="box-gallery-orange">
	                  <div class="wrap-box-hover">
	                    <div class="box-img-hover">
	                      <div class="bg-img-hover" style=background-image:url({!!asset("images/gallery/gallery_".$gallery_event->id.".".$gallery_event->extension)!!})></div>
	                      <div class="body-box-img">
	                        <div class="table-view">
	                        	<?php $url ="galeria/".$gallery_event['id_encode'] ?>
                      			{!!HTML::link($url,$gallery_event->description, array('class'=>'vertical-align'))!!}
	                        </div>
	                      </div>
	                    </div>
	                  </div>
	                  <div class="cont-box-hover">
	                    <p>{!!$gallery_event->name!!}</p>
	                  </div>
	                </div>
              	</div>
            	@endforeach
              
            </div>
          </div>
          <div class="row">
            <div class="col-xs-offset-0-5 col-xs-12 col-sm-offset-2-5 col-sm-1-5 cont-buttom">
              <button type="button" class="btn btn-green btn-block">Ver más</button>
            </div>
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