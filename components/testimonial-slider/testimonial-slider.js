/**
* Testimonial Slider JS
* -----------------------------------------------------------------------------
*
* All the JS for the Testimonial Slider component.
*/

/*
 * Example of importing modules if needed. Like for scroll magic / gsap
 */

// import {gsap} from 'gsap';
// import {ScrollTrigger} from 'gsap/ScrollTrigger.js';
// gsap.registerPlugin( ScrollTrigger );
( function( app ) {
  const COMPONENT = {

    className: 'testimonial-slider',
    selector: function() {
      return '.' + this.className;
    },
    // Fires after common.init, before .finalize and common.finalize
    init: function() {
      $( '.testimonial-slider' ).each( function() {
        if ( $( this ).find( '.testimonial-slider__slide' ).length > 3 ) {
          $( this ).find( '.testimonial-slider__slider' ).slick( {
            accessability: true,
            dots: false,
            infinite: false,
            arrows: true,
            appendArrows: $( this ).find( '.testimonial-slider__slider-nav' ),
            prevArrow: $( this ).find( '.testimonial-slider__prev' ),
            nextArrow: $( this ).find( '.testimonial-slider__next' ),
            slidesToShow: 3,
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
  app.registerComponent( 'testimonial-slider', COMPONENT );
} )( app );
