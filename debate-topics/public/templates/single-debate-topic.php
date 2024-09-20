<?php
/**
 * The template for displaying single debate topics
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

                <article id="post-<?php the_ID(); ?>" <?php post_class('debate-topic'); ?>>
                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </header>

                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>

                    <div class="debate-voting">
    <h2><?php esc_html_e('参与投票', 'debate-topics'); ?></h2>
    <div class="debate-progress-bar">
        <div class="for-bar" style="width: <?php echo esc_attr($for_percentage); ?>%;">
            <?php echo esc_html(sprintf(__('赞成 %s%%', 'debate-topics'), number_format($for_percentage, 2))); ?>
        </div>
        <div class="against-bar" style="width: <?php echo esc_attr($against_percentage); ?>%;">
            <?php echo esc_html(sprintf(__('反对 %s%%', 'debate-topics'), number_format($against_percentage, 2))); ?>
        </div>
    </div>
    <p class="vote-counts">
        <?php echo esc_html(sprintf(__('赞成票数: %d | 反对票数: %d | 总票数: %d', 'debate-topics'), $for_votes, $against_votes, $total_votes)); ?>
    </p>
    <?php if (is_user_logged_in()) : ?>
        <button class="vote-button" data-vote="for" data-debate-id="<?php echo esc_attr($debate_id); ?>"><?php esc_html_e('赞成', 'debate-topics'); ?></button>
        <button class="vote-button" data-vote="against" data-debate-id="<?php echo esc_attr($debate_id); ?>"><?php esc_html_e('反对', 'debate-topics'); ?></button>
    <?php else : ?>
        <p><?php esc_html_e('请登录后参与投票。', 'debate-topics'); ?></p>
    <?php endif; ?>
</div>

            <div class="debate-arguments">
                <h2><?php esc_html_e('辩论观点', 'debate-topics'); ?></h2>
                <div class="for-arguments">
                    <h3><?php esc_html_e('赞成方观点', 'debate-topics'); ?></h3>
                    <?php
                    $for_args = get_comments(array(
                        'post_id' => $debate_id,
                        'meta_key' => 'argument_type',
                        'meta_value' => 'for',
                        'type' => 'debate_argument',
                    ));
                    wp_list_comments(array(
                        'style'      => 'ol',
                        'short_ping' => true,
                    ), $for_args);
                    ?>
                    <?php if (is_user_logged_in()) : ?>
                        <form class="argument-form" data-type="for">
                            <textarea name="argument_content" required></textarea>
                            <input type="hidden" name="debate_id" value="<?php echo $debate_id; ?>">
                            <input type="submit" value="<?php esc_attr_e('提交赞成观点', 'debate-topics'); ?>">
                        </form>
                    <?php endif; ?>
                </div>
                <div class="against-arguments">
                    <h3><?php esc_html_e('反对方观点', 'debate-topics'); ?></h3>
                    <?php
                    $against_args = get_comments(array(
                        'post_id' => $debate_id,
                        'meta_key' => 'argument_type',
                        'meta_value' => 'against',
                        'type' => 'debate_argument',
                    ));
                    wp_list_comments(array(
                        'style'      => 'ol',
                        'short_ping' => true,
                    ), $against_args);
                    ?>
                    <?php if (is_user_logged_in()) : ?>
                        <form class="argument-form" data-type="against">
                            <textarea name="argument_content" required></textarea>
                            <input type="hidden" name="debate_id" value="<?php echo $debate_id; ?>">
                            <input type="submit" value="<?php esc_attr_e('提交反对观点', 'debate-topics'); ?>">
                        </form>
                    <?php endif; ?>
                </div>
            </div>
            </article>

<?php
endwhile;
?>
</main>
</div>
</div>
</div>

<?php wp_footer(); ?>
</body>
</html>