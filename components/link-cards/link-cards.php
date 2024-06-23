<?php
/**
* Link Cards
* -----------------------------------------------------------------------------
*
* Link Cards component
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
  'image' => null,
  'content' => '',
  'cards' => null,
];

$component_data = ll_parse_args( $component_data, $defaults );

$image = $component_data['image'];
$cards = $component_data['cards'];
?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="link-cards relative py-16 lg:py-24 flex justify-center items-end <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="link-cards">
  <?php if( $image['image_id'] != '' ) : ?>
    <?php
      ll_include_component(
        'fit-image',
        array(
          'image_id' => $image['image_id'],
          'thumbnail_size' => 'full',
          'position' => $image['image_focus_point'],
          'fit' =>  $image['image_fit'],
          'loading' => $image['image_loading']
        )
      );
    ?>
  <?php endif; ?>
  <div class="absolute inset-0 w-full h-full bg-brand-dark-teal-70"></div>
  <div class="relative">
    <div class="container">
      <div class="justify-center row">
        <div class="w-full col lg:w-8/12">
          <div class="mb-10 text-white wysiwyg js-fade-group">
            <?php echo $component_data['content']; ?>
          </div>
        </div>
        <div class="w-full col lg:w-10/12">
          <?php if( $cards ) : ?>
            <div class="flex justify-center">
              <div class="grid grid-cols-1 gap-8 lg:grid-cols-3 js-fade-group">
                <?php foreach( $cards as $card ) : ?>
                  <?php if ( $card['link'] ) : ?>
                    <div class="p-6 bg-white group-hover:bg-brand-teal cursor-pointer inline-flex text-brand-navy w-[300px] lg:w-[244px] xl:w-[300px] h-[176px] items-end relative group rounded-sm overflow-hidden duration-300 ease-in-out">
                      <a class="absolute inset-0 z-40 w-full h-full" href="<?php echo $card['link']['url']; ?>" <?php echo $card['link']['target'] ? 'target="' . $card['link']['target'] . '"' : '' ?>></a>
                      <div class="absolute inset-0 z-30 flex items-end w-full h-full">
                        <div class="absolute z-30 flex items-center justify-center w-10 h-10 bg-white border rounded-full top-4 right-4 border-brand-teal">
                          <svg class='w-4 h-4 icon icon-arrow-right-corner text-brand-teal'><use xlink:href='#icon-arrow-right-corner'></use></svg>
                        </div>
                        <span class="mx-6 my-6 hdg-5 group-hover:text-white">
                          <?php echo $card['link']['title']; ?>
                        </span>
                      </div>
                      <?php if($card['link']['target'] === '_blank') : ?>
                        <span class="sr-only"> (opens in new tab)</span>
                      <?php endif; ?>
                      <div class="absolute inset-0 z-20 w-full h-full overflow-hidden duration-300 ease-in-out rounded-sm opacity-0 group-hover:opacity-100 bg-brand-teal">
                        <img class="absolute bottom-0 left-0" src="<?php echo get_template_directory_uri(); ?>/assets/img/link-cards-wave.svg" alt="background wave graphic">
                      </div>
                    </div>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
