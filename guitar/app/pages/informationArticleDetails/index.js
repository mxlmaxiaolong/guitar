import './../../js/common.js';
import './index.scss';
import $ from 'jquery';

$(document).ready(() => { 
    const $switch = $('#switch');
    const $filterList = $('#filterList');

    $switch.click(e => {
        if ($switch.attr('data-off') == 0){
            $filterList.stop().animate({
                height: '46'
            });
            $switch.attr('data-off', 1);
            $switch.find('.text').text('展开');
        }else{
            $filterList.css({
                height: 'auto'
            });
            $switch.attr('data-off', 0);
            $switch.find('.text').text('收起');
        };
    });

    const $more = $('.more');

    $more.click(function (e) {
        $(this).parent().css('height','auto');
        $(this).remove();
    });
});