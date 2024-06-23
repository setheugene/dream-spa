<?php
/**
* Treatments Archive
* -----------------------------------------------------------------------------
*
* Treatments Archive component
*/

/**
 * Any additional classes to apply to the main component container.
 *
 * @var array
 * @see args['classes']
 */
$classes = ( isset( $component_args['classes'] ) ? $component_args['classes'] : array() );

/**
 * ID to apply to the main component container.
 *
 * @var array
 * @see args['id']
 */
$component_id   = ( isset( $component_args['id'] ) ? $component_args['id'] : false );
?>

<?php
$defaults = [

];

$component_data = ll_parse_args( $component_data, $defaults );

switch_to_blog( get_main_site_id() );
function get_nested_categories($parent_id = 0) {
  $categories = get_categories(array(
      'taxonomy'     => 'll_treatment_category',
      'parent'       => $parent_id,
      'hide_empty'   => false,
      'orderby'      => 'term_order',
  ));

  $nested_categories = array();

  foreach ($categories as $category) {
      $category_data = (array) $category;
      $category_data['children'] = get_nested_categories($category->term_id);
      $nested_categories[] = $category_data;
  }

  return $nested_categories;
}

$parent_categories = get_nested_categories();


restore_current_blog();
?>

<?php if ( ll_empty( $parent_categories ) ) return; ?>
<section class="treatment-archive <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="treatment-archive">
  <div class="container">
    <div class="row">
      <div class="w-full mb-8 col lg:w-3/12 lg:mb-0">
        <div class="pt-10 bg-white">
          <div class="mb-6 uppercase hdg-6 text-brand-navy">
            Categories
          </div>
          <?php if (!empty($parent_categories)) : ?>
            <?php foreach ($parent_categories as $key => $parent_category) : ?>
              <button class="block w-full group" data-toggle-class="is-open" data-toggle-target="#parent-id-<?php echo $parent_category['term_id']; ?>" data-toggle-radio-group="parent-cats" <?php echo $key == 0 ? 'data-toggle-is-active' : ''; ?>>
                <div class="p-5 flex items-center duration-200 w-full group-[.is-open]:bg-brand-off-white">
                  <svg class='group-[.is-open]:text-brand-teal h-5 w-5 duration-200 icon mr-3 icon-<?php echo get_field('treatment_cat_icon', 'll_treatment_category_' . $parent_category['term_id'])['svg_icon'] ?? '' ?>'><use xlink:href='#icon-<?php echo get_field('treatment_cat_icon', 'll_treatment_category_' . $parent_category['term_id'])['svg_icon'] ?? '' ?>'></use></svg>
                  <span class="hdg-5 relative group-[.is-open]:text-brand-teal group-hover:text-brand-teal group-[.is-open]:after:opacity-100 after:opacity-0 after:h-[1px] after:w-full after:-bottom-[2px] after:bg-brand-teal after:absolute after:left-0"><?php echo esc_html($parent_category['name']); ?></span>
                </div>
              </button>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
      <div class="w-full relative col lg:w-9/12 after:bg-brand-off-white after:h-full after:w-[50px] after:absolute after:-left-4 after:top-0">
        <div class="relative z-10 pt-10 pb-12 bg-brand-off-white">
          <div class="relative">
            <?php if (!empty($parent_categories)) : ?>
              <?php foreach ($parent_categories as $key => $parent_category) : ?>
                <div class="parent-cat" id="parent-id-<?php echo $parent_category['term_id']; ?>">
                  <div class="mb-6 hdg-4 text-brand-navy">
                    <?php echo get_field('treatment_cat_title', 'll_treatment_category_' . $parent_category['term_id']) ?? '' ?>
                  </div>
                  <?php if (!empty($parent_category['children'])) : ?>
                    <div class="w-full mb-6 border-b border-brand-storm">
                      <?php foreach ($parent_category['children'] as $key => $child_category) : ?>
                        <button class="inline-block p-3 mr-5 lasts:mr-0 [&.is-open]:text-brand-navy font-medium text-brand-gray duration-200 relative after:h-[1px] after:w-full after:bg-brand-teal after:opacity-0 [&.is-open]:after:opacity-100 after:absolute after:duration-200 after:left-0 after:bottom-0" <?php echo $key === 0 ? 'data-toggle-is-active' : ''; ?> data-toggle-target="#treatment-results-<?php echo $child_category['slug'] ?>" data-toggle-class="is-open" data-toggle-radio-group="treatment-archive-chilren-menu-<?php echo $parent_category['term_id']; ?>">
                          <?php echo esc_html($child_category['name']); ?>
                        </button>
                      <?php endforeach; ?>
                    </div>
                    <?php foreach ($parent_category['children'] as $key => $child_category) : ?>
                      <div id="treatment-results-<?php echo $child_category['slug'] ?>" class="treatment-results">
                        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                          <?php if (!empty($child_category['children'])) : ?>
                            <?php foreach ($child_category['children'] as $key => $grandchild_category) : ?>
                              <?php $transient_name = 'll_treatment_category_locations_'.$grandchild_category['term_id'];
                              $grandchild_locations = get_transient($transient_name) ?? false;
                              $grandchild_locations = false;
                              if( !$grandchild_locations ) {
                                global $wpdb;
                                $grandchild_locations = [];
                                $grandchild_term_id = $grandchild_category['term_id'];

                                $blog_ids = get_sites(['fields' => 'ids', 'site__not_in' => [get_main_site_id()]]);

                                foreach ($blog_ids as $blog_id) {
                                  switch_to_blog($blog_id);

                                  $sql = $wpdb->prepare(
                                    "SELECT p.ID, p.post_title
                                    FROM {$wpdb->prefix}posts p
                                    INNER JOIN {$wpdb->prefix}postmeta pm ON p.ID = pm.post_id
                                    WHERE pm.meta_key = %s AND pm.meta_value = %s AND p.post_type = %s AND p.post_status = 'publish'",
                                    'treatment_related_to',
                                    $grandchild_term_id,
                                    'll_treatment'
                                  );
                                  $results = $wpdb->get_results($sql);
                                  // var_dump($results);
                                  if (!empty($results)) {
                                    $grandchild_locations[] = [
                                      'site_id' => $blog_id,
                                      'treatment_link' => get_the_permalink($results[0]->ID),
                                    ];
                                  }
                                  restore_current_blog();
                                }
                                set_transient($transient_name, $grandchild_locations, 60*60);
                              }

                              ?>
                              <div class="p-4 bg-white">
                                <div class="mb-2 font-semibold paragraph-large text-brand-navy">
                                  <?php echo $grandchild_category['name']; ?>
                                </div>
                                <div class="mb-4 paragraph-small text-brand-gray">
                                  <?php echo category_description($grandchild_category['term_id']) ?? ''; ?>
                                </div>
                                <?php if( !empty($grandchild_locations) ) : ?>
                                  <div class="uppercase text-brand-gray font-xs">
                                    <span class="mb-[10px] block">Locations Offered:</span>
                                    <div class="flex gap-2 flex-flow">
                                      <?php foreach( $grandchild_locations as $location ) : ?>
                                        <?php switch_to_blog( $location['site_id'] ); ?>
                                          <div class="special-grid__card-location-pill w-fit py-1 pr-3 pl-[10px] group hover:bg-brand-teal hover:text-white duration-200 relative paragraph-small rounded-full text-brand-teal items-center flex bg-brand-off-white">
                                            <svg class='icon h-4 w-4 mr-[9px] text-brand-teal group-hover:text-white icon-Location'><use xlink:href='#icon-Location'></use></svg>
                                            <?php echo get_bloginfo('name'); ?>
                                            <a href="<?php echo $location['treatment_link']; ?>" class="absolute inset-0 w-full h-full"></a>
                                          </div>
                                        <?php restore_current_blog(); ?>
                                      <?php endforeach; ?>
                                    </div>
                                  </div>
                                <?php endif; ?>
                              </div>
                            <?php endforeach; ?>
                          <?php endif; ?>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
          <div id="treatment-archive__grid" class="">
            <?php if (!empty($parent_categories)) : ?>
              <?php foreach ($parent_categories as $key => $parent_category) : ?>
                <?php if (!empty($parent_category['children'])) : ?>
                  <?php foreach ($parent_category['children'] as $key => $child_category) : ?>

                  <?php endforeach; ?>
                <?php endif; ?>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
