<?php 
$component_data['image'] = array (
  'image_id' => 368,
  'image_focus_point' => 'object-center',
  'image_fit' => 'object-cover',
  'image_loading' => true,
); 
$component_data['heading'] = array (
  'heading' => 
  array (
    'tag' => 'h2',
    'text' => 'Heading ',
  ),
); 
$component_data['list_items'] = array (
  0 => 
  array (
    'svg_icon' => 'Sparkles',
    'title' => 'Title',
    'description' => 'Description',
  ),
  1 => 
  array (
    'svg_icon' => 'Bandages',
    'title' => 'Title',
    'description' => 'Description',
  ),
  2 => 
  array (
    'svg_icon' => 'Injectable',
    'title' => 'Title',
    'description' => 'Description',
  ),
); 
?>
<?php ll_include_component('icon-list', $component_data, array("classes"=>array(),"id"=>"") );?>