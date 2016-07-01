/**
 * Created by Administrator on 2016/3/22 0022.
 */
$(function(){
    var um = UM.getEditor('ueditor', {
        autoHeightEnabled: true,
        autoFloatEnabled: true,
        initialFrameWidth: 'auto',
        initialFrameHeight: 280,
        imageUrl : 'index.php?r=article/upload'
    });

    $('#article-thumbnail').uploadify({
        width           : 30,
        heigth          : 30,
        fileSizeLimit   : '2048KB',
        buttonText      : '',
        buttonImage     : '/back/images/attachment.png',
        swf             : '/back/css/uploadify.swf',
        uploader        : uploadUrl,
        formData        : {_csrf : _csrf},
        fileObjName     : 'upfile',
        onUploadSuccess : function(file, data, response){
            if(response){
                var rs = $.parseJSON(data);
                if(rs.err_code > 0){
                    alert(rs.msg);
                }else{
                    var data = rs.data;
                    $('input[name="Article[thumbnail]"]').val(data.url);
                    $('.field-article-thumbnail').find('img').remove();
                    $('<img>').attr({src : data.url, width:80}).appendTo($('.field-article-thumbnail'))
                }
            }
        }
    });
});