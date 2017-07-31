<?php


namespace Zorrow\ThriftParser;

use Exception;
use Closure;


class ParserFunc
{
    public $manager;
    public $ignore = ["\n", "\r", " ", "\t"];

    public function __construct(ParserCal $manager)
    {
        $this->manager = $manager;
    }

    public function readKeyword($word)
    {
        $len = strlen($word);
        for ($i = 0; $i < $len; $i++) {
            if ($this->manager->getOffsetChar($i) != $word[$i]) {
                throw new Exception("Unexcepted token " . $word);
            }
        }
        $this->manager->offsetForward($len);
        $this->readSpace();
        return $word;
    }

    public function readSpace()
    {

        while (true) {
            $byte = $this->manager->getOffsetChar();
            if (in_array($byte, $this->ignore)) {
                $this->manager->offsetForward();
            } else {
                try {
                    if (!$this->readCommentMultiple() && !$this->readCommentSharp() && !$this->readCommentDoubleSlash()) {
                        return;
                    }
                } catch (Exception $e) {
                    return;
                }

            }
        }

    }

    public function readCommentMultiple()
    {
        if ($this->manager->getOffsetChar() !== '/' ||
            $this->manager->getOffsetChar(1) !== '*'
        ) {
            return false;
        }
        $i = 2;
        do {
            while ($this->manager->isNotEOF($i) && $this->manager->getOffsetChar($i++) !== '*') {
            }
        } while ($this->manager->isNotEOF($i) && $this->manager->getOffsetChar($i) !== '/');
        $i++;
        $this->manager->offsetForward($i);
        return true;
    }

    public function readCommentSharp()
    {
        if ($this->manager->getOffsetChar() !== '#') {
            return false;
        }
        while ($this->manager->getOffsetChar(1) !== '\n' && $this->manager->getOffsetChar(1) !== '\r') {
            $this->manager->offsetForward();
        }
        $this->manager->offsetForward(1);
        return true;
    }

    public function readCommentDoubleSlash()
    {
        if ($this->manager->getOffsetChar() !== '/' || $this->manager->getOffsetChar(1) !== '/') {
            return false;
        }
        while ($this->manager->getOffsetChar(2) !== '\n' && $this->manager->getOffsetChar(2) !== '\r') {
            $this->manager->offsetForward();
        }
        $this->manager->offsetForward(2);
        return true;

    }

    public function readValue()
    {
        return $this->readAnyOne(
            'readHexadecimalValue',
            'readEnotationValue',
            'readNumberValue',
            'readStringValue',
            'readBooleanValue',
            'readListValue',
            'readMapValue',
            'readRefValue'
        );
    }

    public function readAnyOne(...$args)
    {
        $beginning = $this->manager->getCurrOffset();
        for ($i = 0; $i < count($args); $i++) {
            try {
                $method = $args[$i];
                if ($method instanceof Closure) {
                    return $method();
                } else {
                    return $this->$method();
                }
            } catch (Exception $e) {
                $this->manager->setCurrOffset($beginning);
                continue;
            }
        }
        $this->manager->setCurrOffset($beginning);
    }

    public function readHexadecimalValue()
    {
        $result = [];
        if ($this->manager->getOffsetChar() === '-') {
            array_push($result, $this->manager->getOffsetChar());
            $this->manager->offsetForward();
        }

        if ($this->manager->getOffsetChar() !== '0') {
            throw  new Exception('Unexpected token');
        }

        array_push($result, $this->manager->getOffsetChar());
        $this->manager->offsetForward();

        if ($this->manager->getOffsetChar() !== 'x' && $this->manager->getOffsetChar() !== 'X') {
            throw new Exception('Unexpected token');
        }
        array_push($result, $this->manager->getOffsetChar());
        $this->manager->offsetForward();

        for (; ;) {
            $byte = $this->manager->getOffsetChar();
            if (($byte >= '0' && $byte <= '9') ||
                ($byte >= 'A' && $byte <= 'F') ||
                ($byte >= 'a' && $byte <= 'f')
            ) {
                $this->manager->offsetForward();
                array_push($result, $byte);
            } else {
                if (count($result) > 0) {
                    $this->readSpace();
                    return implode('', $result);
                } else {
                    throw new Exception('Unexpected token ' . $byte);
                }
            }
        }

    }

    public function readEnotationValue()
    {
        $result = [];
        if ($this->manager->getOffsetChar() === '-') {
            array_push($result, $this->manager->getOffsetChar());
            $this->manager->offsetForward();
        }

        for (; ;) {
            $byte = $this->manager->getOffsetChar();
            if ($byte >= '0' && $byte <= '9' || $byte === ".") {
                array_push($result, $byte);
                $this->manager->offsetForward();
            } else {
                break;
            }
        }

        if ($this->manager->getOffsetChar() !== 'e' && $this->manager->getOffsetChar() !== 'E') {
            throw new Exception('Unexpected toke');
        }
        array_push($result, $this->manager->getOffsetChar());
        $this->manager->offsetForward();

        for (; ;) {
            $byte = $this->manager->getOffsetChar();
            if ($byte >= '0' && $byte <= '9') {
                $this->manager->offsetForward();
                array_push($result, $byte);
            } else {
                if (count($result) > 0) {
                    $this->readSpace();
                    return implode('', $result);
                } else {
                    throw new Exception('Unexpected token' . $byte);
                }
            }
        }

    }

    public function readNumberValue()
    {

        $result = [];
        if ($this->manager->getOffsetChar() === '-') {
            array_push($result, '-');
            $this->manager->offsetForward();
        }

        while (true) {
            $byte = $this->manager->getOffsetChar();
            if ($byte >= '0' && $byte <= '9' || $byte === '.') {
                $this->manager->offsetForward();
                array_push($result, $byte);
            } else {
                if (count($result) > 0) {
                    $this->readSpace();
                    return implode('', $result);
                } else {
                    throw new Exception('Unexception token' . $byte);
                }
            }
        }
    }

    public function readScope()
    {
        $i = 0;
        $byte = $this->manager->getOffsetChar();
        while (($byte >= 'a' && $byte <= 'z') ||
            ($byte === '_') ||
            ($byte >= 'A' && $byte <= 'Z') ||
            ($byte >= '0' && $byte <= '9') ||
            ($byte === '*')) {
            $i++;
            $byte = $this->manager->getOffsetChar($i);
        }
        if ($i == 0) {
            throw new Exception('Unexpected token on readScope');
        }
        $value = $this->manager->getOffsetStr($i);
        $this->manager->offsetForward($i);
        $this->readSpace();
        return $value;
    }

    public function readStringValue()
    {
        $receiver = [];
        $start = '';
        while (true) {
            $byte = $this->manager->getOffsetChar();
            $this->manager->offsetForward();
            if (count($receiver) > 0) {
                if ($byte === $start) {
                    array_push($receiver, $byte);
                    $this->readSpace();
                    return implode('', $receiver);
                } elseif ($byte === '\\') {
                    array_push($receiver, $byte);
                    $this->manager->offsetForward();
                    array_push($receiver, $this->manager->getOffsetChar());
                    $this->manager->offsetForward();
                } else {
                    array_push($receiver, $byte);
                }
            } else {
                if ($byte === '"' || $byte === '\'') {
                    $start = $byte;
                    array_push($receiver, $byte);
                } else {
                    throw new Exception('Unexpected token ILLEGAL');
                }
            }
        }

    }

    public function readBooleanValue()
    {
        return $this->readAnyOne(function () {
            return $this->readKeyword('true');
        }, function () {
            return $this->readKeyword('false');
        });
    }

    public function readListValue()
    {
        $this->readChar('[');
        $list = $this->readUntilThrow(function () {
            $value = $this->readValue();
            $this->readComma();
            return $value;
        });
        $this->readChar(']');
        return $list;
    }

    public function readComma()
    {
        if ($this->manager->getOffsetChar() === ',' || $this->manager->getOffsetChar() === ';') {
            $this->manager->offsetForward();
            $this->readSpace();
            return ',';
        }
    }

    public function readMapValue()
    {
        $this->readChar('{');
        $list = $this->readUntilThrow(function () {
            $key = $this->readValue();
            $this->readChar(':');
            $value = $this->readValue();
            $this->readComma();
            return ['key' => $key, 'value' => $value];
        });
        $this->readChar('}');
        return $list;
    }

    public function readRefValue()
    {
        $list = [$this->readName()];
        $this->readUntilThrow(function () use ($list) {
            $this->readChar('.');
            array_push($list, $this->readName());
        });
        return ['=' => $list];
    }

    public function readName()
    {
        $i = 0;
        $byte = $this->manager->getOffsetChar();
        while (($byte >= 'a' && $byte <= 'z') ||
            $byte === '.' || $byte === '_' ||
            ($byte >= 'A' && $byte <= 'Z') ||
            ($byte >= '0' && $byte <= '9')) {
            $i++;
            $byte = $this->manager->getOffsetChar($i);
        }

        if ($i == 0) {
            throw new Exception('Unexpected token no readName');
        }
        $value = $this->manager->getOffsetStr($i);
        $this->manager->offsetForward($i);
        $this->readSpace();
        return $value;
    }

    public function readEnumBlock()
    {
        $this->readChar('{');
        $receiver = $this->readUntilThrow(function () {
            return $this->readEnumItem();
        });
        $this->readChar('}');
        return $receiver;
    }

    public function readEnumItem()
    {
        $name = $this->readName();
        $value = $this->readAssign();
        $this->readComma();
        return ['name' => $name, 'value' => $value];
    }


    public function readNoop()
    {

    }

    public function readAssign()
    {
        $beginning = $this->manager->getCurrOffset();
        try {
            $this->readChar('=');
            return $this->readValue();
        } catch (Exception $e) {
            $this->manager->setCurrOffset($beginning);
        }
    }

    public function readChar($char)
    {
        if ($this->manager->getOffsetChar() !== $char) {
            throw new Exception('Unexpected char' . $char);
        }
        $this->manager->offsetForward();
        $this->readSpace();
        return $char;
    }


    public function readUntilThrow(\Closure $transaction, $key = '')
    {
        $receiver = [];
        while (true) {
            try {
                $beginning = $this->manager->getCurrOffset();
                $result = $transaction();
                if (empty($key)) {
                    array_push($receiver, $result);
                } else {
                    $receiver[$result[$key]] = $result;
                }
            } catch (Exception $e) {
                $this->manager->setCurrOffset($beginning);
                return $receiver;
            }
        }
    }

    public function readQuotation()
    {
        if ($this->manager->getOffsetChar() === '"' || $this->manager->getOffsetChar() === '\'') {
            $this->manager->offsetForward();
        } else {
            throw new Exception('include error');
        }
        $i = 0;
        while ($this->manager->getOffsetChar($i) != '"' && $this->manager->getOffsetChar($i) !== '\'') {
            $i++;
        }
        if ($this->manager->getOffsetChar($i) === '"' || $this->manager->getOffsetChar($i) === '\'') {
            $value = $this->manager->getOffsetStr($i);
            $i++;
            $this->manager->setCurrOffset($i);
            return $value;
        } else {
            throw new Exception('include error');
        }

    }

    public function readExtends()
    {
        $beginning = $this->manager->getCurrOffset();
        try {
            $this->readKeyword('extends');
            $ref = $this->readRefValue();
            $name = implode('.', $ref['=']);
            return $name;
        } catch (Exception $e) {
            $this->manager->setCurrOffset($beginning);
            return;
        }
    }

    public function readOneway()
    {
        return $this->readKeyword('oneway');
    }

    public function readType()
    {
        return $this->readAnyOne('readTypeMap', 'readTypeList', 'readTypeNormal');
    }

    public function readTypeMap()
    {
        $name = $this->readName();
        $this->readChar('<');
        $keyType = $this->readType();
        $this->readComma();
        $valueType = $this->readType();
        $this->readChar('>');
        return ['name' => $name, 'keyType' => $keyType, 'valueType' => $valueType];
    }

    public function readTypeList()
    {
        $name = $this->readName();
        $this->readChar('<');
        $valueType = $this->readType();
        $this->readChar('>');
        return ['name' => $name, 'valueType' => $valueType];
    }


    public function readTypeNormal()
    {
        return $this->readName();
    }


    public function readStructLikeBlock()
    {
        $this->readChar('{');
        $receiver = $this->readUntilThrow(function () {
            return $this->readStructLikeItem();
        });
        $this->readChar('}');
        return $receiver;

    }

    public function readStructLikeItem()
    {
        $id = $this->readNumberValue();
        $this->readChar(':');

        $option = $this->readAnyOne(function () {
            return $this->readKeyword('required');
        }, function () {
            return $this->readKeyword('optional');
        }, 'readNoop');

        $type = $this->readType();
        $name = $this->readName();
        $defaultValue = $this->readAssign();

        $this->readComma();

        $result = ['id' => $id, 'type' => $type, 'name' => $name];
        if ($option) {
            $result['option'] = $option;
        }
        if ($defaultValue) {
            $result['defaultValue'] = $defaultValue;
        }
        return $result;

    }


    public function getCurrentOffset()
    {
        return $this->manager->getCurrOffset();
    }

    public function setCurrentOffset($offset)
    {
        $this->manager->setCurrOffset($offset);
    }


    public function getThriftLength()
    {
        return $this->manager->getLength();
    }
}
