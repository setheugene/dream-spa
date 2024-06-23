/**
* Form JS
* -----------------------------------------------------------------------------
*
* All the JS for the Form component.
*/

/*
 * Example of importing modules if needed. Like for scroll magic / gsap
 */

import {gsap} from 'gsap';
import {ScrollTrigger} from 'gsap/ScrollTrigger.js';
gsap.registerPlugin( ScrollTrigger );
( function( app ) {
  const COMPONENT = {

    className: 'form',
    selector: function() {
      return '.' + this.className;
    },
    // Fires after common.init, before .finalize and common.finalize
    init: function() {
      // if ( $( window ).width() > 768 ) {
      //   const headerHeight = $( 'header.navbar' ).height();
      //   const top = headerHeight + 65;

      //   const st = ScrollTrigger.create( {
      //     trigger: 'section.form',
      //     pin: 'section.form .wysiwyg',
      //     pinSpacing: false,
      //     start: `top top+=${top}`,
      //     end: 'bottom bottom',
      //     // markers: true,
      //   } );
      // }
    },
    finalize: function() {
    },
  };

  // Hooks the component into the app
  app.registerComponent( 'form', COMPONENT );
} )( app );
