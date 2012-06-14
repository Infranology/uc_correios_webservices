<?php

/*
 *
 * Essa função utiliza o cep do remetente fixo dentro da função
 * Você especifica o cep destino e peso
 * o terceiro parametro é como você quer o retorno:
 * 'objeto', 'arrray', 'json'
 *
 * Se você precisar especificar mais variáveis para o PAC fique a vontade para atualizar a função
 * XD divirta-se
 *
 */
function calculo_frete_correios_api($cod_empresa, 
                        $senha, 
                        $cep_origem, 
                        $cep_destino, 
                        $altura,
                        $largura,
                        $diametro,
                        $comprimento,
                        $peso='0.300',
                        $servico,
                        $valor_declarado='0', 
                        $retorno = 'array')
{
   // TRATA OS CEP'S
   $cep_destino = eregi_replace("([^0-9])",'',$cep_destino);
   $cep_origem = eregi_replace("([^0-9])",'',$cep_origem);
 
   /*
    * TIPOS DE FRETE
    *
         41106 = PAC sem contrato
         40010 = SEDEX sem contrato
         40045 = SEDEX a Cobrar, sem contrato
         40215 = SEDEX 10, sem contrato
         40290 = SEDEX Hoje, sem contrato
         40096 = SEDEX com contrato
         40436 = SEDEX com contrato
         40444 = SEDEX com contrato
         81019 = e-SEDEX, com contrato
         41068 = PAC com contrato
    *
    *
    */
 
   // ESTE ARRAYS PARA O RETORNO (NO MEU CASO SÓ QUERO MOSTRAR ESTES)
   $rotulo = array( '41106'=>'PAC sem contrato',
                    '40010'=>'SEDEX sem contrato',
                    '40215'=>'SEDEX 10, sem contrato',
                    '40290'=>'SEDEX Hoje, sem contrato');
 
   //$webservice = 'http://shopping.correios.com.br/wbm/shopping/script/CalcPrecoPrazo.asmx?WSDL';// URL ANTIGA
   $webservice = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx?WSDL';
 
   // TORNA EM OBJETO AS VARIAVEIS
   $parms = new stdClass;
   $parms->nCdServico = $servico;//'41106,40010,40215,40290';// PAC, SEDEX E ESEDEX (TODOS COM CONTRATO) - se vc precisar de mais tipos adicione aqui
   $parms->nCdEmpresa = $cod_empresa;// <- LOGIN DO CADASTRO NO CORREIOS (OPCIONAL)
   $parms->sDsSenha = $senha;// <- SENHA DO CADASTRO NO CORREIOS (OPCIONAL)
   $parms->StrRetorno = 'xml';
 
   // DADOS DINAMICOS
   $parms->sCepDestino = $cep_destino;// CEP CLIENTE
   $parms->sCepOrigem = $cep_origem;// CEP DA LOJA (BD)
   $parms->nVlPeso = $peso;
 
   // VALORES MINIMOS DO PAC (SE VC PRECISAR ESPECIFICAR OUTROS FAÇA ISSO AQUI)
   $parms->nVlComprimento = $comprimento;
   $parms->nVlDiametro = $diametro;
   $parms->nVlAltura = $altura;
   $parms->nVlLargura = $largura;
 
   // OUTROS OBRIGATORIOS (MESMO VAZIO)
   $parms->nCdFormato = 1;
   $parms->sCdMaoPropria = 'N';
   $parms->nVlValorDeclarado = $valor_declarado;
   $parms->sCdAvisoRecebimento = 'N';

   // Inicializa o cliente SOAP
   $soap = @new SoapClient($webservice, array(
           'trace' => true,
           'exceptions' => true,
           'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
           'connection_timeout' => 1000
   ));
 
   // Resgata o valor calculado
   $resposta = $soap->CalcPrecoPrazo($parms);
   $objeto = $resposta->CalcPrecoPrazoResult->Servicos->cServico;
 
   // RETORNO
   if($retorno == 'object')
   {
      return $objeto;
   }
   elseif($retorno == 'json')
   {
      $json = json_encode($objeto);
      return $json;
   }
   else
   {
      return $soap;
   }
}

?>
