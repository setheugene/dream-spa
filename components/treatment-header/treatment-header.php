<?php
/**
* Treatment Header
* -----------------------------------------------------------------------------
*
* Treatment Header component
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
];

$component_data = ll_parse_args( $component_data, $defaults );

$add_breadcrumbs = $component_data['breadcrumbs'] ?? false;
$jump_links_data = $component_data['jump_links'] ?? null;
$jump_links = [];
if( $jump_links_data ) :
  foreach( $jump_links_data as $jump_link_data )
  $jump_links[] = [
    'text' => $jump_link_data['jump_link_text'],
    'id' => $jump_link_data['jump_link_id'],
  ];
endif;
$add_jumplinks = false;
if(!empty($jump_links)) {
  $add_jumplinks = true;
}

?>
<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="treatment-header relative <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="treatment-header">
  <?php if ( $add_breadcrumbs && function_exists('yoast_breadcrumb') ) : ?>
    <div class="bg-brand-off-white">
      <div class="container">
        <div class="relative z-10 w-full py-2 text-brand-gray paragraph-small">
          <?php yoast_breadcrumb(); ?>
        </div>
      </div>
    </div>
  <?php endif; ?>
  <div class="relative treatment-header__height <?php echo $add_breadcrumbs ? 'with-breadcrumbs' : ''; ?> <?php echo $add_jumplinks ? 'with-jumplinks' : ''; ?>">
    <div class="absolute inset-0 z-20 flex items-end justify-end w-full h-full pointer-events-none">
      <img class="" src="<?php echo get_template_directory_uri(); ?>/assets/img/treatment-header-wave.svg" alt="background wave graphic">
    </div>
    <?php if($component_data['loop_video_url']) : ?>
      <?php
        ll_include_component(
          'loop-video',
          array(
            'video' => $component_data['loop_video_url'],
            'display' => 'desktop',
            'image_id' => $component_data['image_id'],
            'thumbnail_size' => 'full',
            'position' => $component_data['image_focus_point'],
            'loading' => $component_data['image_loading']
          )
        );
      ?>
    <?php else : ?>
      <?php
        ll_include_component(
          'fit-image',
          array(
            'image_id' => $component_data['image_id'],
            'thumbnail_size' => 'full',
            'position' => $component_data['image_focus_point'],
            'fit' =>  $component_data['image_fit'],
            'loading' => $component_data['image_loading']
          )
        );
      ?>
    <?php endif; ?>
    <div class="absolute inset-0 flex items-end w-full h-full <?php echo $add_jumplinks ? 'py-10 lg:py-12' : 'py-12 lg:py-16'; ?>">
      <div class="container relative z-10">
        <div class="row">
          <div class="col w-full lg:w-[58%]">
            <div class="text-white wysiwyg">
              <?php echo $component_data['content'] ?? ''; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php if( $add_jumplinks ) : ?>
    <div class="hidden w-full py-5 bg-white dream-spa__jump-links lg:block">
      <ul class="flex items-center justify-center w-full">
        <?php foreach( $jump_links as $jump_link ) : ?>
          <li class="mr-8 last:mr-0">
            <?php if ( $jump_link ) : ?>
              <a class="paragraph-default text-brand-teal" href="<?php echo get_permalink( get_the_ID() ); ?>#<?php echo $jump_link['id']; ?>">
                <?php echo $jump_link['text']; ?>
              </a>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>
</section>
