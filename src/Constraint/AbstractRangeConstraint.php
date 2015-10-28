<?php

namespace JVal\Constraint;

use JVal\Constraint;
use JVal\Context;
use JVal\Exception\Constraint\InvalidTypeException;
use JVal\Exception\Constraint\MissingKeywordException;
use JVal\Types;
use JVal\Walker;
use stdClass;

/**
 * Base class for constraints based on a numeric limit.
 */
abstract class AbstractRangeConstraint implements Constraint
{
    /**
     * {@inheritDoc}
     */
    public function supports($type)
    {
        return $type === Types::TYPE_INTEGER
            || $type === Types::TYPE_NUMBER;
    }

    /**
     * {@inheritDoc}
     */
    public function normalize(stdClass $schema, Context $context, Walker $walker)
    {
        $property = $this->keywords()[0];
        $secondaryProperty = $this->keywords()[1];

        if (!property_exists($schema, $property)) {
            throw new MissingKeywordException($context, $property);
        }

        if (!property_exists($schema, $secondaryProperty)) {
            $schema->{$secondaryProperty} = false;
        }

        if (!Types::isA($schema->{$property}, Types::TYPE_NUMBER)) {
            $context->enterNode($schema->{$property}, $property);

            throw new InvalidTypeException($context, Types::TYPE_NUMBER);
        }

        if (!is_bool($schema->{$secondaryProperty})) {
            $context->enterNode($schema->{$secondaryProperty}, $secondaryProperty);

            throw new InvalidTypeException($context, Types::TYPE_BOOLEAN);
        }
    }
}
