<?php
class Debate_Topics_Deactivator {
    public static function deactivate() {
        flush_rewrite_rules();
    }
}
