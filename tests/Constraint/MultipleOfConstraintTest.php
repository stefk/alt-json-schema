<?php

namespace JsonSchema\Constraint;

use JsonSchema\Exception\ConstraintException;
use JsonSchema\Testing\ConstraintTestCase;

class MultipleOfConstraintTest extends ConstraintTestCase
{
    public function testNormalizeThrowsIfNotANumber()
    {
        $this->expectException(ConstraintException::MULTIPLE_OF_NOT_NUMBER);
        $schema = $this->loadSchema('invalid/multiple-of-not-number');
        $this->getConstraint()->normalize($schema);
    }

    /**
     * @dataProvider invalidSchemaProvider
     * @param string $schemaName
     */
    public function testNormalizeThrowsOnNonPositiveNumber($schemaName)
    {
        $this->expectException(ConstraintException::MULTIPLE_OF_NOT_POSITIVE);
        $schema = $this->loadSchema($schemaName);
        $this->getConstraint()->normalize($schema);
    }

    public function invalidSchemaProvider()
    {
        return [
            ['invalid/multiple-of-not-positive-1'],
            ['invalid/multiple-of-not-positive-2']
        ];
    }

    protected function getConstraint()
    {
        return new MultipleOfConstraint();
    }

    protected function getCaseFileNames()
    {
        return ['multipleOf'];
    }
}
