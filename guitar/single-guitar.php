<?php
get_header(); ?>
<?php
function getGuitarGallery($fileName)
{
    $currentGuitarGallery      = get_field($fileName);
    $currentGuitarGalleryCount = count($currentGuitarGallery);
    $currentGuitarGalleryHtml  = '';
    foreach ($currentGuitarGallery as $image) {
        $currentImageTitle        = $image['title'];
        $currentImageUrl          = $image['url'];
        $currentGuitarGalleryHtml .= "<li><img width=\"264\" height=\"176\" src=\"{$currentImageUrl}\" alt=\"\"><p class=\"name\">{$currentImageTitle}</p></li>";
    }
    return ['count' => $currentGuitarGalleryCount, 'html' => $currentGuitarGalleryHtml];
}

function getGuitarTerms($fileName)
{
    $currentGuitarTerms     = get_the_terms($currentPost->ID, $fileName);
    $currentGuitarTermsHtml = "";
    foreach ($currentGuitarTerms as $key => $term) {
        $currentGuitarTermsName = $term->name;
        $class                  = $key == 0 ? ' class="active"' : '';
        $currentGuitarTermsHtml .= "<li{$class}>{$currentGuitarTermsName}</l>";
    }
    return $currentGuitarTermsHtml;
}

function getGuitarSpecs($fileName)
{
    $currentGuitarSpecs      = get_field_object($fileName);
    $currentGuitarSpecsLabel = $currentGuitarSpecs['label'];
    $currentGuitarSpecsValue = $currentGuitarSpecs['value'];
    $currentGuitarSpecsHtml  = "<th>{$currentGuitarSpecsLabel}</th><td>{$currentGuitarSpecsValue}</td>";
    return $currentGuitarSpecsHtml;
}

// 获取内容
$currentPost = get_post();
// 颜色
$currentGuitarColorHtml = getGuitarTerms('guitar_color');
// 桶型
$currentGuitarShapeHtml = getGuitarTerms('guitar_shape');
// 参数
$currentGuitarSpecs = [
    'guitar_specs_name',
    'guitar_specs_model',
    'guitar_specs_barrel_shape',
    'guitar_specs_color',
    'guitar_specs_market_price',
    'guitar_specs_producing_area',
    'guitar_specs_size',
    'guitar_specs_panel_material',
    'guitar_specs_panel_thickness',
    'guitar_specs_dorsal_lateral_plate',
    'guitar_specs_neck',
    'guitar_specs_neck_shape',
    'guitar_specs_fingerboard',
    'guitar_specs_nut_width',
    'guitar_specs_material_of_paint',
    'guitar_specs_head_plate',
    'guitar_specs_bridge_material',
    'guitar_specs_scale_length',
    'guitar_specs_wrapping_material',
    'guitar_specs_upper_nut',
    'guitar_specs_lower_nut',
    'guitar_specs_knob',
    'guitar_specs_bridge_pin',
    'guitar_specs_fret',
    'guitar_specs_factory_guitar_strings',
    'guitar_specs_factory_pickup_model',
    'guitar_specs_note',
];

$currentGuitarSpecsHtml = '';
foreach ($currentGuitarSpecs as $key => $specs) {
    $currentGuitarSpecsHtml .= $key % 2 == 0 ? '<tr>' : '';
    $currentGuitarSpecsHtml .= getGuitarSpecs($specs);
    $currentGuitarSpecsHtml .= $key % 2 != 0 || ($key + 1 == count($currentGuitarSpecs)) ? '</tr>' : '';
}
// 吉他图片
$GuitarGalleryType      = ['guitar_appearance' => '外观', 'guitar_detail' => '细节', 'guitar_internal' => '内部', 'guitar_official_image' => '官方相册'];
$GuitarGalleryTitleHtml = '';
$GuitarGalleryImageHtml = '';
$i                      = 0;
foreach ($GuitarGalleryType as $name => $label) {
    $currentGuitarGallery = getGuitarGallery($name);
    if ($currentGuitarGallery['count']) {
        $class                     = $i == 0 ? ' class="active"' : '';
        $currentGuitarGalleryCount = $currentGuitarGallery['count'];
        $currentGuitarGalleryHtml  = $currentGuitarGallery['html'];
        $GuitarGalleryTitleHtml    .= "<li{$class}>{$label}({$currentGuitarGalleryCount})</li>";
        $style                     = $i != 0 ? ' style="display:none;"' : '';
        $GuitarGalleryImageHtml    .= "<ul{$style}>{$currentGuitarGalleryHtml}</ul>";
        $i++;
    }
}
// 经销商
$currentGuitarDistributor     = get_field('distributor');
$currentGuitarDistributorHtml = '';
foreach ($currentGuitarDistributor as $distributor) {
    $currentDistributorStoreName  = get_field('store_name', $distributor->ID);
    $currentDistributorAddress    = get_field('address', $distributor->ID);
    $currentDistributorPhone      = get_field('phone', $distributor->ID);
    $currentDistributorStoreImage = get_field('store_Image', $distributor->ID);
    $currentGuitarDistributorHtml .= "<li>
										<div class=\"img fl\"><img width=\"140\" height=\"162\"
										                         src=\"{$currentDistributorStoreImage}\"
										                         alt=\"\"></div>
										<div class=\"info-div fl\"><p class=\"name\">{$currentDistributorStoreName}</p>
											<p class=\"address\">地址：{$currentDistributorAddress}</p>
											<p class=\"telephone\">电话：{$currentDistributorPhone}</p></div>
										<div class=\"location\"><span> 586米</span> <img width=\"24\" height=\"24\"
										                                              src=\"/wp-content/themes/CIA/dist/images/bb1b95222e0e8a614574e9674d61f719.png\"
										                                              alt=\"\"></div>
									</li>";
}
// 吉他参考价格
$currentGuitarReferencePrice = get_field('reference_price');
// 吉他轮播图
$currentGuitarGuitarSlider     = get_field('guitar_slider');
$currentGuitarGuitarSliderHtml = '';
foreach ($currentGuitarGuitarSlider as $key => $slider) {
    $class = $key == 0 ? ' class="active"' : '';
    if ($slider['image']) {
        $currentGuitarGuitarSliderHtml .= "<li{$class}><img width=\"120\" height=\"80\"
					                        src=\"{$slider['image']}\"
					                        alt=\"\"></li>";
    } else {
        $currentGuitarGuitarSliderHtml .= "<li{$class}><iframe width=\"120\" height=\"80\" src='{$slider['video']}' frameborder=0 'allowfullscreen'></iframe></li>";
    }
}
$commentsParm              = [
    'post_id' => $currentPost->ID,
];
$currentGuitarComments     = get_comments($commentsParm);
$currentGuitarCommentsHtml = '';
foreach ($currentGuitarComments as $commentObject) {
    $currentCommentContent    = $commentObject->comment_content;
    $currentCommentAuthorName = $commentObject->comment_author;
    // $currentCommentDate = date('Y-m-d', strtotime($commentObject->comment_date));
    $currentCommentDate         = $commentObject->comment_date;
    $currentCommentAuthorAvatar = get_avatar($commentObject->user_id, 50, 'https://via.placeholder.com/50x50', $currentCommentAuthorName, ['class' => ['head', 'fl']]);
    $currentGuitarCommentsHtml  .= "<li>
                                    <div class=\"user\">{$currentCommentAuthorAvatar}
                                        <div class=\"fl\"><p class=\"name\">{$currentCommentAuthorName}</p>
                                            <p class=\"date\">{$currentCommentDate}</p></div>
                                    </div>
                                    <div class=\"content\">{$currentCommentContent}</div>
                                </li>";
}

// 评论模板
$currentcommenter = wp_get_current_commenter();
$req              = get_option('require_name_email');
$aria_req         = ($req ? " aria-required='true'" : '');
$comments_args    = array(
    'comment_field' => '<input type="text" id="searchInput" name="comment" class="search-input" placeholder="说说你的想法吧...">',
    'label_submit'  => '提交',
    'title_reply'   => '',
    'logged_in_as'  => ''
);

// 收藏
$currentFavorites = get_field('my_favorites_of_guitar', 'user_' . $current_user->ID);
?>
<style>
    #commentform .form-submit {
        float: right;
    }
    .guitar-wrap .guitar-info .remove-btn{background: #ccc;}
    .guitar-wrap .guitar-info .remove-btn img {display: none;}
</style>
<script type="text/javascript" src="/wp-content/themes/CIA/dist/js/guitarDetails.bundle.js"></script>
<section class="main">
    <section class="guitar-wrap">
        <div class="guitar-images fl">
            <div class="preview" id="preview"><img width="510" height="336"
                                                   src="http://guitar.local/wp-content/uploads/2018/08/brand1.gif"
                                                   alt=""></div>
            <div class="thumbs" id="thumbs">
                <ul>
                    <?php echo $currentGuitarGuitarSliderHtml; ?>
                </ul>
            </div>
        </div>
        <div class="guitar-info fl"><h2 class="name"><?php echo $currentPost->post_title; ?></h2>
            <div class="skus-box">
                <div class="sku-row"><p class="label">颜色</p>
                    <ul class="sku-list">
                        <?php echo $currentGuitarColorHtml; ?>
                    </ul>
                </div>
                <div class="sku-row"><p class="label">桶型</p>
                    <ul class="sku-list">
                        <?php echo $currentGuitarShapeHtml; ?>
                    </ul>
                </div>
            </div>
            <div class="price"><span class="label">参考价格</span> <strong
                        class="num"><?php echo $currentGuitarReferencePrice ? "¥ {$currentGuitarReferencePrice}" : ''; ?></strong>
            </div>
            <!-- <button type="button" class="add-btn" > <img style="position: relative;top: 3px;left: -3px;" width="20" height="20" src="/wp-content/themes/CIA/dist/images/729507a742c0d5ee58e9363a6ac8341f.png" alt="" > 添加到琴房</button> -->
            
            <?php if (in_array($currentPost->ID, (array)$currentFavorites)) { ?>
                <button type="button" class="add-btn remove-btn"><img
                        style="position: relative;top: 3px;left: -3px;" width="20" height="20"
                        src="/wp-content/themes/CIA/dist/images/729507a742c0d5ee58e9363a6ac8341f.png" alt=""> 已添加
                </button>
            <?php } else { ?>
                <button type="button" class="add-btn"><img
                        style="position: relative;top: 3px;left: -3px;" width="20" height="20"
                        src="/wp-content/themes/CIA/dist/images/729507a742c0d5ee58e9363a6ac8341f.png" alt=""> 添加到琴房
                </button>
            <?php } ?>
        </div>
    </section>
    <section class="comment-wrap">
        <div class="wrap-top"><h3>琴友口碑</h3></div>
        <section class="search-wrap">
            <!-- <form><input type="text" id="searchInput" class="search-input" placeholder="说说你的想法吧..."> <input
                        type="submit" value="评论" class="submit-search-btn"></form> -->
            <?php
                if (is_user_logged_in()) {
                    ob_start();
                    comment_form($comments_args);
                    //提交按钮添加样式
                    echo str_replace('class="submit"', 'class="submit-search-btn"', ob_get_clean());
                }
            ?>
        </section>
        <div class="comment-list">
            <ul>
                <?php echo $currentGuitarCommentsHtml; ?>
            </ul>
            <button type="button" class="view-more-btn">查看更多评论</button>
        </div>
    </section>        <!-- <section class="audition-wrap">        </section> -->
    <section class="guitar-param">
        <div class="wrap-top"><h3>吉他参数</h3></div>
        <table class="param-table" cellspacing="0">
            <?php echo $currentGuitarSpecsHtml; ?>
        </table>
    </section>
    <section class="guitar-album">
        <div class="wrap-top"><h3>吉他图片</h3></div>
        <div class="album-menu clearfix" id="albumMenu">
            <ul>
                <?php echo $GuitarGalleryTitleHtml; ?>
            </ul>
        </div>
        <div class="album-images" id="albumImages">
            <?php echo $GuitarGalleryImageHtml; ?>
        </div>
        <div class="pagination">
            <button type="button" disabled="disabled" class="btn-prev"><img width="16" height="18"
                                                                            src="/wp-content/themes/CIA/dist/images/f77a6b38b33f56b02f3c26af1f5eefb3.png"
                                                                            alt=""></button>
            <ul class="pager">
                <li class="number active"><a href="#">1</a></li>
                <li class="number"><a href="#">2</a></li>
                <li class="more">…</li>
                <li class="number"><a href="#">3</a></li>
            </ul>
            <button type="button" class="btn-next"><img width="16" height="18"
                                                        src="/wp-content/themes/CIA/dist/images/166f0337fed06c8484661d7cb7edde90.png"
                                                        alt=""></button>
        </div>
    </section>
    <section class="nearby-dealer-list">
        <div class="wrap-top"><h3>附近经销商</h3></div>
        <ul>
            <?php echo $currentGuitarDistributorHtml; ?>
        </ul>
    </section>
</section>


<?php get_footer(); ?>

<input type="hidden" name="nonce" value="<?php echo wp_create_nonce('wp_rest'); ?>">
<input type="hidden" name="postId" value="<?php echo $currentPost->ID; ?>">
<script>
    jQuery(document).ready(function ($) {
        $('.add-btn').click(function () {
            var $nonce = $('input[name=nonce]').val();
            var $postId = $('input[name=postId]').val();
            var $this = $(this);
            var $method = $this.hasClass('remove-btn') ? 'DELECT' : 'PUT';
            $.ajax({
                url: '/wp-json/cia/v1/user/' + $postId + '/favorites',
                method: $method,
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-WP-Nonce', $nonce);
                },
                dataType: 'json'
            }).done(function (response) {
                if (response.data.status == 200) {
                    $this.toggleClass('remove-btn');
                    var html = '<img style="position: relative;top: 3px;left: -3px;" width="20" height="20" src="/wp-content/themes/CIA/dist/images/729507a742c0d5ee58e9363a6ac8341f.png" alt=""> ';
                    html += $method == 'PUT' ? '已添加' : '添加到琴房';
                    $('.add-btn').html(html);
                }
            });
        })
    })
</script>
</body>

</html>

