<?php
namespace AdultVideosApi\Model\Request\Video;

class SearchRequestModel {
    const ENDPOINT_URI = '/videos/search';

    public string $query;
    public string $sections;
    public bool $only_best;
    public bool $has_preview;
    public int $page;
    public int $per_page;
    public string $order;
}