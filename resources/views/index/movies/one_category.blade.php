@foreach($data['movies_category'] as $movie)

<div class="col-xs-12 col-md-4">
  <div class="m-10">
    <div class="wrap-box-section">      
      <a style=background-image:url({!!asset("images/movie/movies_".$movie->id.".".$movie->extension_img)!!}) href={!!asset("tiens_tv/".$movie['id_encode'])!!} ></a>
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