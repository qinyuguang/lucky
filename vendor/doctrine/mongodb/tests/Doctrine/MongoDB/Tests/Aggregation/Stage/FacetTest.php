<?php

namespace Doctrine\MongoDB\Tests\Aggregation\Stage;

use Doctrine\MongoDB\Aggregation\Stage\Facet;
use Doctrine\MongoDB\Tests\Aggregation\AggregationTestCase;
use Doctrine\MongoDB\Tests\TestCase;

class FacetTest extends TestCase
{
    use AggregationTestCase;

    public function testFacetStage()
    {
        $nestedBuilder = $this->getTestAggregationBuilder();
        $nestedBuilder->sortByCount('$tags');

        $facetStage = new Facet($this->getTestAggregationBuilder());
        $facetStage
            ->field('someField')
            ->pipeline($nestedBuilder)
            ->field('otherField')
            ->pipeline($this->getTestAggregationBuilder()->sortByCount('$comments'));

        $this->assertSame([
            '$facet' => [
                'someField' => [['$sortByCount' => '$tags']],
                'otherField' => [['$sortByCount' => '$comments']],
            ]
        ], $facetStage->getExpression());
    }

    public function testFacetFromBuilder()
    {
        $nestedBuilder = $this->getTestAggregationBuilder();
        $nestedBuilder->sortByCount('$tags');

        $builder = $this->getTestAggregationBuilder();
        $builder->facet()
            ->field('someField')
            ->pipeline($nestedBuilder)
            ->field('otherField')
            ->pipeline($this->getTestAggregationBuilder()->sortByCount('$comments'));

        $this->assertSame([[
            '$facet' => [
                'someField' => [['$sortByCount' => '$tags']],
                'otherField' => [['$sortByCount' => '$comments']],
            ]
        ]], $builder->getPipeline());
    }

    public function testFacetThrowsExceptionWithoutFieldName()
    {
        $facetStage = new Facet($this->getTestAggregationBuilder());

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('requires you set a current field using field().');
        $facetStage->pipeline($this->getTestAggregationBuilder());
    }

    public function testFacetThrowsExceptionOnInvalidPipeline()
    {
        $facetStage = new Facet($this->getTestAggregationBuilder());

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('expects either an aggregation builder or an aggregation stage.');
        $facetStage
            ->field('someField')
            ->pipeline(new \stdClass());
    }
}
