/**
* Left Right Image Slider JS
* -----------------------------------------------------------------------------
*
* All the JS for the Left Right Image Slider component.
*/

/*
 * Example of importing modules if needed. Like for scroll magic / gsap
 */

// import {gsap} from 'gsap';
// import {ScrollTrigger} from 'gsap/ScrollTrigger.js';
// gsap.registerPlugin( ScrollTrigger );
( function( app ) {
  const COMPONENT = {

    className: 'left-right-image-slider',
    selector: function() {
      return '.' + this.className;
    },
    // Fires after common.init, before .finalize and common.finalize
    init: function() {
      $( '.left-right-image-slider' ).each( function() {
        if ( $( this ).find( '.left-right-image-slider__slide' ).length > 1 ) {
          $( this ).find( '.left-right-image-slider__primary-slider' ).slick( {
            accessability: true,
            dots: false,
            infinite: false,
            arrows: true,
            asNavFor: $( this ).find( '.left-right-image-slider__nav-slider' ),
            appendArrows: $( this ).find( '.left-right-image-slider__slider-nav' ),
            prevArrow: $( this ).find( '.left-right-image-slider__prev' ),
            nextArrow: $( this ).find( '.left-right-image-slider__next' ),
            slidesToShow: 1,
          } );
        }
        if ( $( this ).find( '.left-right-image-slider__nav-slide' ).length > 1 ) {
          $( this ).find( '.left-right-image-slider__nav-slider' ).slick( {
            accessability: true,
            dots: false,
            infinite: false,
            arrows: true,
            focusOnSelect: true,
            asNavFor: $( this ).find( '.left-right-image-slider__primary-slider' ),
            appendArrows: $( this ).find( '.left-right-image-slider__slider-nav' ),
            prevArrow: $( this ).find( '.left-right-image-slider__prev' ),
            nextArrow: $( this ).find( '.left-right-image-slider__next' ),
            slidesToShow: 3,
          } );
        }
      } );
    },
    finalize: function() {
    },
  };

  // Hooks the component into the app
  app.registerComponent( 'left-right-image-slider', COMPONENT );
} )( app );
