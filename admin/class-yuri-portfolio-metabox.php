<?php

class Yuri_Portfolio_Metabox
{
    /**
     * Screen context where the meta box should display.
     *
     * @var string
     */
    private $context;

    /**
     * The ID of the meta box.
     *
     * @var string
     */
    private $id;

    /**
     * The display priority of the meta box.
     *
     * @var string
     */
    private $priority;

    /**
     * Screens where this meta box will appear.
     *
     * @var string[]
     */
    private $screens;

    /**
     * Path to the template used to display the content of the meta box.
     *
     * @var string
     */
    private $template;

    /**
     * The title of the meta box.
     *
     * @var string
     */
    private $title;

    /**
     * Constructor.
     *
     * @param string   $id
     * @param string   $emplate
     * @param string   $title
     * @param string   $context
     * @param string   $priority
     * @param string[] $screens
     */
    public function __construct($id, $template, $title, $screens = array(), $context = 'advanced', $priority = 'default')
    {
        if (is_string($screens)) {
            $screens = (array) $screens;
        }

        $this->context = $context;
        $this->id = $id;
        $this->priority = $priority;
        $this->screens = $screens;
        $this->template = plugin_dir_path(dirname(__FILE__)) . 'admin/partials/' . $template . '.php';
        $this->title = $title;
    }

    public function add_metabox()
    {

        add_meta_box($this->get_id(), $this->get_title(), $this->get_callback(), $this->get_screens(), $this->get_context(), $this->get_priority());
    }

    /**
     * Get the callable that will the content of the meta box.
     *
     * @return callable
     */
    public function get_callback()
    {
        return array($this, 'render');
    }

    /**
     * Get the screen context where the meta box should display.
     *
     * @return string
     */
    public function get_context()
    {
        return $this->context;
    }

    /**
     * Get the ID of the meta box.
     *
     * @return string
     */
    public function get_id()
    {
        return $this->id;
    }

    /**
     * Get the display priority of the meta box.
     *
     * @return string
     */
    public function get_priority()
    {
        return $this->priority;
    }

    /**
     * Get the screen(s) where the meta box will appear.
     *
     * @return array|string|WP_Screen
     */
    public function get_screens()
    {
        return $this->screens;
    }

    /**
     * Get the title of the meta box.
     *
     * @return string
     */
    public function get_title()
    {
        return $this->title;
    }

    /**
     * Render the content of the meta box using a PHP template.
     *
     * @param WP_Post $post
     */
    public function render(WP_Post $post)
    {
        $template = plugin_dir_path(dirname(__DIR__)) . 'admin/partials/portfolio.php';
        if (!is_readable($this->template)) {
            return;
        }

        require_once $this->template;
    }

    /**
     * Portfolio Custom Fields Save.
     */
    public function save_portfolio_postdata($post_id)
    {
        if (!isset($_POST['portfolio_meta_box_nonce'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['portfolio_meta_box_nonce'], 'yuri_lucas_save_postdata')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        if (array_key_exists('yuri_lucas_client_field', $_POST)) {
            $client_name = sanitize_text_field($_POST['yuri_lucas_client_field']);
            update_post_meta(
                $post_id,
                '_client_meta_field',
                $client_name
            );
        }

        if (array_key_exists('yuri_lucas_project_date_field', $_POST)) {
            $project_date = $_POST['yuri_lucas_project_date_field'];
            update_post_meta(
                $post_id,
                '_project_date_meta_field',
                $project_date
            );
        }

        if (array_key_exists('yuri_lucas_project_url_field', $_POST)) {
            $project_url = sanitize_text_field($_POST['yuri_lucas_project_url_field']);
            update_post_meta(
                $post_id,
                '_project_url_meta_field',
                $project_url
            );
        }
    }

    /**
     * Testimonials Custom Fields Save.
     */
    public function save_testimonial_postdata($post_id)
    {
        if (!isset($_POST['testimonial_meta_box_nonce'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['testimonial_meta_box_nonce'], 'yuri_lucas_save_postdata')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        if (array_key_exists('yuri_lucas_testimonial_profession_field', $_POST)) {
            $testimonial_profession = sanitize_text_field($_POST['yuri_lucas_testimonial_profession_field']);
            update_post_meta(
                $post_id,
                '_testimonial_profession_meta_field',
                $testimonial_profession
            );
        }
    }

    /**
     * Services Custom Fields Save.
     */
    public function save_service_postdata($post_id)
    {
        if (!isset($_POST['service_meta_box_nonce'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['service_meta_box_nonce'], 'yuri_lucas_save_postdata')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        if (array_key_exists('yuri_lucas_service_field', $_POST)) {
            $service = sanitize_text_field($_POST['yuri_lucas_service_field']);
            update_post_meta(
                $post_id,
                '_service_meta_field',
                $service
            );
        }
    }

    /**
     * Portfolio Gallery Custom Fields Save.
     */
    public function portfolio_gallery_save($post_id)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);
        $is_valid_nonce = (isset($_POST['sample_nonce']) && wp_verify_nonce($_POST['sample_nonce'], basename(__FILE__))) ? 'true' : 'false';

        if ($is_autosave || $is_revision || !$is_valid_nonce) {
            return;
        }
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Correct post type
        if ('portfolios' != $_POST['post_type']) // here you can set the post type name
            return;

        if ($_POST['gallery']) {

            // Build array for saving post meta
            $gallery_data = array();
            for ($i = 0; $i < count($_POST['gallery']['image_url']); $i++) {
                if ('' != $_POST['gallery']['image_url'][$i]) {
                    $gallery_data['image_url'][]  = $_POST['gallery']['image_url'][$i];
                }
            }

            if ($gallery_data)
                update_post_meta($post_id, 'gallery_data', $gallery_data);
            // else
                // delete_post_meta($post_id, 'gallery_data');
        }
        // Nothing received, all fields are empty, delete option
        else {
            // delete_post_meta($post_id, 'gallery_data');
        }
    }

    public function portfolio_gallery_styles_scripts()
    {
        global $post;
        if ('portfolios' != $post->post_type)
            return;
        ?>
        <style type="text/css">
            .gallery_area {
                float: right;
            }

            .image_container {
                float: left !important;
                width: 100px;
                background: url('https://i.hizliresim.com/dOJ6qL.png');
                height: 100px;
                background-repeat: no-repeat;
                background-size: cover;
                border-radius: 3px;
                cursor: pointer;
            }

            .image_container img {
                height: 100px;
                width: 100px;
                border-radius: 3px;
            }

            .clear {
                clear: both;
            }

            #gallery_wrapper {
                width: 100%;
                height: auto;
                position: relative;
                display: inline-block;
            }

            #gallery_wrapper input[type=text] {
                width: 300px;
            }

            #gallery_wrapper .gallery_single_row {
                float: left;
                display: inline-block;
                width: 100px;
                position: relative;
                margin-right: 8px;
                margin-bottom: 20px;
            }

            .dolu {
                display: inline-block !important;
            }

            #gallery_wrapper label {
                padding: 0 6px;
            }

            .button.remove {
                background: none;
                color: #f1f1f1;
                position: absolute;
                border: none;
                top: 4px;
                right: 7px;
                font-size: 1.2em;
                padding: 0px;
                box-shadow: none;
            }

            .button.remove:hover {
                background: none;
                color: #fff;
            }

            .button.add {
                background: #c3c2c2;
                color: #ffffff;
                border: none;
                box-shadow: none;
                width: 100px;
                height: 100px;
                line-height: 100px;
                font-size: 4em;
            }

            .button.add:hover,
            .button.add:focus {
                background: #e2e2e2;
                box-shadow: none;
                color: #0f88c1;
                border: none;
            }
        </style>
        <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/solid.js" integrity="sha384-+Ga2s7YBbhOD6nie0DzrZpJes+b2K1xkpKxTFFcx59QmVPaSA8c7pycsNaFwUK6l" crossorigin="anonymous">
        </script>
        <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
        <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/fontawesome.js" integrity="sha384-7ox8Q2yzO/uWircfojVuCQOZl+ZZBg2D2J5nkpLqzH1HY0C1dHlTKIbpRz/LG23c" crossorigin="anonymous">
        </script>
        <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <script type="text/javascript">
            function remove_img(value) {
                var parent = jQuery(value).parent().parent();
                parent.remove();
            }
            var media_uploader = null;

            function open_media_uploader_image(obj) {
                media_uploader = wp.media({
                    frame: "post",
                    state: "insert",
                    multiple: false
                });
                media_uploader.on("insert", function() {
                    var json = media_uploader.state().get("selection").first().toJSON();
                    var image_url = json.url;
                    var html = '<img class="gallery_img_img" src="' + image_url +
                        '" height="55" width="55" onclick="open_media_uploader_image_this(this)"/>';
                    console.log(image_url);
                    jQuery(obj).append(html);
                    jQuery(obj).find('.meta_image_url').val(image_url);
                });
                media_uploader.open();
            }

            function open_media_uploader_image_this(obj) {
                media_uploader = wp.media({
                    frame: "post",
                    state: "insert",
                    multiple: false
                });
                media_uploader.on("insert", function() {
                    var json = media_uploader.state().get("selection").first().toJSON();
                    var image_url = json.url;
                    console.log(image_url);
                    jQuery(obj).attr('src', image_url);
                    jQuery(obj).siblings('.meta_image_url').val(image_url);
                });
                media_uploader.open();
            }

            function open_media_uploader_image_plus() {
                media_uploader = wp.media({
                    frame: "post",
                    state: "insert",
                    multiple: true
                });
                media_uploader.on("insert", function() {

                    var length = media_uploader.state().get("selection").length;
                    var images = media_uploader.state().get("selection").models

                    for (var i = 0; i < length; i++) {
                        var image_url = images[i].changed.url;
                        var box = jQuery('#master_box').html();
                        jQuery(box).appendTo('#img_box_container');
                        var element = jQuery('#img_box_container .gallery_single_row:last-child').find(
                            '.image_container');
                        var html = '<img class="gallery_img_img" src="' + image_url +
                            '" height="55" width="55" onclick="open_media_uploader_image_this(this)"/>';
                        element.append(html);
                        element.find('.meta_image_url').val(image_url);
                        console.log(image_url);
                    }
                });
                media_uploader.open();
            }
            jQuery(function() {
                jQuery("#img_box_container").sortable(); // Activate jQuery UI sortable feature
            });
        </script>
        <?php
    }
}
