<?php
class Debate_Topics_Admin {
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles() {
        wp_enqueue_style($this->plugin_name, DEBATE_TOPICS_PLUGIN_URL . 'admin/css/debate-topics-admin.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts() {
        wp_enqueue_script($this->plugin_name, DEBATE_TOPICS_PLUGIN_URL . 'admin/js/debate-topics-admin.js', array('jquery'), $this->version, false);
    }

    public function add_plugin_admin_menu() {
        add_menu_page(
            '辩论话题', 
            '辩论话题', 
            'manage_options', 
            $this->plugin_name, 
            array($this, 'display_plugin_setup_page'),
            'dashicons-format-chat',
            5
        );
        add_submenu_page(
            $this->plugin_name,
            __('待审核话题', 'debate-topics'),
            __('待审核话题', 'debate-topics'),
            'manage_options',
            'debate-topics-pending',
            array($this, 'display_pending_topics_page')
        );
    }
    public function display_pending_topics_page() {
        $pending_topics = get_posts(array(
            'post_type' => 'debate_topic',
            'post_status' => 'pending',
            'posts_per_page' => -1,
        ));

        include DEBATE_TOPICS_PLUGIN_DIR . 'admin/partials/debate-topics-pending-display.php';
    }

    public function approve_debate_topic() {
        if (!current_user_can('manage_options')) {
            wp_die(__('您没有足够的权限执行此操作', 'debate-topics'));
        }

        $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;

        if (!$post_id) {
            wp_die(__('无效的话题ID', 'debate-topics'));
        }

        $post = get_post($post_id);

        if ($post->post_type !== 'debate_topic') {
            wp_die(__('无效的话题类型', 'debate-topics'));
        }

        wp_publish_post($post_id);

        wp_redirect(admin_url('admin.php?page=debate-topics-pending&approved=1'));
        exit;
    }
    public function display_plugin_setup_page() {
        include_once DEBATE_TOPICS_PLUGIN_DIR . 'admin/partials/debate-topics-admin-display.php';
    }

    public function add_meta_boxes() {
        add_meta_box(
            'debate_topic_meta_box',
            __('辩论话题设置', 'debate-topics'),
            array($this, 'render_debate_topic_meta_box'),
            'debate_topic',
            'normal',
            'high'
        );
    }

    public function render_debate_topic_meta_box($post) {
        wp_nonce_field('debate_topic_meta_box', 'debate_topic_meta_box_nonce');

        $status = get_post_meta($post->ID, '_debate_topic_status', true);
        ?>
        <p>
            <label for="debate_topic_status"><?php _e('状态:', 'debate-topics'); ?></label>
            <select name="debate_topic_status" id="debate_topic_status">
                <option value="open" <?php selected($status, 'open'); ?>><?php _e('开放', 'debate-topics'); ?></option>
                <option value="closed" <?php selected($status, 'closed'); ?>><?php _e('关闭', 'debate-topics'); ?></option>
            </select>
        </p>
        <?php
    }

    public function save_debate_topic_meta($post_id) {
        if (!isset($_POST['debate_topic_meta_box_nonce'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['debate_topic_meta_box_nonce'], 'debate_topic_meta_box')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        if (isset($_POST['debate_topic_status'])) {
            update_post_meta($post_id, '_debate_topic_status', sanitize_text_field($_POST['debate_topic_status']));
        }
    }
}
add_action('admin_post_approve_debate_topic', array($this, 'approve_debate_topic'));