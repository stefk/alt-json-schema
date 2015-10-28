<?php

namespace JVal\Constraint;

use JVal\Constraint;
use JVal\Context;
use JVal\Exception\Constraint\EmptyArrayException;
use JVal\Exception\Constraint\InvalidTypeException;
use JVal\Exception\Constraint\NotUniqueException;
use JVal\Types;
use JVal\Walker;
use stdClass;

/**
 * Constraint for the "required" keyword.
 */
class RequiredConstraint implements Constraint
{
    /**
     * {@inheritDoc}
     */
    public function keywords()
    {
        return ['required'];
    }

    /**
     * {@inheritDoc}
     */
    public function supports($type)
    {
        return $type === Types::TYPE_OBJECT;
    }

    /**
     * {@inheritDoc}
     */
    public function normalize(stdClass $schema, Context $context, Walker $walker)
    {
        $context->enterNode($schema->required, 'required');

        if (!is_array($schema->required)) {
            throw new InvalidTypeException($context, Types::TYPE_ARRAY);
        }

        if (0 === $requiredCount = count($schema->required)) {
            throw new EmptyArrayException($context);
        }

        foreach ($schema->required as $index => $property) {
            if (!is_string($property)) {
                $context->enterNode($property, $index);

                throw new InvalidTypeException($context, Types::TYPE_STRING);
            }
        }

        if ($requiredCount !== count(array_unique($schema->required))) {
            throw new NotUniqueException($context);
        }

        $context->leaveNode();
    }

    /**
     * {@inheritDoc}
     */
    public function apply($instance, stdClass $schema, Context $context, Walker $walker)
    {
        foreach ($schema->required as $property) {
            if (!property_exists($instance, $property)) {
                $context->addViolation('property "%s" is missing', [$property]);
            }
        }
    }
}
