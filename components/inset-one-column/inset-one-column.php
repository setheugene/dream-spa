<?php
/**
* Inset One Column
* -----------------------------------------------------------------------------
*
* Inset One Column component
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
];

$component_data = ll_parse_args( $component_data, $defaults );
?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="inset-one-column py-12 lg:py-16 bg-white lg:bg-brand-off-white <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="inset-one-column">
  <div class="container">
    <div class="py-12 bg-white lg:py-16">
      <div class="justify-center row">
        <div class="w-full col lg:w-8/12">
          <div class="wysiwyg js-fade-group">
            <?php echo $component_data['content']; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
