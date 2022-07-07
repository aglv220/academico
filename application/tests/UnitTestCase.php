<?php

class UnitTestCase extends CIPHPUnitTestUnitTestCase
{
    private $op;

    public function setUp():void{
        $this->op = new UsuarioControlador();
    }

    public function TestSumWithTwoValues(){
        $this->assertEquals(7,$this->op->sum(2,4));
    }

}
