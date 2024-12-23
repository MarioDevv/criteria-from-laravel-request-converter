<?php

namespace MarioDevv\Criteria\Tests;

use CodelyTv\Criteria\Criteria;
use MarioDevv\Criteria\CriteriaFromUrlConverter;
use PHPUnit\Framework\TestCase;

class CriteriaFromUrlConverterTest extends TestCase
{

    /** @test */
    public function it_should_create_a_criteria_from_an_url()
    {

        $url = 'http://localhost:3000/api/products?' .
            'filters[0][field]=category&filters[0][operator]==&filters[0][value]=Electronics&' .
            'filters[1][field]=price&filters[1][operator]=>&filters[1][value]=100&' .
            'orderBy=price&order=desc&pageSize=20&pageNumber=1';

        $expectedCriteria = Criteria::fromPrimitives(
            [
                ['field' => 'category', 'operator' => '=', 'value' => 'Electronics'],
                ['field' => 'price', 'operator' => '>', 'value' => '100']
            ],
            'price',
            'desc',
            20,
            1
        );

        $criteria = (new CriteriaFromUrlConverter())->toCriteria($url);


        $this->assertEquals($expectedCriteria, $criteria);
    }


    /** @test */
    public function it_should_create_a_criteria_without_filters()
    {

        $url = 'http://localhost:3000/api/products?' .
            'orderBy=price&order=desc&pageSize=20&pageNumber=1';

        $expectedCriteria = Criteria::fromPrimitives(
            [],
            'price',
            'desc',
            20,
            1
        );

        $criteria = (new CriteriaFromUrlConverter())->toCriteria($url);

        $this->assertEquals($expectedCriteria, $criteria);

    }

}
