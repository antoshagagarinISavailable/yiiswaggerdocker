<?php

namespace app\assets;

use yii\web\AssetBundle;

class SwaggerUiAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/swagger_ui';

    public $css = [
        'web/swagger-ui.css',
        'web/index.css',
    ];

    public $js = [
        'web/swagger-ui-bundle.js',
        'web/swagger-ui-standalone-preset.js',
    ];

}