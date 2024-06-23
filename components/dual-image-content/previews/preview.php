<?php 
$component_data[''] = NULL; 
$component_data['content'] = '<p class="hdg-6">Med Spa in the Boston Area</p>
<p class="hdg-1">Look Better Feel Better</p>
'; 
$component_data[''] = NULL; 
$component_data['left_image'] = array (
  'image_id' => 327,
  'image_focus_point' => 'object-center',
  'image_fit' => 'object-cover',
  'image_loading' => true,
); 
$component_data['right_image'] = array (
  'image_id' => 45,
  'image_focus_point' => 'object-center',
  'image_fit' => 'object-cover',
  'image_loading' => true,
); 
?>
<?php ll_include_component('dual-image-content', $component_data, array("classes"=>array(),"id"=>"") );?>