<?php
define('DOMAIN_NAME','mytheme');
load_theme_textdomain( DOMAIN_NAME, TEMPLATEPATH.'/lang' );
define( 'RWMB_URL', trailingslashit( get_stylesheet_directory_uri() . '/meta' ) );
define( 'RWMB_DIR', trailingslashit( STYLESHEETPATH . '/meta' ) );
require_once RWMB_DIR . 'meta-box.php';
require_once('includes/navmenu.php');
require_once('includes/custom_meta.php');
require_once('includes/custom_meta_contacts.php');
require_once('includes/pagination.php');
require_once('includes/menu_class.php');
require_once('includes/reCaptcha.php');


add_theme_support( 'post-thumbnails' );
add_image_size( 'slider', 1700, 632, true );


add_action( 'init', 'set_up_menu' );
function set_up_menu() {

    $locations = array(
        'navbar' => __('Navbar',DOMAIN_NAME),
        'social' => __('social menu',DOMAIN_NAME),
    );
    register_nav_menus( $locations );

}

add_action( 'wp_enqueue_scripts', 'set_style' );
function set_style() {
    wp_enqueue_style( 'style', get_stylesheet_uri(),array(),NULL );
    if(is_rtl()){
        wp_enqueue_style( 'uikit', get_stylesheet_directory_uri() . '/css/uikit.min.rtl.css',array(),NULL );
    }else{
        wp_enqueue_style( 'uikit', get_stylesheet_directory_uri() . '/css/uikit.min.css',array(),NULL );
    }
    wp_enqueue_style( 'owl-carousel', get_stylesheet_directory_uri() . '/css/owl.carousel.min.css',array(),NULL );
    wp_enqueue_style( 'animate', get_stylesheet_directory_uri() . '/css/animate.css',array(),NULL );
    wp_enqueue_style( 'normalize', get_stylesheet_directory_uri() . '/css/normalize.min.css',array(),NULL );
    wp_enqueue_style( 'fancybox-min', get_stylesheet_directory_uri() . '/includes/fancybox/jquery.fancybox.min.css',array(),NULL );
    wp_enqueue_style( 'fancybox-buttons', get_stylesheet_directory_uri() . '/includes/fancybox/helpers/jquery.fancybox-buttons.min.css',array(),NULL );
    wp_enqueue_style( 'fancybox-thumbs', get_stylesheet_directory_uri() . '/includes/fancybox/helpers/jquery.fancybox-thumbs.min.css',array(),NULL );

    wp_enqueue_style( 'main', get_stylesheet_directory_uri() . '/css/main.css',array(),NULL );
    if(is_rtl()){
        wp_enqueue_style( 'rtl', get_stylesheet_directory_uri() . '/css/rtl.css',array(),NULL );
    }
    wp_enqueue_style( 'main-responsive', get_stylesheet_directory_uri() . '/css/main-responsive.css',array(),NULL );
}

add_action( 'wp_enqueue_scripts', 'set_scripts' );
function set_scripts(){
    wp_enqueue_script( 'jquery-2',get_stylesheet_directory_uri() . '/js/jquery-2.2.0.min.js',array(),NULL,false);
    wp_enqueue_script( 'modernizr', get_stylesheet_directory_uri() . '/js/modernizr.min.js',array(),NULL,false );
    wp_enqueue_script( 'uikit', get_stylesheet_directory_uri() . '/js/uikit.min.js', array(),'2.12.0',false );
    wp_enqueue_script( 'owl-carousel', get_stylesheet_directory_uri() . '/js/owl.carousel.min.js', array(),null,false );
    wp_enqueue_script( 'mousewheel', get_stylesheet_directory_uri() . '/js/jquery.mousewheel-3.0.6.pack.min.js', array(),NULL,false );
    wp_enqueue_script( 'fancybox', get_stylesheet_directory_uri() . '/includes/fancybox/jquery.fancybox.min.js', array(),"2.1.5",false );
    wp_enqueue_script( 'fancybox-buttons', get_stylesheet_directory_uri() . '/includes/fancybox/helpers/jquery.fancybox-buttons.min.js', array(),"1.0.5",false );
    wp_enqueue_script( 'fancybox-thumbs', get_stylesheet_directory_uri() . '/includes/fancybox/helpers/jquery.fancybox-thumbs.min.js', array(),"1.0.7",false );
    wp_enqueue_script( 'fancybox-media', get_stylesheet_directory_uri() . '/includes/fancybox/helpers/jquery.fancybox-media.min.js', array(),"1.0.6",false );
    wp_enqueue_script( 'script', get_stylesheet_directory_uri() . '/js/js.js', array(),NULL,false );
}
function load_custom_wp_admin_style() {
    wp_enqueue_style('custom_wp_admin_css', get_template_directory_uri() . '/css/admin-style.css', false, '1.0.0' );
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );


function set_up_post_types() {
    $labels_slider = array(
        'name'                => __( 'slider', DOMAIN_NAME ),
        'singular_name'       => __( 'slider', DOMAIN_NAME ),
        'menu_name'           => __( 'Slider', DOMAIN_NAME ),
        'parent_item_colon'   => __( 'Parent Slider:', DOMAIN_NAME ),
        'all_items'           => __( 'All Sliders', DOMAIN_NAME ),
    );
    register_post_type( 'slider', array(
        'labels'              => $labels_slider,
        'supports'            => array( 'title', 'thumbnail'),
        'hierarchical'        => false,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => false,
        'show_in_admin_bar'   => false,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
        'menu_icon'     => 'dashicons-images-alt2',
    ) );
    //Slider



}
add_action( 'init', 'set_up_post_types', 0 );



/*add_filter( 'wp_nav_menu_items', 'add_lang_link', 10, 2 );
function add_lang_link( $items, $args ) {
    if ($args->theme_location == 'navbar') {
        $items .='<li class="lang">'.ps_012_multilingual_list().'</li>';
    }

    return $items;
}*/

add_filter( 'wp_nav_menu_objects', 'qd_filter_menu_social', 10, 2 );
function qd_filter_menu_social( $objects, $args ) {
    if ($args->theme_location == 'social') {
        $count= count($objects);
        for($i=1;$i<=$count;$i++){
            $objects[$i]->title = '<i class="uk-icon-'.$objects[$i]->classes[0].'"></i>';
        }
    }
    return $objects;
}

if(is_rtl()){
    $lang='ar';
}else{
    $lang = 'en';
}

define('SITEKEY_RE','');
define('SECRET_RE','');
define('LANG_RE',$lang);

