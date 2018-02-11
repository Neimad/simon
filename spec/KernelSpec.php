<?php

namespace spec\App;

use App\Kernel;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpKernel\KernelInterface;

class KernelSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('test', 'debug');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Kernel::class);
    }

    function it_is_a_Symfony_HTTP_kernel()
    {
        $this->shouldImplement(KernelInterface::class);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('simon');
    }

}
