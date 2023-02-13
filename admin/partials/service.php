<?php
wp_nonce_field('yuri_lucas_save_postdata', 'service_meta_box_nonce');
$service = get_post_meta($post->ID, '_service_profession_meta_field', true);
?>
    <label for="yuri_lucas_service_field">Service Icon (https://fontawesomeicons.com/bootstrap/icons/)</label>
    <input type="text" placeholder="bi-briefcase" name="yuri_lucas_service_field" id="yuri_lucas_service_field" class="postbox" value="<?php echo esc_attr($service) ?>">

<?php