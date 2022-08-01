<?php
namespace AdultVideosApi\Model\Request\Video;

class GetByIdRequestModel {
    const ENDPOINT_URI = '/videos/get-by-id';

    public string $video_ids;
}