<?php

    public $publicProperty;
    protected $protectedProperty;
    private $privateProperty;
    static public $staticProperty;

    public $anotherPublicProperty;

    protected $anotherProtectedProperty;

    private $anotherPrivateProperty;

    static protected $anotherPublicProperty;

    public function publicMethod()
    {
    }

    protected function protectedMethod()
    {
    }

    private function privateMethod()
    {
    }

    /**
     * phpDoc
     */
    public function methodWithPhpDoc()
    {
    }

    public function methodWithArguments($name, $value)
    {
    }

    public function methodWithCode()
    {
        return null;
    }

    static public function staticMethod()
    {
    }

    public function methodWithObjectProperties(\ArrayObject $array, \Mandango\Query $query)
    {
        return $array;
    }
