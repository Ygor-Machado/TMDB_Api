<?php

use app\controllers\TmdbController;

$app->get('/', TmdbController::class . ':index');
$app->get('/{id}', TmdbController::class . ':show');
