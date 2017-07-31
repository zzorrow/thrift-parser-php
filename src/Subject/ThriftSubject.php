<?php


namespace Zorrow\ThriftParser\Subject;

use Zorrow\ThriftParser\ParserFunc;

abstract class ThriftSubject
{
    public $parserFunc;

    public function __construct(ParserFunc $parserFunc)
    {
        $this->parserFunc = $parserFunc;
    }

    abstract function read();
}
