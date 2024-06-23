<?php
/**
* Hero Banner
* -----------------------------------------------------------------------------
*
* Hero Banner component
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
$component_id = ( isset( $component_args['id'] ) ? $component_args['id'] : false );
?>

<?php
$defaults = [
  'heading' => array(
    'tag'  => 'h2',
    'text' => null
  ),
  'image_id' => null,
  'image_focus_point' => null,
];

$component_data = ll_parse_args( $component_data, $defaults );
?>

<?php if ( ll_empty( $component_data ) ) return; ?>

<section class="hero-banner relative h-screen--reduced flex justify-center items-end py-12 lg:py-16 <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="hero-banner">
  <?php if($component_data['loop_video_url']) : ?>
      <?php
        ll_include_component(
          'loop-video',
          array(
            'video' => $component_data['loop_video_url'],
            'display' => 'desktop',
            'image_id' => $component_data['image_id'],
            'thumbnail_size' => 'full',
            'position' => $component_data['image_focus_point'],
            'loading' => $component_data['image_loading']
          )
        );
    ?>
  <?php else : ?>
    <?php
      ll_include_component(
        'fit-image',
        array(
          'image_id' => $component_data['image_id'],
          'thumbnail_size' => 'full',
          'position' => $component_data['image_focus_point'],
          'fit' =>  $component_data['image_fit'],
          'loading' => $component_data['image_loading']
        )
      );
    ?>
  <?php endif; ?>
  <div class="container relative z-10">
    <div class="justify-center row">
      <div class="w-full col lg:w-8/12">
        <div class="text-center text-white wysiwyg js-fade-group">
          <?php echo $component_data['content'] ?? ''; ?>
        </div>
      </div>
    </div>
  </div>
</section>
