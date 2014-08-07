<?php

namespace Pinq\Tests\Integration\ExpressionTrees;

use Pinq\Expressions as O;

class MiscIntepreterTest extends InterpreterTest
{
    /**
     * @dataProvider interpreters
     */
    public function testParameterExpressions()
    {
        $this->assertParametersAre(
                function ($i) { },
                [O\Expression::parameter('i')]);

        $this->assertParametersAre(
                function ($i, $foo) { },
                [O\Expression::parameter('i'), O\Expression::parameter('foo')]);

        $this->assertParametersAre(
                function ($i = null) { },
                [O\Expression::parameter('i', null, O\Expression::value(null))]);

        $this->assertParametersAre(
                function ($i = 'bar') { },
                [O\Expression::parameter('i', null, O\Expression::value('bar'))]);

        $this->assertParametersAre(
                function (\DateTime $i) { },
                [O\Expression::parameter('i', 'DateTime')]);

        $this->assertParametersAre(
                function (&$i) { },
                [O\Expression::parameter('i', null, null, true)]);

        $this->assertParametersAre(
                function (\stdClass &$i = null, array $array = ['foo']) { },
                [O\Expression::parameter('i', 'stdClass', O\Expression::value(null), true), O\Expression::parameter('array', 'array', O\Expression::value(['foo']))]);

        $this->assertParametersAre(
                function (callable &$v = null) { },
                [O\Expression::parameter('v', 'callable', O\Expression::value(null), true)]);
                
        $this->assertParametersAre(
                function ($v = [1,2,3, 'test' => 'foo', [2 => 'boo', '']]) { },
                [O\Expression::parameter('v', null, O\Expression::value([1,2,3, 'test' => 'foo', [2 => 'boo', '']]))]);
    }
    
    /**
     * @dataProvider interpreters
     */
    public function testParsedFunctionWithConstantsInParameters()
    {
        $this->assertRecompilesCorrectly(function ($i = SORT_ASC) { return $i; });
        $this->assertRecompilesCorrectly(function ($i = \ArrayObject::STD_PROP_LIST) { return $i; });
        $this->assertRecompilesCorrectly(function ($i = [SORT_ASC, SORT_DESC]) { return $i; });
    }

    /**
     * @dataProvider interpreters
     * @expectedException Pinq\Parsing\InvalidFunctionException
     */
    public function testInternalFunction()
    {
        $valueSet = [
            [''],
            ['1'],
            ['test'],
            ['fooo'],
            ['geges ges  gse e'],
            ['striiiiiiiiiiing']
        ];

        $this->assertRecompilesCorrectly('strlen', $valueSet);
        $this->assertRecompilesCorrectly('str_split', $valueSet);
    }

    /**
     * @dataProvider interpreters
     * @expectedException Pinq\Parsing\InvalidFunctionException
     */
    public function testVariadicInternalFunction()
    {
        $valueSet = [
            [[1], [2], [3]], 
            [[1, 3], [2, 5], [6, 3]],
            [['test' => 5], ['foo' => 'bar'], ['baz' => 'boron']],
        ];

        $this->assertRecompilesCorrectly('array_merge', $valueSet);
    }
}
