/**
* Team Member Slider JS
* -----------------------------------------------------------------------------
*
* All the JS for the Team Member Slider component.
*/

/*
 * Example of importing modules if needed. Like for scroll magic / gsap
 */

// import {gsap} from 'gsap';
// import {ScrollTrigger} from 'gsap/ScrollTrigger.js';
// gsap.registerPlugin( ScrollTrigger );
( function( app ) {
  const COMPONENT = {

    className: 'team-member-slider',
    selector: function() {
      return '.' + this.className;
    },
    // Fires after common.init, before .finalize and common.finalize
    init: function() {
      $( '.team-member-slider' ).each( function() {
        const progressBarLabel = $( this ).find( '.slider__label' );
        const progressBar = $( this ).find( '.progress-bar' );
        $( '.team-member-slider__slider' ).on( 'beforeChange', function( event, slick, currentSlide, nextSlide ) {
          let calc = ( ( nextSlide ) / ( slick.slideCount-1 ) ) * 100;
          if ( calc === 0 ) {
            calc = 5;
          }
          progressBar
              .css( 'background-size', calc + '% 100%' )
              .attr( 'aria-valuenow', calc );
          progressBarLabel.text( calc + '% completed' );
          console.log( nextSlide );
        } );
        if ( $( this ).find( '.team-member-slider__slide' ).length > 3 ) {
          $( this ).find( '.team-member-slider__slider' ).slick( {
            accessability: true,
            dots: false,
            infinite: true,
            arrows: true,
            appendArrows: $( this ).find( '.team-member-slider__slider-nav' ),
            prevArrow: $( this ).find( '.team-member-slider__prev' ),
            nextArrow: $( this ).find( '.team-member-slider__next' ),
            slidesToShow: 3,
            responsive: [
              {
                breakpoint: 1024,
                settings: {
                  slidesToShow: 2,
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
  app.registerComponent( 'team-member-slider', COMPONENT );
} )( app );
