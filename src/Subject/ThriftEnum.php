<?php


namespace Zorrow\ThriftParser\Subject;

class ThriftEnum extends ThriftSubject
{
    function read()
    {
        // TODO: Implement read() method.
        $this->parserFunc->readSpace();
        $subject = $this->parserFunc->readKeyword('enum');
        $name = $this->parserFunc->readName();
        $items = $this->parserFunc->readEnumBlock();

        return ['subject' => $subject, 'name' => $name, 'items' => $items];
    }

    public function readEnumBlock()
    {
        $this->parserFunc->readChar('{');
        $receiver = $this->parserFunc->readUntilThrow(function () {
            return $this->readEnumItem();
        });
        $this->parserFunc->readChar('}');
        return $receiver;
    }

    public function readEnumItem()
    {
        $name = $this->parserFunc->readName();
        $value = $this->parserFunc->readAssign();
        $this->parserFunc->readComma();
        return ['name' => $name, 'value' => $value];
    }
}
