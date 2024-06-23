<?php
add_action( 'mec_top_single_event', 'll_custom_mec_add_single_event_image_banner' );
function ll_custom_mec_add_single_event_image_banner( $event_id ) {
  echo get_the_post_thumbnail( $event_id, 'full' );
}

add_action( 'mec_single_after_content', 'll_custom_mec_add_custom_wysiwyg_to_single_event' ); function ll_custom_mec_add_custom_wysiwyg_to_single_event( $event ) { echo '<div class="wysiwyg elementor-widget-container">' . format_text(get_the_content( null, null, $event->ID )) . '</div>'; }


function ll_mec_classic_after_title( $event ) {
  $event_id = $event->ID;
  $event_locations = get_field( 'mec_locations_site_ids', $event_id ) ?? '';
  $location_pills = '';
  $event_info = $event->data->post->post_excerpt ?? '';
  if($event_info != '') {
    $location_pills .= '<div class="mb-5 paragraph-small text-brand-gray">' . $event_info . '</div>';
  }
  if($event_locations != '') {
    if (!empty($event_locations)) {
      $location_pills .= '<div class="flex flex-wrap gap-2">';
      foreach($event_locations as $event_location) {
        $current_blog_details = get_blog_details( array( 'blog_id' => $event_location ) );
        $blog_name = $current_blog_details->blogname ?? '';
        $location_pills .= '<div class="special-grid__card-location-pill w-fit py-1 pr-3 pl-[10px] paragraph-small rounded-full text-brand-teal items-center flex bg-brand-off-white">';
        $location_pills .= '<svg class="icon h-4 w-4 mr-[9px] text-brand-teal icon-Location"><use xlink:href="#icon-Location"></use></svg>';
        $location_pills .= $blog_name;
        $location_pills .= '</div>';
        ;
      }
      $location_pills .= '</div>';
    }
    echo $location_pills;
  }
}
add_filter( 'mec_classic_view_action', 'll_mec_classic_after_title', 10, 2 );
