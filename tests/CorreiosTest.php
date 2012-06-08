<?php

include_once 'api/correioswebservice.php';

class CorreiosTest extends PHPUnit_Framework_TestCase
{

    public static function correiosdata()
    {
        return array(
        //  array($cod_empresa, $senha, $cep_origem, $cep_destino, $altura, $largura, $diametro, $comprimento, $peso, $servico, $valor_declarado, $retorno)
            array(NULL, NULL, '71939360', '72151613', '5', '15', '0', '20', '2', '41106', '200', 'object'),
            array(NULL, NULL, '71939360', '72151613', '5', '15', '0', '20', '1', '40010', '200', 'object'),
            array(NULL, NULL, '71939360', '72151613', '5', '15', '0', '20', '1', '40215', '200', 'object'),
        );
    }
 
    /**
     * @dataProvider correiosdata
     */
    public function testConnection($cod_empresa,$senha,$cep_origem,$cep_destino,$altura,$largura,$diametro,$comprimento,$peso,$servico,$valor_declarado,$retorno)
    {
        $a=frete_correios($cod_empresa, 
                        $senha, 
                        $cep_origem, 
                        $cep_destino, 
                        $altura,
                        $largura,
                        $diametro,
                        $comprimento,
                        $peso,
                        $servico,
                        $valor_declarado, 
                        $retorno);
        print_r($a);
    }

    public function testParseResult()
    {


    }

    public function testReturnError()
    {


    }

    public function testPushAndPop()
    {
        $stack = array();
        $this->assertEquals(0, count($stack));

        array_push($stack, 'foo');
        $this->assertEquals('foo', $stack[count($stack)-1]);
        $this->assertEquals(1, count($stack));

        $this->assertEquals('foo', array_pop($stack));
        $this->assertEquals(0, count($stack));
    }
}
