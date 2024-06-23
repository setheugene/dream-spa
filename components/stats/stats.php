<?php
/**
* Stats
* -----------------------------------------------------------------------------
*
* Stats component
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
  'rows' => [],
];

$component_data = ll_parse_args( $component_data, $defaults );

$rows = $component_data['rows'];
?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="stats py-10 bg-brand-off-white <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="stats">
  <div class="container">
    <?php foreach ( $rows as $key => $row ) : ?>
      <div class="relative items-center mb-8 overflow-hidden text-center text-white row last:mb-0 stats__row">
        <div class="w-full col lg:w-1/2 order-2 stats-row__bg-color h-full <?php echo $key % 2 === 1 ? '' : 'md:order-1'; ?>">
          <div class="relative h-full py-16">
            <p class="mb-5 hdg-1">
              <?php echo $row['large_text']; ?>
            </p>
            <p class="hdg-5">
              <?php echo $row['text']; ?>
            </p>
          </div>
        </div>
        <div class="order-1 w-full col lg:w-1/2 <?php echo $key % 2 === 1 ? '' : 'md:order-2'; ?>">
          <div class="relative h-full aspect-16/9">
            <?php
              ll_include_component(
                'fit-image',
                array(
                  'image_id' => $row['image']['image_id'],
                  'position' => $row['image']['image_focus_point'],
                )
              );
            ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>
