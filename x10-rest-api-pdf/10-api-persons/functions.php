<?php

  /**
   * Funkce pro odeslání JSON odpovědi
   * @param string|array|JsonSerializable $data
   * @param int $code = 200
   */
  function send_json_response($data, $code=200){
    if (!is_string($data)){
      $data=json_encode($data);
    }

    http_response_code($code);//odeslání stavového kódu
    header("Content-Type: application/json;charset=utf-8");//nastavení hlavičky pro korektní identifikaci JSONu se správným kódováním
    echo $data;
  }

  /**
   * Funkce pro jednoduché odeslání chyby
   * @param string|array|JsonSerializable $message
   * @param int $code = 404
   */
  function send_error_response($message, $code=404){
    send_json_response([
      'error'=>$message
    ], $code);
  }

  /**
   * Funkce pro dekódování JSON dat poslaných v HTTP požadavku
   * @return array|false
   */
  function get_json_request_body(){
    $result=json_decode(file_get_contents('php://input'), true);
    if(json_last_error() == JSON_ERROR_NONE){
      return $result;
    }
    return false;
  }