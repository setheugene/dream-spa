<?php
/**
* Honors Cards
* -----------------------------------------------------------------------------
*
* Honors Cards component
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
  'cards' => null,
];

$component_data = ll_parse_args( $component_data, $defaults );

$heading = $component_data['heading'];
$cards_fields = $component_data['cards'];
$cards = [];
if($cards_fields) :
  foreach ($cards_fields as $key => $card) {
    $cards[] = [
      'title' => $card['title'],
      'description' => $card['description'],
    ];
  }
endif;
$slider_active = false;
if(!empty( $cards ) && count( $cards ) > 1):
  $slider_active = true;
endif;
?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="honors-cards bg-brand-dark-teal py-12 lg:py-16 <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="honors-cards">
  <div class="container mb-8">
    <div class="flex flex-col lg:items-center lg:justify-between flex-flow lg:flex-row">
      <?php if( $heading['heading'] && $heading['heading']['text']) : ?>
        <<?php echo $heading['heading']['tag']; ?> class='w-full mb-4 mr-0 js-fade lg:w-8/12 lg:mr-6 lg:mb-0 hdg-3 text-brand-off-white'><?php echo $heading['heading']['text']; ?></<?php echo $heading['heading']['tag']; ?>>
      <?php endif; ?>
      <div class="flex justify-end w-full lg:w-4/12">
        <div class="honors-cards__slider-nav relative flex w-full lg:justify-end lg:mb-0 <?php echo $slider_active ? 'flex' : 'hidden'; ?>">
          <button aria-label="button to go to previous slide" role="button" class="flex items-center justify-center w-10 h-10 mr-3 duration-200 ease-in-out border border-white rounded-full aria-disabled:opacity-50 aria-disabled:pointer-events-none hover:bg-white group honors-cards__prev">
            <svg class='w-4 h-4 text-white duration-200 ease-in-out icon group-hover:text-brand-teal icon-arrow-left'><use xlink:href='#icon-arrow-left'></use></svg>
          </button>
          <button aria-label="button to go to next slide" role="button" class="flex items-center justify-center w-10 h-10 duration-200 ease-in-out border border-white rounded-full aria-disabled:opacity-50 aria-disabled:pointer-events-none hover:bg-white group honors-cards__next">
            <svg class='w-4 h-4 text-white duration-200 ease-in-out icon group-hover:text-brand-teal icon-arrow-right'><use xlink:href='#icon-arrow-right'></use></svg>
          </button>
        </div>
      </div>
    </div>
  </div>
  <div class="honors-cards__slider <?php echo $slider_active ? '' : 'flex justify-center'; ?>">
    <?php foreach( $cards as $card ) : ?>
      <div class="honors-cards__slide p-5 mr-5 overflow-hidden bg-white h-full rounded-sm w-[240px]">
        <svg class='inline-block w-8 h-8 mb-4 icon icon-Award-2 text-brand-teal'><use xlink:href='#icon-Award-2'></use></svg>
        <div>
          <p class="mb-1 font-semibold text-brand-navy paragraph-large">
            <?php echo $card['title']; ?>
          </p>
          <p class="paragraph-small text-brand-gray">
            <?php echo $card['description']; ?>
          </p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>
