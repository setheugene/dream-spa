<?php 
$component_data['heading_content'] = '<h2>Video Slider</h2>
'; 
$component_data['videos'] = array (
  0 => 
  array (
    'image' => 
    array (
      'image_id' => 327,
      'image_focus_point' => 'object-center',
      'image_fit' => 'object-cover',
      'image_loading' => true,
    ),
    'video_url' => 'https://www.youtube.com/watch?v=eOSXGQMPiN0',
  ),
  1 => 
  array (
    'image' => 
    array (
      'image_id' => 369,
      'image_focus_point' => 'object-center',
      'image_fit' => 'object-cover',
      'image_loading' => true,
    ),
    'video_url' => 'https://www.youtube.com/watch?v=eOSXGQMPiN0',
  ),
); 
?>
<?php ll_include_component('video-slider', $component_data, array("classes"=>array(),"id"=>"") );?>