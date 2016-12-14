<?php
/**
 * The template for displaying home page.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package SKT Gravida
 */

get_header(); 
?>

<?php if ( 'page' == get_option( 'show_on_front' ) && ( '' != get_option( 'page_for_posts' ) ) && $wp_query->get_queried_object_id() == get_option( 'page_for_posts' ) ) : ?>

   
<div id="content">
    <div class="site-aligner">
        <section class="site-main content-left" id="sitemain">
        	 <div class="blog-post">
					<?php
                    if ( have_posts() ) :
                        // Start the Loop.
                        while ( have_posts() ) : the_post();
                            /*
                             * Include the post format-specific template for the content. If you want to
                             * use this in a child theme, then include a file called called content-___.php
                             * (where ___ is the post format) and that will be used instead.
                             */
                            get_template_part( 'content', get_post_format() );
                    
                        endwhile;
                        // Previous/next post navigation.
                        gravida_pagination();
                    
                    else :
                        // If no content, include the "No posts found" template.
                         get_template_part( 'no-results', 'index' );
                    
                    endif;
                    ?>
                    </div><!-- blog-post -->
             </section>
        <div class="sidebar_right">
        <?php get_sidebar();?>
        </div><!-- sidebar_right -->
        <div class="clear"></div>
    </div><!-- site-aligner -->
</div><!-- content -->

<?php else: ?>

		<div class="feature-box-main site-aligner">
        	<?php for($f=1; $f<5; $f++) { ?>
        	<?php if( get_theme_mod('page-setting'.$f)) { ?> 
            	<?php $queryvar = new WP_query('page_id='.get_theme_mod('page-setting'.$f,true)); ?>
                <?php while( $queryvar->have_posts() ) : $queryvar->the_post(); ?>
        		<div class="feature-box <?php if($f%4==0){ ?>last<?php } ?>">
                	<?php the_post_thumbnail(); ?>
                	<div class="feature-title"><?php the_title(); ?></div><!-- feature-title -->
                    <div class="feature-content"><?php echo gravida_content(18); ?></div>
                    <a href="<?php the_permalink(); ?>"><?php _e('Read More >','gravida'); ?></a>
                </div><!-- feature-box --><?php if($f%4==0) { ?><div class="clear"></div><?php } ?>
                <?php endwhile; ?>
                <?php wp_reset_query(); ?>
            <?php } else { ?>
            	<div class="feature-box <?php if($f%4==0){ ?>last<?php } ?>">
                	<img src="<?php echo get_template_directory_uri(); ?>/images/icon<?php echo $f; ?>.png" />
                	<div class="feature-title"><?php _e('Page Title','gravida'); ?> <?php echo $f; ?></div><!-- feature-title -->
                    <div class="feature-content"><?php _e('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc eget sapien nec eros ultricies eleifend non imperdiet tortor. Duis vulputate dignissim ante. Suspendisse vehicula quam vel pharetra molestie.','gravida'); ?></div>
                    <a href="#"><?php _e('Read More','gravida'); ?> ></a>
                </div><!-- feature-box --><?php if($f%4==0) { ?><div class="clear"></div><?php } ?>
            <?php } ?>
            <?php } ?>
        	
        </div>

	
            <section class="latest-blog">
                <div class="site-aligner">
                        <div class="section-title"><?php _e('Latest Blog','gravida'); ?></div>
                    		<div>
                            	<?php $k = 1; ?>
							<?php global $wp_query; ?>
                            	<?php while( $wp_query->have_posts() ) : $wp_query->the_post(); ?>                                
                                	<?php $k++; ?>
                            	<div class="one_fourth <?php if($k%4==0){?>last_column<?php } ?>">
                                		<p><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
                                        	<?php if( has_post_thumbnail() ) { ?>
												<?php the_post_thumbnail(); ?>
                                            <?php } else {  ?>
                                            	<img src="<?php echo get_template_directory_uri(); ?>/images/img_404.png" />
                                            <?php } ?>
                                            </a>
                                        </p>
				<div class="recent-post-title">
                		<a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </div>
				<div class="recent-meta"><?php echo get_the_date(); ?> | <?php comments_number(); ?></div>
				<p><?php echo gravida_content(25); ?></p>
<span><a href="<?php the_permalink(); ?>"><?php _e('Read More','gravida'); ?></a></span>
			</div><?php if($k%4==0){?><div class="clear"></div><?php } ?>
            	<?php endwhile; ?>
            		</div>                    
                    
                </div><div class="clear"></div>
            </section>

<?php endif; ?>


<?php get_footer(); ?>