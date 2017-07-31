<?php


namespace Zorrow\ThriftParser\Subject;

class ThriftStruct extends ThriftSubject
{
    function read()
    {
        // TODO: Implement read() method.
        $this->parserFunc->readSpace();
        $subject = $this->parserFunc->readKeyword('struct');
        $name = $this->parserFunc->readName();
        $items = $this->parserFunc->readStructLikeBlock();
        return ['subject' => $subject, 'name' => $name, 'items' => $items];
    }
}
