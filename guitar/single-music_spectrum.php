<?php
get_header(); ?>
<?php

// 获取浏览数
$selector   = 'music_spectrum_views_count';
$viewsCount = get_field($selector);

// 增加浏览数
$viewsCount++;
update_field($selector, $viewsCount);

// 获取内容
$currentPost               = get_post();
$currentPostAuthor         = get_userdata($currentPost->post_author);
$currentPost->authorName   = $currentPostAuthor->data->user_nicename;
$currentPost->authorAvatar = get_avatar($currentPost->post_author, 50, 'https://via.placeholder.com/50x50', $currentPost->authorName, ['class' => ['fl', 'img']]);
$currentPost->date         = date('Y-m-d', strtotime($currentPost->post_date));
$currentPost->composer     = get_field('music_spectrum_composer') ?: '佚名';
$currentFavorites          = get_field('my_favorites_of_music', 'user_' . $current_user->ID);

$isLogged = false;
$currentUser = wp_get_current_user();
if ( 0 !== $currentUser->ID ) {
    // User is logged
	$isLogged = true;
	$generated = AntonWeChatPay::getScanUrl($currentUser->ID, 'compose', get_the_ID());
}



?>
    <section class="main">
        <h1 class="title">
            <?php echo $currentPost->post_title; ?>
        </h1>
        <p class="author">
            <?php echo $currentPost->composer; ?>
        </p>
        <section class="content-wrap clearfix">
            <div class="fl content" id="content">
                <?php echo $currentPost->post_content; ?>
            </div>
            <div class="fl sidebar">
                <div class="charge-box">
                    <p class="tips">
                        开通VIP，尊享所有曲谱高清 去广告下载
                    </p>
                    <button type="button" id="clickOpenVip" class="openvip-btn">
                        开通VIP
                    </button>
                </div>
                <div class="upload-user">
                    <?php echo $currentPost->authorAvatar; ?>
                    <p class="name">
                        <?php echo $currentPost->authorName; ?>
                    </p>
                </div>
                <div class="change">
                    <p class="date">
                        上传时间：<?php echo $currentPost->date; ?>
                    </p>
                    <p class="view-num">
                        查看数：<?php echo $viewsCount; ?>次
                    </p>
                    <div class="share">
							<span>
								分享至：
							</span>
                        <a href="#">
                            <img src="/wp-content/themes/CIA/dist/images/b75c72e5d7abe8f5ad7d70d64a2928de.png"
                                 alt="">
                        </a>
                        <img class="wx-share"
                             src="/wp-content/themes/CIA/dist/images/4e8494b58b194335441a6cbcc6c0d5c3.png"
                             alt="">
                        <div class="wx-share-hover">
                            <img src="/wp-content/themes/CIA/dist/images/62fa72f3900728bd9695308cb473a21f.png"
                                 alt="">
                        </div>
                    </div>
                </div>
                <div class="operation">
                    <?php if (in_array($currentPost->ID, (array)$currentFavorites)) { ?>
                        <button type="button" class="collect remove" id="collect">
                            <img width="18"
                                 src="/wp-content/themes/CIA/dist/images/f2526a8236ff253bb8d023b191a6e48e.png"
                                 alt="">
                            已收藏
                        </button>
                    <?php } else { ?>
                        <button type="button" class="collect" id="collect">
                            <img width="18"
                                 src="/wp-content/themes/CIA/dist/images/f2526a8236ff253bb8d023b191a6e48e.png"
                                 alt="">
                            收藏
                        </button>
                    <?php } ?>
                    <button type="button">
                        <img width="18" src="/wp-content/themes/CIA/dist/images/91afbe38cf10872449e08fff926b9506.png"
                             alt="">
                        普通免费下载
                    </button>
                </div>
                <p class="charge-tips">
                    ￥1.29 单首高清去广告下载
                </p>
                <div class="wx-scanpay">

                    <?php if(is_user_logged_in()){
                        echo "<img src=http://mobile.qq.com/qrcode?url=" . urlencode($generated) . "> <p> 微信扫码支付 </p>";
                    } else {
                        echo "<p>登陆后扫码支付</p>";
                    }?>

                </div>
                <div class="reading">
                    <p>
                        阅读模式
                    </p>
                    <button type="button" id="clickFullscreen">
                        <img width="20" src="/wp-content/themes/CIA/dist/images/a01ed9c7452840b639057fa09e91f2f9.png"
                             alt="">
                        全屏模式
                    </button>
                    <button type="button" id="clickdoublescreen">
                        <img width="18" src="/wp-content/themes/CIA/dist/images/4969f5bd96ae788505fa7340b4f84f87.png"
                             alt="">
                        双页模式
                    </button>
                </div>
            </div>
        </section>
    </section>
    <script type="text/template" id="modalTpl">
        <div class="mask">
        </div>
        <section class="modal-popup" id="modalPopup">
            <div class="modal-header">
                <?php
                if( is_user_logged_in() ){
	                echo '<div class="yes-login"> <img class="fl img" width="44" height="44" src="http://p3.music.126.net/VyEOqlhwbjDVfLkv3C3U9Q==/109951163408473790.jpg?param=44y44" alt=""> <p class="name">' . wp_get_current_user()->display_name . '</p> </div>';

                }else {
                    echo '<div class="no-login"> <p> 您还没有登录，请先登录！ </p> <a href="javascript:void(0);" class="clickLogin login-btn"> 立即登录 </a> </div>';
                }
                ?>

                <img width="25" class="closeModal vip-close"
                     src="/wp-content/themes/CIA/dist/images/2deb57e0cf6c19d17e881544e6d986b3.png"
                     alt="">
            </div>
            <div class="modal-main">
                <p class="title">
                    开通VIP，尊享所有曲谱高清去广告下载
                </p>
                <div class="pay-mode" id="payMode">
                    <div class="mode active">
                        <p class="price">
                            ¥
                            <strong>
                                8
                            </strong>
                            /月
                        </p>
                        <p class="primary-price">
                            ¥
                            <strong>
                                24
                            </strong>
                            /月
                        </p>
                        <p class="name">
                            包月VIP会员
                        </p>
	                    <?php $generatedOneMonth = AntonWeChatPay::getScanUrl($currentUser->ID, 'vip', '1');?>
                        <img class="wxcode"
                             src=<?php echo 'http://mobile.qq.com/qrcode?url=' . urlencode($generatedOneMonth);?>
                             alt="">
                    </div>
                    <div class="mode" data-src="./../../images/2018-08-02-1728244092.png">
                        <p class="price">
                            ¥
                            <strong>
                                72
                            </strong>
                            /年
                        </p>
                        <p class="primary-price">
                            ¥
                            <strong>
                                178
                            </strong>
                            /年
                        </p>
                        <p class="name">
                            包年VIP会员
                        </p>
	                    <?php $generatedOneYear = AntonWeChatPay::getScanUrl($currentUser->ID, 'vip', '3');?>
                        <img class="wxcode"
                             src=<?php echo 'http://mobile.qq.com/qrcode?url=' . urlencode($generatedOneMonth);?>
                             alt="">
                    </div>
                </div>
                <div class="wx-scanpay">
                    <p>
                        微信扫码支付
                    </p>
                    <img class="wxcode" id="wxCode" width="115" height="118"
                         src="/wp-content/themes/CIA/dist/images/62fa72f3900728bd9695308cb473a21f.png"
                         alt="">
                </div>
            </div>
        </section>
    </script>
    <script type="text/javascript" src="/wp-content/themes/CIA/dist/js/musicSpectrumDetails.bundle.js"></script>
    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('wp_rest'); ?>">
    <input type="hidden" name="postId" value="<?php echo $currentPost->ID; ?>">

<?php get_footer(); ?>