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
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <aside class="sidebar">
              <div class="box-sidebar">
                <div class="top-sidebar">
                  <h2 class="title-green-line lg-title">Categorías</h2>
                </div>
                <div class="body-sidebar">
                  <ul class="links-resources">
                    @foreach($data['trainings_categories'] as $training_category)
                    <li>
                      <?php $url ="capacitacionesCat/".$training_category['id_encode']  ?>
                      {!!HTML::link($url,$training_category->name)!!}
                    </li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </aside>
          </div>
          <div class="col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-7">
            <div class="recursos">
              <div class="top-recursos">
                <h2 class="title-green-line lg-title">Últimas Capacitaciones</h2>
              </div>
              <div class="body-recursos">
                <div class="list-recursos">
                  @foreach($data['trainings'] as $training)
                  <div class="box-recurso">
                    <div class="row">
                      <div class="col-xs-12 col-sm-6">
                        <div class="m-10">
                          <div class="cover-recurso" style= background-image:url({!!asset("images/training/training_".$training->id.".".$training->extension)!!})></div>
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-6">
                        <div class="m-10">
                          <div class="wrap-recurso">
                            <h2>
                              <?php $url ="capacitaciones/".$training['id_encode']  ?>
                              {!!HTML::link($url,$training->name)!!}
                            </h2>
                            <?php $training->description=mb_strimwidth($training->description, 0, 220, "...");?>
                            <div class="text-cut">{!!$training->description!!}</div>
                            <p class="post-meta">{!!$training->created_at!!}</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach                  
                </div>
                <div class="pagination-eventos text-center">
                  <ul class="pagination">
                    {!! $data['trainings']->render() !!}
                  </ul>
                </div>
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