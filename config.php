<?

session_start();

//BANCO DE DADOS
/*
  //Conteudo do bd.php
  define('DB_LIB', 'mysql');
  define('DB_HOST', '127.0.0.1');
  define('DB_NAME', 'SITE');
  define('DB_USER', 'root');
  define('DB_PASS', '');
  define('DB_CHARSET', 'utf8');
 */
require_once '../bd_crudPhpMvcPdoJs.php';

//Title
define('TITULO', 'Exemplo de Sistema com PHP e JS');

//Funções
require_once 'libs/funcoes.php';
iniciar();
