<?php 
$component_data['image'] = array (
  'image_id' => 368,
  'image_focus_point' => 'object-center',
  'image_fit' => 'object-cover',
  'image_loading' => true,
); 
$component_data['content'] = '<p class="hdg-2">Why Patients Choose Dream Spa Medical</p>
'; 
$component_data['cards'] = array (
  0 => 
  array (
    'link' => 
    array (
      'title' => 'Click to Play',
      'url' => 'http://dream-spa.local/component/click-to-play/',
      'target' => '',
    ),
  ),
  1 => 
  array (
    'link' => 
    array (
      'title' => 'Paired Treatments',
      'url' => 'http://dream-spa.local/component/paired-treatments/',
      'target' => '',
    ),
  ),
  2 => 
  array (
    'link' => 
    array (
      'title' => 'Image Grid',
      'url' => 'http://dream-spa.local/component/image-grid/',
      'target' => '',
    ),
  ),
); 
?>
<?php ll_include_component('link-cards', $component_data, array("classes"=>array(),"id"=>"") );?>