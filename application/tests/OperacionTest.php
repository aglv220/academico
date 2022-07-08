<?php

use PHPUnit\Framework\TestCase;

final class OperacionTest extends TestCase
{
    private $op;

    public function setUp():void{
        $this->op = new UsuarioModelo();
    }

    public function TestSumWithTwoValues(){
        $correo = "u17200379@utp.edu.pe";
        $this->assertEquals(1,$this->op->inicio_sesion($correo));
    }

}