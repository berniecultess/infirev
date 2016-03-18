<?php
/**
 * Template: Header.php
 *
 * @package EvoLve
 * @subpackage Template
 */
?>
<!DOCTYPE html>
<!--BEGIN html-->
<html <?php language_attributes(); ?>>
    <!--BEGIN head-->
    <head>

        <?php
        $evolve_favicon = evolve_get_option('evl_favicon');
        if ($evolve_favicon) {
            ?>
            <!-- Favicon -->
            <!-- Firefox, Chrome, Safari, IE 11+ and Opera. -->
            <link href="<?php echo $evolve_favicon; ?>" rel="icon" type="image/x-icon" />
        <?php } ?>

        <!-- Meta Tags -->
        <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <?php wp_head(); ?>

        <!--[if lt IE 9]>
                <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/ie.css">
        <![endif]-->

    </head><!--END head-->

    <!--BEGIN body-->
    <body <?php body_class(); ?>>
        <?php
        $evolve_custom_background = evolve_get_option('evl_custom_background', '1');
        if ($evolve_custom_background == "1") {
            ?>
            <div id="wrapper">
            <?php } ?>
            <div id="top"></div>
            <!--BEGIN .header-pattern-->
            <div class="header-pattern">
                <!--BEGIN .header-border-->
                <div class="header-border<?php
                $evolve_width_layout = evolve_get_option('evl_width_layout', 'fixed');
                if (get_header_image()) {
                    echo ' custom-header';
                }
                ?>">
                    <!--BEGIN .header-->
                    <div class="header">
                        <!--BEGIN .container-header-->
                        <div class="container container-header">
                            <!--BEGIN #righttopcolumn-->
                            <div id="righttopcolumn">
                                <?php
                                $evolve_social_links = evolve_get_option('evl_social_links', '1');
                                if ($evolve_social_links == "1") {
                                    ?>
                                    <!--BEGIN #subscribe-follow-->
                                    <div id="social">
                                        <?php
                                        get_template_part('social-buttons', 'header');                                        
                                        ?>                                        
                                    </div>
                                    <!--END #subscribe-follow-->
                                <?php } ?>

                                <!--BEGIN #Woocommerce-->
                                <?php
								$woocommerce_cart_link_main_nav = evolve_get_option('evl_woocommerce_cart_link_main_nav', '0'); 
                                if (class_exists('Woocommerce') && $woocommerce_cart_link_main_nav) {
                                    global $woocommerce;									
                                    ?>
                                    <span class="woocommerce-menu-holder">
                                        <ul class="woocommerce-menu">
                                            <?php $woocommerce_acc_link_main_nav = evolve_get_option('evl_woocommerce_acc_link_main_nav', '0'); ?>
                                            <?php if ($woocommerce_acc_link_main_nav): ?>
                                                <li class="my-account">
                                                    <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>" class="my-account-link"><?php _e('My Account', 'evolve'); ?></a>
                                                    <?php if (!is_user_logged_in()): ?>
                                                        <div class="login-box">
                                                            <form action="<?php echo wp_login_url(); ?>" name="loginform" method="post">
                                                                <p>
                                                                    <input type="text" class="input-text" name="log" id="username" value="" placeholder="<?php echo __('Username', 'evolve'); ?>" />
                                                                </p>
                                                                <p>
                                                                    <input type="password" class="input-text" name="pwd" id="pasword" value="" placeholder="<?php echo __('Password', 'evolve'); ?>" />
                                                                </p>
                                                                <p class="forgetmenot">
                                                                    <label for="rememberme"><input name="rememberme" type="checkbox" id="rememberme" value="forever"> <?php _e('Remember Me', 'evolve'); ?></label>
                                                                </p>
                                                                <p class="submit">
                                                                    <input type="submit" name="wp-submit" id="wp-submit" class="button small default comment-submit" value="<?php _e('Log In', 'evolve'); ?>">
                                                                    <input type="hidden" name="redirect_to" value="<?php echo $_SERVER['HTTP_REFERER']; ?>">
                                                                    <input type="hidden" name="testcookie" value="1">
                                                                </p>
                                                                <div class="clear"></div>
                                                            </form>
                                                        </div>
                                                    <?php else: ?>
                                                        <ul class="sub-menu">
                                                            <li><a href="<?php echo wp_logout_url(get_permalink()); ?>"><?php _e('Logout', 'evolve'); ?></a></li>
                                                        </ul>
                                                    <?php endif; ?>
                                                </li><!-- /li.my-account -->
                                            <?php endif; //if($woocommerce_acc_link_main_nav):   ?>
                                            <?php $woocommerce_cart_link_main_nav = evolve_get_option('evl_woocommerce_cart_link_main_nav', '0'); ?>
                                            <?php if ($woocommerce_cart_link_main_nav): ?>
                                                <li class="cart">
                                                    <?php if (!$woocommerce->cart->cart_contents_count): ?>
                                                        <a class="empty-cart" href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>">
                                                            <?php echo woocommerce_price($woocommerce->cart->cart_contents_total); ?>
                                                        </a>
                                                        <ul class="sub-menu">
                                                            <li>
                                                                <div class="cart-contents">
                                                                    <div class="cart-content">
                                                                        <strong style="padding:7px 10px;line-height:35px;">
                                                                            <?php _e('Your cart is currently empty.', 'evolve'); ?>
                                                                        </strong>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    <?php else: ?>
                                                        <a class="my-cart-link my-cart-link-active" href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>">
                                                            <?php echo woocommerce_price($woocommerce->cart->cart_contents_total); ?>
                                                        </a>
                                                        <div class="cart-contents">
                                                            <?php foreach ($woocommerce->cart->cart_contents as $cart_item): //var_dump($cart_item);  ?>
                                                                <div class="cart-content">
                                                                    <a href="<?php echo get_permalink($cart_item['product_id']); ?>">
                                                                        <?php $thumbnail_id = ($cart_item['variation_id']) ? $cart_item['variation_id'] : $cart_item['product_id']; ?>
                                                                        <?php echo get_the_post_thumbnail($thumbnail_id, 'recent-works-thumbnail'); ?>
                                                                        <div class="cart-desc">
                                                                            <span class="cart-title"><?php echo $cart_item['data']->post->post_title; ?></span>
                                                                            <span class="product-quantity">
                                                                                <?php echo $cart_item['quantity']; ?> x <?php echo $woocommerce->cart->get_product_subtotal($cart_item['data'], $cart_item['quantity']); ?>
                                                                            </span>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            <?php endforeach; ?>
                                                            <div class="cart-checkout">
                                                                <div class="cart-link">
                                                                    <a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>"><?php _e('View Cart', 'evolve'); ?></a>
                                                                </div>
                                                                <div class="checkout-link">
                                                                    <a href="<?php echo get_permalink(get_option('woocommerce_checkout_page_id')); ?>"><?php _e('Checkout', 'evolve'); ?></a>
                                                                </div>
                                                            </div>
                                                        </div><!-- /.cart-contents -->
                                                    <?php endif; //if(!$woocommerce->cart->cart_contents_count):    ?>
                                                </li><!-- /li.cart -->
                                            <?php endif; //if($woocommerce_cart_link_main_nav):    ?>
                                        </ul><!-- /ul.woocommerce-menu -->
                                    </span><!-- /span .woocommerce-menu-holder -->
                                <?php } ?>
                                <!--END #Woocommerce-->
                            </div>
                            <!--END #righttopcolumn-->

                            <?php
                            $evolve_pos_logo = evolve_get_option('evl_pos_logo', 'left');
                            if ($evolve_pos_logo == "disable") {
                                
                            } else {
                                $evolve_header_logo = evolve_get_option('evl_header_logo', '');
                                if ($evolve_header_logo) {
                                    if ($evolve_pos_logo == "center") {

                                        echo "<div class='header-logo-container clearfix'><a href=" . home_url() . "><img id='logo-image' class='img-responsive' src=" . $evolve_header_logo . " /></a></div>";
                                    } else {
                                        echo "<div class='header-logo-container'><a href=" . home_url() . "><img id='logo-image' class='img-responsive' src=" . $evolve_header_logo . " /></a></div>";
                                    }
                                }
                            }
                            ?>
                            <!--BEGIN .title-container-->
                            <div class="title-container <?php
                            if (($evolve_pos_logo == "center" ) && ($evolve_header_logo != "")) {
                                echo "clearfix";
                            } elseif ($evolve_pos_logo == "center") {
                                echo "clearfix";
                            }
                            ?>">
                                     <?php
                                     $tagline = '<div id="tagline">' . get_bloginfo('description') . '</div>';
                                     $evolve_tagline_pos = evolve_get_option('evl_tagline_pos', 'next');
                                     if (($evolve_tagline_pos !== "disable") && ($evolve_tagline_pos == "above")) {
                                         echo $tagline;
                                     }
                                     $evolve_blog_title = evolve_get_option('evl_blog_title', '0');
                                     if ($evolve_blog_title == "0" || !$evolve_blog_title) {
                                         ?>
                                    <div id="logo"><a href="<?php echo home_url(); ?>"><?php bloginfo('name') ?></a></div>
                                    <?php
                                } else {
                                    
                                }
                                if (($evolve_tagline_pos !== "disable") && (($evolve_tagline_pos == "") || ($evolve_tagline_pos == "next") || ($evolve_tagline_pos == "under"))) {
                                    echo $tagline;
                                }
                                ?>                        
                            </div>
                            <!--END .title-container-->
                        </div>
                        <!--END .container-header-->
                    </div>
                    <!--END .header-->
                </div>
                <!--END .header-border-->
            </div>
            <!--END .header-pattern-->
            <div class="menu-container">
                <?php
                $evolve_menu_background = evolve_get_option('evl_disable_menu_back', '1');
                $evolve_width_layout = evolve_get_option('evl_width_layout', 'fixed');
                if ($evolve_width_layout == "fluid" && $evolve_menu_background == "1") {
                    ?>
                    <div class="fluid-width">
                    <?php } ?>
                    <div class="menu-header">
                        <!--BEGIN .container-menu-->
                        <div class="container nacked-menu container-menu">
                            <?php
                            $evolve_main_menu = evolve_get_option('evl_main_menu', '0');
                            if ($evolve_main_menu == "1") {
                                ?>
                                <br /><br />
                            <?php } else { ?>
                                <div class="primary-menu">
                                    <?php
                                    if (has_nav_menu('primary-menu')) {
                                        echo '<nav id="nav" class="nav-holder link-effect">';
                                        wp_nav_menu(array('theme_location' => 'primary-menu', 'menu_class' => 'nav-menu', 'fallback_cb' => 'wp_page_menu', 'walker' => new evolve_Walker_Nav_Menu()));
                                    } else {
                                        ?>
                                        <nav id="nav" class="nav-holder">
                                            <?php
                                            wp_nav_menu(array('theme_location' => 'primary-menu', 'menu_class' => 'nav-menu', 'fallback_cb' => 'wp_page_menu'));
                                        }
                                        ?>
                                    </nav>
                                </div><!-- /.primary-menu -->
                                <?php
                                $evolve_searchbox = evolve_get_option('evl_searchbox', '1');
                                if ($evolve_searchbox == "1") {
                                    ?>
                                    <!--BEGIN #searchform-->
                                    <form action="<?php echo home_url(); ?>" method="get" class="searchform">
                                        <div id="search-text-box">
                                            <label class="searchfield" id="search_label_top" for="search-text-top"><input id="search-text-top" type="text" tabindex="1" name="s" class="search" placeholder="<?php _e('Type your search', 'evolve'); ?>" /></label>
                                        </div>
                                    </form>
                                    <div class="clearfix"></div>
                                    <!--END #searchform-->
                                    <?php
                                }
                                $evolve_sticky_header = evolve_get_option('evl_sticky_header', '1');
                                if ($evolve_sticky_header == "1") {
                                    // sticky header
                                    get_template_part('sticky-header');
                                }
                                ?>
                            <?php } ?>
                        </div><!-- /.container -->
                    </div><!-- /.menu-header -->
                    <div class="menu-back">
                        <?php
                        // LayerSlider
                        $evolve_slider_page_id = '';
                        if (!empty($post->ID)) {
                            if (!is_home() && !is_front_page() && !is_archive()) {
                                $evolve_slider_page_id = $post->ID;
                            }
                            if (!is_home() && is_front_page()) {
                                $evolve_slider_page_id = $post->ID;
                            }
                        }
                        if (is_home() && !is_front_page()) {
                            $evolve_slider_page_id = get_option('page_for_posts');
                        }
                        if (get_post_meta($evolve_slider_page_id, 'evolve_slider_type', true) == 'layer'):
                            $evolve_layerslider = evolve_get_option('evl_layerslider', '1');
                            if ($evolve_layerslider == "1"):
                                evolve_layerslider();
                            endif;
                        endif;

                        // Revolution Slider
                        if (get_post_meta($evolve_slider_page_id, 'evolve_slider_type', true) == 'rev' && get_post_meta($evolve_slider_page_id, 'evolve_revslider', true) && function_exists('putRevSlider')) {
                            putRevSlider(get_post_meta($evolve_slider_page_id, 'evolve_revslider', true));
                        }

                        // FlexSlider
                        // $flexslider_number = evolve_get_option('evl_flexslider_number', '5');
                        // if (get_post_meta($evolve_slider_page_id, 'evolve_slider_type', true) == 'flex' && (get_post_meta($evolve_slider_page_id, 'evolve_wooslider', true) || get_post_meta($evolve_slider_page_id, 'evolve_wooslider', true) != 0)) {
                            // echo do_shortcode('[wooslider slide_page="' . get_post_meta($evolve_slider_page_id, 'evolve_wooslider', true) . '" slider_type="slides" limit="' . $flexslider_number . '"]');
                        // }
						 // Theme4press Slider
                        if (get_post_meta($evolve_slider_page_id, 'evolve_slider_type', true) == 'flex' && (get_post_meta($evolve_slider_page_id, 'evolve_wooslider', true) || get_post_meta($evolve_slider_page_id, 'evolve_wooslider', true) != 0)) {			
							evolve_wooslider(get_post_meta($evolve_slider_page_id, 'evolve_wooslider', true));							
							evolve_woosliderfunc(get_post_meta($evolve_slider_page_id, 'evolve_wooslider', true));
                        }

                        // Bootstrap Slider
                        $evolve_slider_page_id = '';
                        $evolve_bootstrap = evolve_get_option('evl_bootstrap_slider', 'homepage');
                        if (!empty($post->ID)) {
                            if (!is_home() && !is_front_page() && !is_archive()) {
                                $evolve_slider_page_id = $post->ID;
                            }
                            if (!is_home() && is_front_page()) {
                                $evolve_slider_page_id = $post->ID;
                            }
                        }
                        if (is_home() && !is_front_page()) {
                            $evolve_slider_page_id = get_option('page_for_posts');
                        }
                        if (get_post_meta($evolve_slider_page_id, 'evolve_slider_type', true) == 'bootstrap' || ($evolve_bootstrap == "homepage" && is_front_page()) || $evolve_bootstrap == "all"):
                            evolve_bootstrap();
                        endif;

                        // Parallax Slider
                        $evolve_slider_page_id = '';
                        $evolve_parallax = evolve_get_option('evl_parallax_slider', 'homepage');
                        if (!empty($post->ID)) {
                            if (!is_home() && !is_front_page() && !is_archive()) {
                                $evolve_slider_page_id = $post->ID;
                            }
                            if (!is_home() && is_front_page()) {
                                $evolve_slider_page_id = $post->ID;
                            }
                        }
                        if (is_home() && !is_front_page()) {
                            $evolve_slider_page_id = get_option('page_for_posts');
                        }
                        if (get_post_meta($evolve_slider_page_id, 'evolve_slider_type', true) == 'parallax' || ($evolve_parallax == "homepage" && is_front_page()) || $evolve_parallax == "all"):
                            $evolve_parallax_slider = evolve_get_option('evl_parallax_slider_support', '1');
                            if ($evolve_parallax_slider == "1"):
                                evolve_parallax();
                            endif;
                        endif;

                        // Posts Slider
                        $evolve_posts_slider = evolve_get_option('evl_posts_slider', 'post');
                        if (get_post_meta($evolve_slider_page_id, 'evolve_slider_type', true) == 'posts' || ($evolve_posts_slider == "homepage" && is_front_page()) || $evolve_posts_slider == "all"):
                            $evolve_carousel_slider = evolve_get_option('evl_carousel_slider', '1');
                            if ($evolve_carousel_slider == "1"):
                                evolve_posts_slider();
                            endif;
                        endif;

                        $evolve_width_layout = evolve_get_option('evl_width_layout', 'fixed');
                        if ($evolve_width_layout == "fluid") {
                            ?>
                            <div class="container">
                                <?php
                            }
                            $evolve_header_widgets_placement = evolve_get_option('evl_header_widgets_placement', 'home');
                            $evolve_widget_this_page = get_post_meta(isset($post->ID), 'evolve_widget_page', true);
                            if (((is_home() || is_front_page()) && $evolve_header_widgets_placement == "home") || (is_single() && $evolve_header_widgets_placement == "single") || (is_page() && $evolve_header_widgets_placement == "page") || ($evolve_header_widgets_placement == "all") || ($evolve_widget_this_page == "yes" && $evolve_header_widgets_placement == "custom")) {
                                $evolve_widgets_header = evolve_get_option('evl_widgets_header', 'disable');
                                // if Header widgets exist
                                if (($evolve_widgets_header == "") || ($evolve_widgets_header == "disable")) {
                                    
                                } else {
                                    $evolve_header_css = '';
                                    if ($evolve_widgets_header == "one") {
                                        $evolve_header_css = 'widget-one-column col-sm-6';
                                    }
                                    if ($evolve_widgets_header == "two") {
                                        $evolve_header_css = 'col-sm-6 col-md-6';
                                    }
                                    if ($evolve_widgets_header == "three") {
                                        $evolve_header_css = 'col-sm-6 col-md-4';
                                    }
                                    if ($evolve_widgets_header == "four") {
                                        $evolve_header_css = 'col-sm-6 col-md-3';
                                    }
                                    ?>
                                    <div class="container">
                                        <div class="header-widgets">
                                            <div class="widgets-back-inside">
                                                <div class="<?php echo $evolve_header_css; ?>">
                                                    <?php if (!dynamic_sidebar('header-1')) : ?>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="<?php echo $evolve_header_css; ?>">
                                                    <?php if (!dynamic_sidebar('header-2')) : ?>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="<?php echo $evolve_header_css; ?>">
                                                    <?php if (!dynamic_sidebar('header-3')) : ?>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="<?php echo $evolve_header_css; ?>">
                                                    <?php if (!dynamic_sidebar('header-4')) : ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.container -->
                                    <?php
                                }
                            } else {
                                
                            }
                            ?>
                        </div><!-- /.container -->
                    </div><!--/.menu-back-->
                    <?php
                    $evolve_width_layout = evolve_get_option('evl_width_layout', 'fixed');
                    if ($evolve_width_layout == "fluid") {
                        ?>
                    </div><!-- /.fluid-width -->
                <?php } ?>
                <!--BEGIN .content-->
                <div class="content <?php semantic_body(); ?>">
                    <?php if (is_page_template('contact.php')): ?>
                        <div class="gmap" id="gmap"></div>
                    <?php endif; ?>
                    <!--BEGIN .container-->
                    <div class="container container-center row">
                        <!--BEGIN #content-->
                        <div id="content">
                            <?php
                            if (is_front_page()) {
                                evolve_content_boxes();
                            }
                            ?>