<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\ODM\PHPCR\DocumentRepository;
use Doctrine\ODM\PHPCR\Id\RepositoryIdInterface;

/**
 * The repository for pages.
 */
final class PagesRepository extends DocumentRepository implements RepositoryIdInterface
{
    /**
     * @inheritDoc
     */
    public function generateId($document, $parent = null)
    {
        $title = $document->getTitle();

        return "/pages/{$title}";
    }
}
