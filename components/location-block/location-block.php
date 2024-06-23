<?php
/**
* Location Block
* -----------------------------------------------------------------------------
*
* Location Block component
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
];

$component_data = ll_parse_args( $component_data, $defaults );

$address_street = get_field('contact_street_address', 'option') ?? null;
$address_city = get_field('contact_city', 'option') ?? null;
$address_state = get_field('contact_state', 'option') ?? null;
$address_zip = get_field('contact_zip', 'option') ?? null;

$address_url = get_field('gmb_link', 'options') != '' ? get_field('gmb_link', 'options') : 'https://www.google.com/maps/place/' . $address_street . ' '. $address_city. ', ' . $address_state . ' ' . $address_zip;

$contact_phone = get_field('contact_phone_number', 'option') ?? null;
$location_hours = get_field('front_end_hours', 'options') ?? null;
?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="location-block py-16 lg:py-20 <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="location-block">
  <div class="container">
    <div class="items-center justify-center row">
      <div class="w-full col xl:w-10/12">
        <div class="items-center row">
          <div class="w-full mb-8 col lg:w-1/2 lg:mb-0">
            <div class="wysiwyg">
              <?php echo $component_data['content']; ?>
            </div>
          </div>
          <div class="w-full col lg:w-1/2">
            <div class="p-10 text-white location-block__location-card">
              <p class="mb-3 uppercase hdg-6">
                Address
              </p>
              <a class="inline-block mb-5 text-white hover:underline paragraph-default" href="<?php echo $address_url; ?>" target="_blank">
                <span class="block"><?php echo $address_street; ?></span>
                <span class="block">
                  <?php echo $address_city; ?>, <?php echo $address_state; ?> <?php echo $address_zip ?>
                </span>
              </a>
              <p class="mb-3 uppercase hdg-6">
                Phone
              </p>
              <a class="inline-block mb-5 text-white hover:underline paragraph-default" href="tel:<?php echo strip_phone(get_field('contact_phone_number', 'option')); ?>">
                <span class="block"><?php echo $contact_phone; ?></span>
              </a>
              <p class="mb-3 uppercase hdg-6">
                Office Hours
              </p>
              <div class="inline-block text-white paragraph-default">
                <div class="wysiwyg">
                  <?php echo $location_hours; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
