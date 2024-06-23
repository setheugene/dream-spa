/**
* Team Member Grid JS
* -----------------------------------------------------------------------------
*
* All the JS for the Team Member Grid component.
*/

/*
 * Example of importing modules if needed. Like for scroll magic / gsap
 */

// import {gsap} from 'gsap';
// import {ScrollTrigger} from 'gsap/ScrollTrigger.js';
// gsap.registerPlugin( ScrollTrigger );
( function( app ) {
  const COMPONENT = {

    className: 'team-member-grid',
    selector: function() {
      return '.' + this.className;
    },
    // Fires after common.init, before .finalize and common.finalize
    init: function() {
    },
    finalize: function() {
    },
  };

  // Hooks the component into the app
  app.registerComponent( 'team-member-grid', COMPONENT );
} )( app );
