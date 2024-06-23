/**
* Honors Cards JS
* -----------------------------------------------------------------------------
*
* All the JS for the Honors Cards component.
*/

/*
 * Example of importing modules if needed. Like for scroll magic / gsap
 */

// import {gsap} from 'gsap';
// import {ScrollTrigger} from 'gsap/ScrollTrigger.js';
// gsap.registerPlugin( ScrollTrigger );
( function( app ) {
  const COMPONENT = {

    className: 'honors-cards',
    selector: function() {
      return '.' + this.className;
    },
    // Fires after common.init, before .finalize and common.finalize
    init: function() {
      $( '.honors-cards' ).each( function() {
        if ( $( this ).find( '.honors-cards__slide' ).length > 1 ) {
          $( this ).find( '.honors-cards__slider' ).slick( {
            accessability: true,
            dots: false,
            infinite: true,
            arrows: true,
            centerMode: true,
            appendArrows: $( this ).find( '.honors-cards__slider-nav' ),
            prevArrow: $( this ).find( '.honors-cards__prev' ),
            nextArrow: $( this ).find( '.honors-cards__next' ),
            slidesToShow: 4,
            responsive: [
              {
                breakpoint: 1024,
                settings: {
                  slidesToShow: 3,
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
  app.registerComponent( 'honors-cards', COMPONENT );
} )( app );
