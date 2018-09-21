<?php
/**
 * Template Name: 个人中心
 *
 * @package WordPress
 */


get_header(); ?>

<?php
$currentUser = wp_get_current_user();
$currentUserName = $currentUser->data->user_nicename;

function getFavoritesBytype($type){
    $selector = [
        'article' => 'my_favorites_of_articles',
        'video'   => 'my_favorites_of_video',
        'music'   => 'my_favorites_of_music',
        'guitar'   => 'my_favorites_of_guitar',
    ];
    if (!isset($selector[$type])) {
        return false;
    }
    global $current_user;
    $currentFavoritesHtml = '';
    $userid = $current_user->ID;
    $currentFavorites     = get_field($selector[$type], 'user_' . $current_user->ID);
    if ($currentFavorites) {
        foreach ((array)$currentFavorites as $postId) {
            $currentPost = get_post($postId);
            if ($type == 'music') {
                $currentFavoritesHtml .= getMusicSpectrumHTMLByMusicSpectrumObject($currentPost);
            } else if ($type == 'guitar') {
                $currentGuitarName = $currentPost->post_title;
                $currentGuitarImg  = get_field('guitar_main_img', $currentPost->ID);
                $currentGuitarLink = esc_url(get_permalink($currentPost->ID));
                $currentFavoritesHtml .= "<li>
                                            <a href=\"{$currentGuitarLink}\"> <img class=\"img\" src=\"{$currentGuitarImg}\" width=\"208\" height=\"208\" alt=\"\">
                                                <div class=\"title text-ellipsis\">{$currentGuitarName}</div>
                                            </a>
                                        </li>";
            } else {
                $currentFavoritesHtml .= getGuitarNewsHTMLByGuitarNewsObject($currentPost);
            }
        }
    }else {
        $currentFavoritesHtml = '<li style="width: 100%;text-align: center;"><img width="350" height="150" src="https://via.placeholder.com/350x150" alt=""></li>';
    }
    return $currentFavoritesHtml; 
}
$currentFavoritesOfArticlesHtml = getFavoritesBytype('article');
$currentFavoritesOfVideoHtml = getFavoritesBytype('video');
$currentFavoritesOfMusicHtml = getFavoritesBytype('music');
$currentFavoritesOfGuitarHtml = getFavoritesBytype('guitar');
?>

    <section class="member-core">
        <div class="member-info">
            <div class="head"> <img width="150" height="150" src="http://p3.music.126.net/gK0nqK8iiG1o6axkHmmqrQ==/109951163416312552.jpg?param=150y150" alt="">
                <!-- <div class="vip">VIP</div> --></div>
            <h2 class="name"><?php echo $currentUserName;?></h2>
            <button type="button" class="open-vip">开通VIP</button>
        </div>
    </section>
    <section class="main">
        <section class="search-tab">
            <section class="search-menu clearfix" id="searchMenu">
                <ul>
                    <li class="active"> <a href="javascript:void(0);">琴房</a> </li>
                    <li> <a href="javascript:void(0);">收藏的曲谱</a> </li>
                    <li> <a href="javascript:void(0);">收藏的文章</a> </li>
                    <li> <a href="javascript:void(0);">收藏的视频</a> </li>
                </ul>
            </section>
            <section class="search-res" id="searchRes">
                <div class="dataBase-item" style="display:block;">
                    <section class="section-item section-item-rowX5">
                        <section class="content-wrap">
                            <ul>
                                <?php echo $currentFavoritesOfGuitarHtml; ?>
                            </ul>
                        </section>
                    </section>
                </div>
                <div class="opern-item">
                    <section class="section-item section-item-rowX5">
                        <section class="content-wrap">
                            <ul>
                                <?php echo $currentFavoritesOfMusicHtml; ?>
                            </ul>
                        </section>
                    </section>
                </div>
                <div class="video-item">
                    <section class="section-item">
                        <section class="content-wrap">
                            <ul>
                                <?php echo $currentFavoritesOfArticlesHtml; ?>
                            </ul>
                        </section>
                    </section>
                </div>
                <div class="article-item">
                    <section class="section-item one">
                        <section class="content-wrap">
                            <ul>
                                <?php echo $currentFavoritesOfVideoHtml; ?>
                            </ul>
                        </section>
                    </section>
                </div>
            </section>
        </section>
    </section>

    <script type="text/javascript" src="/wp-content/themes/CIA/dist/js/member.bundle.js"></script>
<?php get_footer(); ?>