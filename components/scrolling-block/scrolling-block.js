/**
* Scrolling Block JS
* -----------------------------------------------------------------------------
*
* All the JS for the Scrolling Block component.
*/

/*
 * Example of importing modules if needed. Like for scroll magic / gsap
 */

import {gsap} from 'gsap';
import {ScrollTrigger} from 'gsap/ScrollTrigger.js';
gsap.registerPlugin( ScrollTrigger );
( function( app ) {
  const COMPONENT = {

    className: 'scrolling-block',
    selector: function() {
      return '.' + this.className;
    },
    // Fires after common.init, before .finalize and common.finalize
    init: function() {
      $( '.scrolling-block' ).each( function( key, component ) {
        const comp = $( component );
        ScrollTrigger.matchMedia( {
          '(min-width: 1024px)': () => {
            let navHeight = $( '.navbar' ).outerHeight();
            if ( $( '#wpadminbar' ).length ) {
              navHeight += $( '#wpadminbar' ).outerHeight();
            }

            const contentBlocksArray = $( '.scrolling-block__content-block' );
            const content = $( '.scrolling-block__content' );

            const imagePinner = gsap.timeline( {
              scrollTrigger: {
                trigger: this,
                start: ( $( this ).find( '.scrolling-block__images .scrolling-block__image' ).first().outerHeight() / 2 ) + ' ' + ( navHeight + ( window.innerHeight - navHeight ) / 2 ),
                end: `top ${navHeight}`,
                endTrigger: () =>$( contentBlocksArray[contentBlocksArray.length - 1] ),
                pin: $( this ).find( '.scrolling-block__images' ),
                pinSpacing: false,
                // markers: true,
              },
            } );

            $( this ).find( '.scrolling-block__content-block' ).each( function( index, element ) {
              const step = $( this ).data( 'step' );
              const image = comp.find( `.scrolling-block-image-${step}` );

              const contentFader = gsap.timeline( {
                scrollTrigger: {
                  trigger: this,
                  start: 'top 75%',
                  end: 'top 60%',
                  endTrigger: $( this ).find( '.scrolling-block__title' ),
                  scrub: true,
                  // markers: true,
                },
              } );
              contentFader.to( this, {opacity: '1', ease: 'linear'} );

              const imageReveal = gsap.timeline( {
                scrollTrigger: {
                  trigger: this,
                  start: 'top bottom',
                  end: 'bottom bottom',
                  scrub: 0.15,
                  // markers: true,
                },
              } );

              imageReveal.to( image, {clipPath: 'polygon(0% 100%, 100% 100%, 100% 0%, 0% 0%)', ease: 'linear'}, 0 );
              imageReveal.to( image, {scale: '1.2', ease: 'linear'}, 0 );
            } );
          },
          '(max-width: 1024px)': () => {
            gsap.set( '.scrolling-block__content-block', {opacity: 1} );
          },
        } );
      } );
    },
    finalize: function() {
    },
  };

  // Hooks the component into the app
  app.registerComponent( 'scrolling-block', COMPONENT );
} )( app );
