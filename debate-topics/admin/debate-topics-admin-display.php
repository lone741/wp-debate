<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <p><?php esc_html_e('欢迎使用辩论话题插件管理界面。', 'debate-topics'); ?></p>
    <h2><?php esc_html_e('使用说明', 'debate-topics'); ?></h2>
    <ol>
        <li><?php esc_html_e('创建新的辩论话题：在左侧菜单中选择"添加新话题"。', 'debate-topics'); ?></li>
        <li><?php esc_html_e('管理现有话题：在左侧菜单中选择"所有辩论话题"。', 'debate-topics'); ?></li>
        <li><?php esc_html_e('查看统计信息：使用下方的统计部分查看总体情况。', 'debate-topics'); ?></li>
    </ol>
    <h2><?php esc_html_e('统计信息', 'debate-topics'); ?></h2>
    <?php
    $total_topics = wp_count_posts('debate_topic')->publish;
    $total_votes = $this->get_total_votes();
    $total_arguments = $this->get_total_arguments();
    ?>
    <ul>
        <li><?php echo sprintf(esc_html__('总辩论话题数：%d', 'debate-topics'), $total_topics); ?></li>
        <li><?php echo sprintf(esc_html__('总投票数：%d', 'debate-topics'), $total_votes); ?></li>
        <li><?php echo sprintf(esc_html__('总观点数：%d', 'debate-topics'), $total_arguments); ?></li>
    </ul>
</div>
