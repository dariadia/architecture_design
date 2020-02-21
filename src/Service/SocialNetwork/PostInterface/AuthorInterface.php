<?php

declare(strict_types=1);

namespace Service\SocialNetwork\PostInterface;

/**
 * AuthorInterface - Интерфейс для сущности, от имени которой мы публикуем пост в соц сеть
 */
interface AuthorInterface
{
    /**
     * @return string
     */
    public function getLogin(): string;

    /**
     * @return string
     */
    public function getUsername(): string;
}
