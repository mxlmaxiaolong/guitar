import { hideModal, showModal, showInputSuccess, hideInputSuccess, showInputErrror, hideInputErrror } from './../../js/common.js';
import { isPoneAvailable, validatePass, treeSelect } from './../../js/util.js';
import './index.scss';

$(document).ready(() => {
    const $searchMenuLi = $('#searchMenu li');
    const $searchResItems = $("#searchRes>div");

    $searchMenuLi.click(function () {
        $(this).addClass('active').siblings().removeClass('active');
        $searchResItems.eq($(this).index()).show().siblings().hide();
    });
});