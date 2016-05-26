
{!! HTML::script('index/js/jquery.js') !!}
{!! HTML::script('index/js/bootstrap.js') !!}
{!! HTML::script('index/js/owl.carousel.js') !!}
{!! HTML::script('index/js/jquery.magnific-popup.js') !!}

{!! HTML::script('alerts/js/lib/alertify.min.js') !!}

<script type="text/javascript">
  
  $(document).ready(function() {
    $('.popup-gallery').magnificPopup({
      delegate: 'a',
      type: 'image',
      tLoading: 'Loading image #%curr%...',
      mainClass: 'mfp-img-mobile',
      gallery: {
        enabled: true,
        navigateByImgClick: true,
        preload: [0,1]
      },
      image: {
        tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
        titleSrc: function(item) {
          return item.el.attr('title');
        }
      }
    });
  });
  
  $('.last-news-carousel').owlCarousel({
    loop:true,
    margin:30,
    nav:true,
    dots: false,
    navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
    responsive:{
      0:{
          items:1
      },
      600:{
          items:2
      },
      1000:{
          items:3
      }
    }
  });

  $('.events-schedule-carousel, .conocimientos-carousel, .gallery-events-carousel, .gallery-videos-carousel').owlCarousel({
    loop:true,
    nav:true,
    dots: false,
    navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
    items: 1
  });

  $('.lideres-carousel').owlCarousel({
    loop:true,
    margin: 15,
    nav:true,
    dots: false,
    navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
    items: 2
  });

  $(document).on('click', '.album-gallery .box-gallery', function() {
    var img = $(this).find('.cover-box').css('background-image').replace('url(','').replace(')','').replace(/"/g, '');
    $('.main-img-gallery img').attr('src', img);
  });

  $('.gallery-carousel').owlCarousel({
    loop: true,
    nav: false,
    dots: true,
    navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
    items: 1
  });

  $('#pagination_gallery').on('click','.btn_pag',function(e){

    e.preventDefault();
    var img = $(this).attr('name');
    $(this).parent().find('.btnSelected').attr('class','btnPagination');
    $(this).find('.btnPagination').attr('class','btnSelected');
    
    $("#down_img").attr('download',$(this).attr('id'));
    $("#down_img").attr('href',$(this).attr('name'));
    
    $('.main-img-gallery img').attr('src', img);
  });

  $(function () {

      $('#carousel-tiens-tv').carousel({
        interval: 5000,
        pause: "false"
      });

      $('.carousel-control').on('click', function () {
        $('#carousel-tiens-tv').carousel('cycle');
        setTimeout(function() {
          $('.item-video').show();
          $('.carousel-video').hide();
        }, 600);

        // insert here to pause/stop all videos

        // Pause all Videos Youtube

        yt_players['playerID1'].pauseVideo();
        yt_players['playerID2'].pauseVideo();
        yt_players['playerID3'].pauseVideo();

      });

      $('.item-video').on('click', function(){
        $('#carousel-tiens-tv').carousel('pause');
        $(this).hide();
        $(this).siblings('.carousel-video').show();
      })

    });

</script>

{!! HTML::script('js/alertNotifications.js') !!}