# Adult Videos API #

<dl>
  <dt>Reference Docs</dt><dd><a href="https://adultvideosapi.com/doc">https://adultvideosapi.com/doc</a></dd>
</dl>

## Installation ##

You can use **Composer** or simply **Download the Release**

### Composer

```sh
composer require adultvideosapi/adultvideosapi
```

This library relies on `php-curl-class/php-curl-class`

## Usage

First of all you need to obtain API key from <a href="https://adultvideosapi.com">adultvideosapi.com</a> and provide it to `\AdultVideosApi\AdultVideosApi` class.

```php
$adultVideosApi = new \AdultVideosApi\AdultVideosApi('72G0hC2jWBP1uHXS747A4CCENOvMuoCP');
```

Package contains model for each API endpoint and each model contains properties based on query parameters of <a href="https://adultvideosapi.com/doc">API Docs.</a>

```php
$getAllModel = \AdultVideosApi\Model\Request\Video\GetAllRequestModel();
$getOnlyBestModel = \AdultVideosApi\Model\Request\Video\GetOnlyBestRequestModel();
$getRecommendedModel = \AdultVideosApi\Model\Request\Video\GetRecommendedRequestModel();
$getRelatedModel = \AdultVideosApi\Model\Request\Video\GetRelatedRequestModel();
$getByIdModel = \AdultVideosApi\Model\Request\Video\GetByIdRequestModel();
$searchModel = \AdultVideosApi\Model\Request\Video\SearchRequestModel();

$categories_getAllModel = \AdultVideosApi\Model\Request\Category\GetAllRequestModel();
```

To retrieve data from API you need to pass the model to `$adultVideosApi->get()` method

```php
$adultVideosApi = new \AdultVideosApi\AdultVideosApi('72G0hC2jWBP1uHXS747A4CCENOvMuoCP');

$getAllModel = \AdultVideosApi\Model\Request\Video\GetAllRequestModel();

$responseData = $adultVideosApi->get($getAllModel);
```

Response from `get()` method is the same as response specified in <a href="https://adultvideosapi.com/doc">API Docs.</a>

```
stdClass Object
(
    [status] => 1
    [pagination] => stdClass Object
        (
            [page] => 1
            [per_page] => 20
            [total] => 5000
        )

    [data] => Array
        (
            ...
        )
)
```

You can also retrieve data from multiple endpoints in parallel

```php
$adultVideosApi = new \AdultVideosApi\AdultVideosApi('72G0hC2jWBP1uHXS747A4CCENOvMuoCP');

$getAllModel = \AdultVideosApi\Model\Request\Video\GetAllRequestModel();
$getOnlyBestModel = \AdultVideosApi\Model\Request\Video\GetRecommendedRequestModel();

$responseData = $adultVideosApi->get($getAllModel, $getOnlyBestModel);
```

Response from `get()` method used with multiple models will be array containing responses with same order. Calls are made in parallel and waits till the last one finish.

```
Array
(
    [0] => stdClass Object
        (
            [status] => 1
            [pagination] => stdClass Object
                (
                    [page] => 1
                    [per_page] => 20
                    [total] => 5000
                )

            [data] => Array
                (
                    ...
                )
        )
        
    [1] => ...
)
```

## Examples

### Get all videos with cyrillic alphabet in Title
```php
$adultVideosApi = new \AdultVideosApi\AdultVideosApi('72G0hC2jWBP1uHXS747A4CCENOvMuoCP');

$getAllModel = \AdultVideosApi\Model\Request\Video\GetAllRequestModel();
$getAllModel->title_alphabet = 'cyrillic';

$responseData = $adultVideosApi->get($getAllModel);
```

### Search for video
```php
$adultVideosApi = new \AdultVideosApi\AdultVideosApi('72G0hC2jWBP1uHXS747A4CCENOvMuoCP');

$getAllModel = \AdultVideosApi\Model\Request\Video\SearchRequestModel();
$getAllModel->query = 'doggy pov';
$getAllModel->order = 'newest';

$responseData = $adultVideosApi->get($getAllModel);
```

### Get recommended videos
```php
$adultVideosApi = new \AdultVideosApi\AdultVideosApi('72G0hC2jWBP1uHXS747A4CCENOvMuoCP');

$getAllModel = \AdultVideosApi\Model\Request\Video\GetRecommendedRequestModel();
$getAllModel->video_ids = '123,456,789';

$responseData = $adultVideosApi->get($getAllModel);
```
