<?php
/**
* Featured Treatments
* -----------------------------------------------------------------------------
*
* Featured Treatments component
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
  'treatments' => null,
];

$component_data = ll_parse_args( $component_data, $defaults );

$treatments_fields = $component_data['treatments'];
$treatments = [];
if(($treatments_fields)) :
  foreach ($treatments_fields as $key => $treatment) {
    $treatments[] = [
      'image_id' => get_post_thumbnail_id( $treatment ) ?? null,
      'title' => get_field( 'treatment_name', $treatment ) ?? '',
      'description' => get_field( 'treatment_description', $treatment ) ?? '',
      'link' => get_permalink( $treatment ) ?? null,
    ];
  }
endif;

$treatment_count = count($treatments);
$grid_classes = 'lg:grid-cols-3';
if($treatment_count === 4) {
  $grid_classes = 'lg:grid-cols-4 md:grid-cols-2';
}

?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="featured-treatments py-12 lg:py-16 bg-brand-off-white overflow-hidden <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="featured-treatments">
  <div class="lg:container">
    <div class="justify-center row">
      <div class="w-11/12 mb-10 col lg:w-8/12">
        <div class="wysiwyg js-fade-group">
          <?php echo $component_data['content']; ?>
        </div>
      </div>
      <div class="grid w-full grid-cols-1 col <?php echo $grid_classes; ?>">
        <?php if( !empty($treatments) ) : ?>
          <?php foreach( $treatments as $treatment ) : ?>
            <div class="w-full relative lg:border-r lg:border-brand-storm group overflow-hidden last:border-r-0 lg:h-[658px] flex items-end">
              <a class="w-full overflow-hidden group" href="<?php echo $treatment['link']; ?>">
                <?php
                  ll_include_component(
                    'fit-image',
                    array(
                      'image_id' => $treatment['image_id'],
                      'thumbnail_size' => 'large',
                      'position' => '',
                      'fit' =>  'object-cover',
                      'loading' => ''
                    ),
                    ['classes' => ['group-hover:scale-105 duration-300 ease-in-out']],
                  );
                ?>
                <div class="absolute inset-0 w-full h-full bg-brand-dark-teal bg-opacity-90 lg:bg-opacity-70"></div>
                <div class="relative z-10 w-full px-8 py-12 text-center duration-300 ease-in-out lg:py-8 group-hover:-translate-y-8">
                  <div class="mb-4 text-white hdg-4">
                    <?php echo $treatment['title']; ?>
                  </div>
                  <div class="mb-4 text-brand-off-white paragraph-default">
                    <?php echo $treatment['description']; ?>
                  </div>
                  <div class="secondary-btn white group-hover:after:opacity-100">
                    View <span class="sr-only"><?php echo $treatment['title']; ?></span> Treatment
                  </div>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
