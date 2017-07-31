<?php

namespace Zorrow\ThriftParser;

use RuntimeException;

class Repository
{
    /**
     *  The array data of thrift description parsed by thrift parser
     *
     * @var array
     */
    protected $thriftDescription;

    const LANGUAGE = 'php';

    public function __construct(array $thriftDescription)
    {
        $this->dl = $thriftDescription;
    }

    public function getNameSpace()
    {
        if (isset($this->dl['namespace'][self::LANGUAGE]['serviceName'])) {
            return $this->dl['namespace'][self::LANGUAGE]['serviceName'];
        }

        throw new RuntimeException("namespace not defined in thrift file");
    }

    public function getSupportMethods($service)
    {
        if (isset($this->dl['service'][$service]['functions'])) {
            return array_keys($this->dl['service'][$service]['functions']);
        }

        return [];
    }

    public function getMethodArgs($service, $method)
    {
        if (isset($this->dl['service'][$service]['functions'][$method]['args'])) {
            return $this->dl['service'][$service]['functions'][$method]['args'];
        }

        return [];
    }

    public function getMethodReturnType($method, $service)
    {
        if (isset($this->dl['service'][$service]['functions'][$method]['type'])) {
            return $this->dl['service'][$service]['functions'][$method]['type'];
        }

        return false;
    }

    public function getTypeDef()
    {
        if (isset($this->dl['typedef'])) {
            return $this->dl['typedef'];
        }

        return [];
    }

    public function getService()
    {
        if (isset($this->dl['service'])) {
            $services = array_keys($this->dl['service']);
            # 只支持定义一个service
            return array_shift($services);
        }

        throw new RuntimeException("service not defined in thrift file");
    }
}
