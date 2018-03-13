<?php

declare(strict_types=1);

namespace features\contexts\App;

use Behat\Gherkin\Node\PyStringNode;
use Ferrandini\Urlizer;
use Neimad\SimonTesting\Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class WebPagesContext extends AbstractWebContext
{
    /**
     * @When I requests the home page
     */
    public function requestsTheHomePage(): void
    {
        $this->visit('/');
    }

    /**
     * @When I create a page with title :title and content
     */
    public function createPage(string $title, PyStringNode $content): void
    {
        $this->httpRequest(Request::METHOD_PUT, '/pages', [
            'title' => $title,
            'content' => (string) $content,
        ]);
    }

    /**
     * @When I delete it
     */
    public function delete(): void
    {
        $uri = $this->getPageUri();

        $this->httpRequest(Request::METHOD_DELETE, $uri);
    }

    /**
     * @When I set its title to :title
     */
    public function setTitle(string $title): void
    {
        $uri = $this->getPageUri();

        $this->httpRequest(Request::METHOD_PATCH, $uri, [
            'title' => $title,
            ]);
    }

    /**
     * @When I set its content to
     */
    public function setContent(PyStringNode $content): void
    {
        $uri = $this->getPageUri();

        $this->httpRequest(Request::METHOD_PATCH, $uri, [
            'content' => (string) $content,
        ]);
    }

    /**
     * @Then I should get it successfully
     * @Then it should be available
     */
    public function shouldBeAvailable(): void
    {
        $uri = $this->getPageUri();

        $response = $this->visit($uri);

        Assert::same($response->getStatusCode(), Response::HTTP_OK);
    }

    /**
     * @Then it should be unavailable
     */
    public function shouldBeUnavailable(): void
    {
        $uri = $this->getPageUri();

        $response = $this->visit($uri);

        Assert::same($response->getStatusCode(), Response::HTTP_NOT_FOUND);
    }

    /**
     * @Then its title should be :title
     */
    public function shouldHaveTitle(string $title): void
    {
        $uri = $this->getPageUri();
        $crawler = $this->crawlUri($uri);

        $currentTitle = $crawler->filter('#title')->text();

        Assert::same($currentTitle, $title);
    }

    /**
     * @Then its content should be
     */
    public function shouldHaveContent(PyStringNode $content): void
    {
        $uri = $this->getPageUri();
        $crawler = $this->crawlUri($uri);

        $currentContent = $crawler->filter('#content')->html();

        Assert::same($currentContent, $content);
    }

    private function getPageUri(): string
    {
        $page = $this->getFixturesContext()->getFixture();

        $title = Urlizer::urlize($page->getTitle());

        return "{$title}";
    }
}
