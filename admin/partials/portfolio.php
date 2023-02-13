<?php
        wp_nonce_field('yuri_lucas_save_postdata', 'portfolio_meta_box_nonce');
        $client_name = get_post_meta($post->ID, '_client_meta_field', true);
        $project_date = get_post_meta($post->ID, '_project_date_meta_field', true);
        $project_url = get_post_meta($post->ID, '_project_url_meta_field', true);
            ?>
            <label for="yuri_lucas_client_field">Client Name</label>
            <input type="text" name="yuri_lucas_client_field" id="yuri_lucas_client_field" class="postbox" value="<?php echo esc_attr($client_name) ?>">
    
            <label for="yuri_lucas_project_date_field">Project Date</label>
            <input type="date" name="yuri_lucas_project_date_field" id="yuri_lucas_project_date_field" class="postbox" value="<?php echo esc_attr($project_date) ?>">
    
            <label for="yuri_lucas_project_url_field">Project URL</label>
            <input type="text" name="yuri_lucas_project_url_field" id="yuri_lucas_project_url_field" class="postbox" value="<?php echo esc_attr($project_url) ?>">
        <?php