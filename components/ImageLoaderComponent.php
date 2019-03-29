<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 27.03.2019
 * Time: 13:07
 */

namespace app\components;


use yii\base\Component;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class ImageLoaderComponent extends Component
{
    public function saveUploadedImage(UploadedFile $file):string{
        $path = $this->genPathForFile($file);

        return $file->saveAs($path) ? $path : '';
    }

    private function genPathForFile(UploadedFile $file):string {
        FileHelper::createDirectory(\Yii::getAlias('@webroot/images/'));
        return \Yii::getAlias('@webroot/images/').uniqid().'.'.$file->extension;
    }
}