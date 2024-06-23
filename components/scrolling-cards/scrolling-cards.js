/**
* Scrolling Cards JS
* -----------------------------------------------------------------------------
*
* All the JS for the Scrolling Cards component.
*/

/*
 * Example of importing modules if needed. Like for scroll magic / gsap
 */

import {gsap} from 'gsap';
import {ScrollTrigger} from 'gsap/ScrollTrigger.js';
gsap.registerPlugin( ScrollTrigger );
( function( app ) {
  const COMPONENT = {

    className: 'scrolling-cards',
    selector: function() {
      return '.' + this.className;
    },
    // Fires after common.init, before .finalize and common.finalize
    init: function() {
      if ( window.innerWidth > 768 ) {
        const headerHeight = $( 'header.navbar' ).height();
        const top = headerHeight + 50;

        const overlappingCards = gsap.utils.toArray( '.scrolling-cards__card' );
        // const spacer = 40;
        let totalCardsHeight = 0;
        let lastCardHeight = 0;
        $( '.scrolling-cards__card' ).each( function( i ) {
          totalCardsHeight += $( this ).height();
          if ( i == overlappingCards.length - 1 ) {
            lastCardHeight = $( this ).height();
          }
        } );

        overlappingCards.forEach( ( card, index ) => {
          ScrollTrigger.create( {
            trigger: card,
            start: `top top+=${top}px`,
            pin: true,
            pinSpacing: false,
            id: 'pin',
            end: `bottom top+=${ totalCardsHeight - lastCardHeight + top - 20 }`,
            endTrigger: '.scrolling-cards',
            invalidateOnRefresh: true,
            // markers: true,
          } );
        } );

        const st = ScrollTrigger.create( {
          trigger: '#scrolling-cards__waves',
          pin: true,
          start: `top top+=${headerHeight}`,
          end: `bottom top+=${totalCardsHeight}`,
          // markers: true,
        } );
      }
    },
    finalize: function() {
    },
  };

  // Hooks the component into the app
  app.registerComponent( 'scrolling-cards', COMPONENT );
} )( app );
