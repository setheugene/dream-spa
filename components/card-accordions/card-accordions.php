<?php
/**
* Card Accordions
* -----------------------------------------------------------------------------
*
* Card Accordions component
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
  'heading_content' => '',
  'cards' => [],
];

$component_data = ll_parse_args( $component_data, $defaults );

$cards_fields = $component_data['cards'];
$cards = [];

if(!empty($cards_fields)) :
  foreach ($cards_fields as $key => $card) {
    $cards[] = [
      'image' => $card['image'] ?? null,
      'heading' => $card['heading'] ?? '',
      'left_column_content' => $card['left_column_content'] ?? '',
      'right_column_content' => $card['right_column_content'] ?? '',
      'add_asterisk' => $card['add_asterisk'] ?? false,
    ];
  }
endif;
?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="card-accordions relative lg:py-24 py-20 bg-brand-dark-teal <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="card-accordions">
  <div id="card-accordions__waves" class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none">
    <img class="w-full" src="<?php echo get_template_directory_uri(); ?>/assets/img/card-accordions-wave.svg" alt="background wave graphic">
  </div>
  <div class="container overflow-hidden">
    <div class="justify-center mb-10 row">
      <div class="w-full col lg:w-1/2">
        <div class="wysiwyg card-accordions__intro js-fade-group">
          <?php echo $component_data['heading_content']; ?>
        </div>
      </div>
    </div>
    <div class="card-accordions__cards">
      <?php foreach( $cards as $key => $card ) : ?>
        <div class="card-accordions__card overflow-hidden rounded-[10px] bg-brand-off-white px-12 mb-3 last:mb-0">

          <div class="flex flex-wrap">
            <button class="w-full py-10 easy-toggle-slide-toggle [&.is-open]:pb-0 duration-200 group" data-toggle-class="is-open" data-toggle-target="#card-accordion-<?php echo $component_id; ?>-<?php echo $key; ?>" data-toggle-group="card-accordions__<?php echo $component_id; ?>">
              <div class="flex items-center justify-between hdg-4 text-brand-navy">
                <div class="flex items-center">
                  <?php if( $card['add_asterisk'] ) : ?>
                    <svg class='w-6 h-6 mr-3 icon icon-asterisk text-brand-teal'><use xlink:href='#icon-asterisk'></use></svg>
                  <?php endif; ?>
                  <?php echo $card['heading']; ?>
                </div>
                <div class="expand large">
                  <div class="vertical group-[.is-open]:h-0 bg-brand-dark-teal"></div>
                  <div class="horizontal bg-brand-dark-teal"></div>
                </div>
              </div>
            </button>
            <div id="card-accordion-<?php echo $component_id; ?>-<?php echo $key; ?>" class="hidden">
              <div class="pt-8 pb-10 row">
                <div class="w-full mb-3 lg:w-1/2 col lg:mb-0">
                  <div class="wysiwyg">
                    <?php echo $card['left_column_content']; ?>
                  </div>
                </div>
                <div class="w-full lg:w-1/2 col">
                  <div class="wysiwyg">
                    <?php echo $card['right_column_content']; ?>
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
