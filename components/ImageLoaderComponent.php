<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 18.04.2019
 * Time: 23:38
 */

namespace app\components;


use yii\base\Component;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class ImageLoaderComponent extends Component
{
    /**
     * @param UploadedFile $file
     * @return string|bool
     * @throws \yii\base\Exception
     */
    public function saveUploadedImage(UploadedFile $file)
    {
        $path = $this->genPathForFile($file);
        return $file->saveAs($path) ? $path : false;
    }

    /**
     * @param UploadedFile $file
     * @return string
     * @throws \yii\base\Exception
     */
    private function genPathForFile(UploadedFile $file):string
    {
        FileHelper::createDirectory(\Yii::getAlias('@webroot/images/'));
        return \Yii::getAlias('@webroot/images/').uniqid().'.'.$file->extension;
    }

}