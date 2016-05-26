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
            <div class="new-cover-image" style=background-image:url({!!asset("images/news/news_".$data['news_show']->id.".".$data['news_show']->extension)!!})></div>
            <div class="wrap-new">
              <h1>{{$data['news_show']->name}}</h1>

              <p></p>
              
              {{$data['news_show']->description}}              

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