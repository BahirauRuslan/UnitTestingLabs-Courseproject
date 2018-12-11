<?php

require_once __DIR__ . '\..\..\model\logic\URIResolver.php';

class URIResolverTest extends \Codeception\Test\Unit
{
    public function testClearURIWithValuesClearURI()
    {
        $uri = "http://localhost:1234/index.php?value1=4&lala=2&value3=abc";
        $expected = "http://localhost:1234/index.php";
        $actual = URIResolver::getURIResolver()->clearURI($uri);
        $this->assertEquals($expected, $actual);
    }

    public function testClearURIWithoutValuesSameURI()
    {
        $uri = "http://localhost:1234/index.php";
        $expected = "http://localhost:1234/index.php";
        $actual = URIResolver::getURIResolver()->clearURI($uri);
        $this->assertEquals($expected, $actual);
    }

    public function testGetValueNoValueExpectFalse()
    {
        $name = "name";
        $actual = URIResolver::getURIResolver()->getValue($name);
        $this->assertFalse($actual);
    }

    public function testGetValueHasValueExpectValue()
    {
        $name = "name";
        $value = "value";
        $_GET[$name] = $value;
        $expected = $value;
        $actual = URIResolver::getURIResolver()->getValue($name);
        $this->assertEquals($expected, $actual);
    }

    public function testGetPOSTValueNoValueExpectFalse()
    {
        $name = "name";
        $actual = URIResolver::getURIResolver()->getPOSTValue($name);
        $this->assertFalse($actual);
    }

    public function testGetPOSTValueHasValueExpectValue()
    {
        $name = "name";
        $value = "value";
        $_POST[$name] = $value;
        $expected = $value;
        $actual = URIResolver::getURIResolver()->getPOSTValue($name);
        $this->assertEquals($expected, $actual);
    }

    public function testSetToURINoValuesExpectAddToURI()
    {
        $name = "name";
        $value = "value";
        $uri = "http://localhost:1234/index.php";
        $expected = "http://localhost:1234/index.php?$name=$value";
        $actual = URIResolver::getURIResolver()->setToURI($uri, $name, $value);
        $this->assertEquals($expected, $actual);
    }

    public function testSetToURIHasOnlyOneValueExpectAddToURI()
    {
        $name = "name";
        $value = "value";
        $uri = "http://localhost:1234/index.php?val1=1";
        $expected = "http://localhost:1234/index.php?val1=1&$name=$value";
        $actual = URIResolver::getURIResolver()->setToURI($uri, $name, $value);
        $this->assertEquals($expected, $actual);
    }

    public function testSetToURIHasNameValueExpectSetToURI()
    {
        $name = "name";
        $value = "value";
        $uri = "http://localhost:1234/index.php?val1=1&$name=666&val2=2";
        $expected = "http://localhost:1234/index.php?val1=1&$name=$value&val2=2";
        $actual = URIResolver::getURIResolver()->setToURI($uri, $name, $value);
        $this->assertEquals($expected, $actual);
    }

    public function testSetToURINoNameExpectInsertToURI()
    {
        $name = "name";
        $value = "value";
        $uri = "http://localhost:1234/index.php?val1=1&val2=2";
        $expected = "http://localhost:1234/index.php?val1=1&val2=2&$name=$value";
        $actual = URIResolver::getURIResolver()->setToURI($uri, $name, $value);
        $this->assertEquals($expected, $actual);
    }
}
