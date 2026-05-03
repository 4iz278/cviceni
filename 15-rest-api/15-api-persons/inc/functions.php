<?php

/**
 * Funkce pro odeslání JSON odpovědi
 */
function send_json_response(mixed $data, int $code=200):void{
  if (!is_string($data)){
    $data=json_encode($data);
  }

  http_response_code($code);//odeslání stavového kódu
  header("Content-Type: application/json;charset=utf-8");//nastavení hlavičky pro korektní identifikaci JSONu se správným kódováním
  echo $data;
}

/**
 * Funkce pro jednoduché odeslání chyby
 */
function send_error_response(mixed $message, int $code=404):void{
  send_json_response([
   'error'=>$message
  ], $code);
}

/**
 * Funkce pro dekódování JSON dat poslaných v HTTP požadavku
 */
function get_json_request_body():array|false{
  $result=json_decode(file_get_contents('php://input'), true);
  if(json_last_error() == JSON_ERROR_NONE){
    return $result;
  }
  return false;
}