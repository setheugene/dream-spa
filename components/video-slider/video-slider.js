/**
* Video Slider JS
* -----------------------------------------------------------------------------
*
* All the JS for the Video Slider component.
*/

/*
 * Example of importing modules if needed. Like for scroll magic / gsap
 */

// import {gsap} from 'gsap';
// import {ScrollTrigger} from 'gsap/ScrollTrigger.js';
// gsap.registerPlugin( ScrollTrigger );
( function( app ) {
  const COMPONENT = {

    className: 'video-slider',
    selector: function() {
      return '.' + this.className;
    },
    // Fires after common.init, before .finalize and common.finalize
    init: function() {
      $( '.video-slider' ).each( function() {
        if ( $( this ).find( '.video-slider__slide' ).length > 2 ) {
          $( this ).find( '.video-slider__slider' ).slick( {
            accessability: true,
            dots: false,
            infinite: false,
            arrows: true,
            appendArrows: $( this ).find( '.video-slider__slider-nav' ),
            prevArrow: $( this ).find( '.video-slider__prev' ),
            nextArrow: $( this ).find( '.video-slider__next' ),
            slidesToShow: 2,
            responsive: [
              {
                breakpoint: 1024,
                settings: {
                  slidesToShow: 2,
                },
              },
              {
                breakpoint: 768,
                settings: {
                  slidesToShow: 1,
                },
              },
            ],
          } );
        }
      } );
    },
    finalize: function() {
    },
  };

  // Hooks the component into the app
  app.registerComponent( 'video-slider', COMPONENT );
} )( app );
