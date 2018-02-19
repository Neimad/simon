<?php

declare(strict_types=1);

namespace features\contexts\App;

use App\Document\DocumentInterface;
use App\Document\Page;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Doctrine\ODM\PHPCR\DocumentManagerInterface;

abstract class AbstractDocumentContext implements Context
{
    use WorkspaceTrait;

    /** @var DocumentManagerInterface */
    private $dm;

    /** @var array */
    private $identifiers = [];

    public function __construct(DocumentManagerInterface $dm)
    {
        $this->dm = $dm;
    }

    /**
     * @Given a page exists with title :title and content
     * @Given a page exists with title :title
     */
    public function pageExists(string $title, ?PyStringNode $content = null): void
    {
        $page = new Page();
        $dm = $this->getDocumentManager();

        if (null === $content) {
            $content = "Content of page {$title}.";
        }

        $page->setTitle($title)
            ->setContent((string) $content);

        $dm->persist($page);
        $dm->flush($page);

        $this->setDocument($page);
    }

    protected function getDocumentManager(): DocumentManagerInterface
    {
        return $this->dm;
    }

    protected function setDocument(DocumentInterface $document): void
    {
        $dm = $this->getDocumentManager();
        $node = $dm->getNodeForDocument($document);

        $this->identifiers[] = $node->getIdentifier();
    }

    protected function getDocument(): ?DocumentInterface
    {
        $id = \end($this->identifiers);

        if (null === $id) {
            return null;
        }

        $dm = $this->getDocumentManager();

        return $dm->find(null, $id);
    }
}
