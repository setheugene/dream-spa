<?php

LL_Wysiwyg()->add_format( array(
  'title' => 'Buttons & Links',
  'items' => array(
    array(
      'title'    => 'Primary Button - Teal',
      'classes'  => 'primary-btn teal',
      'selector' => 'a',
      'wrapper'  => false,
      'attributes' => array(
        'data-span' => "true"
      )
    ),
    array(
      'title'    => 'Primary Button - Glass',
      'classes'  => 'primary-btn glass',
      'selector' => 'a',
      'wrapper'  => false,
      'attributes' => array(
        'data-span' => "true"
      )
    ),
    array(
      'title'    => 'Primary Button - Ghost',
      'classes'  => 'primary-btn ghost',
      'selector' => 'a',
      'wrapper'  => false,
      'attributes' => array(
        'data-span' => "true"
      )
    ),
    array(
      'title'    => 'Secondary Button - Teal',
      'classes'  => 'secondary-btn teal',
      'selector' => 'a',
      'wrapper'  => false,
      'attributes' => array(
        'data-span' => "true"
      )
    ),
    array(
      'title'    => 'Secondary Button - White',
      'classes'  => 'secondary-btn white',
      'selector' => 'a',
      'wrapper'  => false,
      'attributes' => array(
        'data-span' => "true"
      )
    ),
    array(
      'title' => 'Button Group',
      'classes' => 'btn-group', // if changing class update line 15 of LL_Wysiwyg>plugins>buttonGroup>plugin.js to include your new class(es)
      'wrapper' => true,
      'block' => 'div',
    )
  )
) );
