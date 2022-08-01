<?php
namespace AdultVideosApi\Model\Request\Video;

class GetOnlyBestRequestModel {
    const ENDPOINT_URI = '/videos/get-only-best';

    public string $categories;
    public bool $has_preview;
    public int $min_duration;
    public int $max_duration;
    public float $min_votes_pct;
    public string $sections;
    public string $title_alphabet;
    public int $page;
    public int $per_page;
    public string $order;
}