<?php
  $ipInfo     = file_get_contents('http://ip-api.com/json/');
  $ipInfo     = json_decode($ipInfo);
  $timezone   = $ipInfo->timezone;
  $timezone   = new DateTimeZone( $ipInfo->timezone );

  $special_image_id = get_post_thumbnail_id() ?? null;
  $logo = get_field( 'global_nav_logo', 'option' );
  $special_locations = get_field( 'special_locations_site_ids' ) ?? '';
  $specials_speakers = get_field('special_organizers') ?? null;
  $special_organizers_block_title = get_field('special_organizers_block_title') ?? '';
  $special_title = get_field('special_title') ?? '';
  $special_subtitle = get_field('special_subtitle') ?? '';
  $special_start_date = get_field('special_start_date') ?? '';
  $special_start_time = get_field('special_start_time') ?? '';
  $special_end_date = get_field('special_end_date') ?? '';
  $special_end_time = get_field('special_end_time') ?? '';
  $special_price = get_field('special_price') ?? '';

  $start_date = date_create($special_start_date);
  $start_date_timestamp = date_timestamp_get($start_date);
  $start_day_of_week = date('l', $start_date_timestamp);

  $end_date = date_create($special_end_date);
  $end_date_timestamp = date_timestamp_get($end_date);
  $end_day_of_week = date('l', $end_date_timestamp);

  $full_event_date = $special_start_date;
  if( $special_end_date != '' ) {
    $full_event_date = '<span class="block">Start: ' . $special_start_date . '</span><span class="block">End: ' . $special_end_date .'</span>';
  }

  $full_event_time = $special_start_time . ' - ' . $special_end_time;

  $locations = [];
  if (!empty($special_locations)) {
    foreach ($special_locations as $key => $location) {
      switch_to_blog($location);
        $locations[] = [
          'name' => get_bloginfo('name'),
          'phone_number' => get_field('contact_phone_number', 'option') ?? null,
          'email' => get_field('contact_email_address', 'option') ?? null,
          'address_street' => get_field('contact_street_address', 'option') ?? null,
          'address_city' => get_field('contact_city', 'option') ?? null,
          'address_state' => get_field('contact_state', 'option') ?? null,
          'address_zip' => get_field('contact_zip', 'option') ?? null,
          'address_url' => get_field('gmb_link', 'options') != '' ? get_field('gmb_link', 'options') : 'https://www.google.com/maps/place/' . get_field('contact_street_address', 'option') . ' '. get_field('contact_city', 'option') . ', ' . get_field('contact_state', 'option') . ' ' . get_field('contact_zip', 'option'),
        ];
      restore_current_blog();
    }
  }
?>
<article class="pt-5 pb-12 bg-brand-off-white">
  <div class="container mb-5 bg-brand-off-white">
    <?php if ( function_exists('yoast_breadcrumb') ) : ?>
      <div class="relative z-10 w-full py-2 text-brand-gray paragraph-small">
        <?php yoast_breadcrumb(); ?>
      </div>
    <?php endif; ?>
    <?php if( $special_image_id ) : ?>
      <div class="relative mb-5 -mt-5 aspect-16/9">
        <?php
          ll_include_component(
            'fit-image',
            array(
              'image_id' => $special_image_id,
              'thumbnail_size' => 'large',
              'position' => '',
              'fit' =>  '',
              'loading' => ''
            )
          );
        ?>
      </div>
    <?php endif; ?>
    <div class="row">
      <div class="order-2 w-full col lg:w-4/12 lg:order-1">
        <div class="p-8 bg-white lg:mx-gutter">
          <?php if ( $logo ) : ?>
            <div class="h-[265px] flex justify-center mx-auto items-center bg-brand-off-white mb-5" href="<?php echo esc_url(home_url('/')); ?>">
              <img class="logo logo--header w-[250px] mx-auto" src="<?php echo $logo['url']; ?>" alt="<?php bloginfo('name'); ?> logo">
            </div>
          <?php endif; ?>
          <?php if( !empty($locations) ) : ?>
            <?php foreach( $locations as $location ) : ?>
              <div class="mb-5">
                <div class="flex mb-3 last:mb-0">
                  <svg class='w-5 h-5 mr-2 icon text-brand-teal icon-location-pin'><use xlink:href='#icon-location-pin'></use></svg>
                  <div class="flex flex-col">
                    <p class="mb-0 font-medium paragraph-small text-brand-navy">
                      <?php echo $location['name']; ?>
                    </p>
                    <a href="<?php echo $location['address_url'] ?>" class="paragraph-small hover:underline">
                      <span class="block"><?php echo $location['address_street']; ?></span>
                      <span class="block"><?php echo $location['address_city'] ?>, <?php echo $location['address_state']; ?> <?php echo $location['address_zip']; ?></span>
                    </a>
                  </div>
                </div>
                <?php if( $location['phone_number'] ) : ?>
                  <div class="flex mb-3 last:mb-0">
                    <svg class='w-5 h-5 mr-2 icon text-brand-teal icon-location-phone'><use xlink:href='#icon-location-phone'></use></svg>
                    <a href="tel:<?php echo strip_phone($location['phone_number']); ?>" class="paragraph-small hover:underline">
                      <?php echo $location['phone_number']; ?>
                    </a>
                  </div>
                <?php endif; ?>
                <?php if( $location['email'] ) : ?>
                  <div class="flex mb-3 last:mb-0">
                    <svg class='w-5 h-5 mr-2 icon text-brand-teal icon-location-email'><use xlink:href='#icon-location-email'></use></svg>
                    <a href="mailto:<?php echo strip_phone($location['email']); ?>" class="paragraph-small text-brand-teal hover:underline">
                      <?php echo $location['email']; ?>
                    </a>
                  </div>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
        <?php if( $specials_speakers ) : ?>
          <div class="p-8 mt-8 bg-white lg:mx-gutter">
            <div class="mb-3 font-semibold text-brand-navy">
              <?php echo $special_organizers_block_title; ?>
            </div>
            <?php foreach( $specials_speakers as $speaker ) : ?>
              <div class="flex items-center mb-4 last:mb-0">
                <div class="relative w-16 h-16 mr-3 overflow-hidden rounded-full aspect-square">
                  <?php
                    ll_include_component(
                      'fit-image',
                      array(
                        'image_id' => $speaker['image']['image_id'],
                        'thumbnail_size' => 'full',
                        'position' => $speaker['image']['image_focus_point'],
                        'fit' =>  $speaker['image']['image_fit'],
                        'loading' => $speaker['image']['image_loading']
                      )
                    );
                  ?>
                </div>
                <div>
                  <p class="mb-0 paragraph-default text-brand-navy">
                    <?php echo $speaker['name']; ?>
                  </p>
                  <p class="mb-0 paragraph-small text-brand-gray">
                    <?php echo $speaker['title']; ?>
                  </p>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
      <div class="order-1 w-full pt-6 col lg:w-8/12 lg:pt-0 lg:order-2">
        <div class="mb-5">
          <h1 class="hdg-4 text-brand-navy">
            <?php echo $special_title; ?>
          </h1>
          <?php if( $special_subtitle != '' ) : ?>
            <div class="mt-3 paragraph-large text-brand-gray">
              <?php echo $special_subtitle; ?>
            </div>
          <?php endif; ?>
        </div>
        <div class="p-8 bg-white flex gap-[50px] flex-wrap mb-8">
          <?php if( $special_start_date != '' ) : ?>
            <div class="flex">
              <svg class='w-[18px] h-[18px] mr-3 icon text-brand-teal icon-special-calendar'><use xlink:href='#icon-special-calendar'></use></svg>
              <div>
                <p class="font-semibold uppercase text-brand-navy paragraph-small">
                  Date
                </p>
                <?php if( $special_start_date === $special_end_date ) : ?>
                  <p class="mb-0 paragraph-default text-brand-navy">
                    <?php echo $start_day_of_week; ?>
                  </p>
                  <p class="mb-0 paragraph-default text-brand-navy">
                    <?php echo $special_start_date; ?>
                  </p>
                <?php else : ?>
                  <p class="mb-0 paragraph-default text-brand-navy">
                    <?php echo $full_event_date; ?>
                  </p>
                <?php endif; ?>
              </div>
            </div>
          <?php endif; ?>
          <?php if( $special_start_time != '' ) : ?>
            <div class="flex">
              <svg class='w-[18px] h-[18px] mr-3 icon text-brand-teal icon-special-time'><use xlink:href='#icon-special-time'></use></svg>
              <div>
                <p class="font-semibold uppercase text-brand-navy paragraph-small">
                  Time
                </p>
                <p class="mb-0 paragraph-default text-brand-navy">
                  <?php echo $full_event_time; ?>
                </p>
              </div>
            </div>
          <?php endif; ?>
          <?php if( $special_price != '' ) : ?>
            <div class="flex">
              <svg class='w-[18px] h-[18px] mr-3 icon text-brand-teal icon-special-price'><use xlink:href='#icon-special-price'></use></svg>
              <div>
                <p class="font-semibold uppercase text-brand-navy paragraph-small">
                  Price
                </p>
                <p class="mb-0 paragraph-default text-brand-navy">
                  <?php echo $special_price; ?>
                </p>
              </div>
            </div>
          <?php endif; ?>
        </div>
        <div class="wysiwyg">
          <?php the_content(); ?>
        </div>
      </div>
    </div>
  </div>
</article>
