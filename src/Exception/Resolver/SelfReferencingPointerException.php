<?php

/*
 * This file is part of the JVal package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JVal\Exception\Resolver;

use JVal\Exception\ResolverException;

class SelfReferencingPointerException extends ResolverException
{
    protected function buildMessage(array $parameters)
    {
        return 'Pointer self reference detected';
    }
}
