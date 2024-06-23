<?php
$categories = get_terms( array(
    'taxonomy' => 'category',
    'hide_empty' => true,
) );

$tags = get_terms( array(
    'taxonomy' => 'post_tag',
    'hide_empty' => true,
) );
?>

<button class="flex items-end justify-between w-full pb-3 mb-3 border-b border-brand-teal blog__sidebar-toggle lg:hidden hdg-4" data-toggle-target-next data-toggle-class="is-open" aria-expanded="false">Filter <svg class="text-xl icon icon-chevron-down"><use xlink:href="#icon-chevron-down"></use></svg></button>

<div class="hidden p-10 space-y-5 bg-white lg:space-y-8 blog__sidebar-inner lg:block" aria-hidden="false">
  <?php if ( $categories ) : ?>
    <div class="blog__sidebar-block blog__block blog__block--categories">
      <h2 class="mb-5 hdg-5">Categories</h2>

      <ul class="space-y-3 blog__block-list categories">
        <?php foreach ( $categories as $key => $cat ) : ?>
          <li>
            <a href="<?php echo get_term_link( $cat->term_id, 'category' ); ?>" class="text-brand-gray hover:underline <?php echo get_queried_object_id() == $cat->term_id ? 'is-active' : ''; ?>"><?php echo $cat->name; ?> (<?php echo $cat->count; ?><span class="sr-only"> Posts</span>)</a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <?php if ( $tags ) : ?>
    <div class="blog__sidebar-block blog__block blog__block--tags">
      <h2 class="mb-5 hdg-5">Tags</h2>

      <ul class="blog__block-list tags">
        <?php foreach ( $tags as $key => $tag ) : ?>
          <li>
            <a href="<?php echo get_term_link( $tag->term_id, 'post_tag' ); ?>" class="<?php echo get_queried_object_id() == $tag->term_id ? 'is-active' : ''; ?>">
              <?php echo $tag->name; ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>
</div>
