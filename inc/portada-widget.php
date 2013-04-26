<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ba01000660
 * Date: 26/04/13
 * Time: 12:22 PM
 * To change this template use File | Settings | File Templates.
 */

class Portada_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'noticias_portada',
            'Noticias Portada',
            array('description' => __('Noticias de Portada'))
        );
    }

    public function form( $instance ) {
        $title = (isset( $instance[ 'title' ])) ? $instance['title' ] : 'Noticias Portada';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' );
            ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
    <?php
    }
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = strip_tags( $new_instance['title'] );
        return $instance;
    }

    public function widget($args, $instance)
    {
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
        echo $before_widget;
        if ( ! empty( $title ) ) echo $before_title . $title .  $after_title;
        $args= array(
            'category_name' => 'cultura',
            'posts_per_page' => 1
        );

        $featuredWidget = new WP_Query($args);
        while ( $featuredWidget->have_posts() ) :
            $featuredWidget->the_post(); ?>
            <div class="widget_featured">
                <div class="thumb"><?php print get_the_post_thumbnail($post->ID); ?></div>
                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <?php the_excerpt(); ?>
            </div>
        <?php
        endwhile;
        wp_reset_postdata();
        echo $after_widget;
    }
}

register_widget('Portada_Widget');
