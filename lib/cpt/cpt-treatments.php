<?php
/**
 * Register the custom post type
 */
if ( ! function_exists('register_treatment_custom_post_type') ) {

  // Register Custom Post Type
  function register_treatment_custom_post_type() {

    /*
     * Checks if you've setup a custom page to use as
     * the archive for this post type. To do that, use the
     * commented out block at the bottom to register the settings page.
     * This makes it behave like the default page_for_posts so that
     * content can change the slug to be more seo friendly.
     */
    $slug = 'treatments';
    if ( class_exists('ACF') ) {
      $id = get_field( 'page_for_treatments', 'option' );

      if ( $id ) {
        $slug = ll_get_the_slug( $id ) ?? 'treatments';
      }
    }

    $labels = array(
      'name'                => 'Treatments',
      'singular_name'       => 'Treatment',
      'menu_name'           => 'Treatments',
      'parent_item_colon'   => 'Parent Treatment',
      'all_items'           => 'All Treatments',
      'view_item'           => 'View Treatment',
      'add_new_item'        => 'Add New Treatment',
      'add_new'             => 'New Treatment',
      'edit_item'           => 'Edit Treatment',
      'update_item'         => 'Update Treatment',
      'search_items'        => 'Search Treatments',
      'not_found'           => 'No Treatments found',
      'not_found_in_trash'  => 'No Treatments found in Trash',
    );
    $args = array(
      'label'               => 'Treatment',
      'description'         => 'Treatment description',
      'labels'              => $labels,
      'supports'            => array( 'title', 'page-attributes', 'thumbnail' ),
      // 'taxonomies'          => array( 'category', 'post_tag' ),
      'hierarchical'        => true,
      'public'              => true,
      'show_ui'             => true,
      'show_in_menu'        => true,
      'show_in_nav_menus'   => true,
      'show_in_admin_bar'   => true,
      'menu_position'       => 20,
      'menu_icon'           => 'dashicons-image-filter',
      'can_export'          => true,
      'has_archive'         => false,
      'exclude_from_search' => true,
      'publicly_queryable'  => true,
      'capability_type'     => 'post',
      'rewrite'             => array( 'slug' => $slug )
    );
    register_post_type( 'll_treatment', $args );

  }

  // Hook into the 'init' action
  add_action( 'init', 'register_treatment_custom_post_type', 0 );

}


/**
 * Custom taxonomies
 */
if ( ! function_exists('register_treatment_taxonomies') ) {

  function register_treatment_taxonomies() {

    /*
      * Checks if you've setup a custom field to use as
      * the slug for the category/tag archives for this post type. To do
      * that, use the commented out block at the bottom to register the
      * settings page. This makes it behave like the default page_for_posts
      * so that content can change the slug to be more seo friendly.
      */
    if ( class_exists('ACF') ) {
      $taxonomy_slug = get_field( 'treatment_category_slug', 'option' ) ?? 'treatment-category';
      $tag_slug = get_field( 'treatment_tag_slug', 'option' ) ?? 'treatment-tag';
    } else {
      $taxonomy_slug = 'treatment-category';
      $tag_slug = 'treatment-tag';
    }

    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
      'name'                => _x( 'Category', 'taxonomy general name' ),
      'singular_name'       => _x( 'Category', 'taxonomy singular name' ),
      'search_items'        => __( 'Search Categories' ),
      'all_items'           => __( 'All Categories' ),
      'parent_item'         => __( 'Parent Category' ),
      'parent_item_colon'   => __( 'Parent Category:' ),
      'edit_item'           => __( 'Edit Category' ),
      'update_item'         => __( 'Update Category' ),
      'add_new_item'        => __( 'Add New Category' ),
      'new_item_name'       => __( 'New Category Name' ),
      'menu_name'           => __( 'Categories' )
    );

    $args = array(
      'hierarchical'        => true,
      'labels'              => $labels,
      'show_ui'             => true,
      'show_admin_column'   => true,
      'query_var'           => true,
      'rewrite'             => array( 'slug' => $taxonomy_slug )
    );

    register_taxonomy( 'll_treatment_category', array( 'll_treatment' ), $args ); // Must include custom post type name

    // Add new taxonomy, NOT hierarchical (like tags)
    // $labels = array(
    //   'name'                         => _x( 'Tags', 'taxonomy general name' ),
    //   'singular_name'                => _x( 'Tag', 'taxonomy singular name' ),
    //   'search_items'                 => __( 'Search Treatment Tags' ),
    //   'popular_items'                => __( 'Popular Treatment Tags' ),
    //   'all_items'                    => __( 'All Treatment Tags' ),
    //   'parent_item'                  => null,
    //   'parent_item_colon'            => null,
    //   'edit_item'                    => __( 'Edit Treatment Tag' ),
    //   'update_item'                  => __( 'Update Treatment Tag' ),
    //   'add_new_item'                 => __( 'Add New Treatment Tag' ),
    //   'new_item_name'                => __( 'New Treatment Tag' ),
    //   'separate_items_with_commas'   => __( 'Separate Treatment Tags with commas' ),
    //   'add_or_remove_items'          => __( 'Add or remove Treatment Tag' ),
    //   'choose_from_most_used'        => __( 'Choose from the most used Treatment Tags' ),
    //   'not_found'                    => __( 'No Treatment found.' ),
    //   'menu_name'                    => __( 'Tags' )
    // );

    // $args = array(
    //   'hierarchical'            => false,
    //   'labels'                  => $labels,
    //   'show_ui'                 => true,
    //   'show_admin_column'       => true,
    //   'update_count_callback'   => '_update_post_term_count',
    //   'query_var'               => true,
    //   'rewrite'                 => array( 'slug' => $tag_slug )
    // );

    // register_taxonomy( 'll_treatment_tag', 'll_treatment', $args ); // Must include custom post type name

  }

  add_action( 'init', 'register_treatment_taxonomies', 0 );

}


/**
 * Create ACF setting page under CPT menu
 */

// if ( function_exists( 'acf_add_options_sub_page' ) ){
//   acf_add_options_sub_page(array(
//     'page_title' => 'Treatment Settings',
//     'menu_title' => 'Settings',
//     'menu_slug'  => 'll-treatment-settings',
//     'parent'     => 'edit.php?post_type=ll_treatment',
//     'capability' => 'edit_posts'
//   ));
// }
