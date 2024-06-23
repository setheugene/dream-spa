<?php
/**
* Team Member Grid
* -----------------------------------------------------------------------------
*
* Team Member Grid component
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
  'heading' => null,
  'members' => null,
];

$component_data = ll_parse_args( $component_data, $defaults );

$heading = $component_data['heading'];

$selected_team_members = $component_data['members'];

if( !empty($selected_team_members) ) {
  $args = array(
    'post_type'       => 'll_team_members',
    'post_status'     => 'publish',
    'orderby'         => 'date',
    'order'           => 'DESC',
    'field'           => 'ids',
    'posts_per_page'  => -1,
    'orderby'         => 'post__in',
    'post__in'        => $selected_team_members,
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

$team_members_data = get_posts( $args );

$team_members = [];

if(!empty($team_members_data)) :
  foreach($team_members_data as $team_member ) :
    $team_member_id = $team_member->ID;
    $team_members[] = [
      'team_member_id' => $team_member_id,
      'image_id' => get_post_thumbnail_id( $team_member_id ) ?? '',
      'name' => get_field('team_member_name', $team_member_id) ?? '',
      'position' => get_field('team_member_position', $team_member_id) ?? '',
      'bio' => get_field('team_member_bio', $team_member_id) ?? '',
      'social' => get_field('team_member_social', $team_member_id) ?? '',
    ];
  endforeach;
endif;

?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="team-member-grid pt-10 pb-14 <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="team-member-grid">
  <div class="container">
    <?php if( $heading['heading'] && $heading['heading']['text']) : ?>
      <<?php echo $heading['heading']['tag']; ?> class='mb-10 text-center js-fade text-brand-navy hdg-1'><?php echo $heading['heading']['text']; ?></<?php echo $heading['heading']['tag']; ?>>
    <?php endif; ?>
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
      <?php if( !empty($team_members) ) : ?>
        <?php foreach( $team_members as $key => $team_member ) : ?>
          <?php
            ll_include_component(
              'team-member-card',
                array(
                  'slider_active' => false,
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
      <?php endif; ?>
    </div>
  </div>
</section>
