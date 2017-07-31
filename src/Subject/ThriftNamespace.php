<?php


namespace Zorrow\ThriftParser\Subject;

class ThriftNamespace extends ThriftSubject
{

    public function read()
    {
        $this->parserFunc->readSpace();
        $subject = $this->parserFunc->readKeyword('namespace');
        $name = $this->parserFunc->readScope();
        $ref = $this->parserFunc->readRefValue();
        $serviceName = implode('.', $ref['=']);

        return ['subject' => $subject, 'name' => $name, 'serviceName' => $serviceName];
    }
}
