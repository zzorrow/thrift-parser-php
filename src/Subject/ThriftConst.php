<?php


namespace Zorrow\ThriftParser\Subject;

class ThriftConst extends ThriftSubject
{

    public function read()
    {
        $this->parserFunc->readSpace();
        $subject = $this->parserFunc->readKeyword('const');
        $type = $this->parserFunc->readType();
        $name = $this->parserFunc->readName();
        $value = $this->parserFunc->readAssign();

        $this->parserFunc->readComma();
        return ['subject' => $subject, 'type' => $type, 'name' => $name, 'value' => $value];
    }
}
