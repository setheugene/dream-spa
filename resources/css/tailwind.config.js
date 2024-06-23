module.exports = {
  content: [
    './components/**/*.{php,js,css}',
    './templates/**/*.php',
    './lib/**/*.php',
    './resources/**/*.{js,css}',
    './search.php',
    './index.php',
    './base.php',
    './404.php',
    './single-ll_specials.php',
    './archive-ll_specials.php',
    /*
     * Include files that have css classes that need to be rendered
     * Files and folders that don't exist should not be included
     * Below you will see some examples of files/paths that are not included and why and when to include them
     */
    // './page.php', // Include this line if you end up adding markup with classes to file
    // './single.php', // Include this line if you end up adding markup with classes to the file
    // './woocommerce/**/*.php', // Include this line if you end up adding woocommerce file overrides
    // './functions.php', // This file is not neccessary to include since it only holds references to all the other functions
    // './*.php', DO NOT INCLUDE THIS LINE
  ],
  safelist: [
    {
      pattern: /object-.+/
    },
    {
      pattern: /(my|mb|mt|mx|py|pb|pt|px)-.+/,
      variants: ['sm', 'md', 'lg', 'xl'],
    },
    {
      pattern: /w-\d{1,2}\/\d{1,2}/,
      variants: ['sm', 'md', 'lg', 'xl'],
    },
    {
      pattern: /w-.+/,
    },
    {
      pattern: /h-.+/,
    },
    /* To safelist more classes such as text color or background color use something like below, if not using bg-brand or text-brand and opting for text- or bg- keep in mind this whitelists classes such as bg-opacity, text-xl etc. */
    /* {
      pattern: /bg-brand-.+/
    } */
  ],
  theme: {
    colors: {
      inherit: 'inherit',
      current: 'currentColor',
      transparent: 'transparent',
      black: '#000',
      white: '#fff',
      brand: {
        'off-white': '#F9F9F9',
        'navy': '#101D27',
        'gray': '#6F707A',
        'dark-teal': '#0B3B4A',
        'teal': '#167593',
        'logo-blue': '#94BCC8',
        'storm': '#BCBCD0',
        'light-gray': '#CAD1D3',
        'error': '#A8022A',
        'teal-10': 'rgba(22, 117, 147, 0.10)',
        'teal-70': 'rgba(22, 117, 147, 0.70)',
        'dark-teal-70': 'rgba(11, 59, 74, 0.70)',
        'blue-gray': '#6F888F',
        'off-white-20' : 'rgba(249, 249, 249, 0.20)',
        'white-50' : 'rgba(250, 250, 250, 0.50)',

        'highlight': '#DDDDD',
        'primary': '#5FB0C8',
        'light-gray': '#BEBEBE',
        'dark-gray': '#443E51',

        'scrim': 'rgba(11, 59, 74, 0.40)',
        'overlay': 'rgba(0, 0, 0, 0.40)',
      },
      form: {
        'placeholder': '#6F707A',
        'description': '#101D27',
        'error': '#A8022A',
        'focus': '#E8F5F9',
        'radio-button-unchecked': '#4B4DED',
        'radio-button-checked': '#0500D7',
        'toggle-unchecked': '#EFEFFD',
        'toggle-checked': '#928FFF',
        'active-bg': '#E8F5F9',
        'field-text': '#444',
      },
      button: {
        DEFAULT: '#4B4DED',
        'hover': '#0500D7',
      }
    },
    fontFamily: {
      sans: [
        'Figtree',
        'sans-serif',
        '"Apple Color Emoji"',
        '"Segoe UI Emoji"',
        '"Segoe UI Symbol"',
        '"Noto Color Emoji"',
      ],
      serif: [
        'Gambetta',
        'serif',
        '"Apple Color Emoji"',
        '"Segoe UI Emoji"',
        '"Segoe UI Symbol"',
        '"Noto Color Emoji"',
      ],
    },
    fontSize: {
      xs: 12 / 16 + 'rem',
      sm: 14 / 16 + 'rem',
      base: 16 / 16 + 'rem',
      lg: 18 / 16 + 'rem',
      xl: 20 / 16 + 'rem',
      '2xl': 22 / 16 + 'rem',
      '3xl': 28 / 16 + 'rem',
      '4xl': 32 / 16 + 'rem',
      '5xl': 40 / 16 + 'rem',
      '6xl': 44 / 16 + 'rem',
      '7xl': 48 / 16 + 'rem',
      '8xl': 64 / 16 + 'rem',
    },
    lineHeight: {
      none: '1',
      tight: '1.2',
      snug: '1.3',
      normal: '1.5',
      relaxed: '1.625',
      loose: '2',
    },
    letterSpacing: {
      normal: '0',
      wide: '0.025em',
    },
    screens: {
      sm: '640px',
      md: '768px',
      lg: '1024px',
      xl: '1270px',
      xxl: '1440px',
    },
    container: {
      center: true,
      padding: {
        DEFAULT: 'calc( var(--gutter) * 2 )',
        lg: '3.125rem', // 50px
      }
    },
    extend: {
      spacing: {
        gutter: 'var(--gutter, 1rem )', // 16px
        'gutter-full': 'calc( var(--gutter) * 2 )', //32px
        '14': '3.5rem', //56px
        '18': '4.5rem', // 72px
      },
      // this section allows you to add more style class options without overwriting all the options for a single style option (for example the z-index and adding -1). You can reference tailwindcss version 3.1.7 docs to see how to extend specific config options not included below
      zIndex: {
        '-1': '-1'
      },
      backgroundImage: {
        // 'gradient-fade-tr': 'linear-gradient(71.24deg, #000000 20.76%, rgba(0, 0, 0, 0) 100%)', // custom gradient example. Usuage would be bg-gradient-fade-tr
      },
      boxShadow: {
        'form-focus': '0px 0px 0px 4px rgba(0, 0, 0, 0.25)',
      }
    },
  },
}
