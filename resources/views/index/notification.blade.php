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
                  <i class="glyphicon glyphicon-search"></i> Notificaciones </i>
                </h3>
              </div>
              <div class="list-notif">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th class="date">Fecha</th>
                      <th class="status">Elemento</th>
                      <th class="message">Mensaje</th>
                    </tr>
                  </thead>
                  <tbody>

                  	@foreach($data['notifications'] as $notification)
                    <tr>
                      <td>
                        <p>{!!$notification->created_at!!}</p>
                        
                      </td>
                      <td>

                      	<?php
                  		switch ($notification->model_type) {
                  			case 'banner':
                  				$name = "Banner";
                  				$class = "'label label-warning'";
                  				break;
                  			case 'training':
                  				$name = "Capacitación";
                  				$class = "'label label-success'";
                  				break;
                  			case 'gallery':
                  				$name = "Galería";
                  				$class = "'label label-primary'";
                  				break;
              				case 'movie':
              					$name = "Video";
                  				$class = "'label label-default'";
                  				break;
              				case 'lion':
              					  $name = "León";
                  				$class = "'label label-info'";
                  				break;
              				case 'trainer':
              					$name = "Capacitador";
                  				$class = "'label label-success'";
                  				break;
              				case 'news':
              					$name = "Noticia";
                  				$class = "'label label-danger'";
                  				break;
              				case 'event':
              					$name = "Evento";
                  				$class = "'label label-success'";
                  				break;
                  			default:
                  				$name = "";
                  				$class = "'label label-danger'";
                  				break;
                  		}
                      	?>

                        <span class={!!$class!!}>{!!$name!!}</span>
                      </td>
                      <td>
                        <p>{!!$notification->message!!}</p>
                      </td>
                    </tr>
                    @endforeach

                  </tbody>
                </table>
              </div>
              <div class="pagination-notif text-right">
                <ul class="pagination">
                  
                  {!! $data['notifications']->render() !!}

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