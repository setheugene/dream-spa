<?php
/**
* Icon List
* -----------------------------------------------------------------------------
*
* Icon List component
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
  'heading' => null,
  'list_items' => null,
];

$component_data = ll_parse_args( $component_data, $defaults );

$image = $component_data['image'];
$heading = $component_data['heading']['heading'];
$list_items = $component_data['list_items'];
?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="icon-list py-12 bg-brand-off-white lg:py-16 <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="icon-list">
  <div class="container">
    <div class="row">
      <div class="relative z-10 w-full col lg:w-1/2">
        <?php if( $image['image_id'] != '' ) : ?>
          <div class="relative h-full w-full min-h-[550px]">
            <?php
              ll_include_component(
                'fit-image',
                array(
                  'image_id' => $image['image_id'],
                  'thumbnail_size' => 'large',
                  'position' => $image['image_focus_point'],
                  'fit' =>  $image['image_fit'],
                  'loading' => $image['image_loading']
                )
              );
            ?>
          </div>
        <?php endif; ?>
      </div>
      <div class="relative w-full col lg:w-1/2 after:absolute after:bg-white after:h-full after:w-20 after:hidden lg:after:block after:-left-8 after:top-0">
        <div class="relative z-10 flex flex-col justify-center h-full px-8 py-12 bg-white lg:py-16 lg:px-0">
          <div class="w-full lg:w-5/6">
            <?php if( $heading['text']) : ?>
              <<?php echo $heading['tag']; ?> class='mb-10 text-brand-navy hdg-3'><?php echo $heading['text']; ?></<?php echo $heading['tag']; ?>>
            <?php endif; ?>
            <?php if( $list_items ) : ?>
              <ul class="js-fade-group">
                <?php foreach( $list_items as $list_item ) : ?>
                  <li class="flex mb-6 last:mb-0">
                    <svg class='icon w-5 h-5 flex-shrink-0 text-brand-teal mr-4 mt-[6px] icon-<?php echo $list_item['svg_icon'] ?>'><use xlink:href='#icon-<?php echo $list_item['svg_icon'] ?>'></use></svg>
                    <div>
                      <p class="mb-2 hdg-5 text-brand-navy">
                        <?php echo $list_item['title']; ?>
                      </p>
                      <p class="paragraph-small text-brand-gray">
                        <?php echo $list_item['description']; ?>
                      </p>
                    </div>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
