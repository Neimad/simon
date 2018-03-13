<?php

declare(strict_types=1);

namespace features\contexts\App;

use Behat\Behat\Hook\Scope\BeforeScenarioScope;

/**
 * Gives access to the fixtures.
 */
trait FixturesAwareTrait
{
    /** @var FixturesContext */
    private $fixturesContext;

    /** @BeforeScenario */
    public function gatherFixturesContext(BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();

        $this->fixturesContext = $environment->getContext(FixturesContext::class);
    }

    public function getFixturesContext(): FixturesContext
    {
        return $this->fixturesContext;
    }
}
