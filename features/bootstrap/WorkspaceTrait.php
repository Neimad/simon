<?php

declare(strict_types=1);

namespace features\contexts\App;

/**
 * Keep workpace clean.
 */
trait WorkspaceTrait
{
    /**
     * @BeforeSuite
     */
    public static function createWorkspace(): void
    {
        `bin/console doctrine:phpcr:workspace:create --ignore-existing testing`;
    }

    /**
     * @AfterSuite
     */
    public static function deleteWorkspace(): void
    {
        `bin/console doctrine:phpcr:workspace:create --ignore-existing testing`;
    }

    /**
     * @BeforeScenario
     */
    public function initWorkspace(): void
    {
        `bin/console doctrine:phpcr:repository:init --env=test`;
    }

    /**
     * @AfterScenario
     */
    public function cleanWorkspace(): void
    {
        `bin/console doctrine:phpcr:workspace:purge --force --env=test`;
    }
}
