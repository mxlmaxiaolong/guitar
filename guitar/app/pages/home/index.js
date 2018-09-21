import './../../js/common.js';
import './index.scss';

$(document).ready(() => { 
    
    /**
     * 搜索框
     */
    const $searchWrap = $('#searchWrap');
    const $searchInput = $('#searchInput');

    $searchInput.focus( e => {
        $searchWrap.addClass('active');
        $searchWrap.find('.history,.search-box').show();
        
    });

    $searchInput.blur( e => {
        setTimeout(() => {
            $searchWrap.removeClass('active');
            $searchWrap.find('.search-box').hide();
        }, 300);
    });
    
    $searchWrap.find('.search-box').click( e => {
        $searchWrap.addClass('active');
        $searchWrap.find('.search-box').show();
    });

    $searchInput.bind('input propertychange', e => {
        if ($searchInput.val() === ''){
            $searchWrap.find('.history').show();
            return false;
        };

        $searchWrap.find('.history').hide();
    });
});