<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
	<link rel="stylesheet"
	      href="https://aliblog-1254407033.cos.ap-guangzhou.myqcloud.com/layui-v2.3.0/layui/css/layui.css">
    <script type="text/javascript"
            src="https://aliblog-1254407033.cos.ap-guangzhou.myqcloud.com/layui-v2.3.0/layui/layui.js"></script>
    <script type="text/javascript" src="/wp-content/themes/CIA/dist/commons.bundle.js"></script>

    <?php
    $currentPageId = get_the_ID();
    switch ($currentPageId){
        case '82':
            echo '<script type="text/javascript" src="/wp-content/themes/CIA/dist/js/guitarDatabase.bundle.js"></script>';
            break;
        case '80':
	        echo '<script type="text/javascript" src="/wp-content/themes/CIA/dist/js/home.bundle.js"></script>';
	        break;
        default:
            echo '';
            break;
    }
    ?>
 
</head>

<body <?php body_class(); ?>>

<header class="header clearfix" id="header">
<!--    Todo: find a better place to input this into-->
	<?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
    <div class="center">
        <div class="logo fl"><a href="/"> <img
                        src="/wp-content/themes/CIA/dist/images/171a7e2b87b3bd8beb04d4d99f501a0d.png" width="147" height="20"
                        alt=""> </a></div>
        <div class="right-wrap fr">
            <nav class="nav fl">
                <ul>
                    <li <?php if(get_the_ID() == 80) {echo 'class="active"';}?>><a href="<?php echo esc_url( get_permalink(80) ); ?>">首页</a></li>
                    <li <?php if(get_the_ID() == 82) {echo 'class="active"';}?>><a href="<?php echo esc_url( get_permalink(82) ); ?>">吉他数据库</a></li>
                    <li <?php if(in_array(get_the_ID(), [84, 123, 138]) || get_post()->post_type == 'music_spectrum') {echo 'class="active"';}?>><a href="<?php echo esc_url( get_permalink(84) ); ?>">曲谱</a></li>
                    <li><a href="#">制谱</a></li>
                    <li <?php if(in_array(get_the_ID(), [88, 116])) {echo 'class="active"';}?>><a href="<?php echo esc_url( get_permalink(88) ); ?>">资讯</a></li>
                    <li><a href="#">联系我们</a> <img class="icon-arrow"
                                                  src="/wp-content/themes/CIA/dist/images/19cd3cc0ac3b4e1f1f642006b97dea20.png"
                                                  width="12" height="14" alt=""> <img class="icon-arrow-y"
                                                                                      src="/wp-content/themes/CIA/dist/images/6465a2cff6c59a83724f8006958d361e.png"
                                                                                      width="20" height="22" alt="">
                        <div class="hover-wrap">
                            <ul>
                                <li><a class="clickThrowCraft" href="javascript:void(0);"> <i class="icon"></i> <span>我要投稿</span>
                                    </a></li>
                                <li><a class="clickEnter" href="javascript:void(0);"> <i class="icon"></i>
                                       <span>商家入驻</span> </a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="menu-wrap fr">
                <?php if(  is_user_logged_in() ) {
	                $current_user = wp_get_current_user();
	                $userName = $current_user->display_name;
	                // Todo: get default image if no user defined avatar
	                $avatarUrl = get_avatar_url( $current_user->ID ) || 'http://p3.music.126.net/VyEOqlhwbjDVfLkv3C3U9Q==/109951163408473790.jpg?param=44y44';
	                if ($avatarUrl == '1') {
		                $avatarUrl = 'http://p3.music.126.net/VyEOqlhwbjDVfLkv3C3U9Q==/109951163408473790.jpg?param=44y44';
                    }
                    ?>
                    <div class="user"><a href="#"> <img class="head"
                                                        src="<?php echo $avatarUrl;?>"
                                                        width="44" height="44" alt=""> <span class="name text-ellipsis"><?php echo $userName?></span>
                        </a>
                        <div class="hover-wrap">
                            <?php
                                global $wp;
                                $current_url = home_url( add_query_arg( array(), $wp->request ) );
                            ?>
                            <ul>
                                <li><a href="/user-center"> <i class="icon"></i> <span>个人主页</span> </a></li>
                                <li><a href="/user-setting/"> <i class="icon"></i> <span>账号设置</span> </a></li>
                                <li><a href="javascript:void(0);"> <i class="icon"></i> <span>消息通知</span> </a></li>
                                <li><a href="<?php echo $current_url . '?logout=1'; ?>"> <i class="icon"></i> <span>退出登录</span> </a></li>
                            </ul>
                        </div>
                    </div>
                <?php } else {?>
                    <div class="no-login">
                        <div class="login"><span class="text">登录</span>
                            <div class="login-box"><p class="title">登录之后可以</p>
                                <div class="hot-tips">下载全网高清曲谱</div>
                                <a href="javascript:void(0);" class="login-btn clickLogin" id="clickLogin">立即登录</a>
                            </div>
                        </div>
                        <a class="register clickReg" href="javascript:void(0);">注册</a></div>
                    </div>
                <?php } ?>

        </div>
    </div>
</header>



