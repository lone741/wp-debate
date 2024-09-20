<?php
class Debate_Topics_Activator {
    public static function activate() {
        require_once DEBATE_TOPICS_PLUGIN_DIR . 'public/class-debate-topics-public.php';
        $plugin_public = new Debate_Topics_Public('debate-topics', DEBATE_TOPICS_VERSION);
        $plugin_public->register_debate_topic_post_type();
        $plugin_public->register_debate_topic_taxonomy();
        flush_rewrite_rules();
    }
}
