<?php

namespace App\Shorteners\Shorteners;

use App\Shorteners\Shorteners\Domain\Url;
use App\Shorteners\Shorteners\Domain\UrlRepository;

class ShortenersHandler
{
    private $urlsRepository;

    public function __construct(
        UrlRepository $urlsRepository
    ) {
        $this->urlsRepository = $urlsRepository;
    }

    public function getShortUrl(string $originalUrl): array
    {
        if (!$this->isValidUrl($originalUrl)) {
            throw new \Exception('Invalid format url');
        }

        $url = new Url($originalUrl);

        $this->urlsRepository->save($url);

        $shortUrl = app()->encoder->encode($url->getId());

        return [
            'short_url' => $shortUrl,
        ];
    }

    protected function isValidUrl($url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL);
    }
}
