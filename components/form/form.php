<?php
/**
* Form
* -----------------------------------------------------------------------------
*
* Form component
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
  'heading' => null,
  'options' => 'gravity-form',
  'iframe' => '',
];

$component_data = ll_parse_args( $component_data, $defaults );

$heading = $component_data['heading'];
$options = $component_data['options'];

?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="form bg-brand-off-white overflow-hidden <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="form">
  <div class="container">
    <div class="relative row">
      <div class="order-2 w-full col lg:w-5/12 lg:order-1">
        <div class="py-12 bg-brand-off-white lg:py-16">
          <div class="px-10 wysiwyg">
            <?php echo $component_data['content']; ?>
          </div>
        </div>
      </div>
      <div class="order-1 w-full col lg:w-7/12 lg:order-2">
        <div class="py-12 bg-white relative lg:py-16 after:bg-white lg:after:block after:absolute after:top-0 after:-left-[100vw]  lg:after:left-[99%] after:h-full after:w-[200vw] lg:after:w-screen">
          <div class="relative z-20 justify-center row">
            <div class="w-full col lg:w-[71%]">
              <?php if( $heading['heading'] && $heading['heading']['text']) : ?>
                <<?php echo $heading['heading']['tag']; ?> class='mb-5 js-fade hdg-4 text-brand-teal'><?php echo $heading['heading']['text']; ?></<?php echo $heading['heading']['tag']; ?>>
              <?php endif; ?>
              <?php if( $options === 'gravity-form' ) : ?>
                <?php echo gravity_form( $component_data['form_id'], false, false, false, null, true ); ?>
              <?php else: ?>
                <div class="wysiwyg">
                  <?php echo $component_data['iframe']; ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
