<?php
/**
 * Template: page-about.php
 *
 * @package EvoLve
 * @subpackage Template
 *
 * Template Name: About Page
 */
get_header();
$xyz = "";
$evolve_layout = evolve_get_option('evl_layout', '2cl');
$evolve_post_layout = evolve_get_option('evl_post_layout', 'two');
$evolve_nav_links = evolve_get_option('evl_nav_links', 'after');
$evolve_header_meta = evolve_get_option('evl_header_meta', 'single_archive');
$evolve_category_page_title = evolve_get_option('evl_category_page_title', '1');
$evolve_excerpt_thumbnail = evolve_get_option('evl_excerpt_thumbnail', '0');
$evolve_share_this = evolve_get_option('evl_share_this', 'single');
$evolve_post_links = evolve_get_option('evl_post_links', 'after');
$evolve_similar_posts = evolve_get_option('evl_similar_posts', 'disable');
$evolve_featured_images = evolve_get_option('evl_featured_images', '1');
$evolve_edit_post = evolve_get_option('evl_edit_post', '0');
$evolve_thumbnail_default_images = evolve_get_option('evl_thumbnail_default_images', '0');
$evolve_posts_excerpt_title_length = intval(evolve_get_option('evl_posts_excerpt_title_length', '40'));
$evolve_blog_featured_image = evolve_get_option('evl_blog_featured_image', '0');
if (evolve_lets_get_sidebar_2() == true):
    get_sidebar('2');
endif;
?>

<!--BEGIN #primary .hfeed-->

<div id="primary" class="<?php evolve_layout_class($type = 1); ?> bernie-page-about">

    <?php
    $evolve_breadcrumbs = evolve_get_option('evl_breadcrumbs', '1');
    if ($evolve_breadcrumbs == "1"):
        if (is_home() || is_front_page()):
        elseif ((is_single() && get_post_meta($post->ID, 'evolve_page_breadcrumb', true) == 'no') || (is_page() && get_post_meta($post->ID, 'evolve_page_breadcrumb', true) == 'no')):
        else:evolve_breadcrumb();
        endif;
    endif;
    ?>

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <!--BEGIN .hentry-->
            <div id="post-<?php the_ID(); ?>" class="<?php semantic_entries(); ?>">

                <?php
                if (get_post_meta($post->ID, 'evolve_page_title', true) == 'no'):
                else:
                    ?>
                <h1 class="entry-title"><?php
                    if (get_the_title()) {
                        the_title();
                    }
                    ?>
					<?php if ($evolve_edit_post == "1") { ?>
                        <?php if (current_user_can('edit_post', $post->ID)): ?>
                            <?php edit_post_link(__('EDIT', 'evolve'), '<span class="edit-page edit-attach">', '</span>'); ?>
                        <?php endif; ?>
						<?php } ?></h1>
                <?php endif; ?>

                <?php
                if (has_post_thumbnail()) {
                    echo '<div class="thumbnail-post">';
                    the_post_thumbnail('post-thumbnail');
                    echo '</div>';
                }
                ?>


                <!--BEGIN .entry-content .article-->
                <div class="entry-content article">

                    <?php
                    the_content();
                    wp_link_pages();
                    ?>

                    <div class="clearfix"></div>

                </div><!--END .entry-content .article-->

                <!-- Auto Discovery Trackbacks
                <?php trackback_rdf(); ?>
                -->
                <!--END .hentry-->
            </div>

            <?php if ($evolve_share_this == 'all') evolve_sharethis(); ?>

            <?php
            if (!is_front_page()) {
                comments_template('', true);
            } //hide from static homepage, allowed in all normal pages.  
            ?>

            <?php
        endwhile;
    endif;
    ?>


    <!--END #primary .hfeed-->
</div>


<?php get_footer(); ?>