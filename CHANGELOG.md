# Change Log
All notable changes to this project will be documented in this file.

## [2.2.0] - 2022-03-21
### Changed
- assets/img/symbol-defs-ui.svg - organized icons into groups, groups are: social media icons, form icons, and general icons. Removed overly specific icons that aren't typically used. Removed icons: LiftedLogic, clock, phone, play and google_plus. Update youtube icon to more brand specific icon. Resized chevrons and social media icons so they all fill a 32x32 viewBox and are centered in the box to fix inconsistent sizing issues with the icons
- generate/cpt-template.php - added page for cpt option, updated not_found and not_found_in_trash settings to use plural instead of single form name, commented out editor and thumbnail options for the supports option put next to it. Added comment next to exclude_from_search option specify to set to false in using taxonomy pages. And rewrite option to set the slug based on the page for cpt option. Updated commented out example hierarchical taxonomy to be called Category for better understanding of taxonomy creation examples 
- lib/cpt/cpt-service.php - updated updated not_found and not_found_in_trash settings to use plural instead of single form name
- lib/custom/custom-gravity-forms.php - added 'Add Type Class to gfield Element' snippet from the lldev site
- resources/css/main.css - moved icon.css into the resources/css/base folder since it holds more global/base styles rather than partial specific styles
- resources/css/tailwind.config.js - updated purge to have a whitelist option and use wild card selectors to be more generic with classes to not exclude from purge. Removed all extra color groups except for the gray color group. Added comment to scrim and overlay color example specifying an alternative option to making custom colors with opacities in them. Updated gutter and gutter-full spacing value to use the css variable --gutter for easier updates when the gutter changes in the design or the gutter needs to change on other screen sizes. Removed unneeded overrides that weren't there as a reference or adding extra options as any config option not include will still be included. Updated container padding to use the --gutter css variable * 2. Added extend config section for adding extra styles and moved the zIndex: -1 option into it. Also included some default options for inset and opacity and an example how to set up custom gradient background classes for easier reusability.
- resources/css/base/icon.css - relocated from resources/css/partials to resources/css/base
- resources/css/base/utilities.css - Updated Wordpress WYSIWYG Figure alignment override to also include img tags since imported blogs with images that don't have the figure tag lose their styling otherwise
- resources/css/base/variables.css - removed adminbarHeight css variable since wordpress now creates their own variable to determine adminbar height. --topOffset variable now set here as well and uses wordpresses new css variable for adminbar height. Also included/updated comments explaining how each of css variables are used in the theme
- resources/css/partials/navbar.css - updated z-index on .navbar to be 90 so it's higher than the default tailwind z-index values. Updated .navbar-toggle and it's associated classes to use css variables for easier setup of our default hamburger menu button when used in designs, added comment with directions for the toggle button css variables
resources/js/_animations.js - removed all extra instances of gsap.registerPlugin( ScrollTrigger ); and moved it to the top with the imports as it only needs to be called once in a file. Create an animate function and moved default animations to it to help with animation load order issues. Updated animations to not create a bunch of gsap timelines and instead create ScrollTriggers or animate the gsap.to function for the reveal on scroll example
resources/js/app.js - added inline style to gridOverlay to increase z-index to over 9000 so it will always overlay everything on the page, including magnificPopup. Add fire event for animations new animate function for global animations to fix animation load order issues
- components/map/map.js - Updated map.js for easier out of the box functionality. Ability to use more than just png's for the marker is now possible. Will center on a single location or show all locations and center in the middle of them. With the way the map component is set up, it should also be easier to expand it for more complex map features such as location searches and more
- components/map/maps.css - Updated map.css for new .marker element
- components/map/map.php - Update map.php so that the container for the map would always have a unique id
- lib/scripts.php -Added wp_dequeue_style for wp-block library stylesheets
- Added minified/compiled files to .gitignore and deleted the files as well

### Removed
- index.php - removed get_template_part for header-page.php 
- package.json - removed sass and sass-loader package as we aren't using sass anymore
- search.php - removed get_template_part for header-page.php partial 
- yarn.lock - deleted the file, does nothing, left over from the past
- lib/custom/custom-functions.php - removed google_plus option from ll_get_social_list function as google plus doesn't exist anymore. Removed google_plus option from social media sites array in ll_generate_schema_json function as google plus doesn't exist anymore
- resources/css/base/base.css - Removed references to logged-in.admin-bar as wordpress now creates their own css variable to determine the admin-bar height. Top offset is now exclusively set in variables.css
- resources/css/base/typography.css - removed :not([class]) selectors from ul and ol styles to prevent them from loosing their styles upon animation classes being added
- templates/contents/content-single.php - removed get_template_part for header-page.php partial 
- templates/partials/header-page.php - deleted file as it wasn't being utilized
- resources/js/plugins - deleted folder as it served the same purpose as the resources/js/vendors folder
- acf - Removed google plus from social media section of site options. Added default mapbox style url - uses Base Theme Default on the mapbox account and should be changed out to an alternative url as needed

## [1.2.0] - 2016-07-07
### Added
- generate: folder containing template files for grunt generate
- sass: _reset.scss to replace bootstrap reset

### Changed
- gruntfile: fixed variable being used before declaration
- gruntfile: added semicolons to satisfy jshint
- gruntfile: include tasks for grunt generate
- package.json: include grunt-contrib-copy
- sass: grid is now flexbox based
- sass: more utility classes
- sass: media object is now flexbox based
- js: new collapse js to replace bootstrap
- lib nav: add item ids to menu items for collapse functionality
- config.json: add new variable for generate prefix

### Removed
- sass: all instances of bootstrap by default

## [1.1.8] - 2015-10-30
### Added
- sass: screen-[size]-maximum variables (matches max-width media query breakpoints to the pixel)

### Changed
- bower: updated modernizr

### Removed
- sass: absolutely positioned footer

### Fixed
- theme: modernizr src


## [1.1.7] - 2015-10-27
### Added
- sass: img { height: auto; }
- sass: %cover utility
- admin: "wpe_dify_news_feed" metabox removal
- theme: <meta name="format-detection" content="telephone=no">

### Changed
- modernizr: updated default modernizr custom build to v3 syntax
- packages: updated modernizr, bower, grunt-contrib-uglify, grunt-sass, grunt-postcss, time-grunt

### Removed
- theme: unused google analytics snippet


## [1.1.6] - 2015-09-28
### Added
- sass: .navbar { border-radius: 0; }
- sass: %overlay utility
- sass: hide gravity form honeypot field

### Changed
- packages: updated bower, grunt-modernizr, autoprefixer, load-grunt-tasks

### Removed
- directory: assets/img/favicons/


## [1.1.5] - 2015-09-11
### Added
- site options: environment toggle for Production and Development environments


## [1.1.4] - 2015-09-09

### Added
- file: config.json.example for devUrl implementation in Gruntfile (duplicate the file and rename the copy to "config.json" - always make sure there is a config.json.example in the repo)

### Changed
- package: updated bower 1.4.1 > 1.5.2
- package: updated grunt-contrib-jshint 0.11.2 > 0.11.3
- package: updated grunt-contrib-uglify 0.9.1 > 0.9.2
- package: updated grunt-postcss 0.5.5 > 0.6.0
- package: updated autoprefixer 5.2.1 > 6.0.1
- package: updated csswring 3.0.5 > 4.0.0

### Removed
- custom favicon module in favor of WordPress 4.3 native icon method


## [1.1.3] - 2015-08-03
### Added
- sass: _variables.scss: $footer-height
- sass: _form-skin.scss: more input selectors

### Changed
- gruntfile: decreased version hash length from 32 > 8
- jquery: updated from 1.11.3 > 2.1.4
- sass: variables organization


## [1.1.2] - 2015-07-28
### Added
- function: added "wpseo-dashboard-overview" to ll_remove_dashboard_meta (removes metabox from WP dashboard)
- sass: img { max-width: 100%; }

### Changed
- gruntfile: browserSync and watch file syntax to catch-all > **/*
- package: updated grunt-postcss 0.5.1 > 0.5.5
- package: updated autoprefixer-core 5.2.0 > 5.2.1
- tgm: updated required plugins module to 2.5.2

### Removed
- file: CONTRIBUTING.md


## [1.1.1] - 2015-07-06
### Added
- sass: _post.scss (used for single post pages)

### Changed
- tgm: updated required plugins module to 2.5.0
- sass: _entry.scss (used for news/blog archive page) - incorporates BEM syntax
- sass: navbar li elements display inline-block (previously inline)
- sass: navbar a elements display block (previously inline-block)
- sass: old transition mixin syntax to regular transition syntax in favor of autoprefixer, which handles prefixing automatically
- file: content.php - modified parent article to include "entry" class, incorporated BEM syntax on all elements
- file: comments.php - modified class to "post__comments"

### Removed
- file: README.md (need to re-write it)
- theme: class "banner" from navbar

### Fixed
- function: set_post_background() spacing issue


## [1.1.0] - 2015-06-23
### Added
- package: grunt-browser-sync (run "grunt" or "grunt dev" instead of "grunt watch")
- package: postcss
- package: autoprefixer-core
- package: csswring
- theme: add_theme_support('title-tag')
- file: helpers/_functions.scss
- map: $breakpoints
- mixin: font-size()
- mixin: make-font-size()

### Changed
- Updated Gruntfile.js
- Updated load-grunt-tasks to 3.2.0
- Updated time-grunt to 1.2.1
- Commented out add_theme_support('post-formats')

### Removed
- package: grunt-autoprefixer
- package: grunt-contrib-concat
- mixin: "border-radius"
- mixin: "opacity" mixin
- mixin: "transform" mixin
- mixin: "transition" mixin
- mixin: "transition-delay" mixin
- theme: wp_title()
- theme: roots_wp_title()
- theme: <link type="application/rss+xml"...> (hardcoded feed link)
- theme: sidebar-footer widget
- theme: load_theme_textdomain()
- theme: lang, lang/roots.pot


## [1.0.14] - 2015-06-17
### Added
- Private attribute to package.json
- transition-delay mixin

### Changed
- Updated bootstrap-sass to 3.3.5
- Updated jQuery to 1.11.3
- Updated grunt-sass to 1.0.0


## [1.0.13] - 2015-06-10
### Added
- "ll_remove_wp_version" filter that removes WP version meta from the <head>
- "ll_remove_wp_emoji" filter that removes Emoji styles/scripts

### Changed
- Updated TGM required plugins module
- Updated CMB2 "example-functions.php"
- Updated "_main.js" to include finalize function for the "about_us" page example

### Removed
- Duplicate variable in _variables.scss

### Fixed
- block-table__cell display issue once it begins to tile


## [1.0.12] - 2015-05-27
### Added
- Filter that adds page slug to the body class

### Changed
- Moved appropriate functions into "custom-functions"
- Bumped jQuery bower dependency to 1.11.3


## [1.0.11] - 2015-05-17
### Added
- %vertical-align utility in _utilities.scss
- Two more examples z-layer uses in _maps.scss

### Changed
- Meta options function prefixes


## [1.0.1] - 2015-02-17
### Added
- _block-table.scss 
- _gravity-forms.scss

### Changed
- Update Favicons module
- Spacing throughout SCSS files
- Rename "meta-options-main" > "meta-options-global"
- Rename "meta-options-social" > "meta-options-contact"


## [1.0.0] - 2014-04-14
### Added
- Initial launch
