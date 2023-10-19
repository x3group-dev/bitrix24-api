<?php

namespace Bitrix24Api;

use ReflectionClass;
use ReflectionException;

use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    protected Response $response;
    protected ReflectionClass $reflectionClass;

    public function setUp(): void
    {
        $this->reflectionClass = new ReflectionClass(Response::class);
    }

    /**
     * Тестирование механизма преобразования http ответа.
     *
     * @param array $response
     * @param array $actualResult
     * @return void
     * @throws ReflectionException
     * @dataProvider prepareDataProvider
     * @author Daniil S. GlobalArts
     */
    public function testPrepareHttpResponse(array $response, array $actualResult): void
    {
        $method = $this->reflectionClass->getMethod('prepareHttpResponse');

        if (PHP_VERSION_ID > 80100) {
            $method->setAccessible(true);
        }

        $mock = $this->getMockBuilder(Response::class)
            ->disableOriginalConstructor();

        $methodResult = $method->invoke($mock->getMock(), $response);

        $this->assertEquals($methodResult, $actualResult);
    }

    /**
     * Набор тестовых даенных, для преобразования.
     * Первым параметром передаются данные, для преобразования,
     * Вторым параметром передается актуальные данные, для преобразования
     *
     * @return array
     * @author Daniil S. GlobalArts
     */
    public static function prepareDataProvider(): array
    {
        return [
            [
                'response' => [
                    'time' => ['data' => 'time']
                ],
                'actualResult' => [
                    'result' => [],
                    'time' => ['data' => 'time'],
                    'next' => null,
                    'total' => null,
                ]
            ],
            [
                'response' => [
                    'result' => ['age', 'food'],
                    'time' => [],
                    'next' => null,
                    'total' => null,
                ],
                'actualResult' => [
                    'result' => ["age", "food"],
                    'time' => [],
                    'next' => null,
                    'total' => null,
                ]
            ],
            [
                'response' => [
                    'result' => ['age', 'food'],
                    'time' => [],
                    'next' => new \stdClass(),
                    'total' => [1,2,3],
                ],
                'actualResult' => [
                    'result' => ["age", "food"],
                    'time' => [],
                    'next' => null,
                    'total' => null,
                ]
            ],
            [
                'response' => [
                    'result' => ['age', 'food'],
                    'time' => [],
                    'next' => 23.5,
                    'total' => "Hello world",
                ],
                'actualResult' => [
                    'result' => ["age", "food"],
                    'time' => [],
                    'next' => 23,
                    'total' => null,
                ]
            ],
            [
                'response' => [
                    'result' => '',
                    'time' => [],
                    'next' => 7566,
                    'total' => "23",
                ],
                'actualResult' => [
                    'result' => [''],
                    'time' => [],
                    'next' => 7566,
                    'total' => 23,
                ]
            ],
            [
                'response' => [
                    'result' => 'opa',
                ],
                'actualResult' => [
                    'result' => ['opa'],
                    'time' => [],
                    'next' => null,
                    'total' => null,
                ]
            ],
        ];
    }
}
