<?php
/**
 * 辩论话题提交表单模板
 */

if (!defined('ABSPATH')) {
    exit; // 如果直接访问则退出
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo esc_html('提交辩论话题'); ?></title>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="debate-submission-wrapper" class="debate-submission-container">
    <h1>提交新的辩论话题</h1>

    <?php if (!is_user_logged_in()) : ?>
        <p>请<a href="<?php echo wp_login_url(get_permalink()); ?>">登录</a>后提交新的辩论话题。</p>
    <?php else : ?>
        <form id="debate-topic-form" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
            <?php wp_nonce_field('submit_debate_topic', 'debate_topic_nonce'); ?>
            <input type="hidden" name="action" value="submit_debate_topic">
            
            <p>
                <label for="debate-topic-title">辩论话题标题：</label>
                <input type="text" id="debate-topic-title" name="debate_topic_title" required>
            </p>
            
            <p>
                <label for="debate-topic-content">话题描述：</label>
                <textarea id="debate-topic-content" name="debate_topic_content" rows="5" required></textarea>
            </p>
            
            <p>
                <label for="debate-topic-category">话题分类：</label>
                <?php
                wp_dropdown_categories(array(
                    'taxonomy' => 'debate_category',
                    'name' => 'debate_topic_category',
                    'show_option_none' => '选择分类',
                    'option_none_value' => '',
                    'required' => true,
                ));
                ?>
            </p>
            
            <p>
                <input type="submit" value="提交辩论话题">
            </p>
        </form>
    <?php endif; ?>
</div>

<?php wp_footer(); ?>
</body>
</html>