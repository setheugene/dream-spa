/**
* Stats JS
* -----------------------------------------------------------------------------
*
* All the JS for the Stats component.
*/

/*
 * Example of importing modules if needed. Like for scroll magic / gsap
 */

import {gsap} from 'gsap';
import {ScrollTrigger} from 'gsap/ScrollTrigger.js';
( function( app ) {
  const COMPONENT = {

    className: 'stats',
    selector: function() {
      return '.' + this.className;
    },
    // Fires after common.init, before .finalize and common.finalize
    init: function() {
      document.querySelectorAll( '.stats__row' ).forEach( ( el ) => {
        const trigger = el;
        ScrollTrigger.create( {
          trigger: el,
          // markers: true,
          start: 'top 70%',
          scrub: 0.15,
          onRefresh: ( self ) => {
            if ( self.progress > 0 ) {
              $( trigger ).addClass( 'js-animated' );
            }
          },
          onEnter: ( {progress, direction, isActive} ) => $( trigger ).addClass( 'js-animated' ),
        } );
      } );
    },
    finalize: function() {
    },
  };

  // Hooks the component into the app
  app.registerComponent( 'stats', COMPONENT );
} )( app );
