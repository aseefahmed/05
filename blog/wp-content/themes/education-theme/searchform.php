<?php 
/**
 * The template for displaying Search Form
 * @package LMS
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
 global $cs_theme_options
?>
<div class="cs-search-area">
    <form  method="get" action="<?php echo esc_url(home_url());?>"  role="search">
        <input name="s" placeholder="<?php  esc_attr_e('Enter Title, Keyword, Company','LMS');?>"  value="" type="text" />
        <?php if ( is_404() ) { ?>
         <label><input type="submit" class="btn cs-bg-color"  value="<?php esc_attr_e('Search', 'LMS'); ?>" />
         <i class="fa style-custom fa-search"></i></label>
		<?php } else { ?>
        	<label><input type="submit" class="btn cs-bg-color" value="<?php esc_attr_e('Search', 'LMS'); ?>" /><i class="fa style-custom fa-search"></i></label>
        <?php }?>
    </form>
</div>