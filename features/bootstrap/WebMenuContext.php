<?php

declare(strict_types=1);

namespace features\contexts\App;

use Behat\Gherkin\Node\TableNode;
use Neimad\SimonTesting\Assert;

final class WebMenuContext extends AbstractWebContext
{
    /**
     * @Then the navigation menu should contain
     */
    public function shouldNavigationMenuContain(TableNode $items): void
    {
        $crawler = $this->crawlUri('/');
        $links = $crawler->filter('#navigation .navigation-item');
        $currentItems = [];

        foreach ($links as $link) {
            $currentItems[] = [
                'label' => $link->nodeName,
                'uri' => $link->getAttribute('href'),
            ];
        }

        Assert::eq($currentItems, $items->getRows());
    }
}
