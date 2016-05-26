<!DOCTYPE html>
<html lang="es">
	@include('layouts.head')
	<body>
  
  <div class="container">
    @include('layouts.container')
  </div>

  <section class="main-content">
    <div class="container">
      <div class="wrapper-content small-space">
        <div class="row">
          <div class="col-xs-12 col-md-11">
            <div class="notifications">
              <div class="top-notif">
                <h3>
                  <img src={!!asset("index/images/bulb.png")!!}> Resultados
                </h3>
              </div>
              <div class="list-notif">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th class="date">Fecha</th>
                      <th class="status">Elemento</th>
                      <th class="message">Resultado</th>
                    </tr>
                  </thead>
                  <tbody>

                  	@foreach($data['results'] as $resoult)

                    <tr>
                      <td>
                        <p><a href="#">{!!$resoult['created']!!}</a></p>                        
                      </td>
                      <td>
                        @if($resoult['type'] == "Noticia")
                        <span class="label label-danger">Noticia</span>
                        @elseif($resoult['type'] == "Evento")
                        <span class="label label-success">Evento</span>
                        @elseif($resoult['type'] == "Capacitación")
                        <span class="label label-warning">Capacitación</span>
                        @elseif($resoult['type'] == "Galería")
                        <span class="label label-primary">Galería</span>
                        @elseif($resoult['type'] == "Video")
                        <span class="label label-default">Video</span>
                        @elseif($resoult['type'] == "León")
                        <span class="label label-info">León</span>
                        @elseif($resoult['type'] == "Capacitador")
                        <span class="label label-success">Capacitador</span>
                        @endif

                      </td>
                      <td>
                        <p>
                        	<?php $url ="noticias/".$resoult['id_encode'] ?>
                  			{!!HTML::link($url,$resoult['name'])!!}
                        </p>
                      </td>
                    </tr>
                    @endforeach

                  </tbody>
                </table>
              </div>
              <div class="pagination-notif text-right">
                <ul class="pagination">
                  {!! $data['results']->render() !!}
                </ul>
              </div>
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