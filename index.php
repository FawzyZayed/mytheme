<?php get_header(); ?>
<?php
$slider = new WP_Query(array('post_type'=>'slider') );
if($slider->have_posts()){
?>
<div id="slider" class="owl-carousel">
    <?php
    while ( $slider->have_posts() ) : $slider->the_post();
        $url_slider = get_post_meta( get_the_ID(), 'url_slider', true );
        $target = get_post_meta( get_the_ID(), 'target_slider', true );
        $target_value=($target=='blank') ? $target_value="target='_blank'" : NULL;
        ?>
        <?php if ( has_post_thumbnail() ) { ?>
            <div class="item">
                <?php
                if(!empty($url_slider)){ ?>
                    <a href="<?php echo $url_slider; ?>" <?php echo $target_value ?>><?php the_post_thumbnail('slider'); ?></a>
                    <?php
                }else{
                    the_post_thumbnail('slider');
                }
                ?>
            </div>

        <?php } ?>
    <?php endwhile;wp_reset_query(); ?>
</div>
<?php } ?>


<?php get_footer(); ?>
