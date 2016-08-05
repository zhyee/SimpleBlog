<?php

use yii\web\JqueryAsset;
use yii\helpers\Url;

JqueryAsset::register($this);

?>

<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>夜小楼的网站</title>
    <?= $this->head() ?>
    <style>
        html,body,div,p,h1,h2,h3,h4,h5,h6,a,span,dl,dt,dd,ul,ol,li{
            padding: 0;
            margin: 0;
        }
        html,body{
            height: 100%;
        }
        body{
            font-family: "Courier New", "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 10px;
            font-weight: normal;
            color: #fefefe;
            background: #fff no-repeat center center;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            background-size: cover;
            -webkit-transition: all 2s ease;
            -moz-transition: all 2s ease;
            transition: all 2s ease;
        }
        a{
            color: #fefefe;
            text-decoration: none;
        }

        .ml-2{
            margin-left: 2px;
        }

        .ml-3{
            margin-left: 3px;
        }

        .ml-5{
            margin-left: 5px;
        }

        .ml-10{
            margin-left: 10px;
        }

        .row {
            width: 85%;
        }
        @media  (min-width: 600px){
            .row{
                width: 65%;
            }
        }
        @media (min-width: 700px){
            .row{
                width: 60%;
            }
        }
        @media (min-width: 800px){
            .row{
                width: 55%;
            }
        }
        @media  (min-width: 900px){
            .row{
                width: 50%;
            }
        }
        @media (min-width: 1000px) {
            .row{
                width: 45%;
            }
        }
        @media  (min-width: 1200px){
            .row{
                width: 40%;
            }
        }
        .container{
            position: absolute;
            width: 100%;
            left:50%;
            top:50%;
            -webkit-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }
        .main{
            min-height: 300px;
            background-color: rgba(0,0,0,0.3);
            border: 1px solid rgba(150,150,150,0.3);
            color: #fefefe;
            border-radius: 1.5rem;
            padding: 0.5rem 1rem;
            margin:0 auto;
        }
        .text-center{
            text-align: center;
        }
        .main-header .face img{
            border-radius: 100%;
            cursor: pointer;
        }
        .main-header h1{
            padding: 0.2rem 0 1.5rem 0;
            font-size: 1.6rem;
            cursor: pointer;
        }
        .main-content{
            border-bottom: 1px solid #d3d3d3;
            border-top: 1px solid #d3d3d3;
            padding: 1.5rem 1rem;
            border-radius: 0.4rem;
        }
        .main-content .nav{
            font-size: 1.6rem;
            background: rgba(0,0,0,0.5);
            padding: 0.5rem 0.2rem;
            border-radius: 0.5rem;
        }
        .main-content .nav a{
            font-size: 1.2rem;
        }

        .main-content .nav a:hover{
            background: wheat;
            color: rgba(0,0,0,0.7);
            -webkit-transition: all 0.5s ease;
            -moz-transition: all 0.5s ease;
            transition: all 0.5s ease;
        }
        .main-content .nav .separator{
            color: rgba(200,200,200, 0.6);
        }
    </style>
</head>
<body>

<?php $this->beginBody() ?>

<div class="container">

    <div class="row main">

        <div class="main-header">
            <div class="face text-center">
                <img id="face" src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/images/face.jpg" alt="夜小楼" width="120">
            </div>
            <h1 id="title" class="text-center">小楼的个人网站</h1>
        </div>

        <div class="main-content">
            <p class="nav">
                <a href="<?= Url::to(['article/article/index']) ?>">Blog<span class="ml-3">&#187;</span></a>
                <span class="separator"> | </span>
                <a href="<?= Url::to(['/site/about']) ?>">About<span class="ml-3">&#187;</span></a>
                <span class="separator"> | </span>
                <a href="<?= Url::to(['/simple-uploader/simple-uploader']) ?>">SimpleUploader<span class="ml-3">&#187;</span></a>
            </p>
        </div>

        <div class="main-footer"></div>

    </div>

</div>

<script>

    $(function () {
        /* 切换页面背景 */
        function switchBackground () {
            var id = Math.floor(Math.random() * 355) + 1;
            var bgimg = '<?= Yii::$app->getUrlManager()->getBaseUrl() . '/images/bgs' ?>';
            bgimg += '/pub_' + id + '.jpg';
            $('body').css('background-image', 'url(' + bgimg + ')');
        }
        switchBackground();
        $('#face,#title').on('click', switchBackground);
    });

</script>

<?php $this->endBody() ?>
</body>
</html>

<?php $this->endPage() ?>