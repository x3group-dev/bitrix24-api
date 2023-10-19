<?php

namespace Bitrix24Api;

use ReflectionClass;
use ReflectionException;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockBuilder;

class ResponseTest extends TestCase
{
    protected MockBuilder $response;
    protected ReflectionClass $reflectionClass;

    public function setUp(): void
    {
        $this->reflectionClass = new ReflectionClass(Response::class);
        $this->response = $this->getMockBuilder(Response::class)
            ->disableOriginalConstructor();
    }

    /**
     * Тестирование механизма преобразования http ответа.
     *
     * @param array $response
     * @param array $actualResult
     * @return void
     * @throws ReflectionException
     * @dataProvider prepareDataProvider
     * @author Daniil S.
     */
    public function testPrepareHttpResponse(array $response, array $actualResult): void
    {
        $method = $this->reflectionClass->getMethod('prepareHttpResponse');

        if (PHP_VERSION_ID > 80100) {
            $method->setAccessible(true);
        }

        $methodResult = $method->invoke($this->getMock(), $response);

        $this->assertEquals($methodResult, $actualResult);
    }

    /**
     * @return Response
     * @author Daniil S.
     */
    protected function getMock(): Response
    {
        return $this->response->getMock();
    }

    /**
     * Набор тестовых даенных, для преобразования.
     * Первым параметром передаются данные, для преобразования,
     * Вторым параметром передается актуальные данные, для преобразования
     *
     * @return array
     * @author Daniil S.
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
                    'result' => null,
                    'time' => [],
                    'next' => new \stdClass(),
                    'total' => [1,2,3],
                ],
                'actualResult' => [
                    'result' => [],
                    'time' => [],
                    'next' => null,
                    'total' => null,
                ]
            ],
            [
                'response' => [
                    'time' => [],
                    'next' => 23.5,
                    'total' => "Hello world",
                ],
                'actualResult' => [
                    'result' => [],
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
            [
                'response' => [
                    'result' => new \stdClass(),
                ],
                'actualResult' => [
                    'result' => [new \stdClass()],
                    'time' => [],
                    'next' => null,
                    'total' => null,
                ]
            ],
            [
                'response' => [
                    'result' => 123,
                ],
                'actualResult' => [
                    'result' => [123],
                    'time' => [],
                    'next' => null,
                    'total' => null,
                ]
            ],
            [
                'response' => [
                    'result' => [[]],
                ],
                'actualResult' => [
                    'result' => [[]],
                    'time' => [],
                    'next' => null,
                    'total' => null,
                ]
            ],
            [
                'response' => [],
                'actualResult' => [
                    'result' => [],
                    'time' => [],
                    'next' => null,
                    'total' => null,
                ]
            ],
        ];
    }
}
