<?php

namespace spec\App\Controller;

use App\Controller\PagesController;
use PhpSpec\ObjectBehavior;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PagesControllerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PagesController::class);
    }

    function it_is_a_controller()
    {
        $this->shouldHaveType(Controller::class);
    }
}
