<?php
/**
* Team Member Card
* -----------------------------------------------------------------------------
*
* Team Member Card component
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
  'team_member_id' => '',
  'image_id' => null,
  'name' => '',
  'position' => '',
  'bio' => '',
];

$component_data = ll_parse_args( $component_data, $defaults );

$image_id = $component_data['image_id'];

$popup_active = false;
if( $component_data['bio'] != '' ) :
  $popup_active = true;
endif;

// $team_member_social = get_field('team_member_social', $component_data['team_member_id']);
?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="team-member-card relative <?php echo $popup_active ? 'group' : ''; ?> <?php echo $component_data['slider_active'] ? 'team-member-slider__slide mx-4' : ''; ?> <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="team-member-card">
  <div class="relative mb-5 overflow-hidden aspect-3/4">
    <?php if( $image_id != '' ) : ?>
      <?php
        ll_include_component(
          'fit-image',
          array(
            'image_id' => $image_id,
            'thumbnail_size' => 'large',
            'position' => '',
            'fit' =>  '',
            'loading' => ''
          ),
          ['classes' => [ $popup_active ? 'duration-200 ease-in-out group-hover:scale-105' : '' ] ]
        );
      ?>
    <?php else : ?>
      <div class="fit-image">
        <img class="<?php echo $popup_active ? 'duration-200 ease-in-out group-hover:scale-105' : ''; ?>" src="<?php echo get_template_directory_uri(); ?>/assets/img/no-image.jpg" alt="dream spa logo">
      </div>
    <?php endif; ?>
  </div>
  <div class="mb-3 text-brand-navy hdg-5 <?php echo $popup_active ? 'duration-200 ease-in-out group-hover:text-brand-teal' : ''; ?>">
    <?php echo $component_data['name']; ?>
  </div>
  <div class="hdg-6 text-brand-gray">
    <?php echo $component_data['position']; ?>
  </div>
  <?php if( $popup_active ) : ?>
    <button class="absolute inset-0 w-full h-full js-init-popup" data-modal="#team-member-modal__<?php echo $component_data['team_member_id']; ?>" data-component="modal"></button>
    <div id="team-member-modal__<?php echo $component_data['team_member_id']; ?>" class="flex bg-white md:pr-12 dream-spa__modal-full-width mfp-hide">
      <div class="w-[50px] lg:w-[150px] bg-brand-dark-teal text-white flex-shrink-0 relative">
        <button class="w-[75px] active:top-12 top-12 group right-0 lg:right-6 duration-200 !text-white transform mfp-close hdg-6 rotate-90 !flex">
          <svg class='flex-shrink-0 w-3 h-3 mr-3 icon icon-close'><use xlink:href='#icon-close'></use></svg>
          Close
        </button>
      </div>
      <div class="w-full py-12 row">
        <div class="w-full col lg:w-1/2">
          <div class="class lg:w-[373px] mx-auto flex flex-col lg:items-center px-8 lg:px-0">
            <div class="relative mb-5 overflow-hidden aspect-3/4 w-[150px] md:w-[373px]">
              <?php if( $image_id != '' ) : ?>
                <?php
                  ll_include_component(
                    'fit-image',
                    array(
                      'image_id' => $image_id,
                      'thumbnail_size' => 'large',
                      'position' => '',
                      'fit' =>  '',
                      'loading' => ''
                    ),
                    ['classes' => [ $popup_active ? 'duration-300 ease-in-out group-hover:scale-105' : '' ] ]
                  );
                ?>
              <?php else : ?>
                <div class="fit-image">
                  <img class="<?php echo $popup_active ? 'duration-300 ease-in-out group-hover:scale-105' : ''; ?>" src="<?php echo get_template_directory_uri(); ?>/assets/img/no-image.jpg" alt="dream spa logo">
                </div>
              <?php endif; ?>
            </div>
            <div class="self-start mb-3 text-brand-navy hdg-5 <?php echo $popup_active ? 'duration-200 ease-in-out group-hover:text-brand-teal' : ''; ?>">
              <?php echo $component_data['name']; ?>
            </div>
            <div class="self-start hdg-6 text-brand-gray">
              <?php echo $component_data['position']; ?>
            </div>
            <div class="self-start">
              <?php echo ll_get_team_member_social_list(['team_member_id' => $component_data['team_member_id'], 'link_classes' => 'mt-5 inline-flex items-center duration-200 ease-in-out hover:bg-brand-teal justify-center relative border border-brand-logo-blue text-brand-teal rounded-full h-10 w-10 hover:text-white social-list__link' ]); ?>
            </div>
          </div>
        </div>
        <div class="w-full mt-8 col lg:w-1/2 lg:mt-0">
          <div class="px-8 wysiwyg lg:px-0">
            <?php echo $component_data['bio']; ?>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
</section>
