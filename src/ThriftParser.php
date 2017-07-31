<?php


namespace Zorrow\ThriftParser;

use Zorrow\ThriftParser\Subject\ThriftSubject;
use Exception;

class ThriftParser
{

    public $subject = [];
    public $parserFunc;
    public $storage = [];

    public function __construct(ParserFunc $parserFunc)
    {
        $this->parserFunc = $parserFunc;

    }

    public function readThrift()
    {
        while (true) {
            $block = $this->readAnySubject();
            if ($block) {
                $subject = $block['subject'];
                $name = $block['name'];
                unset($block['subject']);
                unset($block['name']);
                switch ($subject) {
                    case 'exception':
                    case 'struct':
                        $this->storage[$subject][$name] = $block['items'];
                        break;
                    default:
                        $this->storage[$subject][$name] = $block;
                }
            }

            if (($this->parserFunc->getCurrentOffset() == $this->parserFunc->getThriftLength()) || !isset($block)) {
                break;
            }

        }
        return $this->storage;

    }


    public function readAnySubject()
    {

        $beginning = $this->parserFunc->getCurrentOffset();
        for ($i = 0; $i < count($this->subject); $i++) {
            try {
                $obj = $this->subject[$i];
                if ($obj instanceof ThriftSubject) {
                    return $obj->read();
                } else {
                    throw new Exception($obj . ' is not an instance of ThriftSubject!');
                }
            } catch (Exception $e) {
                $this->parserFunc->setCurrentOffset($beginning);
                continue;
            }
        }
        $this->parserFunc->setCurrentOffset($beginning);

    }

    public function initSubject($subject)
    {
        array_push($this->subject, $subject);
    }
}
