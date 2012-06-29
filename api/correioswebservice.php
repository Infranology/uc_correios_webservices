<?php

/**
 * Função retorna via SOAP o valor do frete correios para diferentes metodos.
 *
 * @param $servico
 *   Define os diferentes metodos de envio:
 *   - 41106 = pac sem contrato
 *   - 40010 = sedex sem contrato
 *   - 40215 = sedex 10, sem contrato
 *   - 40290 = sedex hoje, sem contrato
 *   - 40096 = sedex com contrato
 *   - 40436 = sedex com contrato
 *   - 40444 = sedex com contrato
 *   - 81019 = e-sedex, com contrato
 *   - 41068 = pac com contrato
 * @param $retorno
 *   Tipo de retorno de dados.
 *   - object
 *   - json
 *   - soap = default
 * 
 * Coded by http://blog.shiguenori.com/2010/08/20/webservice-dos-correios/.
 * Modified by Infranology.
 */

function calculo_frete_correios_api($cod_empresa, $senha, $cep_origem, 
  $cep_destino, $altura, $largura, $diametro, $comprimento, $peso = '0.300', 
  $servico, $valor_declarado = '0', $retorno) {
  
  // trata os cep's.
  $cep_destino = preg_replace("([^0-9])", '', $cep_destino);
  $cep_origem = preg_replace("([^0-9])", '', $cep_origem);

  $webservice = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx?WSDL';

  // torna em objeto as variaveis.
  $parms = new stdClass();
  // pac, sedex e esedex (todos com contrato).
  $parms->nCdServico = $servico;
  // login do cadastro no correios (opcional).
  $parms->nCdEmpresa = $cod_empresa;
  // senha do cadastro no correios (opcional).
  $parms->sDsSenha = $senha;
  // tipo de retorno.
  $parms->StrRetorno = 'xml';
  // cep cliente.
  $parms->sCepDestino = $cep_destino;
  // cep da loja (bd).
  $parms->sCepOrigem = $cep_origem;

  // informacoes de cubagem
  $parms->nVlPeso = $peso;
  $parms->nVlComprimento = $comprimento;
  $parms->nVlDiametro = $diametro;
  $parms->nVlAltura = $altura;
  $parms->nVlLargura = $largura;

  // outros obrigatorios (mesmo vazio).
  $parms->nCdFormato = 1;
  $parms->sCdMaoPropria = 'N';
  $parms->nVlValorDeclarado = $valor_declarado;
  $parms->sCdAvisoRecebimento = 'N';

  // inicializa o cliente SOAP.
  $soap = @new SoapClient($webservice, array(
      'trace' => TRUE,
      'exceptions' => TRUE,
      'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
      'connection_timeout' => 1000
    )
  );

  // resgata o valor calculado.
  $resposta = $soap->CalcPrecoPrazo($parms);
  $objeto = $resposta->CalcPrecoPrazoResult->Servicos->cServico;

  // retorno.
  if ($retorno == 'object') {
    return $objeto;
  }
  elseif ($retorno == 'json') {
    $json = json_encode($objeto);
    return $json;
  }
  else {
    return $soap;
  }
}
