<?php

declare(strict_types=1);

namespace Service\SocialNetwork\Post;

use Service\SocialNetwork\PostInterface\AuthorInterface;
use Service\SocialNetwork\PostInterface\PostInterface;

class FacebookPost implements PostInterface
{
    /**
     * @var AuthorInterface
     */
    private $author;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $post;

    /**
     * @param AuthorInterface $author
     * @param string $title
     * @param string $post
     */
    public function __construct(
        AuthorInterface $author,
        string $title,
        string $post
    ) {
        $this->author = $author;
        $this->title = $title;
        $this->post = $post;
    }

    public function post(): void
    {
        echo "Публикуем пост '$this->title' на стене от лица "
            . "'{$this->author->getLogin()}' с текстом "
            . "'$this->post'.\n";
    }
}
