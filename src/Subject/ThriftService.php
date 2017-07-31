<?php


namespace Zorrow\ThriftParser\Subject;

use Exception;

class ThriftService extends ThriftSubject
{

    public function read()
    {
        $this->parserFunc->readSpace();
        $subject = $this->parserFunc->readKeyword('service');
        $name = $this->parserFunc->readName();
        $extend = $this->parserFunc->readExtends();
        $functions = $this->readServiceBlock();
        $result = ['subject' => $subject, 'name' => $name];
        if ($extend) {
            $result['extend'] = $extend;
        }
        if ($functions) {
            $result['functions'] = $functions;
        }
        return $result;
    }


    public function readServiceBlock()
    {
        $this->parserFunc->readChar('{');
        $receiver = $this->parserFunc->readUntilThrow(function () {
            return $this->readServiceItem();
        }, 'name');
        return $receiver;
    }

    public function readServiceItem()
    {
        $oneway = !!$this->parserFunc->readAnyOne('readOneway', 'readNoop');
        $type = $this->parserFunc->readType();
        $name = $this->parserFunc->readName();
        $args = $this->readServiceArgs();
        $throws = $this->readServiceThrow();

        $this->parserFunc->readComma();
        return ['type' => $type, 'name' => $name, 'args' => $args, 'throws' => $throws, 'oneway' => $oneway];
    }


    public function readServiceArgs()
    {
        $this->parserFunc->readChar('(');
        $receiver = $this->parserFunc->readUntilThrow(function () {
            return $this->parserFunc->readStructLikeItem();
        });

        $this->parserFunc->readChar(')');
        $this->parserFunc->readSpace();
        return $receiver;

    }

    public function readServiceThrow()
    {

        $beginning = $this->parserFunc->getCurrentOffset();
        try {
            $this->parserFunc->readKeyword('throws');
            return $this->readServiceArgs();
        } catch (Exception $e) {
            $this->parserFunc->setCurrentOffset($beginning);
            return [];
        }
    }
}
