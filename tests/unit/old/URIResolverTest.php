<?php

require_once __DIR__ . '\..\..\model\logic\URIResolver.php';

class URIResolverTest extends \Codeception\Test\Unit
{
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testUnsetFromURIFirstValueWithValues()
    {
        $uri = "http://localhost:1234/index.php?value1=2&value2=2&value3=3";
        $expected = "http://localhost:1234/index.php?value2=2&value3=3";
        $this->assertEquals($expected,
            URIResolver::getURIResolver()->unsetFromURI($uri, 'value1'));
    }

    public function testUnsetFromURIOneValue()
    {
        $uri = "http://localhost:1234/index.php?value1=2";
        $expected = "http://localhost:1234/index.php";
        $this->assertEquals($expected,
            URIResolver::getURIResolver()->unsetFromURI($uri, 'value1'));
    }

    public function testUnsetFromURIValueWithValues()
    {
        $uri = "http://localhost:1234/index.php?value1=2&value2=2&value3=3";
        $expected = "http://localhost:1234/index.php?value1=2&value3=3";
        $this->assertEquals($expected,
            URIResolver::getURIResolver()->unsetFromURI($uri, 'value2'));
    }

    public function testClearURIWithValuesClearURI()
    {
        $uri = "http://localhost:1234/index.php?value1=4&lala=2&value3=abc";
        $expected = "http://localhost:1234/index.php";
        $this->assertEquals($expected,
            URIResolver::getURIResolver()->clearURI($uri));
    }

    public function testClearURIWithoutValuesSameURI()
    {
        $uri = "http://localhost:1234/index.php";
        $expected = "http://localhost:1234/index.php";
        $this->assertEquals($expected,
            URIResolver::getURIResolver()->clearURI($uri));
    }
}