/**
* Logo Marquee JS
* -----------------------------------------------------------------------------
*
* All the JS for the Logo Marquee component.
*/

/*
 * Example of importing modules if needed. Like for scroll magic / gsap
 */

// import {gsap} from 'gsap';
// import {ScrollTrigger} from 'gsap/ScrollTrigger.js';
// gsap.registerPlugin( ScrollTrigger );
( function( app ) {
  const COMPONENT = {

    className: 'logo-marquee',
    selector: function() {
      return '.' + this.className;
    },
    // Fires after common.init, before .finalize and common.finalize
    init: function() {
      $( 'section.logo-marquee' ).each( function() {
        $( this ).find( '#logo-marquee__slick' ).slick( {
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
      } );
    },
    finalize: function() {
    },
  };

  // Hooks the component into the app
  app.registerComponent( 'logo-marquee', COMPONENT );
} )( app );
