## thrift-parser-php

To parse thrift file to struct,support const、enum、exception、include、namespace、service、struct、typedef and union

### Example

ParserCal,ParserFunc are baisc functions.

initSubject function (Class ThriftParser) is to set the sets which will be dealed.

```php

        $path = "./namespace.thrift";
        $parserCal = new ParserCal($path);
        $parserFunc = new ParserFunc($parserCal);

        $parser = new ThriftParser($parserFunc);
        $thriftNamespace = new ThriftNamespace($parserFunc);
        $parser->initSubject($thriftNamespace);

        $file = $parser->readThrift();

```

### Return

```php
    [
        'namespace' => [
            'php' => [
                'serviceName'=>'SMS'
            ]
        ]
    ]

```


### Reference

https://github.com/eleme/thrift-parser
