<?php
class Debate_Topics {
    protected $loader;
    protected $plugin_name;
    protected $version;

    public function __construct() {
        $this->version = DEBATE_TOPICS_VERSION;
        $this->plugin_name = 'debate-topics';
        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    private function load_dependencies() {
        require_once DEBATE_TOPICS_PLUGIN_DIR . 'includes/class-debate-topics-loader.php';
        require_once DEBATE_TOPICS_PLUGIN_DIR . 'includes/class-debate-topics-i18n.php';
        require_once DEBATE_TOPICS_PLUGIN_DIR . 'admin/class-debate-topics-admin.php';
        require_once DEBATE_TOPICS_PLUGIN_DIR . 'public/class-debate-topics-public.php';

        $this->loader = new Debate_Topics_Loader();
    }

    private function set_locale() {
        $plugin_i18n = new Debate_Topics_i18n();
        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    private function define_admin_hooks() {
        $plugin_admin = new Debate_Topics_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        $this->loader->add_action('admin_menu', $plugin_admin, 'add_plugin_admin_menu');
        $this->loader->add_action('add_meta_boxes', $plugin_admin, 'add_meta_boxes');
        $this->loader->add_action('save_post_debate_topic', $plugin_admin, 'save_debate_topic_meta');
    }

    private function define_public_hooks() {
        $plugin_public = new Debate_Topics_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        $this->loader->add_action('init', $plugin_public, 'register_debate_topic_post_type');
        $this->loader->add_action('init', $plugin_public, 'register_debate_topic_taxonomy');
        $this->loader->add_filter('template_include', $plugin_public, 'debate_template_include');
        $this->loader->add_action('wp_ajax_debate_topics_vote', $plugin_public, 'debate_topics_vote');
        $this->loader->add_action('wp_ajax_debate_topics_submit_argument', $plugin_public, 'debate_topics_submit_argument');
    }

    public function run() {
        $this->loader->run();
    }

    public function get_plugin_name() {
        return $this->plugin_name;
    }

    public function get_version() {
        return $this->version;
    }
}
