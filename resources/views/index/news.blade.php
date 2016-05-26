<!DOCTYPE html>
<html lang="es">
	@include('layouts.head')
	<body>
  
  <div class="container">
    @include('layouts.container')
  </div>

  <section class="main-content">
    <div class="container">
      <div class="wrapper-content">

        <div class="box-new">
          <div class="row">
            <div class="col-xs-offset-0 col-sm-offset-2 col-xs-12 col-sm-8">
              <div class="list-news">
                <div class="top-news">
                  <div class="row">
                    <div class="col-xs-12 col-sm-5">
                      <h4>Noticias</h4>
                    </div>
                  </div>
                </div>
                <div class="wrapper-list-news">
                  @foreach($data['newspaper'] as $news)
                  <article class="new">
                    <?php $route_bg_news="background-image:url('images/news/news_".$news->id.".".$news->extension."')";?>
                    <div class="cover-new" style={!!$route_bg_news!!}></div>
                    <div class="new-content">
                      <?php $url ="noticias/".$news['id_encode'] ?>
                      <h2><a href={!!$url!!}>{!!$news->name!!}</a></h2>
                      <p>{!!$news->description!!}</p>
                      <div class="more-data">
                        <div class="row">
                          <div class="col-xs-12 col-md-9">
                            <?php  $time = date('D j F, Y',strtotime($news->created_at));?>
                            <p class="post-meta">{!!$time!!}</p>
                          </div>
                          <div class="col-xs-12 col-md-3 text-right">                            
                            {!!HTML::link($url,"Ver más", array('class'=>'btn btn-green btn-box'))!!}
                            
                          </div>
                        </div>
                      </div>
                    </div>
                  </article>
                  @endforeach
                </div>
              </div>
              <div class="news-pagination">
                <ul class="pagination">                  
                  {!! $data['newspaper']->render() !!}
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