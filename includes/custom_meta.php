<?php
add_action( 'admin_init', 'rw_register_meta_boxes' );
function rw_register_meta_boxes(){
$meta_boxes = array();
    $meta_boxes[] = array(
        'title' => __('slider option',DOMAIN_NAME),
        'pages' => array( 'slider' ),
        'fields' => array(

            array(
                'name' => __('URL slider',DOMAIN_NAME),
                'id' => 'url_slider',
                'type' => 'text',
            ),
            array(
                'name' => __('Target slider',DOMAIN_NAME),
                'id' => 'target_slider',
                'type' => 'select',
                'options' => array(
                    'normal' => __( 'normal', DOMAIN_NAME ),
                    'blank' => __( 'blank', DOMAIN_NAME ),
                ),
                'std' => 'normal',
            ),
        ));


    $meta_boxes[] = array(
        'title' => __('Arabic Thumbnail',DOMAIN_NAME),
        'pages' => array( 'slider' ),
        'context'    => 'side',
        'priority'   => 'low',
        'fields' => array(

            array(
                'id' => 'thumbnail_arabic',
                'type' => 'image_advanced',
                'max_file_uploads' => 1,
            ),
        ));



foreach ( $meta_boxes as $meta_box ){

new RW_Meta_Box( $meta_box );}

}

function rw_maybe_include( $conditions ) {

// Include in back-end only

if ( ! defined( 'WP_ADMIN' ) || ! WP_ADMIN ) {

return false;

}



// Always include for ajax

if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

return true;

}



if ( isset( $_GET['post'] ) ) {

$post_id = $_GET['post'];

}

elseif ( isset( $_POST['post_ID'] ) ) {

$post_id = $_POST['post_ID'];

}

else {

$post_id = false;

}



$post_id = (int) $post_id;

$post = get_post( $post_id );



foreach ( $conditions as $cond => $v ) {

// Catch non-arrays too

if ( ! is_array( $v ) ) {

$v = array( $v );

}



switch ( $cond ) {

case 'id':

if ( in_array( $post_id, $v ) ) {

return true;

}

break;

case 'parent':

$post_parent = $post->post_parent;

if ( in_array( $post_parent, $v ) ) {

return true;

}

break;

case 'slug':

$post_slug = $post->post_name;

if ( in_array( $post_slug, $v ) ) {

return true;

}

break;

case 'template':

$template = get_post_meta( $post_id, '_wp_page_template', true );

if ( in_array( $template, $v ) ) {

return true;

}

break;

}

}



// If no condition matched

return false;

}