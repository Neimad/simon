<?php

declare(strict_types=1);

namespace App\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Symfony\Cmf\Component\Routing\RouteReferrersReadInterface;

/**
 * A simple page.
 *
 * @PHPCR\Document(repositoryClass="App\Repository\PagesRepository",
 *                 referenceable=true)
 */
final class Page implements DocumentInterface, RouteReferrersReadInterface
{
    /**
     * @PHPCR\Id(strategy="repository")
     *
     * @var string
     */
    private $id;

    /**
     * @PHPCR\Referrers(referringDocument="Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route",
     *                  referencedBy="content")
     *
     * @var array
     */
    private $routes;

    /**
     * @PHPCR\Field(type="string", nullable=false)
     *
     * @var string
     */
    private $title;

    /**
     * @PHPCR\Field(type="string", nullable=false)
     *
     * @var string
     */
    private $content;

    /**
     * @inheritDoc
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Gives the title of the page.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets the title of the page.
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Gives the content of the page.
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Sets the title of the page.
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
