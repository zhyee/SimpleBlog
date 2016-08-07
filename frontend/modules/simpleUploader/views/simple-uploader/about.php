<?php

use yii\helpers\Html;

?>

<style>
    .logo, .code{
        padding: 15px 0;
        margin-bottom: 10px;
    }


</style>


<div class="row">

    <div class="logo col-md-12">
        <h3>上传效果图：</h3>
        <br>
        <img src="http://img.zyee.org/uploads/20160806/01/570257a4cdef54018.png" class="img-responsive img-thumbnail">
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
        <p class="lead">step 5: Now enjoy it!</p>
        <blockquote style="width: 100%">
            源码下载GitHub : <a target="_blank" href="https://github.com/zhyee/simpleUploader">https://github.com/zhyee/simpleUploader</a>
        </blockquote>

    </div>
</div>
