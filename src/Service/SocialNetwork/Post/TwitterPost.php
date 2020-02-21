<?php

declare(strict_types=1);

namespace Service\SocialNetwork\Post;

use Service\SocialNetwork\PostInterface\AuthorInterface;
use Service\SocialNetwork\PostInterface\PostInterface;

class TwitterPost implements PostInterface
{
    /**
     * @var AuthorInterface
     */
    private $author;

    /**
     * @var string
     */
    private $post;

    /**
     * @param AuthorInterface $author
     * @param string $post
     */
    public function __construct(
        AuthorInterface $author,
        string $post
    ) {
        $this->author = $author;
        $this->post = $post;
    }

    public function post(): void
    {
        echo "Публикуем запись в Twitter от лица "
            . "'{$this->author->getLogin()}' с текстом "
            . "'$this->post'.\n";
    }
}
