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
          <div class="col-xs-12 col-sm-9">

            <div class="tiens-carousel">
              <div id="carousel-tiens-tv" class="carousel slide" data-ride="carousel">

                <ol class="carousel-indicators">
                  
                  <?php $i=0;?>
                  @foreach($data['movies_to_Show'] as $movie)
                  @if($i==0)
                  <li data-target="#carousel-tiens-tv" data-slide-to="0" class="active"></li>
                  @else
                  <li data-target="#carousel-tiens-tv" data-slide-to={!!$i!!}></li>
                  @endif
                  <?php $i++;?>
                  @endforeach
                </ol>

                <div class="carousel-inner">
                	<?php $i=0;?>
                	@foreach($data['movies_to_Show'] as $movie)
                		<?php $extension="video/".$movie->extension;?>
                		@if($i==0)
        				  	<div class="item active">
        				  	@else
    				  		  <div class="item">
        				  	@endif
                      <div class="item-video" style=background-image:url({!!asset("images/movie/movies_".$movie->id.".".$movie->extension_img)!!})></div>
                      <div class="carousel-video">
                        @if($movie->flag_youtube==1)
                            <iframe width='848' height='458' src={!!'http://www.youtube.com/embed/'.$movie->youtube_link!!}> </iframe>
                        @else

                          @if($movie->flag_low_quality)
                          <?php $video_name = "video/movie_l_";?>
                          @elseif($movie->flag_hight_quality)
                          <?php $video_name = "video/movie_h_";?>
                          @else
                          <?php $video_name = "video/movie_";?>
                          @endif

                        <video id='myVideo' width='848' height='458' controls >
          				  				<source src={!!asset($video_name.$movie->id.".".$movie->extension)!!} type={!!$extension!!}>
          							  	"Your browser does not support HTML5 video."
          							</video>
                        @endif

                      </div>
                      <div class="title-caption">                      	
                          <div class="col-xs-12 col-sm-12"><h2>{!!$movie->name!!}</h2></div>
                          <div class="text-right">
                            @if($movie->flag_low_quality)
                              <a id="down_img" class="btn btn-link" download={!!$movie->name.".".$movie->extension!!} href={!!asset("video/movie_l_".$movie->id.".".$movie->extension)!!}>Descarga Baja Calidad<i class="fa fa-download"></i></a>
                            @endif
                            @if($movie->flag_hight_quality)
                              <a id="down_img" class="btn btn-link" download={!!$movie->name.".".$movie->extension!!} href={!!asset("video/movie_h_".$movie->id.".".$movie->extension)!!}>Descarga Alta Calidad<i class="fa fa-download"></i></a>
                            @endif
                          </div>
                      </div>

            	      </div>
	                  <?php $i++?>                  
                	@endforeach
                </div>

                <a class="left carousel-control" href="#carousel-tiens-tv" data-slide="prev">
                  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#carousel-tiens-tv" data-slide="next">
                  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>

              </div>
            </div>

            <div class="box-section">
              <h2 class="title-green-line lg-title">{!! $data['name_category'] or "Categorías" !!}</h2>
              <div class="cont-box-section">
                <div class="row">

                	@if($data['type_data'] == 'general')
                	@include('index.movies.show_categories')
                	@endif

                	@if($data['type_data'] == 'category')
                	@include('index.movies.one_category')
                	@endif

                </div>
              </div>
            </div>

            <div class="box-section">
              <h2 class="title-green-line lg-title">Últimos Videos</h2>
              <div class="cont-box-section">
                <div class="row">
                  
                	@foreach($data['last_movies'] as $movie)
                  <div class="col-xs-12 col-md-4">
                    <div class="m-10">
                      <div class="wrap-box-section">
                        <a style=background-image:url({!!asset("images/movie/movies_".$movie->id.".".$movie->extension_img)!!}) href={!!asset("tiens_tv/".$movie['id_encode'])!!}>
                        </a>
                        <div class="desc-box-section">
                          <p>{!!$movie->name!!}</p>
                        </div>
                        <div class="data-more">
                          <span><i class="fa fa-eye"></i> <span>{!!$movie->see_num!!}</span></span>
                          <span><i class="fa fa-clock-o"></i> <span>{!!$movie->last_time_see!!}</span></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  	@endforeach
                </div>
              </div>
            </div>

          </div>
          <div class="col-xs-12 col-sm-3">
            <aside class="sidebar">
              <div class="box-sidebar">
                <div class="top-sidebar">
                  <h2 class="title-green-line lg-title">Los más Vistos</h2>
                </div>
                <div class="body-sidebar">
                  <div class="boxes-more-views">
                    @foreach($data['most_seen'] as $movie)
                    <div class="box-more-view">
                      <div class="row">
                        <div class="col-xs-3 p-r-none">
                          <a href={!!asset("tiens_tv/".$movie['id_encode'])!!} class="link-more-view">
                            <img src={!!asset("images/movie/movies_".$movie->id.".".$movie->extension_img)!!}>
                          </a>
                        </div>
                        <div class="col-xs-9">
                          <div class="wrap-more-view">
                            <a href={!!asset("tiens_tv/".$movie['id_encode'])!!}>{!!$movie->name!!}</a>
                            <div class="data-more">
                              <span><i class="fa fa-eye"></i> <span>{!!$movie->see_num!!}</span></span>
                              <span><i class="fa fa-clock-o"></i> <span>{!!$movie->last_time_see!!}</span></span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>
              <div class="box-sidebar">
                <div class="top-sidebar">
                  <h2 class="title-green-line lg-title">Categorías</h2>
                </div>
                <div class="body-sidebar">
                  <div class="list-links">
                    <div class="row">
                      
                    	@foreach($data['categories'] as $category)
                    	@if($category['count']>0)
                      <div class="col-xs-6">
                        <a href={!!asset("tiens_tv/cat/".$category['id_encode'])!!}>{!!$category->name!!} <span class="badge">{!!$category['count']!!}</span></a>
                      </div>
                    	@endif
                    	@endforeach
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-sidebar">
              <div class="top-sidebar">
                <h2 class="title-green-line lg-title">Redes Sociales</h2>
              </div>
              <div class="body-sidebar">
                <p>Encuentranos en:</p>
                <ul class="social">
                  <li>
                    <a href="https://www.facebook.com/Tiensregionamerica" target="_blank"><i class="fa fa-facebook"></i></a>
                  </li>                  
                  <li>
                    <a href="https://www.youtube.com/user/TiensPeruOficial" target="_blank"><i class="fa fa-youtube"></i></a>
                  </li>
                </ul>
              </div>
            </div>
            </aside>
          </div>
        </div>

        <div class="row">          
          <div class="col-xs-12 col-sm-3">
            
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