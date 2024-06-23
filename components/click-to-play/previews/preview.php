<?php 
$component_data['content'] = '<p class="hdg-6">Keyword</p>
<p class="hdg-2">Heading Here</p>
<p>Content can go here content can go here  content can go here content can go here content can go here content can go here content can go here content can go here content can go here content can go here .</p>
'; 
$component_data['image'] = array (
  'image_id' => 327,
  'image_focus_point' => 'object-center',
  'image_fit' => 'object-cover',
  'image_loading' => true,
); 
$component_data['video_url'] = 'https://www.youtube.com/watch?v=eOSXGQMPiN0'; 
?>
<?php ll_include_component('click-to-play', $component_data, array("classes"=>array(),"id"=>"") );?>