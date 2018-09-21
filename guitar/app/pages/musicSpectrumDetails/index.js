import './../../js/common.js';
import './index.scss';
import $ from 'jquery';

$(document).ready(() => { 
    
    /**
     * 收藏
     */
    $('#collect').click( e => {


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
                var html = '<img width="18" src="/wp-content/themes/CIA/dist/images/f2526a8236ff253bb8d023b191a6e48e.png" alt=""> ';
                html += $method == 'PUT' ? '已收藏' : '收藏';
                $('.collect').html(html);
            } else {
                const code = `<div class="mask"></div><div class="toast">您还未登录，请先登录</div>`;
                $('body').prepend(code);

                $('.mask').click(function (e) {
                    $(this).remove(); $('.toast').remove();
                });
            }
        });

    });


    /**
     * 阅读模式
     */
        let $imgLi = $('#content img');
        let imgIndex = 0;

        $('#clickFullscreen').click(e => {
            const $img = $(this);
            imgIndex = 0;
            showPhotosModal([{ src: $imgLi.eq(0).attr('src'), alt: $imgLi.eq(0).attr('alt') }]);
        });

        $('#clickdoublescreen').click(e => {
            const $img = $(this);
            imgIndex = 0;
            if ($imgLi.eq(1).attr('src') !== undefined){
                showPhotosModal([{ src: $imgLi.eq(0).attr('src'), alt: $imgLi.eq(0).attr('alt') }, { src: $imgLi.eq(1).attr('src'), alt: $imgLi.eq(1).attr('alt') }]);
            }else{
                showPhotosModal([{ src: $imgLi.eq(0).attr('src'), alt: $imgLi.eq(0).attr('alt') }]);
            }
        });

        $(document).on('click', '#content img', function (e) {
            const $img = $(this);
            imgIndex = $(this).index();
            showPhotosModal([{ src: $img.attr('src'), alt: $img.attr('alt')}]);
        });

        $(document).on('click', '#imgPrev', e => {
            const $phImg = $('.ph-img');
            imgIndex--;
            
            if ($phImg.length === 1) {
                if (imgIndex < 0) imgIndex = ($imgLi.length - 1);
                $phImg.attr('src', $imgLi.eq(imgIndex).attr('src'));
            } else if ($phImg.length === 2){
                if (imgIndex < 0) imgIndex = ($imgLi.length - 3);
                $phImg.eq(0).attr('src', $imgLi.eq(imgIndex*2).attr('src'));
                $phImg.eq(1).attr('src', $imgLi.eq(imgIndex*2+1).attr('src'));
            }

        });
        $(document).on('click', '#imgNext', e => {
            const $phImg = $('.ph-img');
            imgIndex++;
            if ($phImg.length === 1) {
                imgIndex %= $imgLi.length;
                $phImg.attr('src', $imgLi.eq(imgIndex).attr('src'));
            } else if ($phImg.length === 2) {
                imgIndex %= $imgLi.length-2;
                $phImg.eq(0).attr('src', $imgLi.eq(imgIndex * 2).attr('src'));
                $phImg.eq(1).attr('src', $imgLi.eq(imgIndex * 2 + 1).attr('src'));
            }
        });

        const showPhotosModal = (imgs, w, h) => {
            let imgHtml = '';
            imgs.forEach(item => {
                imgHtml += `<img class="ph-img" width="469" height="640"src="${item.src}" alt="${item.alt}">`;
            });

            $('body').append(`<div class="mask"></div>
                <div class="popupp-photos" id="popuppPhotos" style="width: 988px;height:640px;">
                    ${imgHtml}
                    <span class="imguide">
                        <a href="javascript:;" id="imgPrev" class="imgprev"></a>
                        <a href="javascript:;" id="imgNext" class="imgnext"></a>
                    </span>
                </div>`);
            $('.mask').click(e => $('#popuppPhotos,.mask').remove());
            
        };
    

    /**
     * 开通 VIP
     */
    $('#clickOpenVip').click( e => {
        $('body').append($('#modalTpl').html());


        $('.mask,.closeModal').click(function () {
            $('#modalPopup,.mask').remove();
        });

        $('#payMode .mode').click(function () {
            $(this).addClass('active').siblings().removeClass('active');

            $('#wxCode').attr('src', $(this).find('.wxcode').attr('src'));
        });

        $('#payMode .mode').eq(0).click();
    });

});