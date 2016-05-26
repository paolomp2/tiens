@foreach($data['categories'] as $category)

@if($category['count']>0)

<div class="col-xs-12 col-md-4">
  <div class="m-10">
    <div class="wrap-box-section">
      <a style=background-image:url({!!asset("images/movie/movies_".$category['last_video'][0]->id.".".$category['last_video'][0]->extension_img)!!}) href={!!asset("tiens_tv/".$category['last_video'][0]['id_encode'])!!} >        
      </a>
      <div class="desc-box-section">
        <p>{!!$category['last_video'][0]->name!!}</p>
      </div>
      <div class="data-more">
        <span><i class="fa fa-eye"></i> <span>{!!$category['last_video'][0]->see_num!!}</span></span>
        <span><i class="fa fa-clock-o"></i> <span>{!!$category['last_video'][0]->last_time_see!!}</span></span>
      </div>
    </div>
  </div>
</div>
@endif
@endforeach