<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package SKT Gravida
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>

</head>

<body <?php body_class(''); ?>>
	<div id="wrapper">
    	<div class="header">
        		<div class="site-aligner">
                	<div class="logo">
                            	<h2><a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a></h2>
                                <p><?php bloginfo('description'); ?></p>
                    </div><!-- logo -->
                    <div class="mobile_nav"><a href="#"><?php _e('Go To...','gravida'); ?></a></div>
                    <div class="site-nav">
                    		<?php wp_nav_menu(array('theme_location' => 'primary')); ?>
                    </div><!-- site-nav --><div class="clear"></div>
                </div><!-- site-aligner -->
        </div><!-- header -->
		<?php if ( is_home() || is_front_page() ) {?>
        <section id="home_slider">
					        
        	<?php
			$sldimages = ''; 
			$sldimages = array(
						'1' => get_template_directory_uri().'/images/slides/slider1.jpg',
						'2' => get_template_directory_uri().'/images/slides/slider2.jpg',
						'3' => get_template_directory_uri().'/images/slides/slider3.jpg',
						'4' => get_template_directory_uri().'/images/slides/slider1.jpg',
						'5' => get_template_directory_uri().'/images/slides/slider3.jpg',
			); ?>
            
        	<?php
			$slAr = array();
			$m = 0;
			for ($i=1; $i<6; $i++) {
				if ( get_theme_mod('slide_image'.$i, $sldimages[$i]) != "" ) {
					$imgSrc 	= get_theme_mod('slide_image'.$i, $sldimages[$i]);
					$imgTitle	= get_theme_mod('slide_title'.$i);
					$imgDesc	= get_theme_mod('slide_desc'.$i);
					$imgLink	= get_theme_mod('slide_link'.$i);
					if ( strlen($imgSrc) > 3 ) {
						$slAr[$m]['image_src'] = get_theme_mod('slide_image'.$i, $sldimages[$i]);
						$slAr[$m]['image_title'] = get_theme_mod('slide_title'.$i);
						$slAr[$m]['image_desc'] = get_theme_mod('slide_desc'.$i);
						$slAr[$m]['image_link'] = get_theme_mod('slide_link'.$i);
						$m++;
					}
				}
			}
			$slideno = array();
			if( $slAr > 0 ){
				$n = 0;?>
                <div class="slider-wrapper theme-default"><div id="slider" class="nivoSlider">
                <?php 
                foreach( $slAr as $sv ){
                    $n++; ?><img src="<?php echo esc_url($sv['image_src']); ?>" alt="<?php echo esc_attr($sv['image_title']);?>" title="<?php echo esc_attr('#slidecaption'.$n) ; ?>" /><?php
                    $slideno[] = $n;
                }
                ?>
                </div><?php
                foreach( $slideno as $sln ){ ?>
                    <div id="slidecaption<?php echo $sln; ?>" class="nivo-html-caption">
                    <div class="slide_info">
                            <h1><a href="<?php echo esc_url(get_theme_mod('slide_link'.$sln,'#link'.$sln)); ?>"><?php echo get_theme_mod('slide_title'.$sln, 'Slide Title'.$sln); ?></a></h1>
                            <p><?php echo get_theme_mod('slide_desc'.$sln, 'Slide Description'.$sln); ?></p>
                    </div>
                    </div><?php 
                } ?>
                </div>
                <div class="clear"></div><?php 
			}
            ?>
        </section>
        <?php } ?>
		