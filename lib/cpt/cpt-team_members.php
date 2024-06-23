<?php
/**
 * Register the custom post type
 */
if ( ! function_exists('register_team_members_custom_post_type') ) {

  // Register Custom Post Type
  function register_team_members_custom_post_type() {

    /*
     * Checks if you've setup a custom page to use as
     * the archive for this post type. To do that, use the
     * commented out block at the bottom to register the settings page.
     * This makes it behave like the default page_for_posts so that
     * content can change the slug to be more seo friendly.
     */
    if (class_exists('ACF')) {
      $id = get_field( 'page_for_team_members', 'option' );
    }
    $slug = 'team_members';

    if ( $id ) {
      $slug = ll_get_the_slug( $id );
    }

    $labels = array(
      'name'                => 'Team Members',
      'singular_name'       => 'Team Members',
      'menu_name'           => 'Team Members',
      'parent_item_colon'   => 'Parent Team Members',
      'all_items'           => 'All Team Members',
      'view_item'           => 'View Team Members',
      'add_new_item'        => 'Add New Team Members',
      'add_new'             => 'New Team Members',
      'edit_item'           => 'Edit Team Members',
      'update_item'         => 'Update Team Members',
      'search_items'        => 'Search Team Members',
      'not_found'           => 'No Team Members found',
      'not_found_in_trash'  => 'No Team Members found in Trash',
    );
    $args = array(
      'label'               => 'Team Members',
      'description'         => 'Team Members description',
      'labels'              => $labels,
      'supports'            => array( 'title', 'page-attributes', 'thumbnail' ),
      // 'taxonomies'          => array( 'category', 'post_tag' ),
      'hierarchical'        => true,
      'public'              => true,
      'show_ui'             => true,
      'show_in_menu'        => true,
      'show_in_nav_menus'   => false,
      'show_in_admin_bar'   => true,
      'menu_position'       => 20,
      'menu_icon'           => 'dashicons-groups',
      'can_export'          => true,
      'has_archive'         => false,
      'exclude_from_search' => true, // false if using taxonomy pages
      'publicly_queryable'  => true,
      'capability_type'     => 'post',
      'rewrite'             => array( 'slug' => $slug )
    );
    register_post_type( 'll_team_members', $args );

  }

  // Hook into the 'init' action
  add_action( 'init', 'register_team_members_custom_post_type', 0 );

}

/**
 * Custom taxonomies
 */
// if ( ! function_exists('register_team_members_taxonomies') ) {

//   function register_team_members_taxonomies() {

//     // Add new taxonomy, make it hierarchical (like categories)
//     $labels = array(
//       'name'                => _x( 'Category', 'taxonomy general name' ),
//       'singular_name'       => _x( 'Category', 'taxonomy singular name' ),
//       'search_items'        => __( 'Search Categories' ),
//       'all_items'           => __( 'All Categories' ),
//       'parent_item'         => __( 'Parent Category' ),
//       'parent_item_colon'   => __( 'Parent Category:' ),
//       'edit_item'           => __( 'Edit Category' ),
//       'update_item'         => __( 'Update Category' ),
//       'add_new_item'        => __( 'Add New Category' ),
//       'new_item_name'       => __( 'New Category Name' ),
//       'menu_name'           => __( 'Categories' )
//     );

//     $args = array(
//       'hierarchical'        => true,
//       'labels'              => $labels,
//       'show_ui'             => true,
//       'show_admin_column'   => true,
//       'query_var'           => true,
//       'rewrite'             => array( 'slug' => get_field( 'team_members_category_slug', 'option' ) ?:  'team_members-category' )
//     );

//     register_taxonomy( 'll_team_members_category', array( 'll_team_members' ), $args ); // Must include custom post type name

//   }

//   add_action( 'init', 'register_team_members_taxonomies', 0 );

// }

/**
 * Create ACF setting page under CPT menu
 */

// if ( function_exists( 'acf_add_options_sub_page' ) ){
//   acf_add_options_sub_page(array(
//     'page_title' => 'Team Members Settings',
//     'menu_title' => 'Settings',
//     'menu_slug'  => 'team_members-settings',
//     'parent'     => 'edit.php?post_type=ll_team_members',
//     'capability' => 'edit_posts'
//   ));
// }



