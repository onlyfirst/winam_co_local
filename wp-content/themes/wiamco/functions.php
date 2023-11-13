<?php

/**
 * News Express functions and definitions
 *
 * @package WordPress
 * @subpackage winamco
 * @since winamco 1.0
 */



/**
 * News Express only works in WordPress 4.4 or later.
 */

if (version_compare($GLOBALS['wp_version'], '4.4-alpha', '<')) {

  require get_template_directory() . '/inc/back-compat.php';

}



if (!function_exists('winamco_setup')):

  /**
   * Sets up theme defaults and registers support for various WordPress features.
   *
   * Note that this function is hooked into the after_setup_theme hook, which
   * runs before the init hook. The init hook is too late for some features, such
   * as indicating support for post thumbnails.
   *
   * Create your own winamco_setup() function to override in a child theme.
   *
   * @since winamco 1.0
   */

  function winamco_setup()
  {

    /*
     * Make theme available for translation.
     * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/winamco
     * If you're building a theme based on News Express, use a find and replace
     * to change 'winamco' to the name of your theme in all the template files
     */

    load_theme_textdomain('winamco');



    // Add default posts and comments RSS feed links to head.

    add_theme_support('automatic-feed-links');



    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */

    add_theme_support('title-tag');



    /*
     * Enable support for custom logo.
     *
     *  @since winamco 1.0
     */

    add_theme_support(
      'custom-logo',
      array(

        'height' => 180,

        'width' => 180,

        'flex-height' => true,

      )
    );



    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
     */

    add_theme_support('post-thumbnails');

    set_post_thumbnail_size(1200, 9999);



    // This theme uses wp_nav_menu() in two locations.

    register_nav_menus(
      array(
        'primary' => __('Primary Menu', 'winamco'),
        'mobile-menu' => __('Left Menu', 'winamco'),
        'footer-menu' => __('Footer Menu', 'winamco'),
      )
    );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */

    add_theme_support(
      'html5',
      array(

        'search-form',

        'comment-form',

        'comment-list',

        'gallery',

        'caption',

      )
    );



    /*
     * Enable support for Post Formats.
     *
     * See: https://codex.wordpress.org/Post_Formats
     */

    add_theme_support(
      'post-formats',
      array(

        'aside',

        'image',

        'video',

        'quote',

        'link',

        'gallery',

        'status',

        'audio',

        'chat',

      )
    );





    // Indicate widget sidebars can use selective refresh in the Customizer.

    //add_theme_support( 'customize-selective-refresh-widgets' );

  }

endif; // winamco_setup

add_action('after_setup_theme', 'winamco_setup');



/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since winamco 1.0
 */

function winamco_widgets_init()
{
  register_sidebar(
    array(
      'name' => __('Sidebar Newsletter', 'winamco'),
      'id' => 'sidebar-newsletter',
      'description' => __('Add widgets here to appear in top of footer.', 'winamco'),
      'before_widget' => '<div id="%1$s" class="widget %2$s">',
      'after_widget' => '</div>',
      'before_title' => '<h2 class="widget-title"><span>',
      'after_title' => '</span></h2>',
    )
  );
}

add_action('widgets_init', 'winamco_widgets_init');



/**
 * Enqueues scripts and styles.
 *
 * @since winamco 1.0
 */

function winamco_scripts()
{
  global $custom_query;

  // Theme stylesheet.

  wp_enqueue_style('winamco_group-fonts', winamco_group_fonts_url(), array(), null);
  wp_enqueue_style('winamco-libs', get_template_directory_uri() . '/css/libs.css', array(), '20200205');
  wp_enqueue_style('winamco-style', get_stylesheet_uri(), array(), time());
  wp_enqueue_style('jquery-ui-style', '//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css', array(), '1');
  wp_enqueue_style('jquery-confirm', get_template_directory_uri() . '/css/jquery-confirm.min.css', array(), '3.3.2');
  wp_enqueue_style('winamco-style', get_stylesheet_uri(), array(), time());


  // jQuery move to bottom

  wp_scripts()->add_data('jquery', 'group', 1);
  wp_scripts()->add_data('jquery-core', 'group', 1);
  wp_scripts()->add_data('jquery-migrate', 'group', 1);

  // Load the html5 shiv.

  wp_enqueue_script('jquery-html5', get_template_directory_uri() . '/js/html5.js', array('jquery'), '3.7.3', true);

  wp_script_add_data('jquery-html5', 'conditional', 'lt IE 9');

  wp_enqueue_script('jquery-respond', get_template_directory_uri() . '/js/respond.min.js', array('jquery'), '1.4.2', true);

  wp_script_add_data('jquery-respond', 'conditional', 'lt IE 9');


  wp_enqueue_script('jquery-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array('jquery'), '20160816', true);


  if (is_singular() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }



  wp_register_script('modernizr-script', get_template_directory_uri() . '/js/modernizr.js', array('jquery'), '1', true);
  wp_enqueue_script('modernizr-script');

  wp_register_script('lightbox-script', get_template_directory_uri() . '/js/lightbox.js', array('jquery'), '1', true);
  wp_enqueue_script('lightbox-script');

  wp_register_script('jquery-ui-script', get_template_directory_uri() . '/js/jquery-ui.min.js', array('jquery'), '1', true);
  wp_enqueue_script('jquery-ui-script');

  wp_register_script('jquery-validate-script', get_template_directory_uri() . '/js/jquery.validate.min.js', array('jquery'), '1.16.0', true);
  wp_enqueue_script('jquery-validate-script');

  wp_register_script('jquery-confirm-script', get_template_directory_uri() . '/js/jquery-confirm.min.js', array('jquery'), '3.3.2', true);
  wp_enqueue_script('jquery-confirm-script');

  wp_register_script('url-helper-script', get_template_directory_uri() . '/js/url-helper.js', array('jquery'), '1', true);
  wp_enqueue_script('url-helper-script');

  wp_enqueue_script('ajax_custom_script', get_template_directory_uri() . '/js/site.js', array('jquery'), '1.0.6', true);
  wp_localize_script(
    'ajax_custom_script',
    'frontendajax',
    array(
      'ajax_url' => admin_url('admin-ajax.php'),
      'terms' => is_tax() ? get_queried_object_id() : null,
      'templateUrl' => get_stylesheet_directory_uri(),
    )
  );

}



add_action('wp_enqueue_scripts', 'winamco_scripts');



if (!function_exists('winamco_group_fonts_url')):

  /**
   * Register Google fonts for Twenty Sixteen.
   *
   * Create your own winamco_group_fonts_url() function to override in a child theme.
   *
   * @since Twenty Sixteen 1.0 
   *
   * @return string Google fonts URL for the theme.
   */

  function winamco_group_fonts_url()
  {
    return 'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap';
  }
endif;



/**
/**
* Custom template tags for this theme.
*/

require get_template_directory() . '/inc/template-tags.php';

require get_template_directory() . '/inc/customizer.php';

require get_template_directory() . '/inc/breadcrumb.php';



// Change admin bar style

add_action('get_header', 'winamco_filter_head');



function winamco_filter_head()
{
  remove_action('wp_head', '_admin_bar_bump_cb');
}

// fix custom panigation error

add_action('pre_get_posts', 'wpse176347_pre_get_posts');

function wpse176347_pre_get_posts($q)
{
  if (!is_admin() && $q->is_main_query() && $q->is_tax('category_product_post')) {
    $q->set('posts_per_page', 12);
  }
  if (is_page_template('page-products.php')) {
    $q->set('posts_per_page', 12);
  }
  if (is_page_template('page-case-study.php')) {
    $q->set('posts_per_page', 15);
  }
}
add_filter('get_the_archive_title', function ($title) {

  if (is_category()) {

    $title = single_cat_title('', false);

  } elseif (is_tag()) {

    $title = single_tag_title('', false);

  } elseif (is_author()) {

    $title = '<span class="vcard">' . get_the_author() . '</span>';

  } elseif (is_tax()) {

    $title = sprintf(__('%1$s'), single_term_title('', false));

  } else {

    $title = post_type_archive_title();

  }

  return $title;

});


// Limit search results by showing only results from multiple post types
function custom_search_filter($query)
{
  if (!is_admin() && $query->is_main_query()) {
    if ($query->is_search) {
      $query->set('post_type', array('post', 'product_post', 'project_post', 'page'));
    }
  }
}

add_action('pre_get_posts', 'custom_search_filter');

function my_acf_init()
{

  acf_update_setting('google_api_key', 'AIzaSyCumDohyJ5o5aBPSQFbxe8f-RlbH04IBcs');

}

add_action('acf/init', 'my_acf_init');



// add_current_nav for custom post type

// add_action('nav_menu_css_class', 'add_current_nav_class', 10, 2 );


function add_current_nav_class($classes, $item)
{



  // Getting the current post details

  global $post;



  // Getting the post type of the current post

  $current_post_type = get_post_type_object(get_post_type($post->ID));

  $current_post_type_slug = $current_post_type->rewrite['slug'];



  // Getting the URL of the menu item

  $menu_slug = strtolower(trim($item->url));



  // If the menu item URL contains the current post types slug add the current-menu-item class

  if ($current_post_type_slug) {

    if (strpos($menu_slug, $current_post_type_slug) !== false) {



      $classes[] = 'current-menu-item';



    }

  }
  // Return the corrected set of classes to be added to the menu item
  return $classes;

}

function getProductQueryData()
{
  $lang = ($_POST['data']['lang']) ? $_POST['data']['lang'] : 'en';
  $paged = $_POST['page'] + 1;
  $order = 'DESC';
  if ($_POST['data']['sort'] === 'oldest') {
    $order = 'ASC';
  }
  $args = array(
    'post_type' => 'product_post',
    'posts_per_page' => 12,
    'lang' => $lang,
    'paged' => $paged,
    'order' => $order,
    'orderby' => 'date'
  );

  $tax_query = array();
  $term = ($_POST['data']['taxanomy']) ? $_POST['data']['taxanomy'] : null;
  if ($term) {
    $args_term = array(
      'taxonomy' => 'category_product_post',
      'field' => 'term_id',
      'terms' => $term,
      'orderby' => 'term_order',
      'order' => 'ASC'
    );
    array_push($tax_query, $args_term);
  }

  if (count($tax_query) > 0) {
    $args = wp_parse_args(
      array(
        'relation' => 'AND',
        'tax_query' => array($tax_query),
      ),
      $args
    );
  }
  return $args;
}

function winamco_loadmore_ajax_handler()
{
  global $wp_query;
  $page = 1;

  $args = getProductQueryData();
  query_posts($args);
  if (have_posts()):
    echo '<div class="product-list">';
    while (have_posts()):
      the_post();
      get_template_part('template-parts/content-product', get_post_format());
    endwhile;
    echo '</div>';
  endif;
  echo '<div id="pagination" data-page="' . $page . '" data-max-page="' . $wp_query->max_num_pages . '" data-found-posts="' . $wp_query->found_posts . '"></div>';
  die;
}
add_action('wp_ajax_loadmore_product', 'winamco_loadmore_ajax_handler');
add_action('wp_ajax_nopriv_loadmore_product', 'winamco_loadmore_ajax_handler');


function winamco_load_single_product_handler()
{
  global $wp_query;
  $lang = ($_POST['data']['lang']) ? $_POST['data']['lang'] : 'en';
  $productId = ($_POST['data']['productId']) ? $_POST['data']['productId'] : null;
  $args = array(
    'post_type' => 'product_post',
    'posts_per_page' => 1,
    'lang' => $lang,
    'p' => $productId
  );
  query_posts($args);
  if (have_posts()):
    echo '<div class="home-product-nav">';
    while (have_posts()):
      the_post();
      get_template_part('template-parts/content-product-home', get_post_format());
    endwhile;
    echo '</div>';
  endif;
  die;
}
add_action('wp_ajax_load_single_product', 'winamco_load_single_product_handler');
add_action('wp_ajax_nopriv_load_single_product', 'winamco_load_single_product_handler');

// get cart list

function getCartQueryData()
{
  $lang = ($_POST['data']['lang']) ? $_POST['data']['lang'] : 'en';
  $cartItems = ($_POST['data']['cartItems']) ? $_POST['data']['cartItems'] : [];
  $productsIds = array_map('intval', array_column($cartItems, 'productId'));
  $args = array(
    'post_type' => 'product_post',
    'posts_per_page' => -1,
    'lang' => $lang,
    'post__in' => $productsIds
  );
  return $args;
}
function winamco_loadcart_ajax_handler()
{
  global $wp_query;
  $cartItems = ($_POST['data']['cartItems']) ? $_POST['data']['cartItems'] : null;
  $args = getCartQueryData();
  query_posts($args);
  if (have_posts() && $cartItems):
    echo '<table class="table-cart">';
    get_template_part(
      'template-parts/content-cart-head'
    );
    $i = 0;
    while (have_posts()):
      the_post();
      get_template_part(
        'template-parts/content-cart',
        null,
        array(
          'cartItems' => $cartItems[$i],
        )
      );
      $i++;
    endwhile;
    echo '</table></div>';
    die;
  else:
    $json = array();
    $html = '<table class="table-cart">';
    $html .= '<tr class="cart-item">';
    $html .= '<th class="cart-item__col-product">' . __('Product', 'winamco') . '</th>';
    $html .= '<th class="cart-item__col-code">' . __('Code', 'winamco') . '</th>';
    $html .= '<th class="cart-item__col-name">' . __('Product name', 'winamco') . '</th>';
    $html .= '<th class="cart-item__col-details">' . __('Details', 'winamco') . '</th>';
    $html .= '<th class="cart-item__col-qty">' . __('Qty', 'winamco') . '</th>';
    $html .= '<th class="cart-item__col-action"></th>';
    $html .= '</tr>';
    $pageId = get_locale() == 'vi' ? 177 : 174;
    $html .= '<tr class="cart-item">';
    $html .= '<td colspan="7" class="no-cart">' . __('No items in cart', 'winamco') . ' <a href="' . get_page_link($pageId) . '">' . __('Continue shoppping', 'winamco') . '</a>';
    $html .= '</td></tr>';
    $html .= '</table></div>';
    $json['html'] = $html;
    wp_send_json_error($json);
    die();
  endif;

}
add_action('wp_ajax_load_cart', 'winamco_loadcart_ajax_handler');
add_action('wp_ajax_nopriv_load_cart', 'winamco_loadcart_ajax_handler');

flush_rewrite_rules(false);

// theme option
if (function_exists('acf_add_options_page')) {
  $languages = array('en', 'vi');
  foreach ($languages as $lang) {
    acf_add_options_page(
      array(
        'page_title' => 'Site Options (' . strtoupper($lang) . ')',
        'menu_title' => __('Site Options (' . strtoupper($lang) . ')', 'text-domain'),
        'menu_slug' => "site-options-${lang}",
        'post_id' => $lang
      )
    );
  }
}

function limit_text($text, $limit)
{
  if (str_word_count($text, 0) > $limit) {
    $words = str_word_count($text, 2);
    $pos = array_keys($words);
    $text = substr($text, 0, $pos[$limit]) . '...';
  }
  return $text;
}

function get_all_product_posts()
{
  $count_posts = wp_count_posts('product_post');

  $published_posts = $count_posts->publish;
  return $published_posts;
}

// display cart form
/**
 * This function displays the validation messages, the success message, the container of the validation messages, and the
 * contact form.
 */
function get_email_body_cart()
{
  $region = isset($_POST['formData']['region']) ? sanitize_text_field($_POST['formData']['region']) : '';
  $name = isset($_POST['formData']['name']) ? sanitize_text_field($_POST['formData']['name']) : '';
  $email = isset($_POST['formData']['email']) ? sanitize_text_field($_POST['formData']['email']) : '';
  $phone = isset($_POST['formData']['phone']) ? sanitize_text_field($_POST['formData']['phone']) : '';
  $message = isset($_POST['formData']['message']) ? sanitize_textarea_field($_POST['formData']['message']) : '';
  $body = '<p style="marin: 0;line-height: 140%; text-align: left; font-size: 16px;">';
  $body .= '<strong>Region:</strong> ' . $region . ' <br />';
  $body .= '<strong>Name:</strong> ' . $name . ' <br />';
  $body .= '<strong>Email:</strong> ' . $email . ' <br />';
  $body .= '<strong>Mobile number:</strong> ' . $phone . ' <br />';
  $body .= '<strong>Messenger:</strong> ' . $message . ' <br />';
  $body .= '</p><p style="marin: 0;">&nbsp;</p><p style="marin: 0;">&nbsp;</p>';
  $cartItems = ($_POST['cartItems']) ? $_POST['cartItems'] : null;
  $args = getCartQueryData();
  query_posts($args);
  if (have_posts() && $cartItems) {
    $body .= '<table style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 320px;Margin: 0 auto;background-color:
    #fff;width:100%" cellpadding="0" cellspacing="0"><tbody>';
    $body .= '<tr style="vertical-align: top">';
    $body .= '<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top; padding: 10px 0;"><b>Product</b></td>';
    $body .= '<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top; padding: 10px 0;"><b>Code</b></td>';
    $body .= '<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top; padding: 10px 0;"><b>Product name</b></td>';
    $body .= '<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top; padding: 10px 0;"><b>Details</b></td>';
    $body .= '<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top; padding: 10px 0;"><b>Qty</b></td>';
    $body .= '</tr>';
    $i = 0;
    while (have_posts()) {
      the_post();
      $body .= '<tr style="vertical-align: top">';
      $body .= '<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: middle; padding: 10px 0; border-top: 1px solid #ccc;">';
      $thunbnail = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'medium') : get_template_directory_uri() . '/images/no-image.png';
      $body .= '<img src="' . $thunbnail . '" alt="" width="70px">';
      $body .= '</td>';
      $product_code = get_field('product_code');
      $body .= '<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: middle; padding: 10px 0; border-top: 1px solid #ccc;">';
      $body .= $product_code;
      $body .= '</td>';
      $body .= '<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: middle; padding: 10px 0; border-top: 1px solid #ccc;">';
      $body .= '<a href="' . esc_url(get_permalink()) . '">' . get_the_title() . '</a>';
      $body .= '</td>';
      $specifications = get_field('specifications');
      $safety = $specifications['safety'];
      $year = $specifications['year'];
      $size = $specifications['size'];
      $body .= '<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: middle; padding: 10px 0; border-top: 1px solid #ccc;">';
      $body .= '<ul style="margin: 0; padding: 0;">';
      $htmlY = $year ? '<li>' . $year . ' Year</li>' : '';
      $htmlSize = $size ? '<li>Size: ' . $size . '</li>' : '';
      $htmlSafety = $safety ? '<li>Safety</li>' : '';
      $body .= $htmlY;
      $body .= $htmlSize;
      $body .= $htmlSafety;
      $body .= '</ul>';
      $body .= '</td>';
      $body .= '<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: middle; padding: 10px 0; border-top: 1px solid #ccc;">';
      $body .= $cartItems[$i]['quantity'];
      $body .= '</td>';
      $body .= '</tr>';
      $i++;
    }
    $body .= '</tbody></table>';
  }
  return $body;
}
function display_cart_form()
{

  ?>
  <!-- Echo a container used that will be used for the JavaScript validation -->
  <div id="validation-messages-container"></div>
  <form id="cart-form" action="<?php echo get_template_directory_uri(); ?>/sendy/cart.php" method="post">
    <h2>
      <?php echo pll_e('Order Information', 'winamco'); ?>
    </h2>
    <div class="form-section">
      <input placeholder="<?php echo pll_e('Full name', 'winamco'); ?>" type="text" id="full-name" name="name" class="form-control">
    </div>
    <div class="form-section">
      <input placeholder="<?php echo pll_e('Mobile number', 'winamco'); ?>" type=" text" id="phone" name="phone" class="form-control">
    </div>
    <div class="form-section">
      <input placeholder="<?php echo pll_e('Email', 'winamco'); ?>" type="email" id="email" name="email" class="form-control">
    </div>
    <div class="form-section">
      <select name="region" id="region" class="form-control">
        <option value="">
          <?php echo pll_e('Choose country', 'winamco'); ?>
        </option>
      </select>
    </div>
    <div class="form-section">
      <input placeholder="<?php echo pll_e('Address', 'winamco'); ?>" type="text" id="address" name="address" class="form-control">
    </div>
    <div class="form-section">
      <textarea id="messenge" name="message" placeholder="<?php echo pll_e('Messenger', 'winamco'); ?>" class=" form-control"></textarea>
    </div>
    <div class="form-section form-section--capcha">
      <div class="capcha-input">
        <input type="text" name="captcha" class="form-control" placeholder="<?php echo pll_e('Enter Captcha', 'winamco'); ?>" />
      </div>
      <div class="capcha-img">
        <img id="capcha" src="<?php echo get_template_directory_uri() ?>/capcha/captcha.php" /><button type="button" id="reload-capcha"><em class="fa fa-refresh "></em></button>
      </div>
    </div>
    <div class="form-section form-section--agree">
      <input type="checkbox" id="agree" name="agree" value="1">&nbsp;
      <label for="agree">
        <b>
          <?php echo pll_e('I would like an offer with installation and transport', 'winamco'); ?>
        </b>
      </label>
    </div>
    <div style="display:none;">
      <label for="hp">HP</label><br />
      <input type="text" name="hp" id="hp" />
    </div>
    <input type="hidden" name="list" value="l763xG46oS8924W2icI5CJSF2w" />
    <input type="hidden" name="subform" value="yes" />
    <button type="submit" class="btn btn-primary" id="cart-form-submit" value="ok">
      <?php echo pll_e('Place Order', 'winamco'); ?>
    </button>
  </form>

  <?php
}

//Add the shortcode
add_shortcode('cart_form', 'display_cart_form');

function winamco_submit_order_cart_ajax_handler()
{
  $json = array();
  if (!empty($_POST['data']['formData']['captcha'])) {
    if ($_SESSION['captcha'] != $_POST['data']['formData']['captcha']) {
      $json['message'] = __('Invalid captcha!', 'winamco');
      wp_send_json_error($json);
      die();
    }
  } else {
    $json['message'] = __('Please fill up captcha field!', 'winamco');
    wp_send_json_error($json);
    die();
  }

  $fullName = isset($_POST['data']['formData']['full_name']) ? $_POST['data']['formData']['full_name'] : '';
  $mail = get_option('admin_email');
  $subject = sprintf(__('New message of cart order from %s', 'winamco'), $fullName);
  $message = get_email_body_cart();


  $send = wp_mail($mail, $subject, $message);
  if ($send) {
    $json['message'] = __('Your message has been successfully sent.', 'winamco');
    wp_send_json_success($json);
  } else {
    $json['message'] = __('An error occurred, please try again later.', 'winamco');
    wp_send_json_error($json);
  }

  die;
}
add_action('wp_ajax_submit_order_cart', 'winamco_submit_order_cart_ajax_handler');
add_action('wp_ajax_nopriv_submit_order_cart', 'winamco_submit_order_cart_ajax_handler');

function register_my_session()
{
  if (!session_id()) {
    session_start();
  }
}

add_action('init', 'register_my_session');
// String stranslate

add_action('init', function () {
  pll_register_string('Oh! This page could not be found.', 'Oh! This page could not be found.');
  pll_register_string('Products', 'Products');
  pll_register_string('Nothing Found', 'Nothing Found');
  pll_register_string('Updating content', 'Updating content');
  pll_register_string('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'Sorry, but nothing matched your search terms. Please try again with some different keywords.');
  pll_register_string('Search', 'Search');
  pll_register_string('Follow us', 'Follow us');
  pll_register_string('Like on Facebook', 'Like on Facebook');
  pll_register_string('Follow on Twitter', 'Follow on Twitter');
  pll_register_string('Watch on Instagram', 'Watch on Instagram');
  pll_register_string('Usefull Link', 'Usefull Link');
  pll_register_string('Subscribe', 'Subscribe');
  pll_register_string('Learn more', 'Learn more');
  pll_register_string('Like this post?', 'Like this post?');
  pll_register_string('Click the \'Like\' button and let us know, or share with a friend.', 'Click the \'Like\' button and let us know, or share with a friend.');
  pll_register_string("All Projects", "All Projects");
  pll_register_string('All products', 'All products');
  pll_register_string("All", "All");
  pll_register_string('Download pdf', 'Download pdf');
  pll_register_string('Sort by', 'Sort by');
  pll_register_string('Default', 'Default');
  pll_register_string('Newest date', 'Newest date');
  pll_register_string('Oldest date', 'Oldest date');
  pll_register_string(' Product Features', ' Product Features');
  pll_register_string('Add to cart', 'Add to cart');
  pll_register_string('Call us now', 'Call us now');
  pll_register_string('Download PDF', 'Download PDF');
  pll_register_string('Similar products', 'Similar products');
  pll_register_string('Recent projects', 'Recent projects');
  pll_register_string("Year", "Year");
  pll_register_string("Code", "Code");
  pll_register_string("Choose country", "Choose country");
  pll_register_string("Contact information", "Contact information");
  pll_register_string("Order information", "Order information");
  pll_register_string("Name", "Name");
  pll_register_string("Full name", "Full name");
  pll_register_string("Email", "Email");
  pll_register_string("City", "City");
  pll_register_string("Region", "Region");
  pll_register_string("Phone number", "Phone number");
  pll_register_string("Messenger", "Messenger");
  pll_register_string("I would like an offer with installation and transport", "I would like an offer with installation and transport");
  pll_register_string("Send", "Send");
  pll_register_string("Submit", "Submit");
  pll_register_string("Subscribe", "Subscribe");
  pll_register_string("Place Order", "Place Order");
  pll_register_string("Enter Captcha", "Enter Captcha");
  pll_register_string("Please enter a valid name.", "Please enter a valid name.");
  pll_register_string("Please enter a valid email address.", "Please enter a valid email address.");
  pll_register_string("Mail to", "Mail to");
  pll_register_string("Read more", "Read more");
  pll_register_string("Related Product", "Related Product");
  pll_register_string("Used products", "Used products");
  pll_register_string("Thank you for subscribing!", "Thank you for subscribing!");
  pll_register_string("Thank you Your subscription has now been successfully confirmed", "Thank you Your subscription has now been successfully confirmed");
  pll_register_string("Subscribe", "Subscribe");
  pll_register_string("Already subscribed.", "Already subscribed.");
  pll_register_string("Your list ID is invalid.", "Your list ID is invalid.");
  pll_register_string("Contact information has been sent. Thank you!", "Contact information has been sent. Thank you!");
  pll_register_string("Contact information already sent", "Contact information already sent");
  pll_register_string("Order information has been sent. Thank you!", "Order information has been sent. Thank you!");
  pll_register_string("Require assistance", "Require assistance");
  pll_register_string("Greetings, I'm Nguyen Tay Tai Nguyen, CEO of WINAM.", "Greetings, I'm Nguyen Tay Tai Nguyen, CEO of WINAM.");
  pll_register_string("Greetings, I'm Nguyen Tay Tai Nguyen, the General Director of WINAM. If you have any inquiries, please don't hesitate to contact me through this form. I commit to providing a personal response within a 24-hour timeframe.", "Greetings, I'm Nguyen Tay Tai Nguyen, the General Director of WINAM. If you have any inquiries, please don't hesitate to contact me through this form. I commit to providing a personal response within a 24-hour timeframe.");
  pll_register_string("Company", "Company");
  pll_register_string("Feel free to write your message or question here.", "Feel free to write your message or question here.");
  pll_register_string("Thanks", "Thanks");
  pll_register_string("We'll be in touch soon", "We'll be in touch soon");
});