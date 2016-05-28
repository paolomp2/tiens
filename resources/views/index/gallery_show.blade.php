<!DOCTYPE html>
<html lang="es">
	@include('layouts.head')

	<style type="text/css">
		.download {
			position: absolute;
      top: 50px;
      right: 10px;
      background-color: #f6f5f5;
		}
	</style>

	<body>
  
  <div class="container">
    @include('layouts.container')
  </div>

  <section class="main-content">
    <div class="container">
      <div class="wrapper-content bg-transparent">
        <div class="album-gallery">
          <div class="row">
            <div class="col-xs-12">
              <div class="title-gallery">
                <h2>Últimas Galerías <span>//</span> {!!$data['training_show']->name!!}</h2>
              </div>
            </div>
            <div class="col-xs-12 popup-gallery">
              @foreach($data['images'] as $image)
                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                  <div class="box-gallery">
                    <a class="cover-box" href={!!asset("documentos/940x650_".$image->id.".".$image->extension)!!} title="" style=background-image:url({!!asset("documentos/150x150_".$image->id.".".$image->extension)!!})></a>
                  </div>
                </div>
              @endforeach              
            </div>
            <div class="col-xs-12">
              <div class="pull-right">
                <div class="gallery-download">
                  @if(count($data['images'])>0)
                  <a class="btn btn-link" download={!!$data['training_show']->name!!} href={!!asset("documentos/".$data['training_show']->id.".zip")!!}>Descarga Todo <i style="margin-left: 10px;" class="fa fa-download"></i></a>
                  @endif
                </div>
              </div>
              <div class="pagination-gallery text-center">
                <ul class="pagination">
                  {!! $data['images']->render() !!}
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
	
	<script type="text/javascript">
		setInterval(function() {
      var vImg = $('.mfp-figure figure img').attr('src');
      if(typeof vImg !== 'undefined') {
        vImgName = vImg.substr(vImg.lastIndexOf('/')+1);
        vImgName = vImg.substr(vImg.lastIndexOf('_')+1);

        vImg = vImg.substr(0,vImg.lastIndexOf('/')+1)+vImgName;

        if($('.mfp-figure figure').find('.download').length == 0) {
          var vHtml = '<div class="download"><a class="btn btn-link" download="' + vImgName + '" href="' + vImg + '">Descarga <i class="fa fa-download"></i></a></div>';
          $('.mfp-figure figure').append(vHtml);
        } else {
          $('.mfp-figure .download a').attr('href', vImg);
          $('.mfp-figure .download a').attr('download', vImgName);
        }        
      }
		}, 100);
	</script>

	</body>
</html>