<?php
get_header(); ?>
<?php
// 获取浏览数
$selector   = 'guitar_news_views_count';
$viewsCount = get_field($selector);

// 增加浏览数
$viewsCount++;
update_field($selector, $viewsCount);

// 获取内容
$currentGuitarNewsType         = get_field('guitar_news_video');
$currentGuitarNews             = get_post();
$currentGuitarNewsId           = $currentGuitarNews->ID;
$currentGuitarNewsPostMimeType = $currentGuitarNews->post_mime_type;
$currentFakeAuthorOfGuitarNews = get_field('upload_by');
$currentGuitarNewsAuthorId     = $currentFakeAuthorOfGuitarNews ? $currentFakeAuthorOfGuitarNews['ID'] : $currentGuitarNews->post_author;
$currentGuitarNewsAuthor       = get_userdata($currentGuitarNewsAuthorId);
$currentGuitarNewsAuthorName   = $currentGuitarNewsAuthor->data->user_nicename;
$currentGuitarNewsAuthorAvatar = get_avatar($currentGuitarNewsAuthorId, 40, 'https://via.placeholder.com/40x40', $currentGuitarNews->authorName, ['class' => ['fl', 'head']]);
$currentGuitarNewsDate         = date('Y年m月d日', strtotime($currentGuitarNews->post_date));
if ($currentGuitarNewsPostMimeType == 'video/mp4') {
    $currentGuitarNewsVideoUrl   = get_field('whether_to_upload_guitar_news_video') == '1' ? get_field('upload_guitar_news_video') : get_field('guitar_news_video_url');
    $currentGuitarNewsVideoImg   = get_field('guitar_news_video_img');
    $currentGuitarNewsCategoryId = get_field('series_of_courses');
    // 读取相关的系列课程
    if ($currentGuitarNewsCategoryId) {
        $seriesOfCoursesParm               = [
            'post_type'  => 'guitar_news',
            'hide_empty' => false,
            'parent'     => 0,
            'meta_key'   => 'guitar_news_views_count',
            'orderby'    => 'meta_value_num',
            'exclude'    => $currentGuitarNews->ID,
        ];
        $seriesOfCourses                   = [];
        $seriesOfCoursesParm['meta_query'] = [
            [
                'key'     => 'series_of_courses',
                'compare' => '=',
                'value'   => $currentGuitarNewsCategoryId,
            ]
        ];
        $currentSeriesOfCourses            = get_posts($seriesOfCoursesParm);
        if ($currentSeriesOfCourses) {
            foreach ($currentSeriesOfCourses as $course) {
                $currentCourseImg  = get_field('guitar_news_Image', $course->ID);
                $currentCourseName = $course->post_title;
                $currentCourseLink = esc_url(get_permalink($course->ID));
                $seriesOfCourses[] = "<li><a href=\"{$currentCourseLink}\"><img class=\"img\" width=\"180\" height=\"100\" src=\"{$currentCourseImg}\" alt=\"\"><p class=\"name text-ellipsis\" style=\"width:180px\" title=\"{$currentCourseName}\">{$currentCourseName}</p></a></li>";
            }
        }
    }
    $currentFavorites = get_field('my_favorites_of_video', 'user_' . $current_user->ID);
} else {
    $currentGuitarNewsContent = get_field('guitar_news_content');
    $currentFavorites         = get_field('my_favorites_of_articles', 'user_' . $current_user->ID);
}

// 读取相关推荐
$recommendationsParm        = [];
$recommendationsTagsParm    = array_column((array)get_the_tags(), 'term_taxonomy_id');
$recommendationsTagsParm    = implode(',', $recommendationsTagsParm);
$recommendationsKeywordParm = get_field('guitar_news_keyword');
global $wpdb;
$recommendationsQueryLeftJoin = '';
$recommendationsQueryWhere    = '(';
if ($recommendationsTagsParm) {
    $recommendationsQueryLeftJoin = " LEFT JOIN {$wpdb->term_relationships} r ON p.ID = r.object_id";
    $recommendationsQueryWhere    .= " r.term_taxonomy_id IN({$recommendationsTagsParm}) OR";
}
if ($recommendationsKeywordParm) {
    $recommendationsQueryWhere .= " p.post_title LIKE '%{$recommendationsKeywordParm}%' OR";
}

$recommendationsQuery = "SELECT * FROM {$wpdb->posts} p{$recommendationsQueryLeftJoin} WHERE p.ID !={$currentGuitarNewsId} AND p.post_status = 'publish' AND p.post_mime_type = '{$currentGuitarNewsPostMimeType}' AND {$recommendationsQueryWhere} p.post_author = {$currentGuitarNewsAuthorId} ) GROUP BY p.ID ORDER BY RAND() LIMIT 4";
$recommendationsArry  = $wpdb->get_results($recommendationsQuery);
$$recommendationsHtml = '';
if ($recommendationsArry) {
    foreach ($recommendationsArry as $guitarNewsObject) {
        $recommendationsHtml .= getGuitarNewsHTMLByGuitarNewsObject($guitarNewsObject);
    }
}
?>
<?php if ($currentGuitarNewsPostMimeType != 'video/mp4') { ?>
    <section class="main">
        <h1 class="title">
            <?php echo $currentGuitarNews->post_title; ?>
        </h1>
        <section class="change-info">
            <?php echo $currentGuitarNewsAuthorAvatar; ?>
            <p class="name fl dot">
                <?php echo $currentGuitarNewsAuthorName; ?>
            </p>
            <p class="time fl dot">
                <?php echo $currentGuitarNewsDate; ?>
            </p>
            <div class="view-num">
                <img width="18" src="/wp-content/themes/CIA/dist/images/03ff070dd25a5e3332bf0bf51690ecb6.png"
                     alt="">
                <?php echo $viewsCount; ?>
            </div>
        </section>
        <section class="content">
            <?php echo $currentGuitarNewsContent; ?>
            <!-- <p>
                玩吉他也有些年头了，关于弹吉他的目的，我不想无限拔高，拿起吉他不是梦想就是音乐。若干年之后，你弹一首喜欢的歌，在一个宁静的黄昏，你会发现，弹吉他真的是一件快乐和幸福的事
            </p>
            <p style="margin-top:30px;">
                关于新手用什么吉他，每个档次都有最合适的，所以先确定好你的预算，要知道好吉他上万甚至几十万都有呀 :!: 。下面我传你大半的功力，从吉他的材质等方面告诉你吉他什么牌子好（毕竟吉他就是木头做的嘛，材质包括两方面：不同的选材和木材的风干级别），让你从此远离大坑小坑，你还可以收藏本文随时揣着去琴行鉴定。选琴我的看法是手感是首位，因为往后的练习都是手指上的功夫，长期练习有一把手感舒适的琴，至少让你练得舒心。音色方面次之，毕竟这个时候还分辨不出音色的好坏，如果不是新手想要换第二把琴那就要考虑音色了，不同等级的琴的演奏体验也是大大不同的
            </p>
            <p style="margin-top:30px;">
                下面就来说说几款主流的吉他，都是各个价位最热门值得推荐的品牌系列：价格：100 — 300 我想这个档次的琴应该称为玩具更贴切吧，如果你是真心学吉他，莫让它毁了你的兴趣，否则只能挂在墙上当装饰品
                :价格：300 — 50
            </p>
            <p style="margin-top:30px;">
                这个档次属初学者入门级别的吉他，面板多用椴木，所以被称为“烧火棍”。是多数商家们为了节约成本不择手段的产品，所以一般这个价位的吉他都会搞成五颜六色，感觉真的很漂（la）亮（ji）
                :cry: 。预算这个价位的吉他，请一定选原木色。一般在琴行，全部是各种小作坊的椴木琴，而且有的打品严重，因为新手不太懂所以好忽悠（例子太多了）；如果是线上，感觉不错的有下面这款玛蒂尔达五周年纪念款M5-DC，相比同价位琴采用的是西提卡云杉面板、沙比利背侧板、全封闭旋钮、可调节弦距，从配置看比椴木琴有诚意的多。另外做工和材质的成色还不错（低端合板琴主要的区别就是材质的风干程度）
            </p>
            <img style="margin-top:30px;" src="https://g-search1.alicdn.com/img/bao/uploaded/i4/imgextra/i3/115207370/TB2QrxCHKuSBuNjSsplXXbe8pXa_!!0-saturn_solar.jpg"
            alt="">
            <p style="margin-top:30px;">
                这个价位还是合板琴，但做工和手感已经脱离烧火棍了，音色相对更稳定些，扫弦声音有种齐刷刷的感觉。不得不提的有Kepma卡马，入门圈里最火爆的一把琴，被众多爱好者誉为“新手神器”。卡马吉他的最大亮点就是其做工和手感，目前只有四个型号，定位明确专供中低端，一代适合弹唱，二代主打指弹。
                配置上看背侧板是沙比利和贝壳杉结合，音色稳定，做工上弦距高低合适不打品，最高的地方大约为2.5mm左右，这样新手在按弦的时候就很容易上手
            </p> -->
        </section>
        <section class="article-footer">
            <div class="share fl">
					<span>
						分享至：
					</span>
                <a href="#">
                    <img src="/wp-content/themes/CIA/dist/images/b75c72e5d7abe8f5ad7d70d64a2928de.png"
                         alt="">
                </a>
                <img class="wx-share" src="/wp-content/themes/CIA/dist/images/4e8494b58b194335441a6cbcc6c0d5c3.png"
                     alt="">
                <!-- <div class="wx-share-hover">                    <img src="/wp-content/themes/CIA/dist/images/62fa72f3900728bd9695308cb473a21f.png" alt="">                </div> -->
            </div>
            <div class="operation fr">
                <button type="button" class="good">
                    <img width="28" src="/wp-content/themes/CIA/dist/images/c117cbe2a66b9a40e87b9f0467f4d6cd.png"
                         alt="">
                    点赞
                </button>
                <?php if (in_array($currentGuitarNewsId, (array)$currentFavorites)) { ?>
                    <button type="button" class="collect remove">
                        <img width="28" src="/wp-content/themes/CIA/dist/images/c4d7b391588885452d2c0ecea431a92b.png"
                             alt="">
                        已收藏
                    </button>
                <?php } else { ?>
                    <button type="button" class="collect">
                        <img width="28" src="/wp-content/themes/CIA/dist/images/c4d7b391588885452d2c0ecea431a92b.png"
                             alt="">
                        收藏
                    </button>
                <?php } ?>
            </div>
        </section>
    </section>
    <section class="section-item">
        <section class="top">
            <h3 class="fl">
                相关推荐
            </h3>
            <button type="button" class="refresh">
                <img width="14" height="14"
                     src="/wp-content/themes/CIA/dist/images/d2645cf07cdcd56e3330fdef0848ed43.png"
                     alt="">
                换一换
            </button>
        </section>
        <section class="content-wrap">
            <ul>
                <?php echo $recommendationsHtml; ?>
            </ul>
        </section>
    </section>
    <script type="text/javascript" src="/wp-content/themes/CIA/dist/js/informationArticleDetails.bundle.js"></script>
<?php } else { ?>
    <section class="main">
        <section class="video-wrap">
            <div class="play-video  fl">
                <video id="video" class="video-js vjs-default-skin" controls preload="auto"
                       width="889" height="502" poster="<?php echo $currentGuitarNewsVideoImg; ?>"
                       data-setup='{"example_option":true}'>
                    <source src="<?php echo $currentGuitarNewsVideoUrl; ?>"
                            type='video/mp4'/>
                </video>
                <section class="article-footer">
                    <div class="operation fl">
                        <button type="button" class="good">
                            <img width="28"
                                 src="/wp-content/themes/CIA/dist/images/c117cbe2a66b9a40e87b9f0467f4d6cd.png"
                                 alt="">
                            点赞
                        </button>
                        <?php if (in_array($currentGuitarNewsId, (array)$currentFavorites)) { ?>
                            <button type="button" class="collect remove">
                                <img width="28"
                                     src="/wp-content/themes/CIA/dist/images/c4d7b391588885452d2c0ecea431a92b.png"
                                     alt="">
                                已收藏
                            </button>
                        <?php } else { ?>
                            <button type="button" class="collect">
                                <img width="28"
                                     src="/wp-content/themes/CIA/dist/images/c4d7b391588885452d2c0ecea431a92b.png"
                                     alt="">
                                收藏
                            </button>
                        <?php } ?>
                    </div>
                    <div class="share fl">
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
                        <!-- <div class="wx-share-hover">                            <img src="/wp-content/themes/CIA/dist/images/62fa72f3900728bd9695308cb473a21f.png" alt="">                        </div> -->
                    </div>
                </section>
            </div>
            <?php if ($currentGuitarNewsCategoryId) { ?>
                <div class="video-list fl">
                    <p class="title">
                        系列课程
                    </p>
                    <ul>
                        <?php echo implode('', $seriesOfCourses); ?>
                    </ul>
                </div>
            <?php } ?>
        </section>
        <section class="change-info">
            <h1 class="title">
                <?php echo $currentGuitarNews->post_title; ?>
            </h1>
            <?php echo $currentGuitarNewsAuthorAvatar; ?>
            <p class="name fl">
                <?php echo $currentGuitarNewsAuthorName; ?>
            </p>
            <div class="tags fl">
					<span>
						#演奏
					</span>
            </div>
            <p class="time fl dot">
                <?php echo $currentGuitarNewsDate; ?>
            </p>
            <div class="view-num">
                <img width="18" src="/wp-content/themes/CIA/dist/images/03ff070dd25a5e3332bf0bf51690ecb6.png"
                     alt="">
                <?php echo $viewsCount; ?>
            </div>
        </section>
        <section class="section-item">
            <section class="top">
                <h3 class="fl">
                    相关推荐
                </h3>
                <button type="button" class="refresh">
                    <img width="14" height="14"
                         src="/wp-content/themes/CIA/dist/images/d2645cf07cdcd56e3330fdef0848ed43.png"
                         alt="">
                    换一换
                </button>
            </section>
            <section class="content-wrap">
                <ul>
                    <?php echo $recommendationsHtml; ?>
                </ul>
            </section>
        </section>
    </section>
    <script type="text/javascript" src="/wp-content/themes/CIA/dist/js/informationVideoDetails.bundle.js"></script>
<?php } ?>
    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('wp_rest'); ?>">
    <input type="hidden" name="postId" value="<?php echo $currentGuitarNews->ID; ?>">
    <script>
        jQuery(document).ready(function ($) {
            $('.good').click(function () {
                var $nonce = $('input[name=nonce]').val();
                var $postId = $('input[name=postId]').val();
                $.ajax({
                    url: '/wp-json/cia/v1/guitar-news-post/' + $postId + '/like',
                    method: 'PUT',
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-WP-Nonce', $nonce);
                    },
                    dataType: 'json'
                }).done(function (response) {
                    if (response.data.status == 200) {
                        $('.good').html('<img width="28" src="/wp-content/themes/CIA/dist/images/c117cbe2a66b9a40e87b9f0467f4d6cd.png" alt=""> 已点赞');
                    }
                });
            })
            $('.collect').click(function () {
                var $nonce = $('input[name=nonce]').val();
                var $postId = $('input[name=postId]').val();
                var $this = $(this);
                var $method = $this.hasClass('remove') ? 'DELECT' : 'PUT';
                $.ajax({
                    url: '/wp-json/cia/v1/user/' + $postId + '/favorites',
                    method: $method,
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-WP-Nonce', $nonce);
                    },
                    dataType: 'json'
                }).done(function (response) {
                    if (response.data.status == 200) {
                        $this.toggleClass('remove');
                        html = $method == 'PUT' ? '<img width="28" src="/wp-content/themes/CIA/dist/images/c4d7b391588885452d2c0ecea431a92b.png" alt=""> 已收藏' : '<img width="28" src="/wp-content/themes/CIA/dist/images/c4d7b391588885452d2c0ecea431a92b.png" alt=""> 收藏';
                        $('.collect').html(html);
                    }
                });
            })
        })
    </script>
<?php get_footer(); ?>