<?php
  $main_site = is_main_site();
  if( !$main_site ) :
    switch_to_blog(get_main_site_id());
  endif;
  $logo = get_field( 'global_footer_logo', 'option' ) ?? null;
  $global_footer_menu = new LL_Menu( 'global_footer_menu' ) ?? null;
  $global_footer_hours = get_field( 'global_footer_hours', 'option' ) ?? null;
  $privacy_policy_link = get_privacy_policy_url() ?? null;
  if( !$main_site ) :
    restore_current_blog();
  endif;
  $sites = get_sites();
  $site_information = [];
  foreach ( $sites as $site ) {
    if($site->blog_id != get_main_site_id()) {
      //get location information from each site site options
      switch_to_blog( $site->blog_id );
        $site_information[] = [
          'url' => esc_url($site->domain),
          'location_name' => $site->blogname,
          'phone_number' => get_field('contact_phone_number', 'option') ?? null,
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
<footer class="pb-8 text-white pt-14 footer bg-brand-dark-teal" role="contentinfo">
  <div class="container">
    <div class="items-center row">
      <div class="flex justify-center w-full mb-6 col lg:w-1/4 lg:mb-0 lg:justify-start last:mb-0">
        <?php if ( $logo ) : ?>
          <a class="inline-block" href="<?php echo esc_url(home_url('/')); ?>">
            <img class="logo logo--footer w-[199px]" src="<?php echo $logo['url']; ?>" alt="<?php bloginfo('name'); ?>">
          </a>
        <?php endif; ?>
      </div>
      <?php if( !empty($site_information) ) : ?>
        <?php foreach( $site_information as $site_link ) : ?>
          <div class="w-full mb-3 lg:w-1/4 col lg:mb-0 last:mb-0">
            <a href="<?php echo $site_link['url']; ?>" class="flex items-center justify-between w-full px-4 py-3 overflow-hidden text-white duration-300 ease-in-out rounded-sm hdg-5 bg-brand-teal bg-opacity-40 hover:bg-opacity-100 group">
              <?php echo $site_link['location_name']; ?> Location
              <div class="flex items-center justify-center w-10 h-10 duration-300 ease-in-out border rounded-full border-brand-off-white group-hover:bg-brand-off-white">
                <svg class='w-4 h-4 text-brand-off-white group-hover:text-brand-teal icon icon-arrow-right-corner'><use xlink:href='#icon-arrow-right-corner'></use></svg>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
    <hr class="my-8 lg:my-10 border-brand-storm">
    <div class="row lg:mb-16">
      <div class="w-full mb-6 col lg:w-1/4 lg:mb-0 last:mb-0">
        <div class="mb-5 hdg-6">
          Office Hours
        </div>
        <div class="text-white wysiwyg paragraph-default">
          <?php echo $global_footer_hours; ?>
        </div>
      </div>
      <?php foreach( $site_information as $site ) : ?>
        <div class="w-full mb-6 col lg:w-1/4 lg:mb-0 last:mb-0">
          <div class="mb-5 hdg-6">
            <?php echo $site['location_name']; ?>
          </div>
          <a class="block mb-3 hover:underline paragraph-default" href="tel:<?php echo strip_phone($site['phone_number']); ?>">
            <span class="block"><?php echo $site['phone_number']; ?></span>
          </a>
          <a href="<?php echo $site['address_url'] ?>" class="block paragraph-default hover:underline" target="_blank">
            <span class="block"><?php echo $site['address_street']; ?></span>
            <span class="block">
              <?php echo $site['address_city']; ?>, <?php echo $site['address_state']; ?> <?php echo $site['address_zip']; ?>
            </span>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
    <hr class="block my-8 lg:hidden border-brand-storm">
    <div class="mb-5 row">
      <div class="w-full col lg:w-8/12 lg:flex lg:items-center">
        <?php if ( isset($global_footer_menu->hasItems) ) : ?>
          <nav class="">
            <ul class="flex flex-col lg:flex-row">
              <?php foreach( $global_footer_menu->items as $menu_item ): ?>
                <li class="my-0 mb-6 mr-8 last:mr-0 lg:mb-0">
                  <a class="font-medium paragraph-default hover:underline" href="<?php echo $menu_item->url ?>" target="<?php echo $menu_item->target; ?>"><?php echo $menu_item->title; ?></a>
                </li>
              <?php endforeach; ?>
            </ul>
          </nav>
        <?php endif; ?>
      </div>
      <div class="w-full col lg:w-4/12">
        <?php ll_get_social_list(); ?>
      </div>
      <div class="w-full col">
        <hr class="mt-8 mb-0 lg:mt-5 border-brand-storm">
      </div>
    </div>
  </div>
  <div class="text-white lg:pt-5 bg-brand-dark-teal footer-bottom">
    <div class="container">
      <div class="flex flex-wrap items-center justify-center text-center lg:flex-nowrap lg:justify-between">
        <div class="w-full lg:w-auto lg:text-left paragraph-default">
          &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All Rights Reserved.
          <?php if( $privacy_policy_link ) : ?>
            <span class="inline-block mx-2">|</span>
            <a class="hover:underline" href="<?php echo $privacy_policy_link; ?>">
              Privacy Policy
            </a>
          <?php endif; ?>
        </div>
        <div class="w-full lg:w-auto lg:text-right paragraph-default">
          <a class="hover:underline" href="https://liftedlogic.com/" target="_blank">Web Design</a> & <a class="hover:underline" href="https://liftedlogic.com/" target="_blank">SEO</a> by <a class="hover:underline" href="https://liftedlogic.com/" target="_blank">Lifted Logic</a>
        </div>
      </div>
    </div>
  </div>
</footer>
