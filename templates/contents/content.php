<?php
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

$post = !empty($component_data['post']) ? $component_data['post'] : get_the_ID();
?>
<article <?php post_class(implode( " ", $classes ), $post ); ?> <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?>>
  <?php
    $cats = get_the_terms( $post, 'category' );
  ?>
  <a class="post__card" href="<?php echo get_permalink($post) ?>" title="Read more about <?php echo get_the_title($post); ?>">
    <div class="relative overflow-hidden post__image-wrapper aspect-3/2">
      <?php
        ll_include_component(
          'fit-image',
          array(
            'image_id' => get_post_thumbnail_id($post),
            'position' => 'object-center'
          ),
          array(
            'classes' => ['post__image']
          )
        );
      ?>
    </div>

    <div class="flex flex-col p-5 bg-white post__content">
      <p class="flex items-center justify-between mb-5 post__meta">
        <?php if ( !empty($cats[0]) ) : ?>
          <span class="font-semibold text-brand-teal paragraph-small post-category"><?php echo $cats[0]->name; ?></span>
        <?php endif; ?>
        <span class="text-right paragraph-small text-brand-gray">
          <?php echo get_the_date( '', $post ); ?>
        </span>
      </p>

      <h2 class="paragraph-large text-brand-navy post__title"><?php echo get_the_title( $post ); ?></h2>
    </div>

    <div class="flex items-center justify-between px-5 py-3 duration-300 ease-in-out text-brand-off-white post__read-more-wrapper bg-brand-teal">
      <span class="post__read-more">Learn More</span>
      <svg class='flex-shrink-0 w-5 h-5 icon text-brand-off-white icon-arrow-right-long'><use xlink:href='#icon-arrow-right-long'></use></svg>
    </div>
  </a>
</article>
