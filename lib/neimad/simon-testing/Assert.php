<?php

declare(strict_types=1);

namespace Neimad\SimonTesting;

use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Webmozart\Assert\Assert as Base;

class Assert extends Base
{
    protected static function valueToString($value): string
    {
        if (\is_array($value)) {
            return static::arrayToString($value);
        }

        return parent::valueToString($value);
    }

    protected static function arrayToString(array $value): string
    {
        $dumper = new CliDumper(null, null, CliDumper::DUMP_LIGHT_ARRAY);
        $cloner = new VarCloner();

        return $dumper->dump($cloner->cloneVar($value), true);
    }
}
