<?php

declare(strict_types=1);

namespace Service\SocialNetwork\PostInterface;

/**
 * Интерфейс, который использует наше приложение для публикации поста в соц сеть
 */
interface PostInterface
{
    public function post(): void;
}
