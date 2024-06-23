<?php
$primary_menu   = new LL_Menu('primary_navigation');
$location_phone_number = get_field('contact_phone_number', 'option') ?? null;
$main_site = is_main_site();
$global_primary_nav_links = [];
$global_nav_links = [];
$global_nav_cta = [];
$sites = get_sites();
$main_site_id = get_main_site_id();

$sites_links = [];
foreach ($sites as $site) {
  if ($site->blog_id != $main_site_id) {
    $sites_links[] = [
      'url' => esc_url($site->domain),
      'location_name' => $site->blogname,
      'site_id' => $site->blog_id,
    ];
  }
}

// top nav is all set on main site site options, so get that.
if (!$main_site) :
  switch_to_blog($main_site_id);
endif;

$logo = get_field('global_nav_logo', 'option');
$explore_menu = new LL_Menu('global_explore_menu');
$global_request_a_consultation_link = get_field('global_request_a_consultation_link', 'option') ?? null;
$global_try_virtual_consultation_link = get_field('global_try_virtual_consultation_link', 'option') ?? null;
$global_book_now_link = get_field('global_book_now_link', 'option') ?? null;
$global_primary_nav_links_fields = get_field('global_primary_nav_links', 'option');

foreach ($global_primary_nav_links_fields as $key => $global_primary_nav_link) {
  $global_primary_nav_links[$key] = [
    'url' => $global_primary_nav_link['global_primary_nav_link']['url'],
    'target' => $global_primary_nav_link['global_primary_nav_link']['target'],
    'title' => $global_primary_nav_link['global_primary_nav_link']['title'],
  ];
}

// Global Nav CTA
$cta_image = get_field('nav_cta_image', 'options') ?? null;
$nav_cta_image_field = get_field('nav_cta_image', 'option') ?? null;

$global_nav_cta[] = [
  'cta_image' => $nav_cta_image_field != null ? wp_get_attachment_image($nav_cta_image_field['image_id'], 'large', false, array("class" => $nav_cta_image_field['image_focus_point'] . ' object-cover')) : null,
  'cta_title' => get_field('nav_cta_title', 'option') ?? '',
  'cta_text' => get_field('nav_cta_text', 'option') ?? '',
  'cta_url' => get_field('nav_cta_url', 'option') ?? '',
  'cta_link_target' => get_field('nav_cta_link_target', 'option') ?? '',
];

if (!$main_site) :
  restore_current_blog();
endif;
?>

<header class="border-b border-brand-logo-blue navbar" role="banner">
  <div id="upper-nav" class="container">
    <div class="flex items-center justify-between flex-nowrap">
      <?php if ($logo) : ?>
        <a class="py-4" href="<?php echo esc_url(home_url('/')); ?>">
          <img class="logo logo--header h-[43px] lg:h-[auto]" src="<?php echo $logo['url']; ?>" alt="<?php bloginfo('name'); ?>">
        </a>
      <?php endif; ?>
      <div class="flex items-center global-nav-links">
        <?php if ($global_request_a_consultation_link) : ?>
          <a class="hidden mr-5 primary-btn teal last:mr-0 lg:block" href="<?php echo $global_request_a_consultation_link['url']; ?>" <?php echo $global_request_a_consultation_link['target'] ? 'target="' . $global_request_a_consultation_link['target'] . '"' : '' ?>>
            <svg class="w-5 h-5 mb-[3px] mr-3 icon icon-arrow-right-long">
              <use xlink:href="#icon-arrow-right-long"></use>
            </svg>
            <?php echo $global_request_a_consultation_link['title']; ?>
            <?php if ($global_request_a_consultation_link['target'] === '_blank') : ?>
              <span class="sr-only"> (opens in new tab)</span>
            <?php endif; ?>
          </a>
        <?php endif; ?>
        <?php if ($global_try_virtual_consultation_link) : ?>
          <a class="hidden mr-5 primary-btn teal last:mr-0 lg:block" href="<?php echo $global_try_virtual_consultation_link['url']; ?>" <?php echo $global_try_virtual_consultation_link['target'] ? 'target="' . $global_try_virtual_consultation_link['target'] . '"' : '' ?>>
            <svg class="w-5 h-5 mb-[3px] mr-3 icon icon-arrow-right-long">
              <use xlink:href="#icon-arrow-right-long"></use>
            </svg>
            <?php echo $global_try_virtual_consultation_link['title']; ?>
            <?php if ($global_try_virtual_consultation_link['target'] === '_blank') : ?>
              <span class="sr-only"> (opens in new tab)</span>
            <?php endif; ?>
          </a>
        <?php endif; ?>
        <?php if ($global_book_now_link) : ?>
          <a class="!py-2 mr-5 primary-btn teal last:mr-0 !px-4 lg:!py-4 lg:!px-6 flex" href="<?php echo $global_book_now_link['url']; ?>" <?php echo $global_book_now_link['target'] ? 'target="' . $global_book_now_link['target'] . '"' : '' ?>>
            <?php echo $global_book_now_link['title']; ?>
            <svg class="w-5 h-5 mb-[3px] !hidden lg:!block ml-3 icon icon-arrow-right-corner">
              <use xlink:href="#icon-arrow-right-corner"></use>
            </svg>
            <?php if ($global_book_now_link['target'] === '_blank') : ?>
              <span class="sr-only"> (opens in new tab)</span>
            <?php endif; ?>
          </a>
        <?php endif; ?>

      </div>
    </div>
  </div>
  <div id="lower-nav" class="relative border-y border-brand-logo-blue bg-brand-off-white">
    <div class="container">
      <nav class="primary-nav" role="navigation">
        <ul class="flex items-center justify-between">
          <div class="flex items-center left-nav w-[88%] lg:w-[unset]">
            <div class="flex w-[209px] items-center paragraph-small border-r lg:border-l dropdown border-brand-logo-blue lg:relative">
              <button class="flex items-center justify-between w-full py-3 pr-4 lg:pl-4 easy-toggle-slide-toggle [&.is-open_.icon-chevron-down-small]:-rotate-180" data-toggle-class="is-open" data-toggle-outside data-toggle-target="#locations-dropdown">
                <div>
                  <svg class='w-4 h-4 mr-2 icon icon-Location text-brand-teal'>
                    <use xlink:href='#icon-Location'></use>
                  </svg>
                  <span class="text-brand-navy">
                    <?php if ($main_site) : ?>
                      Select a Location
                    <?php elseif (!empty($sites_links)) : ?>
                      <?php foreach ($sites_links as $site) : ?>
                        <?php if ($site['site_id'] == get_current_blog_id()) : ?>
                          <?php echo $site['location_name']; ?>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </span>
                </div>
                <svg class='w-3 h-3 duration-150 icon text-brand-teal icon-chevron-down-small'>
                  <use xlink:href='#icon-chevron-down-small'></use>
                </svg>
              </button>
              <div id="locations-dropdown" class="container absolute z-50 px-8 lg:px-0 left-0 top-[100%] lg:-left-[1px] hidden w-screen lg:w-[209px] bg-brand-off-white border border-brand-logo-blue">
                <?php if (!empty($sites_links)) : ?>
                  <ul>
                    <?php foreach ($sites_links as $site_link) : ?>
                      <?php if ($site_link['site_id'] != get_current_blog_id()) : ?>
                        <li class="border-b border-brand-logo-blue">
                          <a href="<?php echo $site_link['url'] ?? ''; ?>" class="flex items-center px-4 py-3 duration-200 ease-in-out border-b border-brand-logo-blue last:border-b-0 group hover:bg-brand-teal">
                            <svg class='w-4 h-4 mr-2 duration-200 ease-in-out icon icon-Location paragraph-default text-brand-teal group-hover:text-white'>
                              <use xlink:href='#icon-Location'></use>
                            </svg>
                            <span class="duration-200 ease-in-out text-brand-navy group-hover:text-white">
                              <?php echo $site_link['location_name'] ?? ''; ?>
                            </span>
                          </a>
                        </li>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </ul>
                <?php endif; ?>
              </div>
            </div>
            <?php if ($location_phone_number && !$main_site) : ?>
              <a href="tel:<?php echo strip_phone($location_phone_number); ?>" class="flex items-center ml-5 text-brand-teal">
                <svg class='w-4 h-4 mr-2 icon text-brand-teal icon-phone'>
                  <use xlink:href='#icon-phone'></use>
                </svg>
                <span class="hidden lg:block"><?php echo $location_phone_number; ?></span>
              </a>
            <?php endif; ?>
          </div>
          <button type="button" class="flex-shrink-0 lg:hidden navbar-toggle" data-toggle-class="is-open" data-toggle-target="#mobile-dropdown-menu, #mobile-sticky-buttons">
            <span class="navbar-toggle-icon"></span>
            <span class="sr-only">Main Menu</span>
          </button>
          <div id="mobile-dropdown-menu" class="items-center relative pb-[300px] lg:pb-0 flex-shrink-0 hidden lg:flex right-nav left-0 lg:left-[unset] top-[46px] lg:top-[unset] h-screen w-screen lg:w-[unset] lg:h-[unset] bg-white lg:bg-transparent">
            <?php if ($primary_menu->items) : ?>
              <?php foreach ($primary_menu->items as $menu_item) : ?>
                <li class="lg:mr-8 primary-menu-item last-of-type:mr-0">
                  <<?php echo $menu_item->has_children ? 'button' : 'a'; ?> class="flex items-center justify-between w-full py-5 font-medium duration-300 ease-in-out border-b last:border-b-0 lg:border-0 lg:py-0 border-brand-logo-blue lg:justify-start paragraph-default text-brand-navy easy-toggle-fade-toggle primary-menu-item__button group hover:text-brand-teal" <?php if ($menu_item->has_children) : ?> data-toggle-class="is-open" data-toggle-target="#menu-<?php echo $menu_item->ID; ?>" aria-expanded="false" data-toggle-group="menu-accordion" id="item-<?php echo $menu_item->ID; ?>" data-toggle-outside <?php else : ?> href="<?php echo $menu_item->url ?>" target="<?php echo $menu_item->target; ?>" <?php endif; ?>>
                    <?php echo $menu_item->title; ?>

                    <?php if ($menu_item->has_children) : ?>
                      <span class="inline-block">
                        <svg class="hidden w-3 h-3 ml-2 duration-300 ease-in-out lg:block icon group-hover:text-brand-teal text-brand-navy icon-chevron-down-small" aria-hidden="true">
                          <use xlink:href="#icon-chevron-down-small"></use>
                        </svg>
                        <svg class='block w-5 h-5 lg:hidden icon icon-arrow-right text-brand-navy'>
                          <use xlink:href='#icon-arrow-right'></use>
                        </svg>
                      </span>
                    <?php endif; ?>
                  </<?php echo $menu_item->has_children ? 'button' : 'a'; ?>>

                  <?php if ($menu_item->has_children) : ?>
                    <div class="absolute lg:top-[calc(100%_+_1px)] top-0 h-screen lg:h-[unset] left-0 hidden w-full py-8 bg-white primary-nav-panel -z--1" id="menu-<?php echo $menu_item->ID; ?>" aria-hidden="true" aria-labelledby="item-<?php echo $menu_item->ID; ?>">
                      <div class="container relative h-screen lg:h-[unset]">
                        <div class="row">
                          <div class="hidden w-full col lg:w-4/12 lg:block">
                            <div class="relative overflow-hidden rounded-sm aspect-4/3 group">
                              <a href="<?php echo $global_nav_cta[0]['cta_url']; ?>" <?php echo $global_nav_cta[0]['cta_link_target'] ? 'target="_blank"' : ''; ?> class="absolute inset-0 z-30 w-full h-full "></a>
                              <div class="absolute inset-0 z-10 w-full h-full duration-300 ease-in-out opacity-70 bg-brand-teal group-hover:opacity-100">
                                <img class="w-full duration-300 ease-in-out opacity-0 group-hover:opacity-100" src="<?php echo get_template_directory_uri(); ?>/assets/img/nav-cta-wave.svg" alt="background wave graphic">
                              </div>
                              <div class="fit-image">
                                <?php echo $global_nav_cta[0]['cta_image']; ?>
                              </div>
                              <div class="absolute inset-0 z-20 flex items-end w-full h-full px-8 py-6">
                                <div class="w-10/12">
                                  <p class="mb-2 text-white hdg-4">
                                    <?php echo $global_nav_cta[0]['cta_title']; ?>
                                  </p>
                                  <p class="text-white paragraph-default">
                                    <?php echo $global_nav_cta[0]['cta_text']; ?>
                                  </p>
                                </div>
                                <div class="absolute flex items-center justify-center w-10 h-10 duration-300 ease-in-out border rounded-full top-5 right-5 border-brand-off-white bg-blur group-hover:bg-brand-off-white">
                                  <svg class='w-4 h-4 duration-300 ease-in-out icon icon-arrow-right-corner text-brand-off-white group-hover:text-brand-teal'>
                                    <use xlink:href='#icon-arrow-right-corner'></use>
                                  </svg>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="w-full col lg:w-4/12">
                            <button class="relative flex items-center justify-center w-full mb-8 lg:hidden back" data-toggle-trigger-off="#menu-<?php echo $menu_item->ID; ?>">
                              <svg class='absolute left-0 w-5 h-5 top-[3px] icon text-brand-navy icon-arrow-left'>
                                <use xlink:href='#icon-arrow-left'></use>
                              </svg>
                              <span class="text-brand-teal hdg-5"><?php echo $menu_item->title; ?></span>
                            </button>
                            <ul class="relative">
                              <?php foreach ($menu_item->children as $key => $child_item) : ?>
                                <li class="border-b lg:mb-3 last:mb-0 border-brand-logo-blue lg:border-b-0">
                                  <?php if ($child_item->has_children) : ?>
                                    <button class="flex items-center justify-between w-full lg:px-4 py-5 lg:py-3 overflow-hidden text-base lg:text-xl font-medium duration-300 ease-in-out rounded-sm grandchild-menu-trigger easy-toggle-fade-toggle group lg:bg-brand-teal-10 text-brand-navy lg:text-brand-blue-gray lg:hover:bg-brand-teal lg:hover:text-brand-off-white <?php echo $key === 0 ? 'grandchild-menu-trigger__first' : ''; ?>" data-toggle-class="is-open" data-toggle-target="#grandchild-menu-<?php echo $child_item->ID; ?>" aria-expanded="false" data-toggle-group="grandchild-menu-options-<?php echo $menu_item->ID; ?>">
                                      <?php echo $child_item->title; ?>
                                      <svg class='hidden w-4 h-4 duration-300 ease-in-out lg:block icon icon-chevron-right text-brand-navy group-hover:text-brand-off-white'>
                                        <use xlink:href='#icon-chevron-right'></use>
                                      </svg>
                                      <div class="block expand lg:hidden">
                                        <div class="duration-200 vertical"></div>
                                        <div class="horizontal"></div>
                                      </div>
                                    </button>
                                    <ul class="grandchild-menu hidden px-5 lg:px-0 lg:absolute top-0 w-full lg:left-[calc(2rem_+_100%)] group-[.is-open]:block pb-5" id="grandchild-menu-<?php echo $child_item->ID; ?>">
                                      <?php foreach ($child_item->children as $grandchild_item) : ?>
                                        <li class="mb-4 last:mb-0">
                                          <a class="flex items-center justify-between w-full duration-300 ease-in-out group hover:text-brand-teal text-brand-navy paragraph-default" href="<?php echo $grandchild_item->url; ?>" target="<?php echo $grandchild_item->target; ?>">
                                            <?php echo $grandchild_item->title; ?>
                                            <svg class='w-4 h-4 duration-300 ease-in-out icon icon-arrow-right-long text-brand-navy group-hover:text-brand-teal'>
                                              <use xlink:href='#icon-arrow-right-long'></use>
                                            </svg>
                                          </a>
                                        </li>
                                      <?php endforeach; ?>
                                    </ul>
                                  <?php else : ?>
                                    <a class="flex items-center justify-between w-full py-3 overflow-hidden text-base font-medium duration-300 ease-in-out rounded-sm lg:text-xl lg:px-4 grandchild-menu-trigger easy-toggle-fade-toggle group lg:bg-brand-teal-10 text-brand-navy lg:text-brand-blue-gray lg:hover:bg-brand-teal lg:hover:text-brand-off-white" href="<?php echo $child_item->url; ?>" target="<?php echo $child_item->target; ?>">
                                      <?php echo $child_item->title; ?>
                                    </a>
                                  <?php endif; ?>
                                </li>
                              <?php endforeach; ?>
                            </ul>
                          </div>
                          <div class="relative z-0 block w-full mt-8 overflow-hidden rounded-sm lg:hidden aspect-4/3 group mobile">
                            <a href="<?php echo $global_nav_cta[0]['cta_url']; ?>" <?php echo $global_nav_cta[0]['cta_link_target'] ? 'target="_blank"' : ''; ?> class="absolute inset-0 z-30 w-full h-full "></a>
                            <div class="absolute inset-0 z-10 w-full h-full duration-300 ease-in-out opacity-70 bg-brand-teal group-hover:opacity-100">
                              <img class="w-full duration-300 ease-in-out opacity-0 group-hover:opacity-100" src="<?php echo get_template_directory_uri(); ?>/assets/img/nav-cta-wave.svg" alt="background wave graphic">
                            </div>
                            <div class="fit-image">
                              <?php echo $global_nav_cta[0]['cta_image']; ?>
                            </div>
                            <div class="absolute inset-0 z-20 flex items-end w-full h-full px-8 py-6">
                              <div class="w-10/12">
                                <p class="mb-2 text-white hdg-4">
                                  <?php echo $global_nav_cta[0]['cta_title']; ?>
                                </p>
                                <p class="text-white paragraph-default">
                                  <?php echo $global_nav_cta[0]['cta_text']; ?>
                                </p>
                              </div>
                              <div class="absolute flex items-center justify-center w-10 h-10 duration-300 ease-in-out border rounded-full top-5 right-5 border-brand-off-white bg-blur group-hover:bg-brand-off-white">
                                <svg class='w-4 h-4 duration-300 ease-in-out icon icon-arrow-right-corner text-brand-off-white group-hover:text-brand-teal'>
                                  <use xlink:href='#icon-arrow-right-corner'></use>
                                </svg>
                              </div>
                            </div>
                          </div>
                        </div>
                        <button class="absolute cursor-default top-[calc(100%_+_2rem)] left-0 w-screen h-screen bg-brand-scrim opacity-50" data-toggle-trigger-off="#menu-<?php echo $menu_item->ID; ?>"></button>
                      </div>
                    </div>
                  <?php endif; ?>
                </li>
              <?php endforeach; ?>
            <?php endif; ?>
            <?php if ($explore_menu->items) : ?>
              <?php foreach ($explore_menu->items as $menu_item) : ?>
                <li class="lg:mr-8 primary-menu-item last-of-type:mr-0">
                  <<?php echo $menu_item->has_children ? 'button' : 'a'; ?> class="flex items-center justify-between w-full py-5 font-medium duration-300 ease-in-out border-b lg:border-0 lg:py-0 border-brand-logo-blue lg:justify-start paragraph-default text-brand-navy easy-toggle-fade-toggle primary-menu-item__button group hover:text-brand-teal" <?php if ($menu_item->has_children) : ?> data-toggle-class="is-open" data-toggle-target="#menu-<?php echo $menu_item->ID; ?>" aria-expanded="false" data-toggle-group="menu-accordions" id="item-<?php echo $menu_item->ID; ?>" data-toggle-outside <?php else : ?> href="<?php echo $menu_item->url ?>" target="<?php echo $menu_item->target; ?>" <?php endif; ?>>
                    <?php echo $menu_item->title; ?>

                    <?php if ($menu_item->has_children) : ?>
                      <span class="inline-block">
                        <svg class="hidden w-3 h-3 ml-2 duration-300 ease-in-out lg:block icon group-hover:text-brand-teal text-brand-navy icon-chevron-down-small" aria-hidden="true">
                          <use xlink:href="#icon-chevron-down-small"></use>
                        </svg>
                        <svg class='block w-5 h-5 lg:hidden icon icon-arrow-right text-brand-navy'>
                          <use xlink:href='#icon-arrow-right'></use>
                        </svg>
                      </span>
                    <?php endif; ?>
                  </<?php echo $menu_item->has_children ? 'button' : 'a'; ?>>

                  <?php if ($menu_item->has_children) : ?>
                    <div class="absolute lg:top-[calc(100%_+_1px)] top-0 left-0 h-screen lg:h-[unset] hidden w-full py-8 z-20 bg-white primary-nav-panel" id="menu-<?php echo $menu_item->ID; ?>" aria-hidden="true" aria-labelledby="item-<?php echo $menu_item->ID; ?>">
                      <div class="container relative h-screen lg:h-[unset]">
                        <div class="row">
                          <div class="hidden w-full col lg:w-4/12 lg:block">
                            <div class="relative overflow-hidden rounded-sm aspect-4/3 group">
                              <a href="<?php echo $global_nav_cta[0]['cta_url']; ?>" <?php echo $global_nav_cta[0]['cta_link_target'] ? 'target="_blank"' : ''; ?> class="absolute inset-0 z-30 w-full h-full "></a>
                              <div class="absolute inset-0 z-10 w-full h-full duration-300 ease-in-out opacity-70 bg-brand-teal group-hover:opacity-100">
                                <img class="w-full duration-300 ease-in-out opacity-0 group-hover:opacity-100" src="<?php echo get_template_directory_uri(); ?>/assets/img/nav-cta-wave.svg" alt="background wave graphic">
                              </div>
                              <div class="fit-image">
                                <?php echo $global_nav_cta[0]['cta_image']; ?>
                              </div>
                              <div class="absolute inset-0 z-20 flex items-end w-full h-full px-8 py-6">
                                <div class="w-10/12">
                                  <p class="mb-2 text-white hdg-4">
                                    <?php echo $global_nav_cta[0]['cta_title']; ?>
                                  </p>
                                  <p class="text-white paragraph-default">
                                    <?php echo $global_nav_cta[0]['cta_text']; ?>
                                  </p>
                                </div>
                                <div class="absolute flex items-center justify-center w-10 h-10 duration-300 ease-in-out border rounded-full top-5 right-5 border-brand-off-white bg-blur group-hover:bg-brand-off-white">
                                  <svg class='w-4 h-4 duration-300 ease-in-out icon icon-arrow-right-corner text-brand-off-white group-hover:text-brand-teal'>
                                    <use xlink:href='#icon-arrow-right-corner'></use>
                                  </svg>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="w-full col lg:w-4/12">
                            <button class="relative flex items-center justify-center w-full mb-8 lg:hidden back" data-toggle-trigger-off="#menu-<?php echo $menu_item->ID; ?>">
                              <svg class='absolute left-0 w-5 h-5 top-[3px] icon text-brand-navy icon-arrow-left'>
                                <use xlink:href='#icon-arrow-left'></use>
                              </svg>
                              <span class="text-brand-teal hdg-5"><?php echo $menu_item->title; ?></span>
                            </button>
                            <ul class="relative">
                              <?php foreach ($menu_item->children as $key => $child_item) : ?>
                                <li class="border-b lg:mb-3 last:mb-0 border-brand-logo-blue lg:border-b-0">
                                  <?php if ($child_item->has_children) : ?>
                                    <button class="flex items-center justify-between w-full lg:px-4 py-3 overflow-hidden text-xl font-medium duration-300 ease-in-out rounded-sm grandchild-menu-trigger easy-toggle-fade-toggle group lg:bg-brand-teal-10 text-brand-navy lg:text-brand-blue-gray lg:hover:bg-brand-teal lg:hover:text-brand-off-white <?php echo $key === 0 ? 'grandchild-menu-trigger__first' : ''; ?>" data-toggle-class="is-open" data-toggle-target="#grandchild-menu-<?php echo $child_item->ID; ?>" aria-expanded="false" data-toggle-group="grandchild-menu-options-<?php echo $menu_item->ID; ?>">
                                      <?php echo $child_item->title; ?>
                                      <svg class='hidden w-4 h-4 duration-300 ease-in-out lg:block icon icon-chevron-right text-brand-navy group-hover:text-brand-off-white'>
                                        <use xlink:href='#icon-chevron-right'></use>
                                      </svg>
                                      <div class="block expand lg:hidden">
                                        <div class="duration-200 vertical"></div>
                                        <div class="horizontal"></div>
                                      </div>
                                    </button>
                                    <ul class="grandchild-menu hidden px-5 lg:px-0 lg:absolute top-0 w-full lg:left-[calc(2rem_+_100%)] group-[.is-open]:block pb-5" id="grandchild-menu-<?php echo $child_item->ID; ?>">
                                      <?php foreach ($child_item->children as $grandchild_item) : ?>
                                        <li class="mb-4 last:mb-0">
                                          <a class="flex items-center justify-between w-full duration-300 ease-in-out group hover:text-brand-teal text-brand-navy paragraph-default" href="<?php echo $grandchild_item->url; ?>" target="<?php echo $grandchild_item->target; ?>">
                                            <?php echo $grandchild_item->title; ?>
                                            <svg class='w-4 h-4 duration-300 ease-in-out icon icon-arrow-right-long text-brand-navy group-hover:text-brand-teal'>
                                              <use xlink:href='#icon-arrow-right-long'></use>
                                            </svg>
                                          </a>
                                        </li>
                                      <?php endforeach; ?>
                                    </ul>
                                  <?php else : ?>
                                    <a class="flex items-center justify-between w-full py-3 overflow-hidden text-xl font-medium duration-300 ease-in-out rounded-sm lg:px-4 grandchild-menu-trigger easy-toggle-fade-toggle group lg:bg-brand-teal-10 text-brand-navy lg:text-brand-blue-gray lg:hover:bg-brand-teal lg:hover:text-brand-off-white" href="<?php echo $child_item->url; ?>" target="<?php echo $child_item->target; ?>">
                                      <?php echo $child_item->title; ?>
                                    </a>
                                  <?php endif; ?>
                                </li>
                              <?php endforeach; ?>
                            </ul>
                          </div>

                        </div>
                        <button class="absolute cursor-default top-[calc(100%_+_2rem)] left-0 w-screen h-screen bg-brand-scrim opacity-50" data-toggle-trigger-off="#menu-<?php echo $menu_item->ID; ?>"></button>
                      </div>
                    </div>
                  <?php endif; ?>
                </li>
              <?php endforeach; ?>
            <?php endif; ?>
            <?php foreach ($global_primary_nav_links as $global_primary_nav_link) : ?>
              <li class="lg:mr-8 primary-menu-item last-of-type:mr-0">
                <a class="flex items-center justify-between w-full py-5 font-medium duration-300 ease-in-out border-b lg:border-0 lg:py-0 border-brand-logo-blue lg:justify-start paragraph-default text-brand-navy easy-toggle-fade-toggle primary-menu-item__button group hover:text-brand-teal" href="<?php echo $global_primary_nav_link['url']; ?>" <?php echo $global_primary_nav_link['target'] ? 'target="' . $global_primary_nav_link['target'] . '"' : '' ?>>
                  <?php echo $global_primary_nav_link['title']; ?>
                  <?php if ($global_primary_nav_link['target'] === '_blank') : ?>
                    <span class="sr-only"> (opens in new tab)</span>
                  <?php endif; ?>
                </a>
              </li>
            <?php endforeach; ?>
            <div class="relative z-0 block mt-8 overflow-hidden rounded-sm lg:hidden aspect-4/3 group mobile">
              <a href="<?php echo $global_nav_cta[0]['cta_url']; ?>" <?php echo $global_nav_cta[0]['cta_link_target'] ? 'target="_blank"' : ''; ?> class="absolute inset-0 z-30 w-full h-full "></a>
              <div class="absolute inset-0 z-10 w-full h-full duration-300 ease-in-out opacity-70 bg-brand-teal group-hover:opacity-100">
                <img class="w-full duration-300 ease-in-out opacity-0 group-hover:opacity-100" src="<?php echo get_template_directory_uri(); ?>/assets/img/nav-cta-wave.svg" alt="background wave graphic">
              </div>
              <div class="fit-image">
                <?php echo $global_nav_cta[0]['cta_image']; ?>
              </div>
              <div class="absolute inset-0 z-20 flex items-end w-full h-full px-8 py-6">
                <div class="w-10/12">
                  <p class="mb-2 text-white hdg-4">
                    <?php echo $global_nav_cta[0]['cta_title']; ?>
                  </p>
                  <p class="text-white paragraph-default">
                    <?php echo $global_nav_cta[0]['cta_text']; ?>
                  </p>
                </div>
                <div class="absolute flex items-center justify-center w-10 h-10 duration-300 ease-in-out border rounded-full top-5 right-5 border-brand-off-white bg-blur group-hover:bg-brand-off-white">
                  <svg class='w-4 h-4 duration-300 ease-in-out icon icon-arrow-right-corner text-brand-off-white group-hover:text-brand-teal'>
                    <use xlink:href='#icon-arrow-right-corner'></use>
                  </svg>
                </div>
              </div>
            </div>
          </div>
        </ul>
      </nav>
    </div>
  </div>
</header>
<div id="mobile-sticky-buttons" class="fixed bottom-0 hidden w-screen z-[80]">
  <?php if ($global_request_a_consultation_link) : ?>
    <a class="w-full mr-5 text-center !border-none primary-btn teal last:mr-0 lg:block" href="<?php echo $global_request_a_consultation_link['url']; ?>" <?php echo $global_request_a_consultation_link['target'] ? 'target="' . $global_request_a_consultation_link['target'] . '"' : '' ?>>
      <svg class="w-5 h-5 mb-[3px] mr-3 icon icon-arrow-right-long">
        <use xlink:href="#icon-arrow-right-long"></use>
      </svg>
      <?php echo $global_request_a_consultation_link['title']; ?>
      <?php if ($global_request_a_consultation_link['target'] === '_blank') : ?>
        <span class="sr-only"> (opens in new tab)</span>
      <?php endif; ?>
    </a>
  <?php endif; ?>
  <?php if ($global_try_virtual_consultation_link) : ?>
    <a class="w-full mr-5 text-center !border-none primary-btn dark-teal last:mr-0 lg:block" href="<?php echo $global_try_virtual_consultation_link['url']; ?>" <?php echo $global_try_virtual_consultation_link['target'] ? 'target="' . $global_try_virtual_consultation_link['target'] . '"' : '' ?>>
      <svg class="w-5 h-5 mb-[3px] mr-3 icon icon-arrow-right-long">
        <use xlink:href="#icon-arrow-right-long"></use>
      </svg>
      <?php echo $global_try_virtual_consultation_link['title']; ?>
      <?php if ($global_try_virtual_consultation_link['target'] === '_blank') : ?>
        <span class="sr-only"> (opens in new tab)</span>
      <?php endif; ?>
    </a>
  <?php endif; ?>
</div>
