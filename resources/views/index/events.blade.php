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

        <div class="box-eventos">
          <div class="row">
            <div class="col-xs-offset-0 col-sm-offset-1 col-xs-12 col-sm-10">
              <div class="list-eventos">
                <div class="wrapper-list-eventos">
                  
                  @foreach($data['events'] as $event)
                  <article class="box-evento">
                    <div class="row">
                      <div class="col-xs-12 col-sm-3">
                        <div class="m-10">
                          <?php $route_bg_event="background-image:url('images/event/event_".$event->id.".".$event->extension."')";?>
                          <div class="cover-evento" style={!!$route_bg_event!!}></div>
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-9">
                        <div class="m-10">                          
                          <?php $url="agenda/".$event['id_encode']?>
                          <h2><a href={!!$url!!}>{!!$event->name!!}</a></h2>
                          <h3>{!!$event->Category->name!!}</h3>
                          <p class="post-meta">{!!$event->date_format!!} a las {!!$event->hour_celebration!!}hrs</p>
                          <h4>{!!$event->site!!}</h4>
                          <div class="text-cut">{!!$event->description!!}</div>
                        </div>
                      </div>
                    </div>
                  </article>
                  @endforeach
                </div>
              </div>
              <div class="pagination-eventos text-center">
                <ul class="pagination">
                  {!! $data['events']->render() !!}
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