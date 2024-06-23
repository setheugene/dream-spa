<?php
/**
* Team Member Slider
* -----------------------------------------------------------------------------
*
* Team Member Slider component
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
  'link' => '',
  'team_members' => null,
];

$component_data = ll_parse_args( $component_data, $defaults );
$link = $component_data['link'];
$featured_team_members = $component_data['team_members'];

if( !empty($featured_team_members) ) {
  $args = array(
    'post_type'       => 'll_team_members',
    'post_status'     => 'publish',
    'orderby'         => 'date',
    'order'           => 'DESC',
    'field'           => 'ids',
    'orderby'         => 'post__in',
    'post__in'        => $featured_team_members,
  );
}else{
  $args = array(
    'post_type'       => 'll_team_members',
    'post_status'     => 'publish',
    'orderby'         => 'date',
    'order'           => 'DESC',
    'posts_per_page'  => -1,
    'field'           => 'ids'
  );
}

$team_member_posts_data = get_posts( $args );

$team_member_posts = [];

if(!empty($team_member_posts_data)) :
  foreach($team_member_posts_data as $team_member_post ) :
    $team_member_id = $team_member_post->ID;
    $team_member_posts[] = [
      'team_member_id' => $team_member_id,
      'image_id' => get_post_thumbnail_id( $team_member_id ) ?? '',
      'name' => get_field('team_member_name', $team_member_id) ?? '',
      'position' => get_field('team_member_position', $team_member_id) ?? '',
      'bio' => get_field('team_member_bio', $team_member_id) ?? '',
      'social' => get_field('team_member_social', $team_member_id) ?? '',
    ];
  endforeach;
endif;

$slider_active = false;
if(!empty( $team_member_posts ) && count( $team_member_posts ) > 3):
  $slider_active = true;
endif;
?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="team-member-slider bg-brand-off-white py-12 lg:py-16 <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="team-member-slider">
  <div class="container">
    <div class="mb-8 row">
      <div class="w-full mb-6 col lg:w-9/12 lg:mb-0">
        <div class="wysiwyg js-fade-group">
          <?php echo $component_data['content']; ?>
        </div>
      </div>
      <div class="flex items-center justify-start w-full col lg:w-3/12 lg:justify-end">
        <?php if ( $link ) : ?>
          <a class="flex items-center flex-shrink-0 mt-5 secondary-btn teal" href="<?php echo $link['url']; ?>" <?php echo $link['target'] ? 'target="' . $link['target'] . '"' : '' ?>>
            <svg class="w-5 h-5 mb-[3px] mr-3 icon icon-arrow-right-long"><use xlink:href="#icon-arrow-right-long"></use></svg>
            <?php echo $link['title']; ?>
            <?php if($link['target'] === '_blank') : ?>
              <span class="sr-only"> (opens in new tab)</span>
            <?php endif; ?>
          </a>
        <?php endif; ?>
      </div>
    </div>
    <div class="team-member-slider__slider <?php echo $slider_active ? '-mx-4' : 'grid grid-cols-1 lg:grid-cols-3 gap-8'; ?>">
      <?php foreach( $team_member_posts as $key => $team_member ) :?>
        <?php
          ll_include_component(
            'team-member-card',
              array(
                'slider_active' => $slider_active,
                'team_member_id' => $team_member['team_member_id'],
                'image_id' => $team_member['image_id'],
                'name' => $team_member['name'],
                'position' => $team_member['position'],
                'bio' => $team_member['bio'],
                'social' => $team_member['social'],
              )
            );
        ?>
      <?php endforeach; ?>
    </div>
    <div class="flex items-center justify-start w-full mt-8">
      <div class="team-member-slider__slider-nav relative flex w-full lg:justify-end lg:mb-0 <?php echo $slider_active ? 'flex' : 'hidden'; ?>">
        <div class="w-full flex items-center mr-6 <?php echo $slider_active ? '' : 'hidden'; ?>">
          <div class="relative progress-inner">
            <div class="progress-bar" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100" style="background-size: 5% 100%;"></div>
            <span class="sr-only slider__label"></span>
          </div>
        </div>
        <button aria-label="button to go to previous slide" role="button" class="flex items-center justify-center flex-shrink-0 w-10 h-10 mr-3 duration-200 ease-in-out border rounded-full aria-disabled:opacity-50 aria-disabled:pointer-events-none hover:bg-brand-teal group team-member-slider__prev border-brand-teal">
          <svg class='w-4 h-4 duration-200 ease-in-out icon group-hover:text-brand-off-white text-brand-teal icon-arrow-left'><use xlink:href='#icon-arrow-left'></use></svg>
        </button>
        <button aria-label="button to go to next slide" role="button" class="flex items-center justify-center flex-shrink-0 w-10 h-10 duration-200 ease-in-out border rounded-full aria-disabled:opacity-50 aria-disabled:pointer-events-none hover:bg-brand-teal group team-member-slider__next border-brand-teal">
          <svg class='w-4 h-4 duration-200 ease-in-out icon group-hover:text-brand-off-white text-brand-teal icon-arrow-right'><use xlink:href='#icon-arrow-right'></use></svg>
        </button>
      </div>
    </div>
  </div>
</section>
