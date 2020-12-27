<?php

namespace App\Shorteners\Shorteners;

use App\Shorteners\Shorteners\Domain\Url;
use App\Shorteners\Shorteners\Domain\UrlRepository;
use Illuminate\Support\Facades\Cache;

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

    public function getOriginalUrl(string $shortUrl): string
    {
        return Cache::store('redis')->remember("urls.{$shortUrl}", 3600, function () use ($shortUrl)
        {
            $decodeShortUrl = app()->encoder->decode($shortUrl);

            if (count($decodeShortUrl) === 0) {
                throw new \Exception(sprintf('Incorrect Short url %s', $shortUrl));
            }

            $urlId = $decodeShortUrl[0];

            $url = $this->urlsRepository->findById($urlId);

            if (!$url) {
                throw new \RuntimeException(sprintf('Short url not found %s', $shortUrl));
            }

            return $url->getOriginalUrl();
        });
    }

    protected function isValidUrl($url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL);
    }
}
