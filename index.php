<?php
require 'vendor/autoload.php';

$adultvideosapi = new \AdultVideosApi\AdultVideosApi('23G0hC9jWBP1uHVS74444GCQNOuMZoHB');

$model = new \AdultVideosApi\Model\Request\Video\SearchRequestModel();
$model->query = 'doggy pov';

echo '<pre>';
print_r($adultvideosapi->get($model));