<?php
/**
* Paired Treatments
* -----------------------------------------------------------------------------
*
* Paired Treatments component
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
      'link' => get_permalink( $treatment ) ?? null,
    ];
  }
endif;

?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="paired-treatments py-16 lg:py-20 bg-brand-dark-teal <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="paired-treatments">
  <div class="container">
    <div class="justify-center row">
      <div class="w-full col xl:w-10/12">
        <div class="mb-10 wysiwyg">
          <?php echo $component_data['content']; ?>
        </div>
      </div>
      <?php if( !empty($treatments) ) : ?>
        <?php foreach( $treatments as $treatment ) : ?>
          <div class="w-full mb-8 col lg:w-1/2 last:mb-0 lg:mb-0">
            <div class="relative inline-flex items-end w-full p-10 overflow-hidden duration-300 ease-in-out bg-white rounded-[4px] cursor-pointer group-hover:bg-brand-teal aspect-square text-brand-navy group">
              <?php
                ll_include_component(
                  'fit-image',
                  array(
                    'image_id' => $treatment['image_id'],
                    'thumbnail_size' => 'large',
                    'position' => 'center',
                    'fit' =>  'object-cover',
                    'loading' => ''
                  ),
                  ['classes' => ['image-gradient']],
                );
              ?>
              <a class="absolute inset-0 z-40 w-full h-full" href="<?php echo $treatment['link']; ?>"></a>
              <div class="absolute inset-0 z-30 flex items-end w-full h-full">
                <div class="absolute z-30 flex items-center justify-center w-16 h-16 group-hover:bg-white border border-white rounded-full group-hover:before:opacity-0 bg-blur top-[40px] right-[40px]">
                  <svg class='w-8 h-8 text-white duration-200 group-hover:text-brand-teal icon icon-arrow-right-corner'><use xlink:href='#icon-arrow-right-corner'></use></svg>
                </div>
                <span class="mb-10 ml-10 text-white hdg-3">
                  <?php echo $treatment['title']; ?>
                </span>
              </div>
              <div class="absolute inset-0 z-20 w-full h-full overflow-hidden duration-300 ease-in-out rounded-[4px] opacity-0 group-hover:opacity-100 bg-brand-teal">
                <img class="w-full h-full" src="<?php echo get_template_directory_uri(); ?>/assets/img/paired-treatment-wave.svg" alt="background wave graphic">
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>
