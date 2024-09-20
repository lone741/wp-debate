<?php
/**
 * The template for displaying debate topic archives
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// 使用 wp_head() 和 wp_footer() 来包含必要的 WordPress 头部和底部内容
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <div id="content" class="site-content">
        <div id="primary" class="content-area">
            <main id="main" class="site-main">

            <?php if (have_posts()) : ?>

                <header class="page-header">
                    <h1 class="page-title"><?php esc_html_e('辩论话题列表', 'debate-topics'); ?></h1>
                </header>

                <?php
                while (have_posts()) :
                    the_post();
                    $debate_id = get_the_ID();
                    $for_votes = get_post_meta($debate_id, '_votes_for', true) ?: 0;
                    $against_votes = get_post_meta($debate_id, '_votes_against', true) ?: 0;
                    $total_votes = $for_votes + $against_votes;
                    $for_percentage = $total_votes > 0 ? round(($for_votes / $total_votes) * 100, 2) : 50;
                    $against_percentage = 100 - $for_percentage;
                    ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class('debate-topic-summary'); ?>>
                        <header class="entry-header">
                            <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        </header>

                        <div class="entry-summary">
                            <?php the_excerpt(); ?>
                        </div>

                        <div class="debate-stats">
                            <div class="debate-progress-bar">
                                <div class="for-bar" style="width: <?php echo $for_percentage; ?>%;">赞成 <?php echo $for_percentage; ?>%</div>
                                <div class="against-bar" style="width: <?php echo $against_percentage; ?>%;">反对 <?php echo $against_percentage; ?>%</div>
                            </div>
                            <p><?php echo sprintf(esc_html__('总投票数: %d', 'debate-topics'), $total_votes); ?></p>
                        </div>

                        <a href="<?php the_permalink(); ?>" class="read-more"><?php esc_html_e('参与讨论', 'debate-topics'); ?></a>
                    </article>

                <?php
                endwhile;

                the_posts_navigation();

            else :
                ?>
                <p><?php esc_html_e('暂无辩论话题。', 'debate-topics'); ?></p>
                <?php
            endif;
            ?>

            </main>
        </div>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>