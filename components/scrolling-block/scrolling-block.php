<?php
/**
* Scrolling Block
* -----------------------------------------------------------------------------
*
* Scrolling Block component
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
  'rows' => null,
];

$component_data = ll_parse_args( $component_data, $defaults );

$rows_fields = $component_data['rows'];
$rows = [];
if($rows_fields) :
  foreach ($rows_fields as $key => $row) {
    $rows[] = [
      'content' => $row['content'] ?? '',
      'image' => $row['image'] ?? null,
    ];
  }
endif;
?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="scrolling-block bg-white relative overflow-hidden <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="scrolling-block">
  <div class="lg:container">
    <div class="items-start row">
      <div class="w-full col lg:w-5/12">
        <div class="scrolling-block__content">
          <?php if ( !empty($rows) ) : ?>
            <?php foreach ( $rows as $key => $content_row ) : ?>
              <?php if(!empty($content_row['image']['image_id'])) : ?>
                <div class="relative block w-full lg:hidden aspect-3/4 sm:before:hidden sm:h-[500px]">
                  <?php
                    ll_include_component(
                      'fit-image',
                      array(
                        'image_id' => $content_row['image']['image_id'],
                        'thumbnail_size' => 'full',
                        'position' => $content_row['image']['image_focus_point'],
                        'fit' =>  $content_row['image']['image_fit'],
                        'loading' => $content_row['image']['image_loading']
                      )
                    );
                  ?>
                </div>
              <?php endif; ?>
              <div class="flex flex-col justify-center pt-8 px-gutter-full lg:px-0 lg:py-8 lg:min-h-[calc(100vh_-_var(--topOffset))] scrolling-block__content-block js-animate-block" data-step="<?php echo $key + 1; ?>">
                <?php if ( $key === 0) : ?>
                  <?php if ( !empty($component_data['main_heading']['text']) ) : ?>
                    <<?php echo $component_data['main_heading']['tag']; ?> class="pt-3 pb-8 lg:pt-32 lg:pb-0 lg:mb-14 scrolling-block__heading hdg-3"><?php echo $component_data['main_heading']['text']; ?></<?php echo $component_data['main_heading']['tag']; ?>>
                  <?php endif; ?>
                <?php endif; ?>
                <?php if ( !empty($content_row['content']) ) : ?>
                  <div class="mb-8 wysiwyg">
                    <?php echo $content_row['content']; ?>
                  </div>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <div class="lg:block hidden absolute top-0 right-0 w-1/2 h-[calc(100vh_-_var(--topOffset))] scrolling-block__images">
    <div class="relative w-full h-full overflow-hidden">
      <?php if ( !empty($rows) ) : ?>
        <?php foreach ( $rows as $key => $row ) : ?>
          <?php if ( !empty($row['image']['image_id']) ) : ?>
              <?php
                ll_include_component(
                  'fit-image',
                  array(
                    'image_id' => $row['image']['image_id'],
                    'thumbnail_size' => 'full',
                    'position' => $row['image']['image_focus_point'],
                    'fit' =>  $row['image']['image_fit'],
                    'loading' => $row['image']['image_loading']
                  ),
                  [
                    'classes' => ['scrolling-block__image scrolling-block-image-' . $key + 1]
                  ]
                );
              ?>
          <?php endif; ?>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>
