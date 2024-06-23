<?php
add_filter( 'gform_disable_form_theme_css', '__return_true' );

/*
 * Change the submit button to be an actual button element rather
 * than input submit. This is so we can style the inputs the exact
 * same as other buttons, which often have pseudo elements that aren't
 * allowed on inputs
 */

function ll_custom_gform_submit( $submit_button, $form ) {
  if(!empty($form['cssClass'])) {
    if ( strpos( $form['cssClass'], 'form-skin' ) !== false || strpos( $form['cssClass'], 'inline-form' ) !== false ) {
      $submit_button = "<button class='primary-btn teal' id='gform_submit_button_{$form['id']}' type='submit'><svg class='w-5 h-5 mb-[3px] mr-3 icon icon-arrow-right-long'><use xlink:href='#icon-arrow-right-long'></use></svg>{$form['button']['text']}</button>";
    }
  }
  return $submit_button;
}
add_filter( 'gform_submit_button', 'll_custom_gform_submit', 10, 2 );

function ll_edit_choice_fields_markup( $field_content, $field ) {

  /*
   * Only continue if we're not on the form editor screen
   * and we're not on the entry screen. This is to ensure
   * we're only editing markup on the front end of the site
   */
  if ( $field->is_entry_detail() || $field->is_form_editor() )
    return $field_content;

  switch ( $field->type ) {
    case 'select':
      /*
       * Add a chevron icon right after select inputs
       */
      $field_content =  str_replace( '</select>', '</select><svg class="w-3 h-3 pointer-events-none fill-current text-brand-teal icon icon-chevron-down select-dropdown-arrow"><use xlink:href="#icon-chevron-down"></use></svg>' , $field_content );
      break;

      case 'address':
        $field_content = str_replace( '<select', '<span class="relative block"><select', $field_content );
        $field_content = str_replace( '</select>', '</select><svg class="w-3 h-3 pointer-events-none fill-current text-brand-teal icon icon-chevron-down select-dropdown-arrow"><use xlink:href="#icon-chevron-down"></use></svg></span>', $field_content);
        return $field_content;
      break;

      case 'fileupload' :
        $start = "<input name='input_{$field->id}' id='input_{$field->formId}_{$field->id}' type='file'";
        $end = "/>";
        $input_html = get_full_string( $field_content, $start, $end );
        $field_content = str_replace( $input_html, "<div class='relative'>".$input_html."<div class='ll-file-upload'><span>No File Chosen</span></div></div>", $field_content );
        break;

    /*
     * Add selected / unselected icons for radios and checkboxes
     */
    // case 'checkbox':
    //   if ( $field->choices ) {
    //     foreach( $field->choices as $field_choice ) {
    //       $field_content =  str_replace( "{$field_choice['text']}</label>", "<svg class='fill-current icon icon-checkbox'><use xlink:href='#icon-checkbox'></use></svg><svg class='fill-current icon icon-checkbox-checked'><use xlink:href='#icon-checkbox-checked'></use></svg>{$field_choice['text']}</label>" , $field_content );
    //     }

    //     return $field_content;
    //   }
    //   break;
    // case 'radio':
    //   if ( $field->choices ) {
    //     foreach( $field->choices as $field_choice ) {
    //       $field_content =  str_replace( "{$field_choice['text']}</label>", "<svg class='fill-current icon icon-radio'><use xlink:href='#icon-radio'></use></svg><svg class='fill-current icon icon-radio-selected'><use xlink:href='#icon-radio-selected'></use></svg>{$field_choice['text']}</label>" , $field_content );
    //     }

    //     return $field_content;
    //   }
    //   break;

    /*
     * Add selected / unselected icon for consent field
     */
    case 'consent' :
      $field_content =  str_replace( "{$field['checkboxLabel']}</label>", "<svg class='checkbox-unchecked' width='20' height='20' viewBox='0 0 23 23' fill='none' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' clip-rule='evenodd' d='M0.5 2C0.5 1.17157 1.17157 0.5 2 0.5H20C20.8284 0.5 21.5 1.17157 21.5 2V20C21.5 20.8284 20.8284 21.5 20 21.5H2C1.17157 21.5 0.5 20.8284 0.5 20V2ZM2 1.5C1.72386 1.5 1.5 1.72386 1.5 2V20C1.5 20.2761 1.72386 20.5 2 20.5H20C20.2761 20.5 20.5 20.2761 20.5 20V2C20.5 1.72386 20.2761 1.5 20 1.5H2Z' fill='#BCBCD0'/></svg><svg class='checkbox-checked' width='20' height='20' viewBox='0 0 23 23' fill='none' xmlns='http://www.w3.org/2000/svg'><rect width='20' height='20' fill='#CCCCCC'/><path d='M-1522 -4284C-1522 -4285.1 -1521.1 -4286 -1520 -4286H1616C1617.1 -4286 1618 -4285.1 1618 -4284V1393C1618 1394.1 1617.1 1395 1616 1395H-1520C-1521.1 1395 -1522 1394.1 -1522 1393V-4284Z' fill='#E6E6E6'/><path d='M-1520 -4276H1616V-4296H-1520V-4276ZM1608 -4284V1393H1628V-4284H1608ZM1616 1385H-1520V1405H1616V1385ZM-1512 1393V-4284H-1532V1393H-1512ZM-1520 1385C-1515.58 1385 -1512 1388.58 -1512 1393H-1532C-1532 1399.63 -1526.63 1405 -1520 1405V1385ZM1608 1393C1608 1388.58 1611.58 1385 1616 1385V1405C1622.63 1405 1628 1399.63 1628 1393H1608ZM1616 -4276C1611.58 -4276 1608 -4279.58 1608 -4284H1628C1628 -4290.63 1622.63 -4296 1616 -4296V-4276ZM-1520 -4296C-1526.63 -4296 -1532 -4290.63 -1532 -4284H-1512C-1512 -4279.58 -1515.58 -4276 -1520 -4276V-4296Z' fill='#B358D3'/><path d='M1 2C1 1.44772 1.44772 1 2 1H20C20.5523 1 21 1.44772 21 2V20C21 20.5523 20.5523 21 20 21H2C1.44772 21 1 20.5523 1 20V2Z' fill='#167593'/><path fill-rule='evenodd' clip-rule='evenodd' d='M0.5 2C0.5 1.17157 1.17157 0.5 2 0.5H20C20.8284 0.5 21.5 1.17157 21.5 2V20C21.5 20.8284 20.8284 21.5 20 21.5H2C1.17157 21.5 0.5 20.8284 0.5 20V2ZM2 1.5C1.72386 1.5 1.5 1.72386 1.5 2V20C1.5 20.2761 1.72386 20.5 2 20.5H20C20.2761 20.5 20.5 20.2761 20.5 20V2C20.5 1.72386 20.2761 1.5 20 1.5H2Z' fill='#167593'/><g clip-path='url(#clip0_492_7930)'><path d='M8.42779 15.7147C8.17035 15.7102 7.91722 15.6477 7.68722 15.532C7.45722 15.4163 7.25624 15.2502 7.09922 15.0461L5.2135 12.9118C5.138 12.8272 5.08006 12.7284 5.04303 12.6211C5.006 12.5139 4.99063 12.4004 4.99781 12.2872C5.00499 12.1739 5.03457 12.0633 5.08483 11.9616C5.1351 11.8599 5.20506 11.7692 5.29065 11.6947C5.46233 11.5459 5.68605 11.4714 5.91267 11.4874C6.13929 11.5035 6.35026 11.6089 6.49922 11.7804L8.26493 13.7776C8.28213 13.8023 8.30528 13.8223 8.33223 13.8358C8.35919 13.8493 8.3891 13.8558 8.41922 13.8547C8.44841 13.8554 8.47739 13.8496 8.50407 13.8378C8.53076 13.8259 8.55447 13.8083 8.5735 13.7861L15.5249 6.55185C15.6858 6.4072 15.8954 6.32871 16.1117 6.33214C16.328 6.33557 16.535 6.42065 16.6912 6.57033C16.8473 6.72 16.9412 6.9232 16.9538 7.13916C16.9664 7.35511 16.8969 7.56785 16.7592 7.73471L9.73065 15.1318C9.57037 15.3196 9.37029 15.4694 9.14493 15.5702C8.91958 15.671 8.6746 15.7204 8.42779 15.7147Z' fill='white'/></g><defs><clipPath id='clip0_492_7930'><rect width='20' height='20' fill='white' transform='translate(5 5)'/></clipPath></defs></svg>{$field['checkboxLabel']}</label>" , $field_content );
      return $field_content;
      break;

    default:
      break;
  }

  return $field_content;
}
add_filter( 'gform_field_content', 'll_edit_choice_fields_markup', 10, 2 );

/*
* Add class based on the field type to the fields parent wrapper
*/
add_filter( 'gform_field_css_class', 'add_gfield_type_class', 10, 3 );
function add_gfield_type_class( $classes, $field, $form ) {
  $classes .= ' ll_gfield_type_' . $field->type;
  return $classes;
}

/* Prevent page from jumping to top of form on submit
 * Note: This will also effect multipage forms and exceptions may need to be handled for
 * them
 * TODO : check if a form is multipaged and return something other than false
 */
if ( function_exists( 'gravity_form' ) ) {
  add_filter( 'gform_confirmation_anchor', '__return_false' );
}

add_action( 'gform_field_appearance_settings', 'll_add_radio_style_setting', 10, 2 );
function ll_add_radio_style_setting( $position, $form_id ) {
    if ( $position == 50 ) {
        ?>
        <li class="ll_radio_style_setting field_setting">
            <label for="field_ll_radio_style_value">
              <?php _e("Radio Style", "ll"); ?>
            </label>
            <select id="field_ll_radio_style_value" onchange="SetFieldProperty('llRadioStyle', this.value);">
              <option value="ll-radio-style--default">Default</option>
              <option value="ll-radio-style--buttons">Buttons</option>
            </select>

        </li>
        <?php
    }
}

// Show the appearance setting on radio and checkbox fields
add_action( 'gform_editor_js', 'll_editor_script' );
function ll_editor_script(){
    ?>
    <script type='text/javascript'>
        //adding setting to fields of type "text"
        fieldSettings.radio += ', .ll_radio_style_setting';
        //binding to the load field settings event to initialize the checkbox
        jQuery(document).on('gform_load_field_settings', function(event, field, form){
            jQuery( '#field_ll_radio_style_value' ).val( rgar( field, 'llRadioStyle' ) );
        });
    </script>
    <?php
}

// add class to field if setting is checked
add_filter( 'gform_field_css_class', 'll_radio_style_field', 10, 3 );
function ll_radio_style_field( $classes, $field, $form ) {
    $classes .= ' ' . $field['llRadioStyle'];
    return $classes;
}
