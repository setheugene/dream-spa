<?php
/**
* Simple Header
* -----------------------------------------------------------------------------
*
* Simple Header component
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
  'jump_links' => null,
];

$component_data = ll_parse_args( $component_data, $defaults );


$jump_links_data = $component_data['jump_links'];
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
<section class="simple-header <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="simple-header">
  <div class="simple-header__inner bg-brand-dark-teal <?php echo $add_jumplinks ? 'py-12 lg:py-16' : 'py-12';?>">
    <div class="container relative z-10">
      <div class="justify-center row">
        <div class="w-full col lg:w-1/2">
          <div class="text-white wysiwyg">
            <?php echo $component_data['content'] ?? ''; ?>
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
