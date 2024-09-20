<?php
class Debate_Topics_i18n {
    public function load_plugin_textdomain() {
        load_plugin_textdomain(
            'debate-topics',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );
    }
}
