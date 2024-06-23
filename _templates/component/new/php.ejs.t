---
to: components/<%= h.changeCase.paramCase(name) %>/<%= h.changeCase.paramCase(name) %>.php
---
<?php
/**
* <%= name %>
* -----------------------------------------------------------------------------
*
* <%= name %> component
*/

/**
 * Any additional classes to apply to the main component container.
 *
 * @var array
 * @see args['classes']
 */
$classes = ( isset( $component_args['classes'] ) ? $component_args['classes'] : array() );

/**
 * ID to apply to the main component container.
 *
 * @var array
 * @see args['id']
 */
$component_id   = ( isset( $component_args['id'] ) ? $component_args['id'] : false );
?>

<?php
$defaults = [
];

$component_data = ll_parse_args( $component_data, $defaults );
?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="<%= h.changeCase.paramCase(name) %> <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="<%= h.changeCase.paramCase(name) %>">

</section>
