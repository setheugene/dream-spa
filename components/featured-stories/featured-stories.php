<?php
/**
* Featured Stories
* -----------------------------------------------------------------------------
*
* Featured Stories component
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
  'featured_story' => null,
];

$component_data = ll_parse_args( $component_data, $defaults );

$featured_stories_fields = $component_data['featured_story'];
$featured_stories = [];
if(($featured_stories_fields)) :
  foreach ($featured_stories_fields as $key => $featured_story) {
    $featured_stories[] = [
      'image' => $featured_story['image'],
      'title' => $featured_story['title'],
      'text' => $featured_story['text'],
      'link' => $featured_story['link'],
    ];
  }
endif;

?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="featured-stories bg-brand-off-white py-12 lg:py-16 <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="featured-stories">
  <div class="container">
    <div class="mb-5 wysiwyg js-fade-group">
      <?php echo $component_data['content']; ?>
    </div>

    <?php if( !empty($featured_stories) ) : ?>
      <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <?php foreach( $featured_stories as $featured_story ) : ?>
          <div class="relative flex flex-col h-full">
            <?php if( $featured_story['image']['image_id'] != '' ) : ?>
              <div class="relative mb-5 aspect-square">
                <?php
                  ll_include_component(
                    'fit-image',
                    array(
                      'image_id' => $featured_story['image']['image_id'],
                      'thumbnail_size' => 'full',
                      'position' => $featured_story['image']['image_focus_point'],
                      'fit' =>  $featured_story['image']['image_fit'],
                      'loading' => $featured_story['image']['image_loading']
                    )
                  );
                ?>
              </div>
              <div class="flex flex-col justify-between h-full">
                <div class="flex flex-col">
                  <p class="mb-3 text-brand-dark-teal hdg-5">
                    <?php echo $featured_story['title']; ?>
                  </p>
                  <p class="paragraph-default text-brand-gray">
                    <?php echo $featured_story['text']; ?>
                  </p>
                </div>
                <a href="<?php echo $featured_story['link']; ?>" class="flex items-center flex-shrink-0 mt-5 secondary-btn teal">
                  <svg class="w-5 h-5 mb-[3px] mr-3 icon icon-arrow-right-long"><use xlink:href="#icon-arrow-right-long"></use></svg>
                  Learn More <span class="sr-only">about <?php $featured_story['title']; ?></span>
                </a>
              </div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
