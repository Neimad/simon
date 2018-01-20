<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ODM\PHPCR\DocumentManagerInterface;

abstract class PHPCRFixture implements FixtureInterface
{
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        if (!$manager instanceof DocumentManagerInterface) {
            $class = get_class($manager);
            throw new \RuntimeException("Fixture requires a PHPCR ODM DocumentManager instance, instance of '$class' given.");
        }

        $this->loadDocuments($manager);
    }

    /**
     * Loads data fixtures with the given DocumentManager.
     */
    abstract public function loadDocuments(DocumentManagerInterface $dm): void;
}
