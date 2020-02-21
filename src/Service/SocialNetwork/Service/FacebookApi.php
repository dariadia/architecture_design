<?php

declare(strict_types=1);

namespace Service\SocialNetwork\Service;

/**
 * Адаптируемый класс
 */
class FacebookApi
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

    public function post(string $login, string $post): void
    {
        echo "Публикуем пост с текстом '$post' на стене '$login'.\n";
    }
}
