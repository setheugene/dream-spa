/**
* Before and After Slider JS
* -----------------------------------------------------------------------------
*
* All the JS for the Before and After Slider component.
*/

/*
 * Example of importing modules if needed. Like for scroll magic / gsap
 */

// import {gsap} from 'gsap';
// import {ScrollTrigger} from 'gsap/ScrollTrigger.js';
( function( app ) {
  const COMPONENT = {

    className: 'before-and-after-slider',
    selector: function() {
      return '.' + this.className;
    },
    // Fires after common.init, before .finalize and common.finalize
    init: function() {
      // gsap.registerPlugin( ScrollTrigger );
      $( '.before-after-slider-outer' ).slick( {
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        appendArrows: $( '.before-after-nav-wrapper' ),
        prevArrow: '<button type="button" class="text-brand-teal paragraph-default font-medium"><svg class="text-brand-teal h-5 w-5 duration-200 icon icon-arrow-left-long mb-1 mr-1"><use xlink:href="#icon-arrow-left-long"></use></svg> Previous case</button>',
        nextArrow: '<button type="button" class="text-brand-teal paragraph-default font-medium">Next case <svg class="text-brand-teal h-5 w-5 duration-200 icon ml-1 mb-1 icon-arrow-right-long"><use xlink:href="#icon-arrow-right-long"></use></svg></button>',
      } );
    },
    finalize: function() {
    },
  };

  // Hooks the component into the app
  app.registerComponent( 'before-and-after-slider', COMPONENT );
} )( app );
