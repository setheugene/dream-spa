<?php
/**
* Call To Action
* -----------------------------------------------------------------------------
*
* Call To Action component
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
  'options' => '',
  'image' => null,
  'cutout_image' => null,
  'content' => null,
];

$component_data = ll_parse_args( $component_data, $defaults );

$image_options = $component_data['options'];
$full_image = $component_data['image'];
?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="call-to-action bg-brand-off-white relative <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="call-to-action">
  <?php if( $image_options === 'full-image' ) : ?>
    <div class="relative aspect-16/9 xxl:w-[1355px] xxl:mx-auto call-to-action__full-image">
      <?php
        ll_include_component(
          'fit-image',
          array(
            'image_id' => $full_image['image_id'],
            'thumbnail_size' => 'full',
            'position' => $full_image['image_focus_point'],
            'fit' =>  $full_image['image_fit'],
            'loading' => $full_image['image_loading']
          )
        );
      ?>
    </div>
  <?php else: ?>
    <div class="absolute inset-0 w-full h-full pointer-events-none xxl:w-[1355px] xxl:mx-auto call-to-action__wave-graphic">
      <img class="" src="<?php echo get_template_directory_uri(); ?>/assets/img/call-to-action-wave.svg" alt="background wave graphic">
    </div>
    <div class="container relative cutout-image__container">
      <div class="justify-center row">
        <div class="w-full col lg:w-10/12">
          <?php echo wp_get_attachment_image( $component_data['cutout_image'], 'large', "", array( "class" => "" ) ); ?>
        </div>
      </div>
    </div>
  <?php endif; ?>
  <div class="call-to-action__white-gradient"></div>
  <div class="relative bg-brand-off-white">
    <div class="container pt-5 pb-12 lg:pb-16">
      <div class="justify-center row">
        <div class="w-full col xl:w-8/12">
          <div class="wysiwyg js-fade-group">
            <?php echo $component_data['content']; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
