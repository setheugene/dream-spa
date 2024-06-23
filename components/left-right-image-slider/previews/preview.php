<?php 
$component_data['background_color'] = 'bg-brand-off-white'; 
$component_data['content'] = '<h2>In the Boston Area.</h2>
'; 
$component_data['images'] = array (
  0 => 
  array (
    'image' => 
    array (
      'image_id' => 368,
      'image_focus_point' => 'object-center',
      'image_fit' => 'object-cover',
      'image_loading' => true,
    ),
  ),
  1 => 
  array (
    'image' => 
    array (
      'image_id' => 47,
      'image_focus_point' => 'object-center',
      'image_fit' => 'object-cover',
      'image_loading' => true,
    ),
  ),
); 
?>
<?php ll_include_component('left-right-image-slider', $component_data, array("classes"=>array(),"id"=>"") );?>