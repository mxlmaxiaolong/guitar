import './../../js/common.js';
import './index.scss';
import $ from 'jquery';

$(document).ready(() => { 

    /**
     * 搜索框
     */
        const $searchWrap = $('#searchWrap');
        const $searchInput = $('#searchInput');

        $searchInput.focus(e => {
            $searchWrap.addClass('active');
            $searchWrap.find('.history').show();
        });

        $searchInput.blur(e => {
            $searchWrap.removeClass('active');
        });

        $searchInput.bind('input propertychange', e => {
            if ($searchInput.val() === '') {
                $searchWrap.find('.history').show();
                return false;
            };

            $searchWrap.find('.history').hide();
        });
});