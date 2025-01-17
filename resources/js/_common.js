/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */
( function( app ) {
  const COMPONENT = {
    init: function() {
      $( '.navbar-toggle' ).on( 'toggleAfter', ( event ) => {
        $( '#mobile-dropdown-menu' ).slideToggle();
        $( '#mobile-sticky-buttons' ).slideToggle();
      } );

      $( 'button.easy-toggle-fade-toggle' ).on( 'toggleBefore', function( event ) {
        const target = $( this ).data( 'toggle-target' );
        $( target ).fadeToggle();
      } );

      $( 'button.easy-toggle-slide-toggle' ).on( 'toggleBefore', function( event ) {
        const target = $( this ).data( 'toggle-target' );
        $( target ).slideToggle();
      } );

      $( '.js-init-video' ).magnificPopup( {
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false,
        callbacks: {
          open: function() {
            $( 'video' ).trigger( 'pause' );
          },
          close: function() {
            $( 'video' ).trigger( 'play' );
          },
        },
      } );

      function handleMobileChange( event ) {
        /*
         * Remove any inline display values when the screen changes
         * between mobile and desktop state. This allows the default
         * stylings to kick in and prevent any weird "half mobile half desktop"
         * nav display states that sometimes occur while resizing the browser
         * Also remove any active is-open classes from the toggle and nav to reset
         * its state when switching between screen sizes
         */
        if ( event.matches ) {
          if ( $( '.primary-nav' ).length > 0 ) {
            $( '.primary-nav' ).get( 0 ).style.removeProperty( 'display' );

            $( '.navbar-toggle, .primary-nav' ).removeClass( 'is-open' );
          }
        }
      }

      /* Run the handleMobileChange function when the screen sizes changes based on the mobileSize const */
      const mobileSize = window.matchMedia( '(min-width: 768px)' );
      handleMobileChange( mobileSize );
      mobileSize.addEventListener( 'change', handleMobileChange );

      if ( mobileSize.matches ) {
        $( '.primary-menu-item' )?.find( 'button.grandchild-menu-trigger__first' )?.trigger( 'click' );
      }

      /* Allow selects to have placeholder styles */
      checkSelectPlaceholder();
      $( '.gfield_select' ).on( 'change', function() {
        checkSelectPlaceholder();
      } );
      function checkSelectPlaceholder() {
        if ( $( '.gfield_select' ).find( 'option:selected' ).hasClass( 'gf_placeholder' ) ) {
          $( '.gfield_select' ).addClass( 'placeholder-selected' );
        } else {
          $( '.gfield_select' ).removeClass( 'placeholder-selected' );
        }
      }

      /* Lazyload all embeds */
      if ( 'IntersectionObserver' in window ) {
        const options = {
          root: null, // avoiding 'root' or setting it to 'null' sets it to default value: viewport
          rootMargin: '0px 0px 100px', // determines how far form the root the intersection callback will trigger
        };
        const embedObserver = new IntersectionObserver( function( entries, observer ) {
          entries.forEach( function( embed ) {
            if ( embed.isIntersecting ) {
              $( embed.target ).attr( 'src', $( embed.target ).attr( 'data-src-defer' ) );
              // remove observer
              embedObserver.unobserve( embed.target );
            }
          } );
        }, options );

        // add the observer to the elements
        $( '[data-src-defer]' ).each( function( index, element ) {
          embedObserver.observe( element );
        } );
      }

      /* Set up arias for blog sidebar toggles */
      toggleBlogSidebarAriaVisibility();

      $( window ).on( 'resize', function() {
        toggleBlogSidebarAriaVisibility();
      } );

      function toggleBlogSidebarAriaVisibility() {
        if ( window.innerWidth > 1024 ) {
          $( '.blog__sidebar-inner' ).attr( 'aria-hidden', false );
        } else if ( window.innerWidth <= 1024 && !$( '.blog__sidebar-inner' ).hasClass( 'is-open' ) ) {
          $( '.blog__sidebar-inner' ).attr( 'aria-hidden', true );
        }
      }
      if ( $( '.form-skin .ll-file-upload' ).length > 0 && typeof( gform ) !== 'undefined' ) {
        $( 'input[type=\'file\']' ).change( function() {
          const fullPath = $( this ).val();
          let filename = fullPath.replace( /^.*[\\/]/, '' );
          if ( filename === '' ) {
            filename = 'No file chosen';
          }
          const theInput = $( this ).parent().find( '.ll-file-upload span' );
          $( theInput ).text( filename );
        } );
      }
      if ( $( '.mec-skin-grid-events-container' ).length > 0 ) {
        $( '.mec-skin-grid-events-container .mec-booking-button' ).each( function() {
          $( this ).text( 'VIEW DETAILS' );
        } );
      }
      function getNavHeight() {
        const $navheight = $( '#upper-nav' ).height() + $( '#lower-nav' ).height();
        console.log( $navheight );
        $( ':root' ).css( '--navbarHeight', $navheight + 'px' );
      }
      $( function() {
        const navThrottle = new app.components.common.Throttle( getNavHeight, 250 );
        $( window ).on( 'resize', function() {
          navThrottle.run();
        } );
      } );
    },
    Throttle: class Throttle {
      constructor( callback, time ) {
        this.callback = callback;
        this.time = time;
        this.throttlePause = false;
      }
      run() {
        if ( this.throttlePause ) return;
        this.throttlePause = true; // Set throttle pause state for this instance
        setTimeout( () => {
          this.callback();
          this.throttlePause = false; // Reset throttle pause state after callback execution
        }, this.time );
      }
    },
    finalize: function() {
    },
  };

  app.registerComponent( 'common', COMPONENT );
} )( app );
