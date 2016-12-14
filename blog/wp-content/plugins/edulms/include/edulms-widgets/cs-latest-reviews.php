<?php

/**
 * @latest reviews widget Class
 *
 *
 */
if ( ! class_exists( 'cs_reviews' ) ) { 
	class cs_reviews extends WP_Widget {	
	
	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
		 
	/**
	 * @init Reviews Module
	 *
	 *
	 */
	 
 
	public function __construct() {
		
		parent::__construct(
			'cs_reviews', // Base ID
			__( 'CS : Latest Reviews','edulms' ), // Name
			array( 'classname' => 'widget_reviews', 'description' => 'Select reviews list to show in widget', ) // Args
		);
	} 
	/**
	 * @Reviews html form
	 *
	 *
	 */
	 function form($instance) {
		$instance = wp_parse_args((array) $instance, array('title' => '' ));
		$title = $instance['title'];
		$showcount = isset($instance['showcount']) ? esc_attr($instance['showcount']) : '';
		?>
        <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"> Title:
            <input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
          </label>
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('showcount'); ?>">Number of Reviews:</label>
          <input class="upcoming" id="<?php echo $this->get_field_id('showcount'); ?>" size="2" name="<?php echo $this->get_field_name('showcount'); ?>" type="text" value="<?php echo esc_attr($showcount); ?>" />
        </p>
        <?php
 		}
		
		/**
		 * @Reviews Update form data
		 *
		 *
		 */
		 function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = $new_instance['title'];
			$instance['showcount'] = $new_instance['showcount'];
   			return $instance;
		}
		
		/**
		 * @Display Reviews widget
		 *
		 *
		 */
		 function widget($args, $instance) {
			extract($args, EXTR_SKIP);
			global $wpdb, $post;
			$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
			$showcount = isset($instance['showcount']) ? esc_attr($instance['showcount']) : '';
 			if (empty($showcount)) {
 				 $showcount = '4';
 			}
			// WIDGET display CODE Start
			echo $before_widget;
 			if (strlen($title) <> 1 || strlen($title) <> 0) {
 				echo $before_title . $title . $after_title;
 			}
  			if ($showcount <> '') {
				$reviews_args = array(
					'posts_per_page'	=> $showcount,
					'post_type'			=> 'cs-reviews',
					'post_status'		=> 'publish',
					'order'				=> 'ASC',
				);
				$reviews_query = new WP_Query($reviews_args);
				if ( $reviews_query->have_posts() <> "" ) {
                	while ( $reviews_query->have_posts() ): $reviews_query->the_post();	
						$var_cp_rating = get_post_meta($post->ID, "cs_reviews_rating", true);
						$var_cp_reviews_members = get_post_meta($post->ID, "cs_reviews_user", true);
						$var_cp_courses = get_post_meta($post->ID, "cs_reviews_course", true);
						?>
                        <article class="widget_instrector reviews-<?php echo absint($post->ID);?>">
                          <figure> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID', $var_cp_reviews_members)); ?>"> <?php echo get_avatar(get_the_author_meta('user_email', $var_cp_reviews_members), apply_filters('PixFill_author_bio_avatar_size', 60)); ?> </a> </figure>
                          <div class="left-sp"> <span><a href="<?php the_permalink(); ?>"><?php the_title();?></a></span>
                            <div class="cs-rating"><span class="rating-box" style="width:<?php echo $var_cp_rating*20;?>%"></span></div>
                          </div>
                        </article>
					<?php
				    endwhile;
                        }
                    }else{
                        if ( function_exists( 'fnc_no_result_found' ) ) { fnc_no_result_found(false); } 
                    }   
                    echo $after_widget; // WIDGET display CODE End
                }
            }
}
add_action('widgets_init', create_function('', 'return register_widget("cs_reviews");'));

?>