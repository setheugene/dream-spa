<?php 
$component_data['options'] = 'no-images'; 
$component_data['heading_content'] = '<h2>Heading Here</h2>
'; 
$component_data['cards'] = array (
  0 => 
  array (
    'image' => 
    array (
      'image_id' => false,
      'image_focus_point' => 'object-center',
      'image_fit' => false,
      'image_loading' => true,
    ),
    'heading' => 'Heading',
    'add_asterisk' => false,
    'content' => '<p>Sed in quam a dui malesuada ultricies id at lectus. Nam ac justo scelerisque, commodo augue ut, fermentum diam. Curabitur varius imperdiet sem at posuere. Duis sed bibendum leo. Vivamus auctor lorem non dolor suscipit, vel tincidunt diam condimentum. Nunc volutpat augue non leo semper lacinia et at nisi. Nunc semper, sem vitae dignissim hendrerit, lorem sem aliquet lacus, vel bibendum nisi sapien vitae ligula. Fusce eros augue, pretium eget consectetur nec, vehicula at justo. Proin posuere fringilla sapien eget efficitur. Quisque a elit eu ex maximus cursus. Morbi tristique vehicula bibendum.</p>
',
  ),
  1 => 
  array (
    'image' => 
    array (
      'image_id' => false,
      'image_focus_point' => 'object-center',
      'image_fit' => false,
      'image_loading' => true,
    ),
    'heading' => 'Heading',
    'add_asterisk' => false,
    'content' => '<p>Sed in quam a dui malesuada ultricies id at lectus. Nam ac justo scelerisque, commodo augue ut, fermentum diam. Curabitur varius imperdiet sem at posuere. Duis sed bibendum leo. Vivamus auctor lorem non dolor suscipit, vel tincidunt diam condimentum. Nunc volutpat augue non leo semper lacinia et at nisi. Nunc semper, sem vitae dignissim hendrerit, lorem sem aliquet lacus, vel bibendum nisi sapien vitae ligula. Fusce eros augue, pretium eget consectetur nec, vehicula at justo. Proin posuere fringilla sapien eget efficitur. Quisque a elit eu ex maximus cursus. Morbi tristique vehicula bibendum.</p>
',
  ),
); 
?>
<?php ll_include_component('scrolling-cards', $component_data, array("classes"=>array(),"id"=>"") );?>