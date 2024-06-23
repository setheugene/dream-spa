<?php
/**
* Scrolling Cards
* -----------------------------------------------------------------------------
*
* Scrolling Cards component
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
  'options' => 'no-images',
  'heading_content' => '',
  'cards' => [],
];

$component_data = ll_parse_args( $component_data, $defaults );

$options = $component_data['options'];
$cards_fields = $component_data['cards'];
$cards = [];

if(!empty($cards_fields)) :
  foreach ($cards_fields as $key => $card) {
    $cards[] = [
      'image' => $card['image'] ?? null,
      'heading' => $card['heading'] ?? '',
      'content' => $card['content'] ?? '',
      'add_asterisk' => $card['add_asterisk'] ?? false,
    ];
  }
endif;
?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="scrolling-cards relative pb-20 pt-[100px] lg:pt-[200px] bg-brand-dark-teal overflow-hidden <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="scrolling-cards">
  <div id="scrolling-cards__waves" class="absolute inset-0 w-screen h-full pointer-events-none">
    <img class="w-full" src="<?php echo get_template_directory_uri(); ?>/assets/img/scrolling-cards-wave.svg" alt="background wave graphic">
  </div>
  <div class="container">
    <div class="justify-center mb-10 row">
      <div class="w-full col lg:w-1/2">
        <div class="wysiwyg scrolling-cards__intro js-fade-group">
          <?php echo $component_data['heading_content']; ?>
        </div>
      </div>
    </div>
    <div class="scrolling-cards__cards">
      <?php foreach( $cards as $key => $card ) : ?>
        <div class="scrolling-cards__card py-12 px-10 lg:px-0 mb-10 last:mb-0 overflow-hidden rounded-[10px] bg-brand-off-white lg:py-16 <?php echo $key > 0 ? 'animate' : 'first'; ?>">
          <div class="justify-center row">
            <div class="w-full col lg:w-10/12">
              <div class="row">
                <div class="w-full mb-5 col lg:w-[30%] lg:mb-0">
                  <?php if( $options === 'no-images' ) : ?>
                    <div class="flex items-center hdg-4 text-brand-navy">
                      <?php if( $card['add_asterisk'] ) : ?>
                        <svg class='w-6 h-6 mr-3 icon icon-asterisk text-brand-teal'><use xlink:href='#icon-asterisk'></use></svg>
                      <?php endif; ?>
                      <?php echo $card['heading']; ?>
                    </div>
                  <?php elseif($options === 'images' && !empty($card['image'])) : ?>
                    <div class="relative aspect-square h-[169px] w-[169px] overflow-hidden rounded-full">
                      <?php
                        ll_include_component(
                          'fit-image',
                          array(
                            'image_id' => $card['image']['image_id'],
                            'thumbnail_size' => 'full',
                            'position' => $card['image']['image_focus_point'],
                            'fit' =>  $card['image']['image_fit'],
                            'loading' => $card['image']['image_loading']
                          ),
                          ['classes' => ['']]
                        );
                      ?>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="w-full col lg:w-[70%]">
                  <div class="wysiwyg">
                    <?php echo $card['content']; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
