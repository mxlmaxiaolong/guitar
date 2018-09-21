import './../../js/common.js';
import './index.scss';
import $ from 'jquery';

$(document).ready(() => { 
    const $searchMenuLi = $('#searchMenu li');
    const $searchResItems = $("#searchRes>div");

    $searchMenuLi.click(function () {
        $(this).addClass('active').siblings().removeClass('active'); 
        $searchResItems.eq($(this).index()).show().siblings().hide();
    });
});