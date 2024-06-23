<?php
/**
* Fit Image
* -----------------------------------------------------------------------------
*
* Fit Image component
* fit accepts tailwind classes for object-fit and its variants
* https://tailwindcss.com/docs/object-fit/#app
*
* position accepts tailwind classes for object-position and its variants
* https://tailwindcss.com/docs/object-position/#app
*
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
  'image_id' => null,
  'thumbnail_size' => 'large',
  'fit'      => 'object-cover',
  'position' => 'object-center',
  'alt'      => null,
  'loading'  => true
];

$component_data = ll_parse_args( $component_data, $defaults );

$image_id       = $component_data['image_id'];
$thumbnail_size = $component_data['thumbnail_size'];
$fit            = $component_data['fit'];
$position       = $component_data['position'];
$image_url      = wp_get_attachment_url( $image_id );
$alt            = $component_data['alt'];

$image_args = [];

$image_args['class'] = $fit . ' ' .$position;

if ($alt) {
  $image_args['alt'] = $alt;
}

$image_args['loading'] = $component_data['loading'] ? 'lazy' : 'eager';

?>

<?php if ( !$image_id ) return; ?>
<div class="fit-image <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?>>
  <?php echo wp_get_attachment_image(
    $image_id,
    $thumbnail_size,
    false,
    $image_args
  ); ?>
</div>

