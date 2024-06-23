<?php
/**
* Left Right Accordion
* -----------------------------------------------------------------------------
*
* Left Right Accordion component
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
  'accordions' => '',
];

$component_data = ll_parse_args( $component_data, $defaults );

$accordions_fields = $component_data['accordions'];
$accordions = [];

if($accordions_fields) :
  foreach($accordions_fields as $accordion) :
    $accordions[] = [
      'title' => $accordion['title'] ?? '',
      'content' => $accordion['content'] ?? '',
    ];
  endforeach;
endif;
?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="left-right-accordion pt-12 lg:py-16 bg-brand-off-white <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="left-right-accordion">
  <div class="container">
    <div class="items-center row">
      <div class="w-full mb-8 col lg:w-5/12 lg:mb-0">
        <div class="wysiwyg js-fade">
          <?php echo $component_data['content']; ?>
        </div>
      </div>
      <div class="w-full col lg:w-7/12">
        <div class="bg-white py-8 lg:py-16 lg:px-[100px] px-0 relative before:w-screen before:absolute before:bg-white before:block before:inset-0 before:h-full before:left-1/2 before:-translate-x-1/2 lg:before:hidden">
          <?php if( !empty($accordions) ) : ?>
            <?php foreach( $accordions as $key => $accordion ) : ?>
              <button class="relative z-10 flex items-center justify-between w-full px-2 pb-3 easy-toggle-slide-toggle group" data-toggle-target="#content-accordion-<?php echo $component_id; ?>-<?php echo $key; ?>" data-toggle-class="is-open" data-toggle-group="content-accordion-<?php echo $component_id; ?>">
                <span class="inline-block font-semibold text-left text-brand-navy paragraph-default w-10/12 duration-200 ease-in-out group-[.is-open]:text-brand-teal group-hover:text-brand-teal">
                  <?php echo $accordion['title']; ?>
                </span>
                <svg class='icon icon-chevron-down h-5 w-5 text-brand-teal duration-500 group-[.is-open]:rotate-180 transform'><use xlink:href='#icon-chevron-down'></use></svg>
              </button>
              <div id="content-accordion-<?php echo $component_id; ?>-<?php echo $key; ?>" class="relative z-10 hidden px-2 pb-4 wysiwyg">
                <?php echo $accordion['content']; ?>
              </div>
              <hr class="relative z-10 mb-4 border-brand-storm">
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
