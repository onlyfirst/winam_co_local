<?php
/**
 * Restaurant and Cafe Theme Customizer.
 *
 * @package WordPress
 */


/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function winamco_customize_register($wp_customize)
{

    if (version_compare(get_bloginfo('version'), '4.9', '>=')) {
        $wp_customize->get_section('static_front_page')->title = __('Static Front Page', 'winamco');
    }

    /** Default Settings */
    $wp_customize->add_panel(
        'wp_default_panel',
        array(
            'priority' => 10,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __('Default Settings', 'winamco'),
            'description' => __('Default section provided by wordpress customizer.', 'winamco'),
        )
    );

    $wp_customize->get_section('title_tagline')->panel = 'wp_default_panel';
    $wp_customize->get_section('colors')->panel = 'wp_default_panel';
    $wp_customize->get_section('header_image')->panel = 'wp_default_panel';
    $wp_customize->get_section('background_image')->panel = 'wp_default_panel';
    $wp_customize->get_section('static_front_page')->panel = 'wp_default_panel';

    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    $wp_customize->remove_section('custom_css');

    /** Default Settings Ends */
    /** Social Section */
    $wp_customize->add_section(
        'winamco_socail_settings',
        array(
            'title' => __('Social & hotline setting', 'winamco'),
            'priority' => 20,
        )
    );


    $wp_customize->add_setting(
        'site_facebook',
        array(
            'default' => '',
            'sanitize_callback' => 'winamco_sanitize_nohtml',
        )
    );

    $wp_customize->add_control(
        'site_facebook',
        array(
            'label' => __('Facebook URL', 'winamco'),
            'section' => 'winamco_socail_settings',
            'type' => 'text',
        )
    );

    $wp_customize->add_setting(
        'site_twitter',
        array(
            'default' => '',
            'sanitize_callback' => 'winamco_sanitize_nohtml',
        )
    );

    $wp_customize->add_control(
        'site_twitter',
        array(
            'label' => __('Twitter URL', 'winamco'),
            'section' => 'winamco_socail_settings',
            'type' => 'text',
        )
    );

    $wp_customize->add_setting(
        'site_youtube',
        array(
            'default' => '',
            'sanitize_callback' => 'winamco_sanitize_nohtml',
        )
    );

    $wp_customize->add_control(
        'site_youtube',
        array(
            'label' => __('Youtube URL', 'winamco'),
            'section' => 'winamco_socail_settings',
            'type' => 'text',
        )
    );

    $wp_customize->add_setting(
        'site_instagram',
        array(
            'default' => '',
            'sanitize_callback' => 'winamco_sanitize_nohtml',
        )
    );

    $wp_customize->add_control(
        'site_instagram',
        array(
            'label' => __('Instagram URL', 'winamco'),
            'section' => 'winamco_socail_settings',
            'type' => 'text',
        )
    );

    $wp_customize->add_setting(
        'site_hotline',
        array(
            'default' => '',
            'sanitize_callback' => 'winamco_sanitize_nohtml',
        )
    );

    $wp_customize->add_control(
        'site_hotline',
        array(
            'label' => __('Hotline', 'winamco'),
            'section' => 'winamco_socail_settings',
            'type' => 'text',
        )
    );

    $wp_customize->add_setting(
        'site_telegram',
        array(
            'default' => '',
            'sanitize_callback' => 'winamco_sanitize_nohtml',
        )
    );

    $wp_customize->add_control(
        'site_telegram',
        array(
            'label' => __('Telegram URL', 'winamco'),
            'section' => 'winamco_socail_settings',
            'type' => 'text',
        )
    );

    $wp_customize->add_setting(
        'site_email',
        array(
            'default' => '',
            'sanitize_callback' => 'winamco_sanitize_nohtml',
        )
    );

    $wp_customize->add_control(
        'site_email',
        array(
            'label' => __('Email', 'winamco'),
            'section' => 'winamco_socail_settings',
            'type' => 'text',
        )
    );
    /*
    $wp_customize->add_setting(
    'site_email',
    array(
    'default' => '',
    'sanitize_callback' => 'winamco_sanitize_nohtml',
    )
    );
    $wp_customize->add_control(
    'site_email',
    array(
    'label' => __( 'Site email', 'winamco' ),
    'section' => 'winamco_socail_settings',
    'type' => 'text',
    )
    );
    */
    /** Social Section Ends */
    /** Footer Section */
    $wp_customize->add_section(
        'winamco_footer_section',
        array(
            'title' => __('Footer Settings', 'winamco'),
            'priority' => 70,
        )
    );

    /* Copyright Text */
    $wp_customize->add_setting(
        'site_copyright',
        array(
            'default' => '',
            'sanitize_callback' => 'wp_kses_post',
        )
    );

    $wp_customize->add_control(
        'site_copyright',
        array(
            'label' => __('Copyright Info', 'winamco'),
            'section' => 'winamco_footer_section',
            'type' => 'textarea',
        )
    );

    /* Footer Info */
    // 1st EDITOR // if you winamcont to add wp_editor you can use this
    /* $wp_customize->add_setting(
    'site_footer_info',
    array(
    'type' => 'option'
    )
    );
    $wp_customize->add_control(new WP_Customize_Teeny_Control($wp_customize, 'site_footer_info',
    array(
    'label' => __('Thông tin công ty', 'winamco'),
    'section' => 'winamco_footer_section'
    )
    ));*/



    /**
     * Sanitization Functions
     *
     */
    if (!function_exists('custom_textarea_value')):
        function custom_textarea_value($value)
        {
            return $value;
        }
    endif;
    function winamco_sanitize_checkbox($checked)
    {
        // Boolean check.
        return ((isset($checked) && true == $checked) ? true : false);
    }

    function winamco_sanitize_nohtml($nohtml)
    {
        return wp_filter_nohtml_kses($nohtml);
    }

    function winamco_sanitize_html($html)
    {
        return wp_filter_post_kses($html);
    }

    function winamco_sanitize_select($input, $setting)
    {
        // Ensure input is a slug.
        $input = sanitize_key($input);

        // Get list of choices from the control associated with the setting.
        $choices = $setting->manager->get_control($setting->id)->choices;

        // If the input is a valid key, return it; otherwise, return the default.
        return (array_key_exists($input, $choices) ? $input : $setting->default);
    }

    function winamco_sanitize_url($url)
    {
        return esc_url_raw($url);
    }

    function winamco_sanitize_number_absint($number, $setting)
    {
        // Ensure $number is an absolute integer (whole number, zero or greater).
        $number = absint($number);

        // If the input is an absolute integer, return it; otherwise, return the default
        return ($number ? $number : $setting->default);
    }

    function winamco_sanitize_shortcode($shortcode)
    {
        return wp_kses_post($shortcode);
    }
    function winamco_sanitize_image($image, $setting)
    {
        /*
         * Array of valid image file types.
         *
         * The array includes image mime types that are included in wp_get_mime_types()
         */
        $mimes = array(
            'jpg|jpeg|jpe' => 'image/jpeg',
            'gif' => 'image/gif',
            'png' => 'image/png',
            'bmp' => 'image/bmp',
            'tif|tiff' => 'image/tiff',
            'ico' => 'image/x-icon',
            'svg' => 'image/svg+xml'
        );
        // Return an array with file extension and mime_type.
        $file = wp_check_filetype($image, $mimes);
        // If $image has a valid mime_type, return it; otherwise, return the default.
        return ($file['ext'] ? $image : $setting->default);
    }
}
add_action('customize_register', 'winamco_customize_register');
function editor_customizer_script()
{
    wp_enqueue_script('wp-editor-customizer', get_template_directory_uri() . '/js/customizer-panel.js', array('jquery'), rand(), true);
}
add_action('customize_controls_enqueue_scripts', 'editor_customizer_script');

if (class_exists('WP_Customize_Control')) {
    class WP_Customize_Teeny_Control extends WP_Customize_Control
    {
        function __construct($manager, $id, $options)
        {
            parent::__construct($manager, $id, $options);

            global $num_customizer_teenies_initiated;
            $num_customizer_teenies_initiated = empty($num_customizer_teenies_initiated)
                ? 1
                : $num_customizer_teenies_initiated + 1;
        }
        function render_content()
        {
            global $num_customizer_teenies_initiated, $num_customizer_teenies_rendered;
            $num_customizer_teenies_rendered = empty($num_customizer_teenies_rendered)
                ? 1
                : $num_customizer_teenies_rendered + 1;

            $value = $this->value();
            ?>
            <label>
                <span class="customize-text_editor">
                    <?php echo esc_html($this->label); ?>
                </span>
                <input id="<?php echo $this->id ?>-link" class="wp-editor-area" type="hidden" <?php $this->link(); ?> value="<?php echo esc_textarea($value); ?>">
                <?php
                wp_editor(
                    $value, $this->id,
                    array(
                        'textarea_name' => $this->id,
                        'media_buttons' => false,
                        'drag_drop_upload' => false,
                        'teeny' => true,
                        'quicktags' => false,
                        'textarea_rows' => 5,
                        // MAKE SURE TINYMCE CHANGES ARE LINKED TO CUSTOMIZER
                        'tinymce' => array(
                            'setup' => "function (editor) {
                  var cb = function () {
                    var linkInput = document.getElementById('$this->id-link')
                    linkInput.value = editor.getContent()
                    linkInput.dispatchEvent(new Event('change'))
                  }
                  editor.on('Change', cb)
                  editor.on('Undo', cb)
                  editor.on('Redo', cb)
                  editor.on('KeyUp', cb) // Remove this if it seems like an overkill
                }"
                        )
                    )
                );
                ?>
            </label>
            <?php
            // PRINT THEM ADMIN SCRIPTS AFTER LAST EDITOR
            if ($num_customizer_teenies_rendered == $num_customizer_teenies_initiated)
                do_action('admin_print_footer_scripts');
        }
    }
}