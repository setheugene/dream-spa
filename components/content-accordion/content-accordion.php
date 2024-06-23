<?php
/**
* Content Accordion
* -----------------------------------------------------------------------------
*
* Content Accordion component
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
  'heading_content' => null,
  'cta_image' => null,
  'cta_title' => '',
  'cta_link' => null,
  'cta_new_tab' => false,
  'accordion_content' => null,
];

$component_data = ll_parse_args( $component_data, $defaults );
$new_tab = $component_data['cta_new_tab'];
$heading = $component_data['heading_content'];
$cta_image = $component_data['cta_image'];
$accordions_fields = $component_data['accordion_content'];
$accordions = [];

if($accordions_fields) :
  foreach($accordions_fields as $accordion) :
    $accordions[] = [
      'title' => $accordion['accordion_title'] ?? '',
      'content' => $accordion['accordion_content'] ?? '',
    ];
  endforeach;
endif;
?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="content-accordion bg-brand-off-white py-16 lg:py-24 <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="content-accordion">
  <div class="container">
    <div class="row">
      <div class="w-full mb-6 col lg:w-4/12 lg:mb-0">
        <div class="flex flex-col justify-between js-fade-group h-[95%] gap-20">
          <div class="wysiwyg">
            <?php echo $component_data['heading_content']; ?>
          </div>
          <?php if( $cta_image['image_id'] != '' ) : ?>
            <a href="<?php echo $component_data['cta_link'] ?? ''; ?>" <?php echo $new_tab ? 'target="_blank"' : "" ; ?> class="relative flex items-center p-3 overflow-hidden duration-300 ease-in-out bg-white rounded-sm group hover:bg-brand-teal">
              <div class="relative flex-shrink-0 w-20 h-20 mr-4 overflow-hidden rounded-full aspect-square">
                <?php
                  ll_include_component(
                    'fit-image',
                    array(
                      'image_id' => $cta_image['image_id'],
                      'thumbnail_size' => 'full',
                      'position' => $cta_image['image_focus_point'],
                      'fit' =>  $cta_image['image_fit'],
                      'loading' => $cta_image['image_loading']
                    )
                  );
                ?>
              </div>
              <div class="flex flex-col">
                <div class="mb-1 duration-300 ease-in-out hdg-5 text-brand-navy group-hover:text-white">
                  <?php echo $component_data['cta_title']; ?>
                </div>
                <div class="font-medium duration-300 ease-in-out paragraph-default group-hover:text-white">
                  <?php echo $component_data['cta_text']; ?>
                </div>
              </div>
            </a>
          <?php endif; ?>
        </div>
      </div>
      <div class="w-full col lg:w-8/12">
        <?php if( !empty($accordions) ) : ?>
          <?php foreach( $accordions as $key => $accordion ) : ?>
            <button class="flex items-center justify-between w-full px-2 pb-3 easy-toggle-slide-toggle group" data-toggle-target="#content-accordion-<?php echo $component_id; ?>-<?php echo $key; ?>" data-toggle-class="is-open" data-toggle-group="content-accordion-<?php echo $component_id; ?>">
              <span class="inline-block font-semibold text-left text-brand-navy paragraph-default w-10/12 duration-200 ease-in-out group-[.is-open]:text-brand-teal group-hover:text-brand-teal">
                <?php echo $accordion['title']; ?>
              </span>
              <div class="expand">
                <div class="vertical group-[.is-open]:h-0"></div>
                <div class="horizontal group-[.is-open]:bg-brand-teal"></div>
              </div>
            </button>
            <div id="content-accordion-<?php echo $component_id; ?>-<?php echo $key; ?>" class="hidden px-2 pb-4 wysiwyg">
              <?php echo $accordion['content']; ?>
            </div>
            <hr class="mb-5 border-brand-storm">
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
