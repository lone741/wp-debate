<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <?php if (!empty($pending_topics)) : ?>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th><?php esc_html_e('标题', 'debate-topics'); ?></th>
                    <th><?php esc_html_e('作者', 'debate-topics'); ?></th>
                    <th><?php esc_html_e('日期', 'debate-topics'); ?></th>
                    <th><?php esc_html_e('操作', 'debate-topics'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pending_topics as $topic) : ?>
                    <tr>
                        <td><?php echo esc_html($topic->post_title); ?></td>
                        <td><?php echo esc_html(get_the_author_meta('display_name', $topic->post_author)); ?></td>
                        <td><?php echo esc_html(get_the_date('', $topic->ID)); ?></td>
                        <td>
                            <a href="<?php echo esc_url(admin_url('admin-post.php?action=approve_debate_topic&post_id=' . $topic->ID)); ?>" class="button button-primary"><?php esc_html_e('批准', 'debate-topics'); ?></a>
                            <a href="<?php echo esc_url(get_edit_post_link($topic->ID)); ?>" class="button"><?php esc_html_e('编辑', 'debate-topics'); ?></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p><?php esc_html_e('当前没有待审核的辩论话题。', 'debate-topics'); ?></p>
    <?php endif; ?>
</div>
