<?php

namespace spec\App\Repository;

use App\Document\Page;
use App\Repository\PagesRepository;
use Doctrine\ODM\PHPCR\DocumentManagerInterface;
use Doctrine\ODM\PHPCR\Id\RepositoryIdInterface;
use Doctrine\ODM\PHPCR\Mapping\ClassMetadata;
use PhpSpec\ObjectBehavior;

class PagesRepositorySpec extends ObjectBehavior
{
    function let(DocumentManagerInterface $dm, ClassMetadata $class)
    {
        $this->beConstructedWith($dm, $class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PagesRepository::class);
    }

    function it_generates_the_identifiers(Page $document)
    {
        $document->getTitle()->willReturn('foo');

        $this->shouldImplement(RepositoryIdInterface::class);
        $this->generateId($document)->shouldReturn('/pages/foo');
    }
}
