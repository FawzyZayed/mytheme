<?php
global $meta_boxes;
$meta_boxes = array();

$meta_boxes[] = array(
    'title' => __('Page Option',DOMAIN_NAME),
    'pages' => array( 'page' ),
    'fields' => array(
        array(
            'id'=>'showmap',
            'type'=>'select',
            'name'=>__('Show Map',DOMAIN_NAME),
            'options' => array(
                'on' => __( 'on', DOMAIN_NAME ),
                'off' => __( 'off', DOMAIN_NAME ),
            ),
            'std' => 'on',
        ),
        array(
            'id' => 'address',
            'name' => __( 'Address', DOMAIN_NAME ),
            'type' => 'text',
            'std' => __( 'Riyadh Saudi Arabia', DOMAIN_NAME ),
        ),
        array(
            'id' => 'loc',
            'name' => __( 'Location', DOMAIN_NAME ),
            'type' => 'map',
            'std' => '24.633333,46.71666700000003,15',
            'style' => 'width: 100%; height: 500px',
            'address_field' => 'address',
        ),
        array(
            'id' => 'tel',
            'name' => __( 'Telephone', DOMAIN_NAME ),
            'type' => 'text',
        ),
        array(
            'id' => 'mob1',
            'name' => __( 'Mobile 1', DOMAIN_NAME ),
            'type' => 'text',
        ),
        array(
            'id' => 'mob2',
            'name' => __( 'Mobile2', DOMAIN_NAME ),
            'type' => 'text',
        ),
        array(
            'id' => 'site',
            'name' => __( 'Site', DOMAIN_NAME ),
            'type' => 'text',
        ),


    ));
/**
 * Register meta boxes
 *
 * @return void
 */
function rw_register_meta_boxes3()
{
    global $meta_boxes;
// Make sure there's no errors when the plugin is deactivated or during upgrade
    if ( ! class_exists( 'RW_Meta_Box' ) )
        return;
// Register meta boxes only for some posts/pages
    if ( ! rw_maybe_include3() )
        return;
    foreach ( $meta_boxes as $meta_box )
    {
        new RW_Meta_Box( $meta_box );
    }
}
add_action( 'admin_init', 'rw_register_meta_boxes3' );
/**
 * Check if meta boxes is included
 *
 * @return bool
 */
function rw_maybe_include3()
{
// Include in back-end only
    if ( ! defined( 'WP_ADMIN' ) || ! WP_ADMIN )
        return false;
// Always include for ajax
    if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
        return true;
// Check for post IDs
    $checked_post_IDs = array( 7 );
    if ( isset( $_GET['post'] ) )
        $post_id = intval( $_GET['post'] );
    elseif ( isset( $_POST['post_ID'] ) )
        $post_id = intval( $_POST['post_ID'] );
    else
        $post_id = false;
    $post_id = (int) $post_id;
    if ( in_array( $post_id, $checked_post_IDs ) )
        return true;
// Check for page template
    $checked_templates = array(  );
    $template = get_post_meta( $post_id, '_wp_page_template', true );
    if ( in_array( $template, $checked_templates ) )
        return true;
// If no condition matched
    return false;
}