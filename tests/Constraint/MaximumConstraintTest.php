<?php

namespace JsonSchema\Constraint;

use JsonSchema\Constraint;
use JsonSchema\Exception\ConstraintException;
use JsonSchema\Testing\ConstraintTestCase;

class MaximumConstraintTest extends ConstraintTestCase
{
    public function testNormalizeThrowsIfMaxNotPresent()
    {
        $this->expectException(ConstraintException::MAXIMUM_NOT_PRESENT);
        $schema = $this->loadSchema('invalid/maximum-not-present');
        $this->getConstraint()->normalize($schema);
    }

    public function testNormalizeSetsExclusiveMaxToFalseIfNotPresent()
    {
        $schema = $this->loadSchema('valid/exclusiveMaximum-not-present');
        $this->getConstraint()->normalize($schema);
        $this->assertTrue(isset($schema->exclusiveMaximum));
        $this->assertEquals(false, $schema->exclusiveMaximum);
    }

    public function testNormalizeThrowsIfMaximumIsNotANumber()
    {
        $this->expectException(ConstraintException::MAXIMUM_NOT_NUMBER);
        $schema = $this->loadSchema('invalid/maximum-not-number');
        $this->getConstraint()->normalize($schema);
    }

    public function testNormalizeThrowsIfExclusiveMaximumIsNotABoolean()
    {
        $this->expectException(ConstraintException::EXCLUSIVE_MAXIMUM_NOT_BOOLEAN);
        $schema = $this->loadSchema('invalid/exclusiveMaximum-not-boolean');
        $this->getConstraint()->normalize($schema);
    }

    protected function getConstraint()
    {
        return new MaximumConstraint();
    }

    protected function getCaseFileNames()
    {
        return ['maximum'];
    }
}
