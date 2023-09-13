<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Desafio PHP</title>
  <link rel="stylesheet" href="style.css">
  </LIk>
</head>

<body>
  <main>
    <h1>Conversor de Moedas</h1>
    <?php

    //cotação vinda da API do Banco Central
    $inicio = date("m/d/Y", strtotime("-7 days"));
    $fim = date("m/d/Y");

    $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\'' . $inicio . '\'&@dataFinalCotacao=\'' . $fim . '\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';

    $dados = json_decode(file_get_contents($url), true);

    //var_dump($dados);

    $cotação = $dados['value'][0]['cotacaoCompra'];

    //quanto de dinheiro você tem?
    $real = $_REQUEST["din"] ?? 0;

    //Equivalencia em dólar
    $dólar = $real / $cotação;

    //mostar o resultado
    // echo "Seus R\$" . number_format($real, 2, ",", ".") . " equivalem a US\$" . number_format($dólar, 2, ",", ".");

    $padrão = numfmt_create("pt_BR", NumberFormatter::CURRENCY);

    echo "<p>Seus " . numfmt_format_currency($padrão, $real, "BRL") . " equivalem a <strong> 
    " . numfmt_format_currency($padrão, $dólar, "USD") . "</strong></p>";
    ?>
    <button onclick="javascript:history.go(-1)">Voltar</button>
  </main>

</body>

</html>