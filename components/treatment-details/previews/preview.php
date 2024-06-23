<?php 
$component_data[''] = NULL; 
$component_data['image'] = array (
  'image_id' => 48,
  'image_focus_point' => 'object-center',
  'image_fit' => 'object-cover',
  'image_loading' => true,
); 
$component_data['card_title'] = 'Card Title'; 
$component_data['card_list'] = array (
  0 => 
  array (
    'list_item' => 'List Item',
  ),
  1 => 
  array (
    'list_item' => 'List Item',
  ),
  2 => 
  array (
    'list_item' => 'List Item',
  ),
  3 => 
  array (
    'list_item' => 'List Item',
  ),
); 
$component_data[''] = NULL; 
$component_data['cards'] = array (
  0 => 
  array (
    'title' => 'Card Title',
    'text' => 'Card Text',
    'icon' => 
    array (
      'svg_icon' => 'Briefcase',
    ),
  ),
  1 => 
  array (
    'title' => 'Title',
    'text' => 'Text',
    'icon' => 
    array (
      'svg_icon' => 'Bullet-List',
    ),
  ),
  2 => 
  array (
    'title' => 'Title',
    'text' => 'Text',
    'icon' => 
    array (
      'svg_icon' => 'Clock',
    ),
  ),
); 
?>
<?php ll_include_component('treatment-details', $component_data, array("classes"=>array(),"id"=>"") );?>