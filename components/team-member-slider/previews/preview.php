<?php 
$component_data['content'] = '<h2>Testimonial Slider</h2>
'; 
$component_data['link'] = array (
  'title' => 'Link Here',
  'url' => 'http://dream-spa.local/events/weekly-on-mondays/',
  'target' => '',
); 
$component_data['team_members'] = array (
  0 => 629,
  1 => 633,
  2 => 632,
  3 => 631,
); 
?>
<?php ll_include_component('team-member-slider', $component_data, array("classes"=>array(),"id"=>"") );?>