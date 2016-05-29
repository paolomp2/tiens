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
                <div class="capacitaciones">
                    <div class="row">
                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                            <!-- required for floating -->
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs tabs-left">
                                <!-- 'tabs-right' for right tabs -->
                                <!-- 
                                    <li class="active">
                                      <a href="#home" data-toggle="tab" class="box-capac leones">
                                        <img src="index/images/leones.png" />
                                        <span>LEONES</span>
                                      </a>
                                    </li>
                                  -->
                                <li class="active">
                                    <a href="#profile" data-toggle="tab" class="box-capac capacitadores">
                                        <img src="index/images/estrella.png" />
                                        <span>CAPACITADORES CERTIFICADOS</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <!--
                                    <div class="tab-pane" id="home">
                                      <div class="leones">
                                        <div class="top-capacitaciones">
                                          <h2>Leones</h2>
                                          <p>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                          </p>
                                        </div>
                                        <div class="body-capacitaciones">
                                          <div class="row">
                                            @foreach($data['lions'] as $lion)
                                              <div class="col-xs-6 col-md-6">
                                                <div class="box-cap">
                                                  <div class="row">
                                                    <div class="col-xs-4">
                                                      <?php $route_bg_lion="background-image:url('images/lion/lion_".$lion->id.".".$lion->extension."')";?>
                                                      <div class="cover-capacitaciones" style={!!$route_bg_lion!!}></div>
                                                    </div>
                                                    <div class="col-xs-8">
                                                      <h3>{!!$lion->name!!}</h3>
                                                      <?php $lion->description=mb_strimwidth($lion->description, 0, 200, "...");?>
                                                      <p>{!!$lion->description!!}</p>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            @endforeach                          
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  -->
                                <div class="tab-pane active" id="profile">
                                    <div class="capacitaciones">
                                        <div class="top-capacitaciones">
                                            <h2>Capacitadores Certificados</h2>
                                            <p>
                                                Para alcanzar el &eacute;xito es necesario prepararte con los mejores, por esto te presentamos a nuestros L&iacute;deres Certificados como Capacitadores Nacionales.
                                            </p>
                                        </div>
                                        <div class="body-capacitaciones">
                                            <div class="row">
                                                @foreach($data['trainers'] as $key => $trainer)
                                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                    <div class="box-cap">
                                                        <div class="row">
                                                            <div class="col-xs-12 col-sm-4">
                                                                <?php $route_bg_trainer="background-image:url('images/trainer/trainer_".$trainer->id.".".$trainer->extension."')";?>
                                                                <div class="cover-capacitaciones" style={!!$route_bg_trainer!!}>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-8">
                                                                <h3>{!!$trainer->name!!}</h3>
                                                                <p>{!!$trainer->description!!}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($key % 2 == 1)
                                                    <div class="clearfix"></div>
                                                @endif 
                                                @endforeach()
                                            </div>
                                        </div>
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
        @include('layouts.footer')
    </div>
    @include('layouts.scripts')
</body>

</html>
