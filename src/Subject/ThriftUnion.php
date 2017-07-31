<?php


namespace Zorrow\ThriftParser\Subject;

class ThriftUnion extends ThriftSubject
{
    function read()
    {
        // TODO: Implement read() method.
        $this->parserFunc->readSpace();
        $subject = $this->parserFunc->readKeyword('union');
        $name = $this->parserFunc->readName();
        $items = $this->parserFunc->readStructLikeBlock();
        return ['subject' => $subject, 'name' => $name, 'items' => $items];
    }
}
