<?php
/**
 * Plugin Name: Debate Topics
 * Plugin URI: http://example.com/debate-topics
 * Description: A plugin to create and manage debate topics with voting system.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: http://example.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: debate-topics
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

define('DEBATE_TOPICS_VERSION', '1.0.0');
define('DEBATE_TOPICS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('DEBATE_TOPICS_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * The code that runs during plugin activation.
 */
function activate_debate_topics() {
    require_once DEBATE_TOPICS_PLUGIN_DIR . 'includes/class-debate-topics-activator.php';
    Debate_Topics_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_debate_topics() {
    require_once DEBATE_TOPICS_PLUGIN_DIR . 'includes/class-debate-topics-deactivator.php';
    Debate_Topics_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_debate_topics');
register_deactivation_hook(__FILE__, 'deactivate_debate_topics');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require DEBATE_TOPICS_PLUGIN_DIR . 'includes/class-debate-topics.php';

/**
 * Begins execution of the plugin.
 */
function run_debate_topics() {
    $plugin = new Debate_Topics();
    $plugin->run();

}
run_debate_topics();
