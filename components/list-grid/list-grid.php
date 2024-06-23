<?php
/**
* List Grid
* -----------------------------------------------------------------------------
*
* List Grid component
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
  'section' => [],
];

$component_data = ll_parse_args( $component_data, $defaults );

$sections_fields = $component_data['section'];
$sections = [];

if(!empty($sections_fields)) :
  foreach ($sections_fields as $key => $section) {
    $sections[] = [
      'section_title' => $section['section_title'] ?? '',
      'grid_columns' => $section['grid_columns'] ?? '',
    ];
  }
endif;

?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="list-grid bg-brand-off-white py-12 lg:py-16 <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="list-grid">
  <div class="container">
    <div class="mb-12 wysiwyg">
      <?php echo $component_data['content']; ?>
    </div>
    <?php foreach( $sections as $section ) : ?>
      <div class="mb-10 row js-fade-group gap-y-8">
        <div class="w-full pb-5 border-b col border-brand-storm">
          <div class="hdg-4 text-brand-navy">
            <?php echo $section['section_title']; ?>
          </div>
        </div>
        <?php if( !empty($section['grid_columns']) ) : ?>
          <?php foreach( $section['grid_columns'] as $section_column ) : ?>
            <div class="w-full mb-5 col lg:mb-0 lg:w-1/4">
              <div class="wysiwyg">
                <?php echo $section_column['column_content'] ?? ''; ?>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
</section>
