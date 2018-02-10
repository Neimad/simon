<?php

namespace spec\App\Document;

use App\Document\Page;
use PhpSpec\ObjectBehavior;

class PageSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Page::class);
    }

    function it_has_a_title()
    {
        $title = 'foo';

        $this->setTitle($title);
        $this->getTitle()->shouldReturn($title);
    }

    function it_has_a_content()
    {
        $content = 'Foo bar baz.';

        $this->setContent($content);
        $this->getContent()->shouldReturn($content);
    }
}
