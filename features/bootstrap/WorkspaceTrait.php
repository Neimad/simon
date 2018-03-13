<?php

declare(strict_types=1);

namespace features\contexts\App;

/**
 * Keeps workpace clean.
 */
trait WorkspaceTrait
{
    /** @BeforeSuite */
    public static function createWorkspace(): void
    {
        self::executeCommand('bin/console doctrine:phpcr:workspace:create --ignore-existing testing');
    }

    /** @AfterSuite */
    public static function deleteWorkspace(): void
    {
        self::executeCommand('bin/console doctrine:phpcr:workspace:delete --force testing');
    }

    /** @BeforeScenario */
    public function initWorkspace(): void
    {
        self::executeCommand('bin/console doctrine:phpcr:repository:init --env=test');
    }

    /** @AfterScenario */
    public function cleanWorkspace(): void
    {
        self::executeCommand('bin/console doctrine:phpcr:workspace:purge --force --env=test');
    }

    private static function executeCommand(string $command): void
    {
        \exec("{$command} 2>&1", $output, $statusCode);

        if (0 !== $statusCode) {
            $output = \implode(\PHP_EOL, $output);

            // throw new \RuntimeException($output, $statusCode);
        }
    }
}
