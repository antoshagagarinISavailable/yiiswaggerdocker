<?php

use app\assets\SwaggerUiAsset;

$this->title = 'Документация API';
$this->params['breadcrumbs'][] = $this->title;

SwaggerUiAsset::register($this);

?>

<div id="swagger-ui"></div>

<script>
    window.onload = function() {
        const ui = SwaggerUIBundle({
            url: '/api/v1/json-schema',
            dom_id: '#swagger-ui',
            presets: [SwaggerUIBundle.presets.apis, SwaggerUIStandalonePreset],
            layout: 'StandaloneLayout',
            validatorUrl: null,
        });
    }
</script>
