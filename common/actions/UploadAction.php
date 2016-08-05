<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/29 0029
 * Time: 16:03
 * 上传文件处理独立操作
 */

namespace common\actions;

use Yii;
use yii\base\Action;
use yii\base\Exception;
use yii\web\UploadedFile;
use yii\web\Response;
use yii\imagine\Image;

class UploadAction extends Action
{
    const IMG_WIDTH = 1024;
    const IMG_HEIGHT = 512;
    public function run()
    {

        Yii::$app->response->format = Response::FORMAT_JSON;
        if(Yii::$app->request->isPost){
            try
            {
                $thumbnail = UploadedFile::getInstanceByName('upfile');
                $runtimeDir = Yii::getAlias('@frontend') . '/runtime';
                if(!is_dir($runtimeDir)){
                    throw new Exception( $runtimeDir . ' 目录不存在');
                }
                $fileName = $runtimeDir . '/' . uniqid(mt_rand(111, 999)) . '.' . $thumbnail->extension;


                if($thumbnail->saveAs($fileName)){
                    $uploadServer = Yii::$app->params['uploadServer'];
                    $url = Yii::uploadFile($fileName, $uploadServer);
                    unlink($fileName);  //删除临时存储文件

                    return [
                        'err_code' => 0,
                        'data' => [
                            'url' => $url,
                            'filename' => $thumbnail->name,
                            'size'  => $thumbnail->size
                        ]
                    ];

                } else {
                    return [
                        'err_code' => 1,
                        'msg' => '图片上传失败'
                    ];
                }
            }
            catch (\Exception $e)
            {
                return [
                    'err_code' => 2,
                    'msg' => $e->getMessage()
                ];
            }

        } else {
            return [
                'err_code' => 2,
                'msg' => '访问异常'
            ];
        }
    }
}