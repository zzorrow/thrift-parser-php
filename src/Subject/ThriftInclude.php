<?php


namespace Zorrow\ThriftParser\Subject;

class ThriftInclude extends ThriftSubject
{

    public function read()
    {
        $this->parserFunc->readSpace();
        $subject = $this->parserFunc->readKeyword('include');
        $this->parserFunc->readScope();
        $includePath = $this->parserFunc->readQuotation();
        $this->parserFunc->readSpace();
        $name = 'ziliang';
        return ['subject' => $subject, 'name' => $name, 'path' => $includePath];
    }
}
