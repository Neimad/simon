<?php

namespace Neimad\SimonBundle\DataFixtures\PHPCR;

use Doctrine\ODM\PHPCR\DocumentManagerInterface;
use Neimad\SimonBundle\Document\Page;
use Neimad\SimonBundle\DataFixtures\PHPCRFixture;

/**
 * Some Pages fixtures.
 */
final class Pages extends PHPCRFixture
{
    /**
     * @inheritDoc
     */
    public function loadDocuments(DocumentManagerInterface $dm): void
    {
        $page = new Page();
        $page->setTitle('Foo')
             ->setContent(<<<_CONTENT_
Proident deserunt eu ullamco laboris amet commodo exercitation culpa sunt nulla duis id. Irure proident proident Lorem incididunt nostrud adipisicing proident deserunt elit aute ut esse non ut. Ullamco Lorem deserunt amet aliqua dolore do aute ad cupidatat exercitation eu. Consequat sit sunt commodo anim nostrud incididunt culpa commodo veniam laboris mollit ipsum enim elit. Proident aliquip veniam ad ad proident est tempor ea nisi velit. Consectetur enim deserunt duis nulla nulla ex. Exercitation eu in id fugiat nostrud sit.
_CONTENT_
);

        $dm->persist($page);
        $dm->flush();
    }
}
