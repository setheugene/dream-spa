<?php
/**
* Treatment Details
* -----------------------------------------------------------------------------
*
* Treatment Details component
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
  'image' => '',
  'cards' => null,
  'card_title' => '',
  'card_list' => null,
];

$component_data = ll_parse_args( $component_data, $defaults );

$image = $component_data['image'];
$cards_fields = $component_data['cards'];
$card_list = $component_data['card_list'];
$cards = [];
if($cards_fields) {
  foreach ($cards_fields as $key => $cards_field) {
    $cards[] = [
      'title' => $cards_field['title'] ?? '',
      'text' => $cards_field['text'] ?? '',
      'icon' => $cards_field['icon'] ?? '',
    ];
  }
}

?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="treatment-details relative bg-brand-dark-teal py-16 lg:py-20 <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="treatment-details">
  <div class="absolute bottom-0 right-0 w-full h-full pointer-events-none">
    <img class="w-full" src="<?php echo get_template_directory_uri(); ?>/assets/img/treatment-details-wave.svg" alt="background wave graphic">
  </div>
  <div class="container relative z-10">
    <div class="justify-center row">
      <div class="w-full col xl:w-10/12">
        <div class="row">
          <div class="w-full mb-4 col lg:w-1/2 lg:mb-0">
            <div class="relative h-full overflow-hidden rounded-sm">
              <?php
                ll_include_component(
                  'fit-image',
                  array(
                    'image_id' => $image['image_id'],
                    'thumbnail_size' => 'full',
                    'position' => $image['image_focus_point'],
                    'fit' =>  $image['image_fit'],
                    'loading' => $image['image_loading']
                  ),
                  ['classes' => ['overflow-hidden rounded-sm']],
                );
              ?>
              <div class="flex flex-col items-center justify-center w-full h-full px-10 py-16 overflow-hidden text-center text-white rounded-sm bg-brand-dark-teal opacity-70">
                <div class="mb-10 hdg-6">
                  <?php echo $component_data['card_title']; ?>
                </div>
                <ul class="js-fade-group">
                  <?php if( $card_list ) : ?>
                    <?php foreach( $card_list as $list_item ) : ?>
                      <li class="mb-4 last:mb-0">
                        <p class="hdg-5">
                          <?php echo $list_item['list_item']; ?>
                        </p>
                      </li>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </ul>
              </div>
            </div>
          </div>
          <div class="w-full col lg:w-1/2 js-fade-group">
            <?php foreach( $cards as $card ) : ?>
              <div class="p-6 mb-4 overflow-hidden bg-white rounded-sm last:mb-0">
                <div class="flex items-center justify-between mb-12">
                  <div class="text-brand-gray paragraph-default">
                    <?php echo $card['title']; ?>
                  </div>
                  <svg class='icon h-6 w-6 text-brand-teal icon-<?php echo $card['icon']['svg_icon'] ?>'><use xlink:href='#icon-<?php echo $card['icon']['svg_icon'] ?>'></use></svg>
                </div>
                <div class="hdg-5 text-brand-navy">
                  <?php echo $card['text']; ?>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
