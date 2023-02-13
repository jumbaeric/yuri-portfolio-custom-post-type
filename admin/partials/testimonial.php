<?php
wp_nonce_field('yuri_lucas_save_postdata', 'testimonial_meta_box_nonce');
	$testimonial_profession = get_post_meta($post->ID, '_testimonial_profession_meta_field', true);
	?>
		<label for="yuri_lucas_testimonial_profession_field">Profession / Job Title</label>
		<input type="text" name="yuri_lucas_testimonial_profession_field" id="yuri_lucas_testimonial_profession_field" class="postbox" value="<?php echo esc_attr($testimonial_profession) ?>">

	<?php