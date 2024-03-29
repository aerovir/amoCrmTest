<?php

namespace addContact;

use function auth\authReq;

require_once 'auth.php';
require_once 'index.php';

authReq();

    $contacts [ 'add' ] = array (
        array (
          'name' => $_POST['contactName'] ,
          'responsible_user_id' => 504141 ,
          'created_by' => 504141 ,
          'created_at' => time() ,
          'tags' => "" ,
          'leads_id' => array (
             "" ,
             ""
          ) ,
       )
    ) ;
    /* Теперь подготовим данные, необходимые для запроса к серверу */
    $subdomain = 'aeroviradmin' ; #Наш аккаунт - поддомен
    #Формируем ссылку для запроса
    $link = 'https://' . $subdomain . '.amocrm.ru/api/v2/contacts' ;
    /* Нам необходимо инициировать запрос к серверу. Воспользуемся библиотекой cURL (поставляется в составе PHP). Подробнее о
    работе с этой
    библиотекой Вы можете прочитать в мануале. */
    $curl = curl_init ( ) ; #Сохраняем дескриптор сеанса cURL
    #Устанавливаем необходимые опции для сеанса cURL
    curl_setopt ( $curl ,CURLOPT_RETURNTRANSFER, true ) ;
    curl_setopt ( $curl ,CURLOPT_USERAGENT, 'amoCRM-API-client/1.0' ) ;
    curl_setopt ( $curl ,CURLOPT_URL, $link ) ;
    curl_setopt ( $curl ,CURLOPT_CUSTOMREQUEST, 'POST' ) ;
    curl_setopt ( $curl ,CURLOPT_POSTFIELDS, json_encode ( $contacts ) ) ;
    curl_setopt ( $curl ,CURLOPT_HTTPHEADER, array ( 'Content-Type: application/json' ) ) ;
    curl_setopt ( $curl ,CURLOPT_HEADER, false ) ;
    curl_setopt ( $curl ,CURLOPT_COOKIEFILE, dirname ( __FILE__ ) . '/cookie.txt' ) ; #PHP>5.3.6 dirname(__FILE__) -> __DIR__
    curl_setopt ( $curl ,CURLOPT_COOKIEJAR, dirname ( __FILE__ ) . '/cookie.txt' ) ; #PHP>5.3.6 dirname(__FILE__) -> __DIR__
    curl_setopt ( $curl ,CURLOPT_SSL_VERIFYPEER, 0 ) ;
    curl_setopt ( $curl ,CURLOPT_SSL_VERIFYHOST, 0 ) ;
    $out = curl_exec ( $curl ) ; #Инициируем запрос к API и сохраняем ответ в переменную
    $code = curl_getinfo ( $curl ,CURLINFO_HTTP_CODE) ;
    /* Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
    $code = (int) $code ;
    $errors = array (
      301 => 'Moved permanently' ,
      400 => 'Bad request' ,
      401 => 'Unauthorized' ,
      403 => 'Forbidden' ,
      404 => 'Not found' ,
      500 => 'Internal server error' ,
      502 => 'Bad gateway' ,
      503 => 'Service unavailable'
    ) ;
    try
    {
      #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
     if ( $code != 200 && $code != 204 ) {
        throw new Exception( isset ( $errors [ $code ] ) ? $errors [ $code ] : 'Undescribed error' , $code ) ;
      }
    }
    catch(Exception $E )
    {
      die ( 'Ошибка: ' . $E -> getMessage ( ) .PHP_EOL. 'Код ошибки: ' . $E -> getCode ( ) ) ;
    }
    /*
     Данные получаем в формате JSON, поэтому, для получения читаемых данных,
     нам придётся перевести ответ в формат, понятный PHP
     */
    $Response = json_decode ( $out , true ) ;
    $Response = $Response ['_embedded']['items'];
    $output = 'ID добавленных контактов: '.PHP_EOL;
    foreach($Response as $v) {
        if (is_array($v)){
            $output .= $v['id'] . PHP_EOL;
        }
        return $output;
    }
if($_POST == true) {
    echo "<script>document.location.href='/index.php';</script>";

}