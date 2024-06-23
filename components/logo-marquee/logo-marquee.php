<?php
/**
* Logo Marquee
* -----------------------------------------------------------------------------
*
* Logo Marquee component
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
  'heading' => null,
  'logos' => [],
];

$component_data = ll_parse_args( $component_data, $defaults );

$title = $component_data['title'];
$logos = $component_data['logos'];
?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="logo-marquee bg-white overflow-hidden <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="logo-marquee">
  <div class="container relative py-6">
    <div class="hidden lg:flex absolute top-0 left-0 z-10 items-center h-full logo-marquee__title pl-[3.125rem]">
      <p class="relative z-10 hdg-6">
        <?php echo $title; ?>
      </p>
    </div>
    <?php if( !empty($logos) ) : ?>
      <div id="logo-marquee__slick" class="h-full">
        <?php foreach( $logos as $logo ) : ?>
          <?php echo wp_get_attachment_image( $logo['logo'], 'large', "", array( "class" => "mr-20 lg:mr-32 w-[200px]" ) ); ?>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
