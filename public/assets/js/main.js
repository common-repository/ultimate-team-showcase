(function($){  
	"use strict";

	//for slider
	 $(".slider-style").each(function() {
	    var options = $(this).data('carousel-options');
	    $(this).owlCarousel(options); 
	 });

	 //for filter
	$('.grid').imagesLoaded(function() {	 	
	   $('.team-filter').on('click', 'button', function() {
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({
                filter: filterValue
            });
        });
        var $grid = $('.grid').isotope({
            itemSelector: '.grid-item',
            percentPosition: true,
            masonry: {
                columnWidth: '.grid-item',
            }
        });
    });


    jQuery(document).ready(function(){
            jQuery(".prallax-img").each(function() {
                var prallaxImg = jQuery(this).get(0);
                var parallaxInstance = new Parallax(prallaxImg);
            });
        });


    // Team Social Icon Collaps Button
    $('.team-social-collaps').on('click', function() {
        $(this).parents('.team-inner-wrap').toggleClass('is-open')
    });

	 // team filder acitve
    $('.team-filter button').on('click', function(event) {
        $(this).siblings('.active').removeClass('active');
        $(this).addClass('active');
        event.preventDefault();
    });

    //
    $( ".plus-team" ).on( "click", function( event ) {
        $(this).toggleClass("active_social");
    });
    //
    $('.share-i').click(function() {
        $(this).parents('.team-wrap').toggleClass('current-share');
    });

    $(window).load(function(){
    $('#slidernav').flexslider({
      animation: "slide",
      controlNav: "thumbnails",
      rtl: true,
      directionNav: false,
      start: function(slider){
        $('body').removeClass('loading');
      }
    });

    $('#slidernav2').flexslider({
    animation: "slide",
    animationLoop: false,
    itemWidth: 83,
    itemMargin: 5,
    pausePlay: false,
    mousewheel: true,
    controlNav: true,
    manualControls: ".slide_controll li",
    sync: '#slidernav',
    rtl: true,
    asNavFor:'.flexslider'
  });

  });
       
})(jQuery);
