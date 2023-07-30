<?php
set_time_limit(10);
error_reporting(0);

function getStr($string, $inicio, $fim)
{
    $string = explode($inicio, $string);
    $string = explode($fim, $string[1]);
    return $string[0];
}


function multiexplode($delimiters, $string)
{
  $one = str_replace($delimiters, $delimiters[0], $string);
  $two = explode($delimiters[0], $one);
  return $two;
}

$cpf = $_GET['cpf'];

if ($cpf == null) {
die('cpf inválido, tente novamente com ?cpf=xxxxxxxxxxx');
}
$curl = curl_init();
curl_setopt_array($curl, [
  CURLOPT_URL => "https://painelrndriver.com.br/webservice_shark.php?",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => 'vGeneralLang=PTBR&GeneralDeviceType=Android&GeneralMemberId=&CUS_IS_SINGLE_STORE_SELECTION=No&APP_TYPE=&vTimeZone=America%2FNew_York&GeneralAppVersionCode=20&ONLYDELIVERALL=&vGeneralCurrency=BRL&vCurrentTime=2022-11-02%2011%3A36%3A00&deviceHeight=1280.0&DELIVERALL=&vUserDeviceCountry=PT&GeneralAppVersion=1.11&UBERX_PARENT_CAT_ID=&iServiceId=&deviceWidth=800.0&vCpf='.$cpf.'&GeneralUserType=Passenger&vFirebaseDeviceToken=f80lZYVhRvixbTBEa44yTz%3AAPA91bFNeLFTdcE4XYk0B_xFEcMcSYmoukrGMGvS52GPHYPiBqHnFitKLv-ge4_ZUcsueGklcz9v2jo3HPERuFq4LXKKJFVCAvFedjyeUAkUEmXxTRt26JlxTNMbW1Ok9ZJtEQDhKDuR&DEFAULT_SERVICE_CATEGORY_ID=&tSessionId=&FOOD_ONLY=&type=getCpfU',
  CURLOPT_HTTPHEADER => [
    "host: painelrndriver.com.br",
    "content-type: application/x-www-form-urlencoded",
    "user-agent: okhttp/3.8.1",
  ],
]);
$consultador_cpf = curl_exec($curl);

$genero = getStr($consultador_cpf, '"GENERO":"', '"');
$nome = getStr($consultador_cpf, '"NOME":"', '"');
$idade = getStr($consultador_cpf, '"IDADE":', ',');
$nacimento = getStr($consultador_cpf, '"NASCIMENTO":"', '"');
$nacimento = str_replace('\/', '/', $nacimento);

if(strpos($consultador_cpf, 'IDADE')){

die("CONSULADO -> $cpf | [ Nome completo: $nome | Sexo: $genero | Idade: $idade | Data de nascimento: $nacimento ]");
   
}elseif(strpos($consultador_cpf, '"error":"User not found"')){
die("NÃO CONSULTADO -> $cpf não existe ou está incorreto.");
}else{
die("Erro ao realizar consulta deste cpf.");
}
?>