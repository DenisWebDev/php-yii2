<?php
/**
 * Created by PhpStorm.
 * User: Talisman
 * Date: 25.03.2019
 * Time: 20:21
 */

namespace app\components;


use yii\base\Component;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class FileServiceComponent extends Component
{
    public function saveUploadedFile(UploadedFile $file):string{
        $path=$this->genPathForFile($file);

        return $file->saveAs($path)?$path:'';
    }

    private function genPathForFile(UploadedFile $file):string {
        FileHelper::createDirectory(\Yii::getAlias('@webroot/images/'));
        return \Yii::getAlias('@webroot/images/').uniqid().'.'.$file->extension;
    }
}