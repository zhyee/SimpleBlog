<?php
namespace frontend\modules\simpleUploader\controllers;

class SimpleUploaderController extends SimpleUploaderBaseController
{
    public function init()
    {
        $this->layout = '/simple-uploader';
        parent::init();
    }

    public function actionIndex()
    {
        return $this->actionAbout();
    }

    public function actionAbout(){
        return $this->render('about');
    }

    public function actionDocs()
    {
        return $this->render('docs');
    }

    public function actionExamples()
    {
        return $this->render('examples');
    }
}
