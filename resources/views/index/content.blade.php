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
        <article class="new-main">
          <div class="new-cover-image" style="background-image: url('index/images/new1.jpg')"></div>
          <div class="wrap-new">
            
            <ul class="new-list">
              <li>
                <h3>Quiénes Somos</h3>
                <p>{!!$data['hwa']->description!!}</p>
              </li>
              <li>
                <h3>Misión y Visión</h3>
                <p>{!!$data['mision']->description!!}</p>
                <p>{!!$data['vision']->description!!}</p>
              </li>
              <li>
                <h3>Valores</h3>
                <p>{!!$data['values']->description!!}</p>
              </li>
            </ul>
          </div>
        </article>
      </div>
    </div>
  </section>

    <div class="container">
  @include('layouts.footer')
  </div>

	@include('layouts.scripts')

	</body>
</html>