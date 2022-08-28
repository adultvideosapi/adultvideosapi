<?php
namespace AdultVideosApi\Model\Request\Video;

class GetRecommendedRequestModel {
    const ENDPOINT_URI = '/videos/get-recommended';

    public string $video_ids;
    public bool $only_gay;
    public bool $only_trans;
    public int $page;
    public int $per_page;
}