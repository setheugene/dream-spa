<?php 
$component_data['content'] = '<h3>Featured Stories Component</h3>
'; 
$component_data['featured_story'] = array (
  0 => 
  array (
    'image' => 
    array (
      'image_id' => 667,
      'image_focus_point' => 'object-center',
      'image_fit' => 'object-cover',
      'image_loading' => true,
    ),
    'title' => 'Title',
    'text' => 'Text goes here',
    'link' => '',
  ),
  1 => 
  array (
    'image' => 
    array (
      'image_id' => 368,
      'image_focus_point' => 'object-center',
      'image_fit' => 'object-cover',
      'image_loading' => true,
    ),
    'title' => 'title',
    'text' => 'Text',
    'link' => '',
  ),
  2 => 
  array (
    'image' => 
    array (
      'image_id' => 47,
      'image_focus_point' => 'object-center',
      'image_fit' => 'object-cover',
      'image_loading' => true,
    ),
    'title' => 'Title ',
    'text' => 'Text about it all goes here',
    'link' => '',
  ),
); 
?>
<?php ll_include_component('featured-stories', $component_data, array("classes"=>array(),"id"=>"") );?>