<?php

include_once '../api/correioswebservice.php';

class CorreiosTest extends PHPUnit_Framework_TestCase {

  public static function correiosdata() {
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
  public function testConnection($cod_empresa, $senha, $cep_origem, $cep_destino, $altura, $largura, $diametro, $comprimento, $peso, $servico, $valor_declarado, $retorno) {
    $a = calculo_frete_correios_api($cod_empresa, $senha, $cep_origem, $cep_destino, $altura, $largura, $diametro, $comprimento, $peso, $servico, $valor_declarado, $retorno);
    print_r($a);
  }

  public function testParseResult() {
    
  }

  public function testReturnError() {
    
  }

}
