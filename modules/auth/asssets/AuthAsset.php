<?php


namespace app\modules\auth\asssets;


use app\assets\AppAsset;
use yii\web\AssetBundle;

class AuthAsset extends AssetBundle
{

//    public $basePath='@app/modules/auth/asssets';

    public $sourcePath='@app/modules/auth/asssets';

    public $baseUrl=null;
    public $css=[
        'css/auth.css'
    ];

    public $depends=[
       AppAsset::class
    ];
}