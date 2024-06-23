<?php
/**
* Locations Block
* -----------------------------------------------------------------------------
*
* Locations Block component
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
  'content' => '',
  'marquee_text' => '',
  'marquee_text_two' => '',
];

$marquee_text = $component_data['marquee_text'];
$marquee_text_two = $component_data['marquee_text_two'];

$component_data = ll_parse_args( $component_data, $defaults );

$location_information = [];
if ( function_exists( 'get_sites' ) && class_exists( 'WP_Site_Query' ) ) {
	$sites = get_sites();
	foreach ( $sites as $key => $site ) {
    $current_blog_id = get_current_blog_id();
    if($site->blog_id != $current_blog_id) {
      switch_to_blog( $site->blog_id );
      $location_image = get_field('location_image', 'options') ?? null;
        $location_information[$key] = [
          'site_link' => esc_url($site->domain),
          'location_name' => $site->blogname,
          'phone_number' => get_field('contact_phone_number', 'option') ?? null,
          'address_street' => get_field('contact_street_address', 'option') ?? null,
          'address_city' => get_field('contact_city', 'option') ?? null,
          'address_state' => get_field('contact_state', 'option') ?? null,
          'address_zip' => get_field('contact_zip', 'option') ?? null,
          'location_image' => $location_image != null ? wp_get_attachment_image($location_image['image_id'], 'large', false, array( "class" => $location_image['image_focus_point'] . ' object-cover' )) : null,
        ];
      restore_current_blog();
    }
	}
}

?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="locations-block lg:pt-16 pt-12 pb-8 bg-brand-off-white <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="locations-block">
  <div class="container">
    <div class="mb-10 wysiwyg js-fade-group">
      <?php echo $component_data['content']; ?>
    </div>
    <div class="mb-12 lg:mb-16 row js-fade-group">
      <?php foreach( $location_information as $location ) : ?>
        <div class="w-full mb-8 col lg:w-1/3 lg:mb-0 last:mb-0">
          <div class="relative overflow-hidden rounded-sm cursor-pointer aspect-square group">
            <div class="fit-image">
              <?php echo $location['location_image']; ?>
            </div>
            <div class="absolute inset-0 z-10 w-full h-full"></div>
            <div class="absolute inset-0 z-20 flex flex-col justify-between w-full h-full p-8 text-white duration-300 ease-in-out opacity-80 bg-brand-teal group-hover:opacity-100">
              <div class="w-11/12">
                <p class="mb-1 hdg-6">Visit</p>
                <p class="hdg-4"><?php echo $location['location_name']; ?></p>
              </div>
              <div>
                <p class="mb-3 paragraph-default">
                  <?php echo $location['phone_number']; ?>
                </p>
                <p>
                  <span class="block"><?php echo $location['address_street']; ?></span>
                  <span class="block"><?php echo $location['address_city'] ?>, <?php echo $location['address_state']; ?> <?php echo $location['address_zip']; ?></span>
                </p>
              </div>
            </div>
            <a class="absolute inset-0 z-40 w-full h-full" href="<?php echo $location['site_link']; ?>"></a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="locations-block__marquee">
    <?php if( $marquee_text != '' ) : ?>
      <div class="relative mr-10 marquee-text hdg-1 text-brand-teal"><?php echo $marquee_text; ?></div>
    <?php endif; ?>
    <?php if( $marquee_text_two != '' ) : ?>
      <div class="relative mr-10 marquee-text hdg-1 text-brand-teal"><?php echo $marquee_text_two; ?></div>
    <?php endif; ?>
    <?php if( $marquee_text != '' ) : ?>
      <div class="relative mr-10 marquee-text hdg-1 text-brand-teal"><?php echo $marquee_text; ?></div>
    <?php endif; ?>
    <?php if( $marquee_text_two != '' ) : ?>
      <div class="relative mr-10 marquee-text hdg-1 text-brand-teal"><?php echo $marquee_text_two; ?></div>
    <?php endif; ?>
  </div>
</section>
