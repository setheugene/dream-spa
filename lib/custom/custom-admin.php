<?php
/**
 *
 * Lifted Logic custom admin
 *
 */

//removes default margin of admin bar
add_action('admin_bar_init', 'remove_admin_login_header');
function remove_admin_login_header() {
  remove_action('wp_head', '_admin_bar_bump_cb');
}

/**
 * Remove Dashboard Widgets
 */
function ll_remove_dashboard_meta() {
  remove_action( 'welcome_panel', 'wp_welcome_panel' ); // welcome panel
  remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
  remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
  remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
  remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_activity', 'dashboard', 'normal'); // since 3.8
  remove_meta_box( 'rg_forms_dashboard', 'dashboard', 'normal' ); // gravity forms
  remove_meta_box( 'tribe_dashboard_widget', 'dashboard', 'normal' ); // modern tribe events calendar
  remove_meta_box( 'mandrill_widget', 'dashboard', 'normal' ); // mandrill
  remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'normal' ); // yoast seo
  remove_meta_box( 'wpe_dify_news_feed', 'dashboard', 'normal' ); // wp engine
}
add_action( 'admin_init', 'll_remove_dashboard_meta' );

function ll_editor_role_capabilities() {
  $role = get_role( 'editor' ) ?? false;

  if ( $role && ! $role->has_cap( 'gform_full_access' ) ) {
    $role->add_cap( 'gform_full_access' );
  }

  if ($role && !$role->has_cap('edit_theme_options')) {
    $role->add_cap('edit_theme_options');
  }
}
add_action( 'admin_init', 'll_editor_role_capabilities', 99);

/**** Dashboard Help Widget ****/

add_action('wp_dashboard_setup', 'll_dashboard_widgets');

function ll_dashboard_widgets() {
  global $wp_meta_boxes;
  add_meta_box('id', 'Support', 'll_dashboard_help', 'dashboard', 'normal', 'high');
}

add_action( 'in_admin_header','ll_in_admin_header' );
function ll_in_admin_header() {
  include_once( get_stylesheet_directory() . '/assets/img/symbol-defs.svg' );
}

function ll_dashboard_help() {
  ?>
  <h2 style="margin-bottom: 0; color: #D54E21;">Need some help?</h2>
  <p>If you have questions or concerns about the following, please let us know and we'll be happy to assist you :)</p>
  <ul style="list-style: disc; padding-left: 30px;">
    <li>Updating the site</li>
    <li>Adding / removing content</li>
  </ul>
  <hr>
  <strong>Lifted Logic</strong><br />
  <a href="mailto:info@liftedlogic.com">info@liftedlogic.com</a><br />
  816.298.7018
  <?php
}

/**
 * Set custom logo for the Wordpress login page
 */
function ll_custom_login_logo() {

  $logo = get_field( 'global_logo', 'option' );

  if ( $logo ) : ?>
    <style type="text/css">
      #login h1 a, .login h1 a {
        background-image: url(<?php echo $logo['url']; ?> );
        width: 100%;
        height: auto;
        min-height: 100px;
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center center;
      }
    </style>
  <?php endif; ?>
<?php }
add_action( 'login_enqueue_scripts', 'll_custom_login_logo' );

function ll_custom_login_logo_url() {
  return home_url();
}
add_filter( 'login_headerurl', 'll_custom_login_logo_url' );

function ll_custom_login_logo_url_title() {
  return get_bloginfo( 'description' );
}
add_filter( 'login_headertitle', 'll_custom_login_logo_url_title' );

/**
* ll_stop_reordering_my_categories
* -----------------------------------------------------------------------------
* Keep categories and taxonomies in their hierarchical order rather than showing the selected terms on top.
*
*/
function ll_stop_reordering_my_categories($args) {
  $args['checked_ontop'] = false;
  return $args;
}
add_filter('wp_terms_checklist_args','ll_stop_reordering_my_categories');

function change_site_visibility() {

  if ( function_exists( 'get_field' ) ) {

    $environment = get_field('global_environment', 'option');

    if ($environment == 'development') {
      update_option('blog_public', '0');
    } else {
      update_option('blog_public', '1');
    }
  }
}
add_action('admin_init', 'change_site_visibility');

//enqueue our admin javascript/styles
function ll_admin_enqueue_scripts() {
  $screen = get_current_screen();
  wp_enqueue_style('fontawesome', 'https://use.fontawesome.com/releases/v5.5.0/css/all.css', '', '5.5.0', 'all');
  wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700;800&display=swap', false );

  if ( WP_ENV === 'development' ) {
    wp_enqueue_style( 'admin-css', get_template_directory_uri().'/assets/css/admin.min.css' );
    wp_enqueue_script('admin-js', get_template_directory_uri() . '/assets/js/admin.min.js', 'jquery', '', true);
  } elseif ( WP_ENV === 'production') {
    $get_assets = file_get_contents(get_stylesheet_directory() . '/assets/mix-manifest.json' );
    $assets     = json_decode($get_assets, true);
    wp_enqueue_style( 'admin-css', get_template_directory_uri().'/assets'.$assets['/css/admin.min.css'] );
    wp_enqueue_script('admin-js', get_template_directory_uri() . '/assets'. $assets['/js/admin.min.js'], 'jquery', '', true);
  }
}
add_action('admin_enqueue_scripts', 'll_admin_enqueue_scripts');

/**** Custom ACF Field Utilites ****/

/*
 * Generates an array of sanitized ids from the definitions in symbol-defs.svg.
 * @params $file defaults to symbol-defs.svg, can be changed for functional use in other situtations
 */
function get_icon_list( $file='symbol-defs.svg' ) {
  $file_path = get_template_directory_uri() . '/assets/img/'.$file;
  $icon_data = simplexml_load_string( file_get_contents( $file_path,false, stream_context_create( array("ssl"=>array("verify_peer"=>false,"verify_peer_name"=>false))) ) );

  if ( $icon_data ) {
    $icon_list = $icon_data->defs;
    if ( $icon_list ) {
      $icon_list = (array) $icon_list;
      if ( is_object( $icon_list['symbol'] ) ) {
        $icon_list['symbol'] = [$icon_list['symbol']];
      }
    }
  }

  $icons = array();
  if ( $icon_list ) {
    foreach( $icon_list['symbol'] as $icon_key => $icon ) {
      if ( isset( $icon['id'] ) ) {
        $icons[] = (string) substr($icon['id'], 5);
      }
    }
  }
  sort($icons);
  return $icons;
}

// Populate select with available gravity forms, shows form name, outputs form id
// Usage: Field Type: Select, Field Name containing "form_id"
add_filter('acf/load_field/type=select', 'll_gravity_form_type_select', 99);
function ll_gravity_form_type_select($field) {
  global $post;
  if ( !is_admin() || !class_exists( 'RGFormsModel' ) ) {
    return $field;
  }

  if ( strpos( $field['name'], 'form_id' ) !== false ) {
    //empty out choices just in case
    $field['choices'] = array();
    $forms = RGFormsModel::get_forms( null, 'title' );

    if ( $forms ) {
      foreach ($forms as $key => $form) {
        $field['choices'][$form->id] = $form->title;
      };
    }
  }

  if ( strpos( $field['name'], 'related_to' ) !== false ) {
    //empty out choices just in case
    $field['choices'] = array();

    switch_to_blog( get_main_site_id() );
    $all_categories = get_categories( array(
      'taxonomy'     => 'll_treatment_category',
      'hide_empty'   => false,
    ) );

    $categories_without_children = array();

    foreach ( $all_categories as $category ) {
      $children = get_term_children( $category->term_id, 'll_treatment_category' );

      if ( empty( $children ) ) {
          $categories_without_children[] = $category;
      }
    }
    restore_current_blog();

    if ( $categories_without_children ) {
      $field['choices'][] = 'No Related Treatment';
      foreach ($categories_without_children as $key => $category) {
        switch_to_blog( get_main_site_id() );
          $parent_cat = get_the_category_by_ID($category->category_parent);
        restore_current_blog();
        $field['choices'][$category->term_id] = $parent_cat . ' - ' . $category->name;
      };
    }
  }

  return $field;
}

// ADD SITE NAMES AND IDS FOR CHOICES ON ANY CHECKBOX FIELD ENDING WITH SITE_IDS
add_filter('acf/load_field/type=checkbox', 'll_gravity_form_type_checkbox', 99);
function ll_gravity_form_type_checkbox($field) {
  global $post;
  if ( !is_admin() || !class_exists( 'RGFormsModel' ) ) {
    return $field;
  }

  if ( strpos( $field['name'], 'site_ids' ) !== false ) {
    //empty out choices just in case
    $field['choices'] = array();

    $sites = get_sites();
    $main_site_id = get_main_site_id();

    if ( $sites ) {
      foreach ($sites as $key => $site) {
        if($site->blog_id != $main_site_id) {
          $field['choices'][$site->blog_id] = $site->blogname;
        }
      };
    }
  }
  return $field;
}

// ADD BEFORE AND AFTER POST NAMES AND IDS FOR CHOICES ON ANY CHECKBOX FIELD ENDING WITH BAG_IDS
add_filter('acf/load_field/type=checkbox', 'll_gravity_form_type_checkbox_bag', 99);
function ll_gravity_form_type_checkbox_bag($field) {
  global $post;
  if ( !is_admin() || !class_exists( 'RGFormsModel' ) ) {
    return $field;
  }

  if ( strpos( $field['name'], 'bag_ids' ) !== false ) {
    //empty out choices just in case
    $field['choices'] = array();

    global $wpdb;
    switch_to_blog( get_main_site_id() );
    $post_type = 'll_bag';

    // SQL query to retrieve custom post type posts
    $query = $wpdb->prepare(
        "SELECT * FROM $wpdb->posts WHERE post_type = %s AND post_status = 'publish'",
        $post_type
    );

    // Execute the query
    $custom_post_type_posts = $wpdb->get_results($query);
    $unsorted_posts = [];
    if ( $custom_post_type_posts ) {
      foreach ($custom_post_type_posts as $key => $bag_post) {
        $field['choices'][$bag_post->ID] = $bag_post->post_title;
      };
    }

    restore_current_blog();
    asort($field['choices']);
  }
  return $field;
}

// ADD BLOG POST NAMES AND IDS FOR CHOICES ON ANY SELECT FIELD ENDING WITH post_ids
add_filter('acf/load_field/type=select', 'll_gravity_form_type_select_post', 99);
function ll_gravity_form_type_select_post($field) {
  global $post;
  if ( !is_admin() || !class_exists( 'RGFormsModel' ) ) {
    return $field;
  }

  if ( strpos( $field['name'], 'post_ids' ) !== false ) {
    //empty out choices just in case
    $field['choices'] = array();

    global $wpdb;
    switch_to_blog( get_main_site_id() );
    $post_type = 'post';

    // SQL query to retrieve custom post type posts
    $query = $wpdb->prepare(
        "SELECT * FROM $wpdb->posts WHERE post_type = %s AND post_status = 'publish'",
        $post_type
    );

    // Execute the query
    $custom_post_type_posts = $wpdb->get_results($query);

    if ( $custom_post_type_posts ) {
      foreach ($custom_post_type_posts as $key => $bag_post) {
        $field['choices'][$bag_post->ID] = $bag_post->post_title;
      };
    }
    restore_current_blog();
  }
  return $field;
}

// ADD TESTIMONIAL POST NAMES AND IDS FOR CHOICES ON ANY SELECT FIELD ENDING WITH TESTIMONIAL_IDS
add_filter('acf/load_field/type=select', 'll_gravity_form_type_select_post_testimonials', 99);
function ll_gravity_form_type_select_post_testimonials($field) {
  global $post;
  if ( !is_admin() || !class_exists( 'RGFormsModel' ) ) {
    return $field;
  }

  if ( strpos( $field['name'], 'testimonial_ids' ) !== false ) {
    //empty out choices just in case
    $field['choices'] = array();

    global $wpdb;
    switch_to_blog( get_main_site_id() );
    $post_type = 'll_testimonials';

    // SQL query to retrieve custom post type posts
    $query = $wpdb->prepare(
        "SELECT * FROM $wpdb->posts WHERE post_type = %s AND post_status = 'publish'",
        $post_type
    );

    // Execute the query
    $custom_post_type_posts = $wpdb->get_results($query);

    if ( $custom_post_type_posts ) {
      foreach ($custom_post_type_posts as $key => $testimonail_post) {
        $field['choices'][$testimonail_post->ID] = $testimonail_post->post_title;
      };
    }
    restore_current_blog();
  }
  return $field;
}

// ADD CATEGORY NAMES AND IDS FOR CHOICES ON ANY SELECT FIELD ENDING WITH CATEGORY_IDS
add_filter('acf/load_field/type=select', 'll_gravity_form_type_select_category', 99);
function ll_gravity_form_type_select_category($field) {
  global $post;
  if ( !is_admin() || !class_exists( 'RGFormsModel' ) ) {
    return $field;
  }

  if ( strpos( $field['name'], 'category_ids' ) !== false ) {
    //empty out choices just in case
    $field['choices'] = array();


    switch_to_blog( get_main_site_id() );

    $categories = get_categories();

    if ( $categories ) {

      foreach ($categories as $key => $post_category) {
        $field['choices'][$post_category->term_id] = $post_category->name;
      };
    }
    restore_current_blog();
  }
  return $field;
}

// Output visual icon selector
// Usage: Field Name: my_component_name, Field Type: clone, Prefix Field Names: yes
// Call my_component_name_svg_icon
/*
 * Populate ACF Button Group field with symbol-defs.svg
 */
add_filter('acf/load_field/type=button_group', 'll_icon_picker', 99);
function ll_icon_picker($field) {
  global $post;
  if ( !is_admin() || !function_exists('get_icon_list') ) {
    return $field;
  }

  if ( strpos( $field['name'], 'svg_icon' ) !== false ) {

    //empty out choices just in case
    $field['choices'] = array();

    $icons = get_icon_list();

    if ( $icons ) {
      foreach ($icons as $key => $icon) {
        $field['choices'][$icon] = '<svg class="icon icon-'.$icon.'" aria-hidden="true"><use xlink:href="#icon-'.$icon.'"></use></svg>';
      };
    }
  }
  return $field;
}

add_filter( 'acf/fields/flexible_content/layout_title', function($title, $field, $layout, $i) {
  return $title . ' <span class="hidden component-key" data-key="'.sanitize_title( $title ).'"></span>';
}, 99, 4 );

/**** Media Utilities ****/
/*
 * Wrap images in a figure tag
 */
function html5_insert_image($html, $id, $caption, $title, $align, $url, $size, $alt ) {
  //Always return an image with a <figure> tag, regardless of link or caption

  //Grab the image tag
  $image_tag = get_image_tag($id, $alt, $title, $align, $size);

  //Let's see if this contains a link
  $linkptrn = "/<a[^>]*>/";
  $found = preg_match($linkptrn, $html, $a_elem);

  // If no link, do nothing
  if($found > 0) {
    $a_elem = $a_elem[0];
  } else {
    $a_elem = "";
  }

  // Set up the attributes for the caption <figure>
  $attributes  = (!empty($id) ? ' id="attachment_' . esc_attr($id) . '"' : '' );
  $attributes .= ' class="thumbnail wp-caption' . 'align'.esc_attr($align) . '"';

  $output  = '<figure' . $attributes .'>';

  //add the image back in
  $output .= $a_elem;
  $output .= $image_tag;

  if($a_elem != "") {
    $output .= '</a>';
  }

  if ($caption) {
    $output .= '<figcaption class="caption wp-caption-text">'.$caption.'</figcaption>';
  }
  $output .= '</figure>';

  return $output;
}

add_filter('image_send_to_editor', 'html5_insert_image', 10, 9);
add_filter( 'disable_captions', '__return_true' );

/*
 * Change WordPress default gallery output
 * http://wpsites.org/?p=10510/
 * Used when using the Create gallery action in the wysiwyg Add Media popup
 * Also used when the media gallery shortcode is used as well
 */
add_filter('post_gallery', 'll_gallery_output', 10, 2);
function ll_gallery_output($output, $attr) {
  global $post;
  if (isset($attr['orderby'])) {
      $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
      if (!$attr['orderby'])
          unset($attr['orderby']);
  }

  extract(shortcode_atts(array(
      'order' => 'ASC',
      'orderby' => 'menu_order ID',
      'id' => $post->ID,
      'itemtag' => 'dl',
      'icontag' => 'dt',
      'captiontag' => 'dd',
      'columns' => 3,
      'size' => 'thumbnail',
      'include' => '',
      'exclude' => ''
  ), $attr));

  $id = intval($id);
  if ('RAND' == $order) $orderby = 'none';

  if (!empty($include)) {
      $include = preg_replace('/[^0-9,]+/', '', $include);
      $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));

      $attachments = array();
      foreach ($_attachments as $key => $val) {
          $attachments[$val->ID] = $_attachments[$key];
      }
  }

  if (empty($attachments)) return '';

  // Here's your actual output, you may customize it to your need
  $output = "<div class=\"gallery\">\n";

  // Now you loop through each attachment
  foreach ($attachments as $id => $attachment) {
      // Fetch all data related to attachment
      $img = wp_prepare_attachment_for_js($id);

      // If you want a different size change 'large' to eg. 'medium'
      $popup = $img['sizes']['full']['url'];
      $url = $img['sizes']['medium']['url'];
      $height = $img['sizes']['medium']['height'];
      $width = $img['sizes']['medium']['width'];
      $alt = $img['alt'];

      // Store the caption
      $caption = $img['caption'];

      $output .= "<figure class=\"gallery-item\">\n";
      $output .= "<a class=\"gallery-item-popup\" href=\"{$popup}\">\n";
      $output .= "<img src=\"{$url}\" width=\"{$width}\" height=\"{$height}\" alt=\"{$alt}\" />\n";
      $output .= "</a>\n";
      $output .= "</figure>\n";
  }

  $output .= "</div>\n";
  return $output;
}

/*
 * Allow SVGs to be uploaded to Media Library
 * upload_mimes filter allows the file picker to actually allow
 * files with the extension of svg. It also allows svgs without
 * a xml declaration to be uploaded.
 *
 * The floowing allow_custom_mimes function is what allows us to also allow
 * svgs with the xml declaration to get uploaded since we need both.
 */
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

function allow_custom_mimes($check, $file, $filename) {
  $mimeTypes = [
    [ 'svg' => 'image/svg+xml' ],
  ];
  if ( empty($check['ext']) && empty($check['type'])) {
    foreach( $mimeTypes as $mime ) {
      remove_filter( 'wp_check_filetype_and_ext', 'allow_custom_mimes', 99 );
      $filtered_mimes = function($mimes) use ($mime) {
        return array_merge($mimes, $mime);
      };
      add_filter('upload_mimes', $filtered_mimes, 99);
      $check = wp_check_filetype_and_ext( $file, $filename, $mime );
      remove_filter('upload_mimes', $filtered_mimes, 99);
      add_filter( 'wp_check_filetype_and_ext', 'allow_custom_mimes', 99, 3 );
      if ( ! empty( $check['ext'] ) || ! empty( $check['type'] ) ) {
        return $check;
      }
    }
  }
  return $check;
}
add_filter( 'wp_check_filetype_and_ext', 'allow_custom_mimes', 99, 3 );

/*
 * Set max upload size for image types
 */
function ll_max_image_size_check( $file ) {
  $size = $file['size'];
  $size = $size / 1024;
  $type = $file['type'];
  $is_image = strpos( $type, 'image' ) !== false;
  $limit = 1000;
  $limit_output = '1000kb';
  $max_size = 2000;
  $img_sizes = getimagesize($file['tmp_name']);

  if ( $is_image && $img_sizes ) {

    if ( $size > $limit ) {
      $file['error'] = 'Image files must be smaller than ' . $limit_output;
    }

    if ( $img_sizes[0] > $max_size || $img_sizes[1] > $max_size ) {
      $file['error'] = 'Image can not be wider or taller than ' . $max_size .'px';
    }
  }

  return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'll_max_image_size_check' );

/* Allow svg and other associated tags and attributes
 * so our svg icon selector displays properly
*/
add_filter( 'wp_kses_allowed_html', 'acf_add_allowed_svg_tag', 10, 2 );
function acf_add_allowed_svg_tag( $tags, $context ) {
    if ( $context === 'acf' ) {
        $tags['svg']  = array(
            'xmlns'       => true,
            'fill'        => true,
            'viewbox'     => true,
            'role'        => true,
            'aria-hidden' => true,
            'focusable'   => true,
            'class' => true,
        );
        $tags['path'] = array(
            'd'    => true,
            'fill' => true,
        );
        $tags['use'] = array(
          'xlink:href' => true,
        );
    }

    return $tags;
}

/*
 * Sort ACF field groups alphabetically
 */
function sort_acf_field_groups( $wp_query ) {
  global $pagenow;
  if ( isset( $_GET['post_type'] ) && is_admin() && $_GET['post_type'] == 'acf-field-group' && 'edit.php' == $pagenow && !isset( $_GET['orderby'] ) ) {
    $wp_query->set( 'orderby', 'title' );
    $wp_query->set( 'order', 'ASC' );
  }
}
add_filter('pre_get_posts', 'sort_acf_field_groups' );

/**
 * START Theme Documentation Functions
 */
add_action( 'admin_menu', 'll_documentation_page' );
function ll_documentation_page() {
	add_menu_page(
		'Theme Documentation', // page <title>Title</title>
		'Theme Documentation', // menu link text
		'manage_options', // capability to access the page
		'theme-documentation', // page URL slug
		'll_documentation_page_content', // callback function /w content
		'dashicons-book-alt', // menu icon
	);
}

function ll_documentation_page_content(){
  $Parsedown = new Parsedown();
  $stream_context =   stream_context_create(
    array(
      "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false
      )
    )
  );

  $folder = get_template_directory(). '/ll-docs';
  echo '<div style="padding: 50px 50px 0;">';

    if ( file_exists( $folder ) ) {
      $checkFiles = scandir($folder);
      $fileCount = count($checkFiles);
      $file_i = 0;
      for ( $i = 0; $i < $fileCount; $i++ ) {
        $file = $checkFiles[$i];
        if($file == '.' || $file == '..'){
          //echo nothing
        }else{
          if ( file_exists( get_template_directory() . '/ll-docs/' . $file ) ) {
            $name = strstr($file, '.md', true);
            echo '<button class="ll-docs__tab' . ( $file_i == 0 ? ' is-active' : '' ) . '" data-target="#ll-docs__' . $name . '">' . ucwords( $name ) . '</button>';
            $file_i++;
          }
        }
      }
    }
    echo '<button class="ll-docs__tab ' . ( empty( $fileCount ) ? ' is-active' : '' ) . '" data-target="#ll-docs__components">Components</button>';
  echo '</div>';

  echo '<div style="padding: 0 50px 50px;">';
    $file_i = 0;
    if ( !empty($fileCount) && $fileCount > 0 ) {
      for ( $i = 0; $i < $fileCount; $i++ ) {
        $file = $checkFiles[$i];
        if($file == '.' || $file == '..'){
          //echo nothing
        }else{
          if ( file_exists( get_template_directory() . '/ll-docs/' . $file ) ) {
            $name = strstr($file, '.md', true);
            echo '<div class="ll-docs__panel' . ( $file_i == 0 ? ' is-active' : '' ) . '" id="ll-docs__' . $name . '" data-i="' . $i . '">';
              ob_start();
              $content = '';
              echo file_get_contents( get_template_directory_uri() . '/ll-docs/' . $file, false, $stream_context ) . PHP_EOL;
              $content .= ob_get_clean();
              ob_flush();
              echo $Parsedown->text($content);
            echo '</div>';
            $file_i++;
          }
        }
      }
    }

    echo '<div class="ll-docs__panel ' . ( empty( $fileCount ) ? ' is-active' : '' ) . '" id="ll-docs__components">';
      ob_start();
      $content = '## Components' . PHP_EOL;
      $folder = get_template_directory(). '/components';
      $checkFiles = scandir($folder);
      $fileCount = count($checkFiles);
      for ( $i = 0; $i < $fileCount; $i++ ) {
        $file = $checkFiles[$i];
        if($file == '.' || $file == '..'){
          //echo nothing
        }else{
          if ( file_exists( get_template_directory() . '/components/' . $file . '/' . $file . '.md' ) ) {
            echo file_get_contents( get_template_directory_uri() . '/components/' . $file . '/' . $file . '.md', false, $stream_context ) . PHP_EOL;
          }
        }
      }
      $content .= ob_get_clean();
      ob_flush();

      echo $Parsedown->text($content);
    echo '</div>';

  echo '</div>';
}

add_action('acf/render_field_settings', 'll_add_documentation_notes_field_setting');
function ll_add_documentation_notes_field_setting( $field ) {
	acf_render_field_setting( $field, array(
		'label'			    => __('Documentation Notes'),
		'instructions'	=> 'If this field group is for a component, this will appear in the component\'s documentation file',
		'name'			    => 'documentation_notes',
		'type'			    => 'textarea',
	), true);
}

add_action('acf/update_field_group', 'll_save_component_fields_to_md');
function ll_save_component_fields_to_md( $field_group ) {
  // Check if this is a field group for a component
  if ( strpos( $field_group['title'], 'Component : ' ) === false && strpos( $field_group['title'], 'Component: ' ) === false ) {
    return;
  }

  // Get the name of the component, removing the prefix (even the mistyped prefix)
  $title = str_replace( 'Component : ', '', $field_group['title'] );
  $title = str_replace( 'Component: ', '', $title );

  // Get the file path for the component
  $component_slug = sanitize_title(str_replace( 'Component : ', '', $title ));

  // If the field group slug is being used for the file name, use that instead of the sanitized title
  if ( get_field( 'll_component_filename', $field_group['ID'] ) ) {
    $component_slug = get_field( 'll_component_filename', $field_group['ID'] );
  }

  $file_path = get_template_directory() . '/components/' . $component_slug . '/' . $component_slug . '.md';
  if ( !file_exists( $file_path ) ) {
    return;
  }

  // Set up where the new table of fields will save to
  $new_table = '';

  // Get the location of where the table will go when you replace it
  $beginning_pos = strpos(file_get_contents($file_path), '<table class="ll-fields-table">');
  $end_pos = strpos(file_get_contents($file_path), '***');

  // If there's not currently a table
  if ( $beginning_pos === false ) {
    $beginning_pos = strpos(file_get_contents($file_path), '***');
  }

  // Start setting up the table
  $new_table .= '<table class="ll-fields-table">
  <thead>
    <th>Label</th>
    <th>Name</th>
    <th>Type</th>
    <th>Notes</th>
  </thead>
  <tbody>';

  // Add a row for each field
  if ( !empty( acf_get_fields( $field_group['ID'] ) ) ) {
    foreach ( acf_get_fields( $field_group['ID'] ) as $key => $field ) {
      if ( $field['type'] == 'clone' ) {
        // show the actual cloned fields
        if ( !empty( $field['clone'] ) ) {
          foreach ( $field['clone'] as $clone_key => $clone ) {
            if ( strpos( $clone, 'field_' ) !== false ) {
              $clone_field = get_field_object($clone);

              // Prefix the cloned field label with the field's label
              if ( $field['prefix_label'] ) {
                $clone_field['label'] = $field['label'] . ' ' . $clone_field['label'];
              }

              // Prefix the cloned field name with the field's name
              if ( $field['prefix_name'] ) {
                $clone_field['name'] = $field['name'] . '_' . $clone_field['name'];
              }
              $new_table .= '
              <tr>
                <td>' . $clone_field['label'] . ' (Clone of ' . $clone . ')</td>
                <td>' . $clone_field['name'] . '</td>
                <td>' . $clone_field['type'] . '</td>
                <td>' . (!empty($clone_field['documentation_notes']) ? $clone_field['documentation_notes'] : '') . '</td>
              </tr>';
            } else {
              $clone_title = acf_get_field_group($field['clone'][0])['title'];
              if ( $field['display'] === 'seamless' ) {
                if ( !empty( acf_get_fields( $clone ) ) ) {
                  foreach ( acf_get_fields( $clone ) as $clone_field_key => $clone_field ) {
                    // Prefix the cloned field label with the field's label
                    if ( $field['prefix_label'] ) {
                      $clone_field['label'] = $field['label'] . ' ' . $clone_field['label'];
                    }

                    // Prefix the cloned field name with the field's name
                    if ( $field['prefix_name'] ) {
                      $clone_field['name'] = $field['name'] . '_' . $clone_field['name'];
                    }
                    $new_table .= '
                    <tr>
                      <td>' . $clone_field['label'] . '</td>
                      <td>' . $clone_field['name'] . '</td>
                      <td>' . $clone_field['type'] . '</td>
                      <td>' . (!empty($clone_field['documentation_notes']) ? $clone_field['documentation_notes'] : '') . ' (Clone of ' . $clone_title . ')</td>
                    </tr>';
                  }
                }
              } elseif ( $field['display'] === 'group' ) {
                $new_table .= '
                <tr>
                  <td>' . $field['label'] . '</td>
                  <td>' . $field['name'] . '</td>
                  <td>' . $field['type'] . '</td>
                  <td>' . (!empty($field['documentation_notes']) ? $field['documentation_notes'] : '') . ' (Clone of ' . $clone_title . ')</td>
                </tr>';
              }
            }
          }
        }
      } else {
        $new_table .= '
        <tr>
          <td>' . $field['label'] . '</td>
          <td>' . $field['name'] . '</td>
          <td>' . $field['type'] . '</td>
          <td>' . (!empty($field['documentation_notes']) ? $field['documentation_notes'] : '') . '</td>
        </tr>';
      }
    }
  }

  // Close up the table
  $new_table .= '
  </tbody>
</table>';

  // Find the text this new table will replace
  $old_table = substr(file_get_contents($file_path), $beginning_pos, ($end_pos + strlen('***')) - $beginning_pos);

  // Replace the table, or add to the end of the file
  $content = str_replace($old_table, $new_table, file_get_contents($file_path)) . PHP_EOL . PHP_EOL . '***';

  // Write to the file
  $file = fopen( $file_path, 'w' );
  fwrite($file, $content);
  fclose($file);
}

// Add a field to the ACF field group to override what the component's filename is. Typically it will be the sanitized title of the field group. Let's say you have a field group called "Component: Left Right." By default, it will remove the "Component : " part, and run sanitize_title on the rest, making it "left-right." However, you may have named your component files something else, like "lr." In this case, you would enter "lr" in this "Component Filename" field.
add_action( 'acf/render_field_group_settings', 'll_component_filename_field' );
function ll_component_filename_field()
{
    global $post;

    // Only show this field on acf-field-group posts
    if (get_current_screen()->id !== 'acf-field-group' || (isset($_POST['post_type']) && $_POST['post_type'] != 'acf-field-group')) return false;

    // Get the current value of the custom field
    $value = get_post_meta($post->ID, 'll_component_filename', true);
    $title = str_replace( 'Component : ', '', $post->post_title );
    $title = str_replace( 'Component: ', '', $title );
    ?>
      <div class="misc-pub-section">
        <label for="ll_component_filename">Component Filename</label>
        <input type="text"<?php echo isset($value) ? ' value="' . $value . '"' : ''; ?>  name="ll_component_filename" placeholder="<?php echo sanitize_title($title);?>" />
      </div>
    <?php
}

// Save the "Component Filename" field to the database.
add_action( 'save_post', 'll_save_component_filename');
function ll_save_component_filename( $postid ) {
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return false;

  if ( function_exists( 'get_current_screen' ) && isset( get_current_screen()->id ) ) {
    if(get_current_screen()->id !== 'acf-field-group' || empty($postid) || (isset($_POST['post_type']) && $_POST['post_type'] != 'acf-field-group') ) return false;

    if(isset($_POST['ll_component_filename'])){
      update_post_meta($postid, 'll_component_filename', $_POST['ll_component_filename'], false );
    }
    else{
      delete_post_meta($postid, 'll_component_filename');
    }
  }
}
/**
 * END Theme Documentation Functions
 */

if ( !function_exists( 'lll' ) ) {
  function lll() {
    if ( current_user_can( 'administrator' ) ) {
      ?>
      <script>
        console.log( 'Undefined function lll() found.' );
      </script>
      <?php
    }
  }
}

// add new field to acf field group
add_action('acf/render_field_group_settings', 'll_acf_option_add_to_components');
function ll_acf_option_add_to_components($field_group){
    acf_render_field_wrap(array(
        'label'			=> __('Add to Components Flexible Content','acf'),
        'type'			=> 'true_false',
        'name'			=> 'add_to_components',
        'prefix'		=> 'acf_field_group',
        'value'			=> ( isset($field_group['add_to_components']) ) ? $field_group['add_to_components'] : '',
    ));
}

function ll_compare_by_component_label($a, $b) {
  return strcmp($a['label'], $b['label']);
}

/**
 * Automatically add components to Components field group, and order it alphabetically
 */
add_action('acf/update_field_group', function( $field_group ) {
  if ( !empty( $field_group['add_to_components'] ) ) {
    $acf_components_field = 'field_5d0d37adc1475';
    $field = acf_get_field( $acf_components_field );

    if ( !$field ) {
      var_error_log( 'Components field not found' );
      return null;
    }
    $layouts = $field['layouts'];

    /* get saved field group stuff */
    /* convert the slug to an underscored name, using the component filename field if necessary */
    $field_group_slug = get_field( 'll_component_filename', $field_group['ID'] ) ?: str_replace( 'Component : ', '', $field_group['title'] );
    $field_group_slug = str_replace('-', '_', sanitize_title($field_group_slug));

    /* Check if the component has already been added to the flexible layout */
    $search = acf_search_fields( $field_group_slug, $layouts );

    $new_field = false;

    if ( !$search ) {
      $new_field = true;
    }

    if ( $new_field ) {
      /* Create new layout in flexible content */
      $layout_key = 'layout_'.uniqid();
      $layouts[$layout_key] = [
        'key' => $layout_key,
        'label' => str_replace( 'Component : ', '', $field_group['title'] ),
        'name' => $field_group_slug,
        'display' => 'block',
        'sub_fields' => [
        ]
      ];

      /* sort the layouts alphabetically */
      usort($layouts, 'll_compare_by_component_label');

      $field['layouts'] = $layouts;

      acf_update_field( $field );

      /* Add meta clone to new layout */
      $meta_args = array(
        'key' => 'field_' . uniqid(),
        'label' => 'Meta',
        'name' => 'meta',
        'type' => 'clone',
        'clone' => array(
          0 => 'group_5d0d37eae4bed',
        ),
        'parent' => $field['ID'],
        'parent_layout' => $layout_key
      );

      acf_update_field($meta_args);

      /* Add new component field group clone to layout */
      $field_args = array(
        'key' => 'field_'.uniqid(),
        'label' => str_replace( 'Component : ', '', $field_group['title'] ) . ' Fields',
        'name' => 'fields',
        'type' => 'clone',
        'clone' => array(
          0 => $field_group['key'],
        ),
        'parent' => $field['ID'],
        'parent_layout' => $layout_key
      );

      acf_update_field($field_args);

      /* Save the updated field group to local json */
      $components_field_group = 'group_5d0d37a81ca8d';
      $component_group = acf_get_field_group( $components_field_group );

      if ( $component_group ) {
        $json = new ACF_Local_JSON;
        $json->update_field_group( $component_group );
      } else {
        var_error_log( 'Components custom field group not found' );
      }
    }
  }
}, 10, 1);

