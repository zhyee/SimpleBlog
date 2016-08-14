<?php

use yii\helpers\Html;

?>

<style>
    .code{
        padding: 15px 0;
        margin-bottom: 10px;
    }
</style>


<div class="row">

    <div class="col-md-12">
        <div class="jumbotron">
            <h1>Hi,Coder!</h1>
            <br>
            <p>由于常用上传插件uploadify是依靠flash的，移动端浏览器的支持并不友好，并且需要加载额外的flash文件，使用上有诸多的不便，因此，有了这个jquery上传插件。本插件利用了html5的一些新特性，比如FormData对象，文件API，以及XMLHttpRequest level 2提供的对文件以及上传下载进度的支持。<br>
                具体技术细节可参考以下网址：<br>
                <a href="https://developer.mozilla.org/en-US/docs/Web/API/FileList">https://developer.mozilla.org/en-US/docs/Web/API/FileList</a><br>
                <a href="https://developer.mozilla.org/en-US/docs/Web/API/File">https://developer.mozilla.org/en-US/docs/Web/API/File</a><br>
                <a href="https://developer.mozilla.org/en-US/docs/Web/API/FormData">https://developer.mozilla.org/en-US/docs/Web/API/FormData</a><br>
                <a href="https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest">https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest</a><br>
                <a href="https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest/upload">https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest/upload</a>
            </p>
            <p>由于本插件是本人业余时间开发，且仍在完善中，没有经过严格地bug测试，也没有经过兼容性测试，目前只使用在个人网站上，但移动端一般都是使用webkit内核的浏览器，能够很好的得到支持，PC端兼容性还有待检验，因此只供大家参考研究。</p>
            <p>
                Please feel free to contact me if there is any question or trouble,may you enjoy it!
            </p>
            <p><a class="btn btn-info btn-lg" href="https://github.com/zhyee/simpleUploader" target="_blank" role="button">Learn more</a></p>
        </div>
    </div>

    <h3>使用入门</h3>

    <div class="code col-md-12">
        <p class="lead">step 1: 引入css和js文件</p>
        <blockquote>
                <pre>
<?php
$code = <<<EOT
<!DOCTYPE html>
    <html lang="zh-CN">
    <head>
        <meta charset="UTF-8">
        <title>SimpleUploader demo</title>

        <link rel="stylesheet" href="css/simple-uploader.css">
        <link rel="stylesheet" href="font-awesome-4.5.0/css/font-awesome.min.css">

        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.simpleuploader.js"></script>
    </head>
EOT;
?>

<?= Html::encode($code) ?>
                </pre>
        </blockquote>

    </div>

    <div class="code col-md-12">
        <p class="lead">step 2: 创建input文件按钮</p>
        <blockquote>
                <pre>
<?php
$code = <<<EOT

<input type="file" name="upfile" id="upfile">

EOT;
?>

<?= Html::encode($code) ?>
                </pre>
        </blockquote>

    </div>


    <div class="code col-md-12">
        <p class="lead">step 3: 准备一个json文件模拟后台返回数据,在当前目录下新建一个result.json文件，拷贝以下内容到该文件</p>
        <blockquote>
                <pre>
<?php
$code = <<<EOT

{
    "errer_code" : 0,
    "data" : {
        "url" : "http://image.golaravel.com/5/c9/44e1c4e50d55159c65da6a41bc07e.jpg",
        "fileName" : "pub_34.jpg",
        "fileSize" : 21592
    }
}

EOT;
?>

<?= Html::encode($code) ?>
                </pre>
        </blockquote>

    </div>


    <div class="code col-md-12">
        <p class="lead">step 4: 调用</p>
        <blockquote>
                <pre>
<?php
$code = <<<EOT

<script>
    $(function(){

        $('#upfile').simpleUploader({
            debug      : true,  //  是否打开控制台调试信息，默认为否
            buttonText : '<i class="fa fa-plus fa-lg"></i>', //按钮显示内容
            url : 'result.json',   // 这里只是便于测试， 实际业务中应该是服务端处理后返回的JSON数据
            onUploadSuccess : function (rt) {
                var result = JSON.parse(rt);
                if (result.errer_code == 0){
                    $('body').css('background-image', 'url(' + result.data.url + ')');  //成功时把返回的图片作为网页的背景图片
                }
            }
        });
    });
</script>


EOT;
?>

<?= Html::encode($code) ?>
                </pre>
        </blockquote>

    </div>

    <div class="code col-md-12">
        <p class="lead">setp5: That's all,enjoy it! 上传效果图</p>

        <blockquote><img src="http://img.zyee.org/uploads/20160806/01/570257a4cdef54018.png" class="img-responsive img-thumbnail"></blockquote>
    </div>

</div>
