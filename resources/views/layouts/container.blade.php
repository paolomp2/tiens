<nav class="navbar navbar-inverse navbar-top">
    <div class="container-fluid">
        <div class="menu-navbar" role="search">
            <ul class="nav navbar-nav">
                <li>
                    <a href="/ayuda" class="notifications">
                        <img src={!!asset( "index/images/rsz_call.png")!!} alt="" class="notif" />
                        <span class="nav-text">Servicio al cliente</span>
                    </a>
                </li>
                <li>
                    <div class="navbar-text m-l-5">|</div>
                </li>
                <li>
                    <a href="/notificaciones" class="notifications">
                        <img src={!!asset( "index/images/bulb.png")!!} alt="" class="notif" />
                        <span class="nav-text">Notificaciones</span>
                    </a>
                </li>
                <li>
                    <div class="navbar-text m-l-5">|</div>
                </li>
                <li class="dropdown">
                    <a id="mainMenu" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                      Bienvenido, <span>{!!$data['username']!!}</span> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="mainMenu">
                        @if($data['rol']==1 || ($data['country_id']==$data['country_id_admin']) )
                        <li>
                            <a href="/banner">Administraci&oacute;n del Sitio Web</a>
                        </li>
                        @endif
                        <!--  
                            <li>
                            <a href="#">Estado de cuenta</a>
                            </li>
                        -->
                        <!--
                            <li>
                              <a href="#">Mis pedido (Web)</a>
                            </li>
                        -->
                        <!--
                            <li>
                              <a href="#">Mis datos personales</a>
                            </li>
                        -->
                        <!--
                            <li>
                              <a href="#">Mis direcciones</a>
                            </li>
                        -->
                        <li>
                            <a href={{ url( '/logout') }}>Salir</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="navbar-main">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="col-sm-2 col-md-2 col-lg-offset-1 col-lg-1">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href={!!asset( "/")!!}>
                        <img src={!!asset( "index/images/logo.png")!!} alt="" />
                    </a>
                </div>
            </div>
            <div class="col-sm-10 col-md-10 col-lg-offset-1 col-lg-9">
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="/">INICIO</a></li>
                        <li><a href="/8_pasos">8 PASOS DEL ÉXITO</a></li>
                        <li><a href="/tiens_tv">TIENS TV</a></li>
                        <li><a href="/galerias">FOTOS</a></li>
                        <li><a href="/capacitaciones">CAPACITACIONES</a></li>
                    </ul>
                    {!!Form::open(['route'=>'find','method'=>'POST', 'class'=>'navbar-form navbar-right', 'role'=>'search'])!!}
                    <div class="input-group">
                        <input name="name" type="text" class="form-control" placeholder="Buscar...">
                        <span class="input-group-btn">
                          <button type="submit" class="btn btn-default" type="button">
                            <i class="glyphicon glyphicon-search"></i>
                          </button>
                        </span>
                    </div>
                    {!!Form::Close()!!}
                </div>
            </div>
        </div>
    </nav>
</div>
