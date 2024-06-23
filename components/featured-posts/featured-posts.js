/**
* Featured Posts JS
* -----------------------------------------------------------------------------
*
* All the JS for the Featured Posts component.
*/

/*
 * Example of importing modules if needed. Like for scroll magic / gsap
 */

// import {gsap} from 'gsap';
// import {ScrollTrigger} from 'gsap/ScrollTrigger.js';
// gsap.registerPlugin( ScrollTrigger );
( function( app ) {
  const COMPONENT = {

    className: 'featured-posts',
    selector: function() {
      return '.' + this.className;
    },
    // Fires after common.init, before .finalize and common.finalize
    init: function() {
      $( '.featured-posts' ).each( function() {
        if ( $( this ).find( '.featured-posts__slide' ).length > 3 ) {
          $( this ).find( '.featured-posts__slider' ).slick( {
            accessability: true,
            dots: false,
            infinite: false,
            arrows: true,
            appendArrows: $( this ).find( '.featured-posts__slider-nav' ),
            prevArrow: $( this ).find( '.featured-posts__prev' ),
            nextArrow: $( this ).find( '.featured-posts__next' ),
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
  app.registerComponent( 'featured-posts', COMPONENT );
} )( app );
