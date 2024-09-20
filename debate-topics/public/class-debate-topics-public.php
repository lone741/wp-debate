<?php
class Debate_Topics_Public {
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    public function enqueue_styles() {
        wp_enqueue_style($this->plugin_name, DEBATE_TOPICS_PLUGIN_URL . 'public/css/debate-topics-public.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts() {
        wp_enqueue_script($this->plugin_name, DEBATE_TOPICS_PLUGIN_URL . 'public/js/debate-topics-public.js', array('jquery'), $this->version, false);
        wp_localize_script($this->plugin_name, 'debate_topics_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('debate_topics_nonce')
        ));
    }
    // ... 前面的代码 ...
    

    public function register_debate_topic_post_type() {
        $labels = array(
            'name'                  => _x('辩论话题', 'Post Type General Name', 'debate-topics'),
            'singular_name'         => _x('辩论话题', 'Post Type Singular Name', 'debate-topics'),
            'menu_name'             => __('辩论话题', 'debate-topics'),
            'name_admin_bar'        => __('辩论话题', 'debate-topics'),
            'archives'              => __('辩论话题归档', 'debate-topics'),
            'attributes'            => __('辩论话题属性', 'debate-topics'),
            'parent_item_colon'     => __('父级辩论话题:', 'debate-topics'),
            'all_items'             => __('所有辩论话题', 'debate-topics'),
            'add_new_item'          => __('添加新辩论话题', 'debate-topics'),
            'add_new'               => __('添加新话题', 'debate-topics'),
            'new_item'              => __('新辩论话题', 'debate-topics'),
            'edit_item'             => __('编辑辩论话题', 'debate-topics'),
            'update_item'           => __('更新辩论话题', 'debate-topics'),
            'view_item'             => __('查看辩论话题', 'debate-topics'),
            'view_items'            => __('查看辩论话题', 'debate-topics'),
            'search_items'          => __('搜索辩论话题', 'debate-topics'),
            'not_found'             => __('未找到', 'debate-topics'),
            'not_found_in_trash'    => __('回收站中未找到', 'debate-topics'),
            'featured_image'        => __('特色图片', 'debate-topics'),
            'set_featured_image'    => __('设置特色图片', 'debate-topics'),
            'remove_featured_image' => __('移除特色图片', 'debate-topics'),
            'use_featured_image'    => __('使用特色图片', 'debate-topics'),
            'insert_into_item'      => __('插入到辩论话题', 'debate-topics'),
            'uploaded_to_this_item' => __('上传到此辩论话题', 'debate-topics'),
            'items_list'            => __('辩论话题列表', 'debate-topics'),
            'items_list_navigation' => __('辩论话题列表导航', 'debate-topics'),
            'filter_items_list'     => __('筛选辩论话题列表', 'debate-topics'),
        );
        $args = array(
            'label'                 => __('辩论话题', 'debate-topics'),
            'description'           => __('辩论话题描述', 'debate-topics'),
            'labels'                => $labels,
            'supports'              => array('title', 'editor', 'thumbnail', 'comments', 'revisions', 'custom-fields'),
            'taxonomies'            => array('debate_category', 'post_tag'),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
        );
        register_post_type('debate_topic', $args);
    }

    public function register_debate_topic_taxonomy() {
        $labels = array(
            'name'                       => _x('辩论分类', 'Taxonomy General Name', 'debate-topics'),
            'singular_name'              => _x('辩论分类', 'Taxonomy Singular Name', 'debate-topics'),
            'menu_name'                  => __('辩论分类', 'debate-topics'),
            'all_items'                  => __('所有辩论分类', 'debate-topics'),
            'parent_item'                => __('父级辩论分类', 'debate-topics'),
            'parent_item_colon'          => __('父级辩论分类:', 'debate-topics'),
            'new_item_name'              => __('新辩论分类名称', 'debate-topics'),
            'add_new_item'               => __('添加新辩论分类', 'debate-topics'),
            'edit_item'                  => __('编辑辩论分类', 'debate-topics'),
            'update_item'                => __('更新辩论分类', 'debate-topics'),
            'view_item'                  => __('查看辩论分类', 'debate-topics'),
            'separate_items_with_commas' => __('使用逗号分隔辩论分类', 'debate-topics'),
            'add_or_remove_items'        => __('添加或移除辩论分类', 'debate-topics'),
            'choose_from_most_used'      => __('从最常用的辩论分类中选择', 'debate-topics'),
            'popular_items'              => __('热门辩论分类', 'debate-topics'),
            'search_items'               => __('搜索辩论分类', 'debate-topics'),
            'not_found'                  => __('未找到', 'debate-topics'),
            'no_terms'                   => __('没有辩论分类', 'debate-topics'),
            'items_list'                 => __('辩论分类列表', 'debate-topics'),
            'items_list_navigation'      => __('辩论分类列表导航', 'debate-topics'),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
        );
        register_taxonomy('debate_category', array('debate_topic'), $args);
    }

    public function debate_template_include($template) {
        if (is_singular('debate_topic')) {
            $new_template = DEBATE_TOPICS_PLUGIN_DIR . 'public/templates/single-debate-topic.php';
            if (file_exists($new_template)) {
                return $new_template;
            }
        } elseif (is_post_type_archive('debate_topic')) {
            $new_template = DEBATE_TOPICS_PLUGIN_DIR . 'public/templates/archive-debate-topic.php';
            if (file_exists($new_template)) {
                return $new_template;
            }
        }
        return $template;
    }

    public function debate_topics_vote() {
        check_ajax_referer('debate_topics_nonce', 'nonce');
        
        $debate_id = intval($_POST['debate_id']);
        $vote_type = sanitize_text_field($_POST['vote_type']);
        
        if (!in_array($vote_type, array('for', 'against'))) {
            wp_send_json_error('Invalid vote type');
        }
        
        $user_id = get_current_user_id();
        if (!$user_id) {
            wp_send_json_error('User not logged in');
        }
        
        // 检查用户是否已经投票
        $user_voted = get_post_meta($debate_id, "_user_voted_{$user_id}", true);
        if ($user_voted) {
            wp_send_json_error('You have already voted');
        }
        
        // 更新投票计数
        $votes_key = "_votes_{$vote_type}";
        $current_votes = intval(get_post_meta($debate_id, $votes_key, true));
        update_post_meta($debate_id, $votes_key, $current_votes + 1);
        
        // 标记用户已投票
        update_post_meta($debate_id, "_user_voted_{$user_id}", $vote_type);
        
        // 获取更新后的投票数
        $for_votes = intval(get_post_meta($debate_id, '_votes_for', true));
        $against_votes = intval(get_post_meta($debate_id, '_votes_against', true));
        $total_votes = $for_votes + $against_votes;
        
        // 计算百分比
        $for_percentage = $total_votes > 0 ? round(($for_votes / $total_votes) * 100, 2) : 0;
        $against_percentage = $total_votes > 0 ? round(($against_votes / $total_votes) * 100, 2) : 0;
        
        wp_send_json_success(array(
            'for_votes' => $for_votes,
            'against_votes' => $against_votes,
            'for_percentage' => $for_percentage,
            'against_percentage' => $against_percentage,
            'total_votes' => $total_votes
        ));
    }

    public function debate_topics_submit_argument() {
        check_ajax_referer('debate_topics_nonce', 'nonce');
        
        $debate_id = intval($_POST['debate_id']);
        $argument_type = sanitize_text_field($_POST['argument_type']);
        $argument_content = wp_kses_post($_POST['argument_content']);
        
        if (!in_array($argument_type, array('for', 'against'))) {
            wp_send_json_error('Invalid argument type');
        }
        
        $user_id = get_current_user_id();
        if (!$user_id) {
            wp_send_json_error('User not logged in');
        }
        
        $argument_data = array(
            'comment_post_ID' => $debate_id,
            'comment_content' => $argument_content,
            'user_id' => $user_id,
            'comment_type' => 'debate_argument',
        );
        
        $argument_id = wp_insert_comment($argument_data);
        
        if ($argument_id) {
            add_comment_meta($argument_id, 'argument_type', $argument_type);
            wp_send_json_success('Argument submitted successfully');
        } else {
            wp_send_json_error('Failed to submit argument');
        }
    }
    public function submit_debate_topic() {
        if (!isset($_POST['debate_topic_nonce']) || !wp_verify_nonce($_POST['debate_topic_nonce'], 'submit_debate_topic')) {
            wp_die('安全检查失败');
        }

        if (!is_user_logged_in()) {
            wp_die('您必须登录才能提交辩论话题');
        }

        $title = sanitize_text_field($_POST['debate_topic_title']);
        $content = wp_kses_post($_POST['debate_topic_content']);
        $category = intval($_POST['debate_topic_category']);

        $post_data = array(
            'post_title'   => $title,
            'post_content' => $content,
            'post_status'  => 'pending',
            'post_type'    => 'debate_topic',
            'post_author'  => get_current_user_id(),
        );

        $post_id = wp_insert_post($post_data);

        if ($post_id) {
            wp_set_object_terms($post_id, $category, 'debate_category');
            wp_redirect(add_query_arg('submitted', '1', wp_get_referer()));
            exit;
        } else {
            wp_die('提交辩论话题时出错');
        }
    }

    // 添加一个短代码来显示提交表单
    public function debate_topic_submission_form_shortcode() {
        ob_start();
        include DEBATE_TOPICS_PLUGIN_DIR . 'public/templates/debate-topic-submission-form.php';
        return ob_get_clean();
    }

}
add_action('admin_post_nopriv_submit_debate_topic', array($this, 'submit_debate_topic'));
add_action('admin_post_submit_debate_topic', array($this, 'submit_debate_topic'));
add_shortcode('debate_topic_form', array($this, 'debate_topic_submission_form_shortcode'));