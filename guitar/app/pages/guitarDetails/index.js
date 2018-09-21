import './../../js/common.js';
import './index.scss';
import $ from 'jquery';

$(document).ready(() => { 
    
    /**
     * 选择规格 效果
     */
        $('.sku-list li').click(function (e) {
            $(this).addClass('active').siblings().removeClass('active');
        });

    /**
     * 切换商品图片 tab 效果
     */
        $('#thumbs li').mouseover(function (e) {
            $(this).addClass('active').siblings().removeClass('active');
            $('#preview').find('img').attr('src', $(this).find('img').attr('src') );
        });

    /**
     * 相册 效果
     */
        let $imgUl = $('#albumImages ul');
        let $imgLi = $imgUl.eq(0).find('li');
        let imgIndex = 0;
        $('#albumMenu li').click(function (e) {
            $(this).addClass('active').siblings().removeClass('active');
            $('#albumImages ul').eq( $(this).index() ).show().siblings().hide();
            $imgLi = $('#albumImages ul').eq($(this).index()).find('li');
        });

        $(document).on('click', '#albumImages li',function (e) {
            const $img = $(this).find('img');
            imgIndex = $(this).index();
            showPhotosModal($img);
        });

        $(document).on('click', '#imgPrev', e => {
            const $phImg = $('#phImg');
            imgIndex--;
            if (imgIndex < 0) imgIndex = ($imgLi.length - 1);

            $phImg.attr('src', $imgLi.eq(imgIndex).find('img').attr('src'));
            $('#popuppPhotos').css({ width: $phImg.width(), height: $phImg.height() });
        });
        $(document).on('click', '#imgNext', e => {
            const $phImg = $('#phImg');
            imgIndex++;
            imgIndex %= $imgLi.length;
            $phImg.attr('src', $imgLi.eq(imgIndex).find('img').attr('src'));
            $('#popuppPhotos').css({ width: $phImg.width(), height: $phImg.height() });
        });
        
        const showPhotosModal = ($img,w,h) => {
            $('body').append(`<div class="popupp-hotos" id="hotos"></div>
            <div class="popupp-photos" id="popuppPhotos">
                <img class="ph-img" id="phImg" src="${$img.attr('src')}" alt="${$img.attr('alt')}">
                <span class="imguide">
                    <a href="javascript:;" id="imgPrev" class="imgprev"></a>
                    <a href="javascript:;" id="imgNext" class="imgnext"></a>
                </span>
            </div>`);
            $('#popuppPhotos').css({ width: $('#phImg').width(), height: $('#phImg').height()});
            $('#hotos').click(e => $('#popuppPhotos,#hotos').remove());
        };
});