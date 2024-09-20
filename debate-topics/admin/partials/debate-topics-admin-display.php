<div class="wrap debate-topics-admin-wrapper">
    <h1>辩论话题管理</h1>
    <div class="debate-topics-list">
        <?php
        $args = array(
            'post_type' => 'debate_topic',
            'post_status' => 'pending',
            'posts_per_page' => -1
        );
        $pending_topics = new WP_Query($args);

        if ($pending_topics->have_posts()) :
            while ($pending_topics->have_posts()) : $pending_topics->the_post();
                ?>
                <div class="debate-topic-item">
                    <div class="debate-topic-title"><?php the_title(); ?></div>
                    <div class="debate-topic-excerpt"><?php the_excerpt(); ?></div>
                    <div class="debate-topic-actions">
                        <button class="approve-debate-topic" data-topic-id="<?php the_ID(); ?>">批准</button>
                        <button class="reject-debate-topic" data-topic-id="<?php the_ID(); ?>">拒绝</button>
                    </div>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
        else :
            echo '<p>暂无待审核的辩论话题。</p>';
        endif;
        ?>
    </div>
</div>
