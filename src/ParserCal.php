<?php


namespace Zorrow\ThriftParser;

class ParserCal
{
    private $source = '';
    private $length = 0;
    private $offset = 0;

    public function __construct($path)
    {
        $handle = fopen($path, "r");
        $this->source = fread($handle, filesize($path));
        $this->length = strlen($this->source);
        fclose($handle);
    }


    public function offsetForward($offset = 0)
    {
        if (is_numeric($offset) && ($offset > 0)) {
            $this->offset += $offset;
        } else {
            $this->offset++;
        }
    }

    public function getOffsetChar($offset = 0)
    {
        $pos = 0;
        if (is_numeric($offset)) {
            $pos = $this->offset + $offset;
        }

        $res = isset($this->source[$pos])?$this->source[$pos]:"";
        return $res;
    }

    public function getOffsetStr($strlen)
    {
        return substr($this->source, $this->offset, $strlen);
    }

    public function isNotEOF($offset = 0)
    {
        return ($this->offset + $offset < $this->length) ? true : false;
    }

    public function getCurrOffset()
    {
        return $this->offset;
    }

    public function setCurrOffset($offset)
    {
        $this->offset = $offset;
    }

    public function getLength()
    {
        return $this->length;
    }
}
