<?php
/**
 * Template Name: 搜索页
 *
 * @package WordPress
 */


get_header(); ?>
<?php

function getGuitarNews($params, $type)
{
    $params['post_type']      = 'guitar_news';
    $params['meta_key']       = 'guitar_news_views_count';
    $params['orderby']        = 'meta_value_num';
    $params['post_mime_type'] = $type == 'video' ? 'video/mp4' : 'text/html';
    $guitarNewsQuery          = new WP_Query($params);
    $guitarNewsArray          = $guitarNewsQuery->posts;
    $guitarNewsHtml           = '<ul>';
    $paginationHtml           = '';
    if ($guitarNewsArray) {
        foreach ($guitarNewsArray as $guitarNewsObject) {
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
                $currentGuitarNewsVideoIconHtml = '<i class="icon-video"> <img src="/wp-content/themes/CIA/dist/images/c260ab17c619a7c262a5dbdcf88f9949.png" width="18" height="16" alt=""> </i>';
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
            $guitarNewsHtml                .= "<li><a href=\"{$currentGuitarNewsLink}\">
                                                <div class=\"img-div fl\"><img class=\"img\" width=\"264\" height=\"149\"
                                                                             src=\"{$currentGuitarNewsImg}\"
                                                                             alt=\"\"> {$currentGuitarNewsVideoIconHtml}</div>
                                                <div class=\"change-div fl\">
                                                    <div class=\"title text-ellipsis\">{$currentGuitarNewsName}</div>
                                                    {$currentGuitarNewsExtraHtml}
                                                    <div class=\"user\">{$currentGuitarNewsAuthorAvatar}
                                                    <span class=\"name\">{$currentGuitarNewsAuthorName}</span></div>
                                                </div>
                                            </a></li>";
        }

        $paginationHtml = get_the_search_result_pagination($guitarNewsQuery);
    } else {
        $guitarNewsHtml = '<ul style="text-align: center;"><img width="350" height="150" src="https://via.placeholder.com/350x150" alt="">';
    }
    wp_reset_postdata();
    $guitarNewsHtml .= '</ul>' . $paginationHtml;
    return $guitarNewsHtml;
}

function getGuitar($params)
{
    $params['post_type'] = 'guitar';
    $params['orderby']   = 'date';
    $guitarQuery         = new WP_Query($params);
    $guitarArray         = $guitarQuery->posts;
    $guitarHtml          = '<ul>';
    $paginationHtml      = '';
    if ($guitarArray) {
        foreach ($guitarArray as $guitarObject) {
            $currentGuitarName = $guitarObject->post_title;
            $currentGuitarImg  = get_field('guitar_main_img', $guitarObject->ID);
            $currentGuitarLink = esc_url(get_permalink($guitarObject->ID));
            // 吉他参考价格
            $currentGuitarPrice = get_field('reference_price', $guitarObject->ID);
            $currentGuitarPrice = $currentGuitarPrice ? "¥ {$currentGuitarPrice}" : '';
            $guitarHtml         .= "<li><a href=\"{$currentGuitarLink}\"><div class=\"img fl\"><img width=\"208\" height=\"208\" src=\"{$currentGuitarImg}\" alt=\"\"></div><div class=\"info-box fl\"><p class=\"name text-ellipsis\">{$currentGuitarName}</p><span class=\"price\">{$currentGuitarPrice}</span></div></a></li>";
        }
        $paginationHtml = get_the_search_result_pagination($guitarMusicSpectrumQuery);
    } else {
        $guitarHtml = '<ul style="text-align: center;"><img width="350" height="150" src="https://via.placeholder.com/350x150" alt="">';
    }
    wp_reset_postdata();
    $guitarHtml .= '</ul>' . $paginationHtml;
    return $guitarHtml;
}

function getUsers($params)
{
    $usersQuery     = new WP_User_Query($params);
    $usersArray     = $usersQuery->get_results();
    $usersHtml      = '<ul>';
    $paginationHtml = '';
    if ($usersArray) {
        foreach ($usersArray as $userObject) {
            $currentUserId     = $userObject->data->user_nicename;
            $currentUserName   = $userObject->data->user_nicename;
            $currentUserAvatar = get_avatar($currentUserId, 70, 'https://via.placeholder.com/70x70', $currentUserName, ['class' => ['head', 'fl']]);
            $usersHtml         .= "<li>{$currentUserAvatar}<p class=\"name fl\">{$currentUserName}</p></li>";
        }
        $paginationHtml = get_the_search_result_pagination($usersQuery);
    } else {
        $usersHtml = '<ul style="text-align: center;"><img width="350" height="150" src="https://via.placeholder.com/350x150" alt="">';
    }
    wp_reset_postdata();
    $usersHtml .= '</ul>' . $paginationHtml;
    return $usersHtml;
}

// 公共参数
global $paged;
$paged  = $paged ?: 1;
$params = [
    'hide_empty'     => false,
    'parent'         => 0,
    'posts_per_page' => 10,
    'paged'          => $paged,
];

if (in_array($_GET['action'], ['guitar', 'music_spectrum', 'articles', 'video', 'users'])) {
    $action = $_GET['action'];
} else {
    $action = 'guitar';
}

if ($_GET['search']) {
    $params['s'] = $_GET['search'];
}

if ($action == 'articles' || $action == 'video') {
    $guitarNewsHtml = getGuitarNews($params, $action);
} else if ($action == 'guitar') {
    $guitarHtml = getGuitar($params);
} else if ($action == 'music_spectrum') {
    $guitarMusicSpectrumHtml = getGuitarMusicSpectrum($params);
} else if ($action == 'users') {
    if ($_GET['search']) {
        unset($params['s']);
        $params['search']         = '*' . $_GET['search'] . '*';
        $params['search_columns'] = ['user_nicename'];
    }
    $params['number'] = $params['posts_per_page'];
    unset($params['posts_per_page']);
    $usersHtml = getUsers($params);
}

?>
    <script type="text/javascript" src="/wp-content/themes/CIA/dist/js/search.bundle.js"></script>
    <style>
        .dataBase-item {
            margin-top: 40px;
        }

        .dataBase-item li {
            overflow: hidden;
            margin-bottom: 40px;
        }

        .dataBase-item li .img {
            margin-right: 30px;
            position: relative;
        }

        .dataBase-item li .name {
            font-size: 18px;
            color: #333;
            margin-top: 80px;
            margin-bottom: 4px;
        }

        .dataBase-item li .price {
            font-size: 16px;
            color: #cdaf6e;
        }

        .pagination {
            overflow: hidden;
            text-align: center;
            margin-top: 20px
        }

        .pagination .btn-next, .pagination .btn-prev, .pagination .pager {
            display: inline-block
        }

        .pagination .pager {
            overflow: hidden;
            vertical-align: top;
            font-size: 0
        }

        .pagination .pager li {
            float: left;
            height: 40px;
            line-height: 40px;
            text-align: center;
            border: 1px solid #bbb;
            padding: 0 16px;
            margin: 0 10px;
            cursor: pointer
        }

        .pagination .pager li.active {
            border-color: #cdaf6e
        }

        .pagination .pager li.active a {
            color: #cdaf6e
        }

        .pagination .pager li.more {
            border: none;
            font-size: 26px;
            color: #999;
            line-height: 26px;
            padding: 0;
            cursor: default
        }

        .pagination .pager li a {
            font-size: 16px;
            color: #bbb
        }

        .pagination .btn-next, .pagination .btn-prev {
            width: 40px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            background: #cdaf6e;
            position: relative;
            top: 1px;
            cursor: pointer;
            outline: none
        }

        .pagination .btn-next img, .pagination .btn-prev img {
            vertical-align: sub
        }

        .pagination .btn-next[disabled=disabled], .pagination .btn-prev[disabled=disabled] {
            background: #eee;
            cursor: no-drop
        }

        .pagination .btn-prev {
            margin-right: 20px
        }

        .pagination .btn-next {
            margin-left: 20px
        }
    </style>
    <section class="main">
        <section class="search-wrap" id="searchWrap">
            <div class="center">
                <form><input type="text" id="searchInput" class="search-input" name="search"
                             value="<?php echo $_GET['search']; ?>" placeholder="吉他产品数据、精彩视频、曲谱、资讯…"> <input
                            type="hidden" name="action" value="<?php echo $action; ?>"><input
                            type="submit" value="搜索" class="submit-search-btn">
                    <div class="search-box">
                        <div class="history">最近搜索</div>
                        <ul>
                            <li><a href="#"> <span>你就不要想</span> <b>起我</b> </a></li>
                            <li><a href="#"> <span>你就不要想</span> <b>起我</b> </a></li>
                            <li><a href="#"> <span>你就不要想</span> <b>起我</b> </a></li>
                            <li><a href="#"> <b>起我</b> </a></li>
                            <li><a href="#"> <b>起我</b> </a></li>
                        </ul>
                    </div>
                </form>
            </div>
        </section>
        <section class="search-tab">
            <section class="search-menu clearfix" id="searchMenu">
                <ul>
                    <li <?php if ($action == 'guitar') echo 'class="active"'; ?>><a
                                href="<?php echo get_permalink() ?>?action=guitar&search=<?php echo $_GET['search'] ?>">吉他数据库</a>
                    </li>
                    <li <?php if ($action == 'music_spectrum') echo 'class="active"'; ?>><a
                                href="<?php echo get_permalink() ?>?action=music_spectrum&search=<?php echo $_GET['search'] ?>">曲谱</a>
                    </li>
                    <li <?php if ($action == 'video') echo 'class="active"'; ?>><a
                                href="<?php echo get_permalink() ?>?action=video&search=<?php echo $_GET['search'] ?>">视频</a>
                    </li>
                    <li <?php if ($action == 'articles') echo 'class="active"'; ?>><a
                                href="<?php echo get_permalink() ?>?action=articles&search=<?php echo $_GET['search'] ?>">文章</a>
                    </li>
                    <li <?php if ($action == 'users') echo 'class="active"'; ?>><a
                                href="<?php echo get_permalink() ?>?action=users&search=<?php echo $_GET['search'] ?>">用户</a>
                    </li>
                </ul>
            </section>
            <section class="search-res" id="searchRes">
                <?php if ($action == 'guitar') { ?>
                    <div class="dataBase-item" style="display:block;">
                        <?php echo $guitarHtml; ?>
                    </div>
                <?php } elseif ($action == 'music_spectrum') { ?>
                    <div class="opern-item" style="display:block;">
                        <?php echo $guitarMusicSpectrumHtml; ?>
                    </div>
                <?php } elseif ($action == 'video') { ?>
                    <div class="video-item" style="display:block;">
                        <?php echo $guitarNewsHtml; ?>
                    </div>
                <?php } elseif ($action == 'articles') { ?>
                    <div class="article-item" style="display:block;">
                        <?php echo $guitarNewsHtml; ?>
                    </div>
                <?php } elseif ($action == 'users') { ?>
                    <div class="user-item" style="display:block;">
                        <?php echo $usersHtml; ?>
                    </div>
                <?php } ?>
            </section>
        </section>
    </section>

    <script type="text/javascript" src="https://api.shui.cn/waters/areajs"></script>
<?php get_footer(); ?>