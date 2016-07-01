/**
 * Created by Administrator on 2016/4/6 0006.
 */

/**
 * 网站的基础js
 */

/**
 * 显示信息
 * @param message
 * @param status
 * @param timeout
 */
function showMsg(message, status, timeout){
    if($('#showMsg').length){
        $('#showMsg').remove();
    }
    $('<div id="showMsg"></div>').css({
        width : '100%',
        height : '36px',
        position : 'absolute',
        left : 0,
        top : '5px',
        zIndex : 9999,
        lineHeight : '36px',
    }).html('<p>' + message + '<span class="close"></span></p>').appendTo('body');

    if(status == 'success'){
        $('#showMsg p').addClass('bg-success');
    } else if(status == 'error'){
        $('#showMsg p').addClass('bg-danger');
    }

    timeout = parseInt(timeout) || 0;

    if(timeout > 0){
        setTimeout(closeMsg, timeout);
    }
    $('#showMsg p span').click(closeMsg);
}

function closeMsg(){
    $('#showMsg').fadeOut('slow', function(){
        $(this).remove();
    });
}


/**
 * 显示成功的信息
 * @param message
 * @param timeout
 */
function success(message, timeout){
    if(typeof timeout == 'undefined'){
        timeout = 3000;
    }
    showMsg(message, 'success', timeout);
}

/**
 * 显示失败的信息
 * @param message
 * @param timeout
 */
function error(message, timeout){
    if(typeof timeout == 'undefined'){
        timeout = 3000;
    }
    showMsg(message, 'error', timeout);
}

/**
 * 添加loading
 */
function addLoading(){
    removeLoading();
    $('<div id="loading"></div>').css({
        width : $(document).width(),
        height : $(document).height(),
        position : 'absolute',
        top : 0,
        left : 0,
        zIndex : 99999,
        opacity : 0.5,
        backgroundColor : '#000'
    }).appendTo('body');

    $('<img>').attr('src', '/images/loading.gif').css({
        position : 'relative',
        left : '50%',
        top : '50%',
        transform : 'translate(-50%,-50%)'
    }).appendTo('#loading');
}

/**
 * 移除loading
 */
function removeLoading(){
    $('#loading').remove();
}

function htmlspecialchars(str){
    return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
}

/**
 * 全局ajax loading
 */
$(function(){
    $(document).ajaxStart(addLoading);
    $(document).ajaxComplete(removeLoading);
});
