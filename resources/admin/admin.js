import resolveConfig from 'tailwindcss/resolveConfig';
import tailwindConfig from '../css/tailwind.config.js';

( function() {
  const copyToClipboard = ( str ) => {
    const el = document.createElement( 'textarea' );
    el.value = str;
    document.body.appendChild( el );
    el.select();
    document.execCommand( 'copy' );
    document.body.removeChild( el );
  };

  /*
   * Custom group labels on load
   */
  const groupLabels = document.querySelectorAll( '.ll-group-label input' );
  if ( groupLabels.length > 0 ) {
    groupLabels.forEach( ( el, index ) => {
      el.closest( '.layout' ).querySelector( '.acf-fc-layout-handle' ).insertAdjacentHTML( 'beforebegin', `<span class="ll-group-title" contenteditable="true">${el.value}</span>` );
    } );
  }

  /*
   * Custom Anchor target and component preview
   */
  const groupNames = document.querySelectorAll( '.ll-target-name input' );
  if ( groupNames.length > 0 ) {
    let permalinkEl = document.getElementById( 'sample-permalink' );
    let permalink = permalinkEl.getAttribute( 'href' );
    if ( !permalink ) {
      permalinkEl = document.querySelectorAll( '#sample-permalink a' );
      permalink = permalinkEl[0].getAttribute( 'href' );
    }

    groupNames.forEach( ( el, index ) => {
      const groupKey = el.closest( '.layout' ).querySelector( '.component-key' ).dataset.key;
      const layoutHandle = el.closest( '.layout' ).querySelector( '.acf-fc-layout-handle' );
      const controls = el.closest( '.layout' ).querySelector( '.acf-fc-layout-controls' );

      layoutHandle.insertAdjacentHTML( 'beforebegin', `<span class="ll-target-title" contenteditable="true">${el.value}</span><span class="ll-target-link">${permalink}#<span>${el.value}</span></span>` );
      // controls.innerHTML = `<a target="_blank" href="/component-preview?component=${groupKey}" class="acf-icon -preview small light acf-js-tooltip" href="#" data-name="preview-layout" title="Preview Component"></a>${controls.innerHTML}`;
    } );
  }

  /*
   * Sync custom group label to the hidden acf input
   *
   */
  document.addEventListener( 'input', ( event ) => {
    if ( !event.target.matches( '.ll-group-title' ) ) return;

    event.target.closest( '.layout' ).querySelector( '.ll-group-label input' ).value = event.target.innerText;
  } );

  /*
   * Sync text from custom target to popup text and hidden acf input
   *
   */
  document.addEventListener( 'input', ( event ) => {
    if ( !event.target.matches( '.ll-target-title' ) ) return;

    const el = event.target;
    const layout = el.closest( '.layout' );
    layout.querySelector( '.ll-target-name input' ).value = el.innerText;
    let str = el.innerText.replace( /^\s+|\s+$/g, '' );
    str = str.toLowerCase();

    // remove accents, swap ñ for n, etc
    const from = 'àáäâèéëêìíïîòóöôùúüûñç·/_,:;';
    const to = 'aaaaeeeeiiiioooouuuunc------';
    for ( let i=0, l=from.length; i<l; i++ ) {
      str = str.replace( new RegExp( from.charAt( i ), 'g' ), to.charAt( i ) );
    }

    str = str.replace( /[^a-z0-9 -]/g, '' ).replace( /\s+/g, '-' ).replace( /-+/g, '-' );
    layout.querySelector( '.ll-target-link' ).classList.remove( 'copied' );
    layout.querySelector( '.ll-target-link span' ).innerHTML = str;
  } );

  /*
   * When a components custom target input is focused,
   * hide any open ones and then make this one visible.
   */
  document.addEventListener( 'click', ( event ) => {
    if ( !event.target.matches( '.ll-target-title' ) ) return;

    const el = event.target;
    const visibleTargetLinks = document.querySelectorAll( '.ll-target-link.visible' );
    if ( visibleTargetLinks.length > 0 ) {
      visibleTargetLinks.forEach( ( el ) => {
        el.classList.remove( 'visible' );
      } );
    }

    el.closest( '.layout' ).querySelector( '.ll-target-link' ).classList.add( 'visible' );
  } );

  document.addEventListener( 'click', ( event ) => {
    if ( !event.target.matches( '.ll-target-link' ) ) return;

    const copyText = event.target.innerText;
    copyToClipboard( copyText );
    event.target.classList.add( 'visible', 'copied' );

    setTimeout( () => {
      event.target.classList.remove( 'copied' );
    }, 3000 );
  } );

  document.addEventListener( 'click', ( event ) => {
    if ( !event.target.matches( '.ll-target-title' ) && !event.target.matches( '.ll-target-link.visible' ) ) {
      const visibleLinks = document.querySelectorAll( '.ll-target-link.visible' );
      if ( visibleLinks.length > 0 ) {
        visibleLinks.forEach( ( el ) => {
          el.classList.remove( 'visible' );
        } );
      }
    }
  } );

  /*
   * LL Documentation
   */
  document.addEventListener( 'click', ( event ) => {
    if ( event.target.matches( '.ll-docs__tab' ) ) {
      const allTabs = document.querySelectorAll( '.ll-docs__tab' );
      if ( allTabs.length > 0 ) {
        allTabs.forEach( ( el ) => {
          el.classList.remove( 'is-active' );
        } );
      }

      const allPanels = document.querySelectorAll( '.ll-docs__panel' );
      if ( allPanels.length > 0 ) {
        allPanels.forEach( ( el ) => {
          el.classList.remove( 'is-active' );
        } );
      }

      event.target.classList.add( 'is-active' );
      document.getElementById( event.target.getAttribute( 'data-target' ).substring( 1 ) ).classList.add( 'is-active' );
    }
  } );

  function createFormats( values, prefix, title, type ) {
    const items = [];

    for ( const [key, value] of Object.entries( values ) ) {
      const item = {
        'title': `${valueParse( value, type )}`,
        'classes': prefix+key,
        'selector': 'p, a, span, li, h1, h2, h3, h4, h5, h6',
        'wrapper': false,
      };

      items.push( item );
    }

    const format = {
      'title': title,
      'items': items,
    };

    return format;
  }

  function valueParse( value, type ) {
    if ( type === 'number' ) {
      const newVal = parseFloat( value );
      if ( newVal ) {
        value = ( newVal * 16 ) + 'px';
      }
    }
    return value;
  }

  const config = resolveConfig( tailwindConfig );

  const spacing = config.theme.spacing;
  delete spacing.px;
  delete spacing.gutter;
  delete spacing['gutter-full'];

  window.bottomSpacing = createFormats( spacing, 'mb-', 'Spacing Bottom', 'number' );
  window.topSpacing = createFormats( spacing, 'mt-', 'Spacing Top', 'number' );
  window.topBottomSpacing = createFormats( spacing, 'my-', 'Spacing Top & Bottom', 'number' );
} )();
