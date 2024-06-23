<?php 
$component_data[''] = NULL; 
$component_data['heading_content'] = '<h2>Look Better Feel Better</h2>
'; 
$component_data['accordion_content'] = array (
  0 => 
  array (
    'accordion_title' => 'Content Title',
    'accordion_content' => '<p>Content here Content here Content here Content here Content here Content here Content here</p>
',
  ),
  1 => 
  array (
    'accordion_title' => 'Title Here',
    'accordion_content' => '<p>Content here Content here Content here Content here Content here Content here Content here</p>
',
  ),
); 
$component_data[''] = NULL; 
$component_data['cta_title'] = 'CTA title'; 
$component_data['cta_text'] = 'CTA Text'; 
$component_data['cta_link'] = 'http://dream-spa.local/blog/'; 
$component_data['cta_image'] = array (
  'image_id' => 368,
  'image_focus_point' => 'object-center',
  'image_fit' => 'object-cover',
  'image_loading' => true,
); 
?>
<?php ll_include_component('content-accordion', $component_data, array("classes"=>array(),"id"=>"") );?>