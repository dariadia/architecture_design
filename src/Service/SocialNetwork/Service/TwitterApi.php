<?php

declare(strict_types=1);

namespace Service\SocialNetwork\Service;

/**
 * Адаптируемый класс
 */
class TwitterApi
{
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function createConnection(): void
    {
        echo "Connected";
    }

    public function post(string $username, string $post): void
    {
        echo "Публикуем пост от лица '$username' с текстом - '$post'.\n";
    }
}
