<?php
function register_my_menu()
{
    register_nav_menu('new-menu', __('Main Menu'));
}

add_action('init', 'register_my_menu');

// Remove admin bar from frontend
function hide_admin_bar_from_front_end()
{
    if (is_blog_admin()) {
        return true;
    }
    return false;
}

add_filter('show_admin_bar', 'hide_admin_bar_from_front_end');


function wpse28782_remove_menu_items()
{
    if (!current_user_can('administrator')):
        remove_menu_page('edit.php?post_type=distributor');
        remove_menu_page('edit.php?post_type=guitar_news');

        remove_menu_page('edit.php'); // Posts
        remove_menu_page('upload.php'); // Media
        remove_menu_page('link-manager.php'); // Links
        remove_menu_page('edit-comments.php'); // Comments
        remove_menu_page('edit.php?post_type=page'); // Pages
        remove_menu_page('plugins.php'); // Plugins
        remove_menu_page('themes.php'); // Appearance
        remove_menu_page('users.php'); // Users
        remove_menu_page('tools.php'); // Tools
        remove_menu_page('options-general.php'); // Settings
        remove_menu_page('profile.php'); // Settings
        remove_menu_page('index.php'); // Settings


    endif;
}

add_action('admin_menu', 'wpse28782_remove_menu_items');

function HTMLGeneratedByMusicSpectrumArray($musicSpectrumParm)
{
    $musicSpectrumArray = get_posts($musicSpectrumParm);
    $musicSpectrumHtml  = '';
    foreach ($musicSpectrumArray as $musicSpectrumObject) {
        $musicSpectrumHtml .= getMusicSpectrumHTMLByMusicSpectrumObject($musicSpectrumObject);
    }
    return $musicSpectrumHtml;
}

function getMusicSpectrumHTMLByMusicSpectrumObject($musicSpectrumObject)
{
    $currentMusicSpectrumName   = $musicSpectrumObject->post_title;
    $currentMusicSpectrumImg    = get_field('music_spectrum_Image', $musicSpectrumObject->ID);
    $currentMusicSpectrumSource = get_field('music_spectrum_source', $musicSpectrumObject->ID);
    $currentMusicSpectrumSource = $currentMusicSpectrumSource ? "<i class=\"label\">{$currentMusicSpectrumSource}</i>" : '';
    $currentMusicSpectrumLink   = esc_url(get_permalink($musicSpectrumObject->ID));
    $currentMusicSpectrumHtml   = "<li><a href=\"{$currentMusicSpectrumLink}\"><img class=\"img\" src=\"{$currentMusicSpectrumImg}\"
	                                alt=\"{$currentMusicSpectrumName}\"><div class=\"title text-ellipsis\">{$currentMusicSpectrumName}</div>{$currentMusicSpectrumSource}</a></li>";
    return $currentMusicSpectrumHtml;
}

function getTheFirstPageUrlByTemplatesParm($templatesParm)
{
    $pages = get_pages($templatesParm);
    return esc_url(get_permalink($pages[0]->ID));
}

function HTMLGeneratedByGuitarNewsArray($guitarNewsParm)
{
    $guitarNewsArray = get_posts($guitarNewsParm);
    $guitarNewsHtml  = '';
    foreach ($guitarNewsArray as $guitarNewsObject) {
        $guitarNewsHtml .= getGuitarNewsHTMLByGuitarNewsObject($guitarNewsObject);
    }
    return $guitarNewsHtml;
}

function getGuitarNewsHTMLByGuitarNewsObject($guitarNewsObject)
{
    $currentGuitarNewsName          = $guitarNewsObject->post_title;
    $currentGuitarNewsImg           = get_field('guitar_news_Image', $guitarNewsObject->ID);
    $currentGuitarNewsLink          = esc_url(get_permalink($guitarNewsObject->ID));
    $currentGuitarNewsPostMimeType  = $guitarNewsObject->post_mime_type;
    $currentGuitarNewsVideoIconHtml = '';
    $currentGuitarNewsExtraHtml     = '';
    if ($currentGuitarNewsPostMimeType == 'video/mp4') {
        $currentGuitarNewsVideoTags     = array_map(function ($tag) {
            return "<span>#{$tag->name}</span>";
        }, (array)get_the_tags($guitarNewsObject->ID));
        $currentGuitarNewsVideoTagsHtml = implode('', $currentGuitarNewsVideoTags);
        $currentGuitarNewsVideoIconHtml = '<i class="icon-video"><img src="/wp-content/themes/CIA/dist/images/c260ab17c619a7c262a5dbdcf88f9949.png" width="18" height="16" alt=""></i>';
        $currentGuitarNewsViewsCount    = get_field('guitar_news_views_count', $guitarNewsObject->ID);
        $currentGuitarNewsExtraHtml     = "<div class=\"change clearfix\"><div class=\"tags fl\">{$currentGuitarNewsVideoTagsHtml}</div><div class=\"visit fl\"><img class=\"icon-arrow\" src=\"/wp-content/themes/CIA/dist/images/03ff070dd25a5e3332bf0bf51690ecb6.png\" width=\"16\" height=\"16\" alt=\"\"><span class=\"num\">{$currentGuitarNewsViewsCount}</span></div></div>";
    }
    // 判断是否用的假用户
    $currentFakeAuthorOfGuitarNews = get_field('upload_by', $guitarNewsObject->ID);
    $currentPostAuthorId           = $currentFakeAuthorOfGuitarNews ? $currentFakeAuthorOfGuitarNews['ID'] : $guitarNewsObject->post_author;
    // 获取作者的相关数据
    $currentPostAuthor             = get_userdata($currentPostAuthorId);
    $currentGuitarNewsAuthorName   = $currentPostAuthor->data->user_nicename;
    $currentGuitarNewsAuthorAvatar = get_avatar($currentPostAuthorId, 28, 'https://via.placeholder.com/28x28', $currentGuitarNewsAuthorName, ['class' => ['head']]);
    $currentGuitarNewsHtml         = "<li>
			    								<a href=\"{$currentGuitarNewsLink}\">
			    									<img class=\"img\" src=\"{$currentGuitarNewsImg}\" alt=\"\">
			                                		<div class=\"title text-ellipsis\">{$currentGuitarNewsName}</div>
		                            				{$currentGuitarNewsVideoIconHtml}
			                                	</a>
			                            		{$currentGuitarNewsExtraHtml}
			                            		<div class=\"user\">
			                            			{$currentGuitarNewsAuthorAvatar}
			                            			<span class=\"name\">{$currentGuitarNewsAuthorName}</span>
			                            		</div>
			                        		</li>";
    return $currentGuitarNewsHtml;
}

add_theme_support('post-formats', array('video', 'aside'));

function rename_post_formats($safe_text)
{
    if ($safe_text == 'Aside')
        return 'Text';

    return $safe_text;
}

add_filter('esc_html', 'rename_post_formats');

function guitar_news_filter_handler($data, $postarr)
{
    if ($postarr['post_type'] == 'guitar_news' && $postarr['post_format'] == 'video') {
        $data['post_mime_type'] = 'video/mp4';
    } else if ($postarr['post_type'] == 'guitar_news' && ($postarr['post_format'] == '0' || $postarr['post_format'] == 'aside')) {
        $data['post_mime_type'] = 'text/html';
    }
    return $data;
}

add_filter('wp_insert_post_data', 'guitar_news_filter_handler', '99', 2);

function ajax_login_init()
{

    wp_register_script('ajax-login-script', get_template_directory_uri() . '/ajax-login-script.js', array('jquery'));
    wp_enqueue_script('ajax-login-script');

    wp_localize_script('ajax-login-script', 'ajax_login_object', array(
        'ajaxurl'        => admin_url('admin-ajax.php'),
        'redirecturl'    => home_url(),
        'loadingmessage' => __('Sending user info, please wait...')
    ));

    // Enable the user with no privileges to run ajax_login() in AJAX
    add_action('wp_ajax_nopriv_ajaxlogin', 'ajax_login');
}

// Execute the action only if the user isn't logged in
if (!is_user_logged_in()) {
    add_action('init', 'ajax_login_init');
}

function ajax_login()
{

    // First check the nonce, if it fails the function will break
    check_ajax_referer('ajax-login-nonce', 'security');

    // Nonce is checked, get the POST data and sign user on
    $info                  = array();
    $info['user_login']    = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember']      = true;

	$user_signon = wp_signon( $info, false );
	if ( is_wp_error($user_signon) ){
		return wp_send_json(array(
			'errorCode'=> 1,
			'errorMsg'=> 'Wrong username or password.'
		), 200);
	} else {
		return wp_send_json(array(
			'errorCode'=> 0,
			'errorMsg'=> ''
		), 200);
	}

    die();
}

function get_the_search_result_pagination($query, $range = 4)
{
    global $paged, $wp_query;
    if (!$max_page) {
        $max_page = $query->max_num_pages;
    }
    $paginationHtml = '';
    if ($max_page > 1) {
        $paged            = $paged ?: 1;
        $paginationHtml   .= '<div class="pagination">';
        $previousDisabled = $paged > 1 ? '' : ' disabled="disabled"';
        $previouUrl       = previous_posts(false);
        $paginationHtml   .= "<a href=\"{$previouUrl}\"{$previousDisabled} class=\"btn-prev\"><img width=\"16\" height=\"18\" src=\"/wp-content/themes/CIA/dist/images/f77a6b38b33f56b02f3c26af1f5eefb3.png\" alt=\"\"></a>";
        $paginationHtml   .= '<ul class="pager">';

        if ($max_page > $range) {
            if ($paged < $range) {
                for ($i = 1; $i <= ($range + 1); $i++) {
                    $paginationHtml .= '<li class="number';
                    if ($i == $paged) $paginationHtml .= ' active';
                    $paginationHtml .= "\"><a href='" . get_pagenum_link($i) . "'>$i</a></li>";
                }
                if ($i <= $max_page) {
                    $paginationHtml .= "<li class=\"more\">…</li><li class=\"number\"><a href='" . get_pagenum_link($max_page) . "'>$max_page</a></li>";
                }
            } elseif ($paged >= ($max_page - ceil(($range / 2)))) {
                if (($max_page - $range) > 1) {
                    $paginationHtml .= "<li class=\"number\"><a href='" . get_pagenum_link(1) . "'>1</a></li><li class=\"more\">…</li>";
                }
                for ($i = $max_page - $range; $i <= $max_page; $i++) {
                    $paginationHtml .= '<li class="number';
                    if ($i == $paged) $paginationHtml .= ' active';
                    $paginationHtml .= "\"><a href='" . get_pagenum_link($i) . "'>$i</a></li>";
                }
                if ($i <= $max_page) {
                    $paginationHtml .= "<li class=\"more\">…</li><li class=\"number\"><a href='" . get_pagenum_link($max_page) . "'>$max_page</a></li>";
                }
            } elseif ($paged >= $range && $paged < ($max_page - ceil(($range / 2)))) {
                if (($paged - ceil($range / 2)) > 1) {
                    $paginationHtml .= "<li class=\"number\"><a href='" . get_pagenum_link(1) . "'>1</a></li><li class=\"more\">…</li>";
                }
                for ($i = ($paged - ceil($range / 2)); $i <= ($paged + ceil(($range / 2))); $i++) {
                    $paginationHtml .= '<li class="number';
                    if ($i == $paged) $paginationHtml .= ' active';
                    $paginationHtml .= "\"><a href='" . get_pagenum_link($i) . "'>$i</a></li>";
                }
                if ($i <= $max_page) {
                    $paginationHtml .= "<li class=\"more\">…</li><li class=\"number\"><a href='" . get_pagenum_link($max_page) . "'>$max_page</a></li>";
                }
            }
        } else {
            for ($i = 1; $i <= $max_page; $i++) {
                $paginationHtml .= '<li class="number';
                if ($i == $paged) $paginationHtml .= ' active';
                $paginationHtml .= "\"><a href='" . get_pagenum_link($i) . "'>$i</a></li>";
            }
        }
        $paginationHtml .= "</ul>\n";
        $nextDisabled   = $paged != $max_page ? '' : ' disabled="disabled"';
        $nextUrl        = next_posts($max_page, false);
        $paginationHtml .= "<a href=\"{$nextUrl}\"{$nextDisabled} class=\"btn-prev\"><img width=\"16\" height=\"18\" src=\"/wp-content/themes/CIA/dist/images/166f0337fed06c8484661d7cb7edde90.png\" alt=\"\"></a>";
        $paginationHtml .= '</div>';
    }

    return $paginationHtml;
}

function getGuitarMusicSpectrum($params)
{
    $params['post_type']      = 'music_spectrum';
    $params['meta_key']       = 'music_spectrum_views_count';
    $params['orderby']        = 'meta_value_num';
    $guitarMusicSpectrumQuery = new WP_Query($params);
    $guitarMusicSpectrumArray = $guitarMusicSpectrumQuery->posts;
    $guitarMusicSpectrumHtml  = '<ul>';
    $paginationHtml           = '';
    if ($guitarMusicSpectrumArray) {
        foreach ($guitarMusicSpectrumArray as $musicSpectrumObject) {
            $currentMusicSpectrumName   = $musicSpectrumObject->post_title;
            $currentMusicSpectrumImg    = get_field('music_spectrum_Image', $musicSpectrumObject->ID);
            $currentMusicSpectrumSource = get_field('music_spectrum_source', $musicSpectrumObject->ID);
            $currentMusicSpectrumSource = $currentMusicSpectrumSource ? "<i class=\"label\">{$currentMusicSpectrumSource}</i>" : '';
            $currentMusicSpectrumLink   = esc_url(get_permalink($musicSpectrumObject->ID));
            $guitarMusicSpectrumHtml    .= "<li><a href=\"{$currentMusicSpectrumLink}\">
                                <div class=\"img fl\"><img src=\"{$currentMusicSpectrumImg}\" width=\"120\" height=\"120\" alt=\"\"> {$currentMusicSpectrumSource}</div>
                                <div class=\"info-box fl\"><p class=\"name text-ellipsis\">{$currentMusicSpectrumName}</p></div>
                            </a></li>";
        }
        $paginationHtml = get_the_search_result_pagination($guitarMusicSpectrumQuery);
    } else {
        $guitarMusicSpectrumHtml = '<ul style="text-align: center;"><img width="350" height="150" src="https://via.placeholder.com/350x150" alt="">';
    }
    wp_reset_postdata();
    $guitarMusicSpectrumHtml .= '</ul>' . $paginationHtml;
    return $guitarMusicSpectrumHtml;
}

add_action('init', 'check_logout');

function check_logout() {
	if(!isset($_GET['logout']) || ($_GET['logout'] != '1'))
		return;

	$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

	if(is_user_logged_in()) {
		wp_logout();
		$url = home_url() . $path;
		wp_redirect($url);
		exit();
	}
}  // check_logout()

function vb_reg_new_user() {

	// First check the nonce, if it fails the function will break
	check_ajax_referer( 'ajax-login-nonce', 'security' );

	// Post values
	$username = $_POST['username'];
	$password = $_POST['password'];
	$code = $_POST['code'];


	// Todo: Server side validation here

	// Todo: custom field here, phone
	$userdata = array(
		'user_login' => $username,
		'user_pass'  => $password,
	);

	// Check DB for correct code
	global $wpdb;
	$tableName = $wpdb->prefix . 'phone_code';

	$results = $wpdb->get_results("SELECT * FROM " . $tableName . " where phone=" . $_POST['username']);

	if(isset($results) && $results[0]->code != $code) {
		return wp_send_json(array(
			'errorCode'=> 1,
			'errorMsg'=> '验证码错误'
		), 200);
	}

	// Delete the code record from DB and insert new user
	$wpdb->delete( $tableName, array( 'phone' => $_POST['username'] ) );
	$user_id = wp_insert_user( $userdata ) ;

	// Return
	if( !is_wp_error($user_id) ) {

		return wp_send_json(array(
			'errorCode'=> 0,
			'errorMsg'=> ''
		), 200);

	} else {
		return wp_send_json(array(
			'errorCode'=> 1,
			'errorMsg'=>$user_id->get_error_message()
		), 200);
	}
	die();
}

add_action('wp_ajax_register_user', 'vb_reg_new_user');
add_action('wp_ajax_nopriv_register_user', 'vb_reg_new_user');