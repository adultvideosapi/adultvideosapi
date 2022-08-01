<?php
namespace AdultVideosApi\Model\Request\Video;

class GetRelatedRequestModel {
    const ENDPOINT_URI = '/videos/get-related';

    public int $video_id;
    public bool $only_best;
}