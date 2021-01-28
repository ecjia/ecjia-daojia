<?php

use Royalcms\Component\Enum\Demo\RequestCode;
use Royalcms\Component\Enum\Enum;
use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    public function testInstantiable()
    {
        $emptyEnum = new RequestCode;
        $this->assertInstanceOf(Enum::class, $emptyEnum);

        $this->assertNull($emptyEnum->getName());
        $this->assertNull($emptyEnum->getValue());

        $this->assertTrue(method_exists($emptyEnum, 'getName'));
        $this->assertTrue(method_exists($emptyEnum, 'getValue'));

        $this->assertTrue(method_exists($emptyEnum, '_getMap'));
        $this->assertTrue(method_exists($emptyEnum, '_getNameMap'));
        $this->assertTrue(method_exists($emptyEnum, '_getDict'));
        $this->assertTrue(method_exists($emptyEnum, '_getNameDict'));

        $this->assertTrue(method_exists($emptyEnum, '_hasName'));
        $this->assertTrue(method_exists($emptyEnum, '_hasValue'));
        $this->assertTrue(method_exists($emptyEnum, '_getNameDict'));
        $this->assertTrue(method_exists($emptyEnum, '_getNameDict'));

        $this->assertTrue(method_exists($emptyEnum, '_getNameDict'));
        $this->assertTrue(method_exists($emptyEnum, '_getNameDict'));

        $this->assertTrue(method_exists($emptyEnum, '__toString'));

        // 实例化带值的enum
        $enum = new RequestCode(RequestCode::SUCCESS);

        $this->assertObjectHasAttribute('name', $enum);
        $this->assertObjectHasAttribute('value', $enum);

        $this->assertInternalType('string', $enum->getName());
        $this->assertInternalType('int', $enum->getValue());

        $this->assertInternalType('string', $enum->__toString());
    }

    public function testStaticable()
    {
        /**
         * 测试基本静态使用以及 name value转换
         */
        $this->assertInternalType('int', RequestCode::SUCCESS);
        $this->assertInternalType('int', RequestCode::ERROR);

        $this->assertInternalType('array', RequestCode::getMap());
        $this->assertInternalType('array', RequestCode::getNameMap());
        $this->assertInternalType('array', RequestCode::getDict());
        $this->assertInternalType('array', RequestCode::getNameDict());

        $name_success = RequestCode::valueToName(RequestCode::SUCCESS);
        $name_error = RequestCode::valueToName(RequestCode::ERROR);

        $this->assertInternalType('string', $name_success);
        $this->assertInternalType('string', $name_error);

        $this->assertTrue(RequestCode::hasName($name_success));
        $this->assertTrue(RequestCode::hasName($name_error));

        $this->assertTrue(RequestCode::SUCCESS === RequestCode::nameToValue($name_success));
        $this->assertTrue(RequestCode::ERROR === RequestCode::nameToValue($name_error));

        /**
         * 测试判断方法返回值
         */
        $this->assertTrue(RequestCode::hasValue(RequestCode::SUCCESS));
        $this->assertTrue(RequestCode::hasValue(RequestCode::ERROR));

        $this->assertTrue(RequestCode::hasValue(strval(RequestCode::SUCCESS), false));
        $this->assertTrue(RequestCode::hasValue(strval(RequestCode::ERROR), false));

        $this->assertFalse(RequestCode::hasValue(strval(RequestCode::SUCCESS)));
        $this->assertFalse(RequestCode::hasValue(strval(RequestCode::ERROR)));
        $this->assertFalse(RequestCode::hasValue(9999999));

        $this->assertFalse(RequestCode::hasName('some impossible name.'));

        /**
         * 测试get方法返回值
         */
        $this->assertArrayHasKey(RequestCode::SUCCESS, RequestCode::getNameMap());
        $this->assertArrayHasKey(RequestCode::ERROR, RequestCode::getNameMap());
        $this->assertArrayHasKey(RequestCode::SUCCESS, RequestCode::getDict());
        $this->assertArrayHasKey(RequestCode::ERROR, RequestCode::getDict());


        $this->assertArrayHasKey($name_success, RequestCode::getMap());
        $this->assertArrayHasKey($name_error, RequestCode::getMap());
        $this->assertArrayHasKey($name_success, RequestCode::getNameDict());
        $this->assertArrayHasKey($name_error, RequestCode::getNameDict());


        /**
         * 测试trans方法返回值
         */
        $this->assertEquals(
            RequestCode::transValue(RequestCode::SUCCESS),
            RequestCode::transName($name_success)
        );

        $this->assertEquals(
            RequestCode::transValue(RequestCode::ERROR),
            RequestCode::transName($name_error)
        );

    }

    /**
     * @afterClass
     */
    public static function done()
    {
        echo PHP_EOL . PHP_EOL . 'Base test already executed.';
    }

}
