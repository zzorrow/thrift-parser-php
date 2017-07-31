<?php

require dirname(__DIR__) . "/vendor/autoload.php";

use Zorrow\ThriftParser\ThriftParser;
use Zorrow\ThriftParser\ParserCal;
use Zorrow\ThriftParser\ParserFunc;
use Zorrow\ThriftParser\Subject\ThriftConst;
use Zorrow\ThriftParser\Subject\ThriftEnum;
use Zorrow\ThriftParser\Subject\ThriftException;
use Zorrow\ThriftParser\Subject\ThriftInclude;
use Zorrow\ThriftParser\Subject\ThriftNamespace;
use Zorrow\ThriftParser\Subject\ThriftService;
use Zorrow\ThriftParser\Subject\ThriftStruct;
use Zorrow\ThriftParser\Subject\ThriftSubject;
use Zorrow\ThriftParser\Subject\ThriftTypedef;
use Zorrow\ThriftParser\Subject\ThriftUnion;

use PHPUnit\Framework\TestCase;

class TestThrift extends TestCase
{


    public function testThriftParser()
    {

        $path = "./sms.thrift";
        $parserCal = new ParserCal($path);
        $parserFunc = new ParserFunc($parserCal);

        $thriftConst = new ThriftConst($parserFunc);
        $thriftEnum = new ThriftEnum($parserFunc);
        $thriftExcep = new ThriftException($parserFunc);
        $thriftInclude = new ThriftInclude($parserFunc);
        $thriftNamespace = new ThriftNamespace($parserFunc);
        $thriftService = new ThriftService($parserFunc);
        $thriftStruct = new ThriftStruct($parserFunc);
        $thriftTypedef = new ThriftTypedef($parserFunc);
        $thriftUnion = new ThriftUnion($parserFunc);


        $parser = new ThriftParser($parserFunc);
        $parser->initSubject($thriftConst);
        $parser->initSubject($thriftEnum);
        $parser->initSubject($thriftExcep);
        $parser->initSubject($thriftInclude);
        $parser->initSubject($thriftNamespace);
        $parser->initSubject($thriftService);
        $parser->initSubject($thriftStruct);
        $parser->initSubject($thriftTypedef);
        $parser->initSubject($thriftUnion);

        $file = $parser->readThrift();
        print_r($file);


    }


    public function testNamespace()
    {
        $path = "./namespace.thrift";
        $parserCal = new ParserCal($path);
        $parserFunc = new ParserFunc($parserCal);

        $parser = new ThriftParser($parserFunc);
        $thriftNamespace = new ThriftNamespace($parserFunc);
        $parser->initSubject($thriftNamespace);

        $file = $parser->readThrift();

        $except = require "./exception/namespace.php";
        $this->assertEquals($except, $file);
    }

    public function testConst()
    {
        $path = "./const.thrift";
        $parserCal = new ParserCal($path);
        $parserFunc = new ParserFunc($parserCal);

        $parser = new ThriftParser($parserFunc);
        $thriftConst = new ThriftConst($parserFunc);
        $parser->initSubject($thriftConst);

        $file = $parser->readThrift();

        $except = require "./exception/const.php";
        $this->assertEquals($except, $file);
    }

    public function testEnum()
    {
        $path = "./enum.thrift";
        $parserCal = new ParserCal($path);
        $parserFunc = new ParserFunc($parserCal);

        $parser = new ThriftParser($parserFunc);
        $thriftEnum = new ThriftEnum($parserFunc);
        $parser->initSubject($thriftEnum);

        $file = $parser->readThrift();

        $except = require "./exception/enum.php";
        $this->assertEquals($except, $file);
    }

    public function testException()
    {
        $path = "./exception.thrift";
        $parserCal = new ParserCal($path);
        $parserFunc = new ParserFunc($parserCal);

        $parser = new ThriftParser($parserFunc);
        $thriftExcep = new ThriftException($parserFunc);
        $parser->initSubject($thriftExcep);

        $file = $parser->readThrift();

        $except = require "./exception/exception.php";
        $this->assertEquals($except, $file);
    }

    public function testStruct()
    {
        $path = "./struct.thrift";
        $parserCal = new ParserCal($path);
        $parserFunc = new ParserFunc($parserCal);

        $parser = new ThriftParser($parserFunc);
        $thriftStruct = new ThriftStruct($parserFunc);
        $parser->initSubject($thriftStruct);

        $file = $parser->readThrift();

        $except = require "./exception/struct.php";
        $this->assertEquals($except,$file);
    }


    public function testTypedef()
    {
        $path = "./typedef.thrift";
        $parserCal = new ParserCal($path);
        $parserFunc = new ParserFunc($parserCal);

        $parser = new ThriftParser($parserFunc);
        $thriftTypedef = new ThriftTypedef($parserFunc);
        $parser->initSubject($thriftTypedef);

        $file = $parser->readThrift();

        $except = require './exception/typedef.php';
        $this->assertEquals($except, $file);
    }

    public function testService()
    {
        $path = "./service.thrift";
        $parserCal = new ParserCal($path);
        $parserFunc = new ParserFunc($parserCal);

        $parser = new ThriftParser($parserFunc);
        $thriftService = new ThriftService($parserFunc);
        $parser->initSubject($thriftService);

        $file = $parser->readThrift();

        $except = require "./exception/service.php";
        $this->assertEquals($except,$file);
    }

}
