<?php

LL_Wysiwyg()->add_format( array(
  'title' => 'List Styles',
  'items' => array(
    array(
      'title'    => 'Checklist',
      'classes'  => 'list-checklist',
      'selector' => 'ul, ol',
      'wrapper'  => false,
    )
  )
) );
