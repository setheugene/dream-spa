/**
* Locations Block JS
* -----------------------------------------------------------------------------
*
* All the JS for the Locations Block component.
*/

/*
 * Example of importing modules if needed. Like for scroll magic / gsap
 */

// import {gsap} from 'gsap';
// import {ScrollTrigger} from 'gsap/ScrollTrigger.js';
// gsap.registerPlugin( ScrollTrigger );
( function( app ) {
  const COMPONENT = {

    className: 'locations-block',
    selector: function() {
      return '.' + this.className;
    },
    // Fires after common.init, before .finalize and common.finalize
    init: function() {
      $( '.locations-block__marquee' ).slick( {
        speed: 8000,
        autoplay: true,
        autoplaySpeed: 0,
        centerMode: true,
        cssEase: 'linear',
        slidesToShow: 1,
        slidesToScroll: 1,
        variableWidth: true,
        infinite: true,
        arrows: false,
        buttons: false,
        initialSlide: 1,
      } );
    },
    finalize: function() {
    },
  };

  // Hooks the component into the app
  app.registerComponent( 'locations-block', COMPONENT );
} )( app );
