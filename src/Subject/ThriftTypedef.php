<?php


namespace Zorrow\ThriftParser\Subject;

class ThriftTypedef extends ThriftSubject
{
    function read()
    {
        // TODO: Implement read() method.
        $this->parserFunc->readSpace();
        $subect = $this->parserFunc->readKeyword('typedef');
        $type = $this->parserFunc->readType();
        $name = $this->parserFunc->readName();
        $this->parserFunc->readComma();

        return ['subject' => $subect, 'type' => $type, 'name' => $name];
    }
}
