<!DOCTYPE html>
<html lang="es">
@include('layouts.head')

<body>
    <div class="container">
        @include('layouts.container')
        <section class="space-bottom">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <?php $i=0; ?> @foreach($data['banners'] as $banner) @if($i==0)
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    @else
                    <li data-target="#carousel-example-generic" data-slide-to={!!$i!!}></li>
                    @endif
                    <?php $i++; ?> @endforeach
                </ol>
                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <?php $i=0; ?> @foreach($data['banners'] as $banner)
                    <?php
                      if ($i==0) {
                        echo "<div class='item active'>";
                        $i=1;
                      }else{
                        echo "<div class='item'>";
                      }
                    ?>
                        <?php $image_name = "images/banner/banner_".$banner->id.".".$banner->extension ?> {!! Html::image($image_name,'a picture') !!}
                        <div class="carousel-caption">
                            <div class="bg-caption">
                                <h2>{!! $banner->name !!}</h2>
                            </div>
                            <div class="bg-caption">
                                <p>{!! $banner->description !!}</p>
                            </div>
                        </div>
                </div>
                @endforeach
            </div>
            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
    </div>
    </section>
    <section class="last-news space-bottom">
        <div class="top-news">
            <div class="container-fluid">
                <div class="row">
                    <h3>Últimas Noticias</h3>
                    <a href="/noticias">Ver más</a>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="owl-carousel owl-theme last-news-carousel">
            @foreach($data['newspaper'] as $news)
            <div class="item">
                <div class="body-new">
                    <figure>
                        <?php $image_name = "images/news/news_".$news->id.".".$news->extension ?> {!! Html::image($image_name,'a picture') !!}
                    </figure>
                    <div class="wrap-new">
                        <h3>
                <?php $url ="noticias/".$news['id_encode']  ?>
                {!!HTML::link($url,$news->name)!!}
              </h3>
                        <?php $news->description=mb_strimwidth($news->description, 0, 180, "...");?>
                        <div class="text-cut">{!!$news->description!!}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    <section class="space-bottom">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-8">
                <div class="cultura-organizacional">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-center">
                        <img class="cover-cultura" src="index/images/cultura.png" alt="" />
                    </div>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="wrapper-cultura">
                                    <h5>
                      <span class="c1">Conociendo más</span> 
                      <span class="c2">acerca de nuestra</span>
                      <br />
                      <span class="c3">Cultura Organizacional</span>
                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-without-padding">
                        <div class="bot-cultura">
                            <div class="row">
                                <div class="col-xs-offset-0 col-xs-12 col-md-offset-4 col-md-8">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <a href="/institucion">
                                                <span>Quiénes Somos</span>
                                            </a>
                                        </div>
                                        <div class="col-xs-4">
                                            <a href="/institucion">
                                                <span>Visión y Misión</span>
                                            </a>
                                        </div>
                                        <div class="col-xs-4">
                                            <a href="/institucion">
                                                <span>Valores</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4">
                <div class="events-schedule">
                    <div class="top-schedule">
                        <div class="container-fluid">
                            <div class="row">
                                <h3>Agenda de Eventos</h3>
                                <a href="/agenda">Ver más</a>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="owl-carousel owl-theme events-schedule-carousel">
                        @foreach($data['events'] as $event)
                        <div class="item">
                            <div class="body-schedule">
                                <div class="row">
                                    <div class="col-xs-4 ico-schedule">
                                        <figure>
                                            <img src="index/images/schedule1.png" alt="" />
                                        </figure>
                                    </div>
                                    <div class="col-xs-8 wrap-schedule">
                                        <?php $event->name=mb_strimwidth($event->name, 0, 35, "...");?>
                                        <h4>{!!$event->name!!}</h4>
                                        <?php $event->description=mb_strimwidth($event->site, 0, 82, "...");?>
                                        <p>{!!$event->description!!}</p>
                                    </div>
                                </div>
                                <div class="foot-schedule">
                                    <div class="col-xs-6 box-bot">
                                        {!!$event->date_format!!}
                                    </div>
                                    <div class="col-xs-3 box-bot">
                                        {!!$event->hour_celebration!!}
                                    </div>
                                    <div class="col-xs-3 box-bot"></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
    </section>
    </div>
    <section class="space-bottom">
        <div class="growing">
            <div class="wrapper-growing">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-offset-0 col-xs-12 col-md-offset-1">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                    <div class="grow-up">
                                        <h5>CRECIENDO CON NOSOTROS</h5>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                    <div class="message-grow-up">
                                        <p>Las herramientas necesarias para desarrollarte como Líder</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <section class="space-bottom">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-8">
                    <div class="lideres">
                        <h3 class="title-orange">LÍDERES Y CAPACITADORES</h3>
                        <div class="body-lideres box-190">
                            <div class="row">
                                <div class="col-xs-12 col-sm-5">
                                    <div class="wrapper-lideres wrap-190">
                                        <h5>Conoce a nuestros <span>capacitadores</span></h5>
                                        <p>Para alcanzar el éxito es necesario prepararte con los mejores, por esto te presentamos a nuestros L&iacute;deres Certificados como Capacitadores Nacionales.</p>
                                        <a class="btn btn-green" href="/leones_capacitadores">Ver todos</a>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-7">
                                    <div class="owl-carousel owl-theme lideres-carousel">
                                        @foreach($data['trainers'] as $trainer)
                                        <div class="item">
                                            <div class="lider-box">
                                                <div class="bg-lider">
                                                    <?php $route_bg_trainer="background-image:url('images/trainer/trainer_".$trainer->id.".".$trainer->extension."')";?>
                                                    <div class="cover-profile" style={!!$route_bg_trainer!!}></div>
                                                    <?php $trainer->description=mb_strimwidth($trainer->description, 0, 85, "...");?>
                                                    <a href="/leones_capacitadores">{!!$trainer->name!!}<br /><span>{!!$trainer->description!!}</span></a>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
                    <div class="conocimientos">
                        <h3 class="title-orange">AMPLÍA TUS CONOCIMIENTOS</h3>
                        <div class="body-conocimientos box-190">
                            <div class="owl-carousel owl-theme conocimientos-carousel">
                                @foreach($data['trainings'] as $training)
                                <div class="item">
                                    <div class="wrap-conocimientos wrap-190">
                                        <div class="row">
                                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                                <h5>Banco de materiales</h5>
                                                <div class="text-cut">{!!$training->name!!}</div>
                                                <?php $training->description=mb_strimwidth($training->description, 0, 100, "...");?>
                                                <div class="text-cut-3">{!!$training->description!!}</div>
                                                <p class="date-conocimiento">
                                                    <time datetime="2015-11-29">{!!$training['date']!!}</time>
                                                </p>
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-4 col-lg-4">
                                                <img src="index/images/file.png" />
                                            </div>
                                        </div>
                                        <a class="btn btn-green" href="/capacitaciones">Ver todos</a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="space-bottom">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="gallery-events gallery-boxes">
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <h4>Galería de Fotos</h4>
                            </div>
                            <div class="col-xs-12">
                                <div class="owl-carousel owl-theme gallery-events-carousel">
                                    <?php $i=0;?> @foreach($data['galleries'] as $gallery) @if($i%4 == 0)
                                    <div class="item row">
                                        @endif
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="wrap-box-hover">
                                                <div class="box-img-hover">
                                                    <?php $route_bg_gallery="background-image:url('images/gallery/gallery_".$gallery->id.".".$gallery->extension."')";?>
                                                    <div class="bg-img-hover" style={!!$route_bg_gallery!!}></div>
                                                    <div class="body-box-img">
                                                        <div class="table-view">
                                                            <?php $url ="galeria/".$gallery['id_encode']  ?> {!!HTML::link($url,$gallery->name, array('class'=>'vertical-align'))!!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if($i%4 == 3)
                                    </div>
                                    @endif
                                    <?php $i++;?> @endforeach @if($i%4 != 0)
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="view-more-gallery">
                                <a href="/galerias" class="btn btn-default">Ver más</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <div class="gallery-videos gallery-boxes">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <h4>Galería de Videos</h4>
                        </div>
                        <div class="col-xs-12">
                            <div class="owl-carousel owl-theme gallery-videos-carousel">
                                <?php $i=0;?> @foreach($data['movies'] as $movie) @if($i%4 == 0)
                                <div class="item row">
                                    @endif
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="wrap-box-hover">
                                            <div class="box-img-hover">
                                                <?php $route_bg_gallery="background-image:url('images/movie/movies_".$movie->id.".".$movie->extension_img."')";?>
                                                <div class="bg-img-hover" style={!!$route_bg_gallery!!}></div>
                                                <div class="body-box-img">
                                                    <div class="table-view">
                                                        <?php $url="tiens_tv/".$movie['id_encode'];?>
                                                        <a href={!!$url!!} class="vertical-align">
                                                            <figure>
                                                                <img src="index/images/play-video.png">
                                                            </figure>
                                                            {!!$movie->name!!}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if($i%4 == 3)
                                </div>
                                @endif
                                <?php $i++;?> @endforeach @if($i%4 != 0)
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="view-more-gallery">
                            <a href="/tiens_tv" class="btn btn-default">Ver más</a>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </div>
    </section>
    </div>
    @include('layouts.footer') @include('layouts.scripts')
</body>

</html>
