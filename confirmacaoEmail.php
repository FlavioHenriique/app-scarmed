<?php
require_once 'web/dao/UsuarioDAO.php';
  $url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  $url_components = parse_url($url);
  parse_str($url_components['query'], $params);
  $id = $params['id'];

  $dao = new UsuarioDAO();
  try{
      if ($dao->validaConfirmacaoEmail($id)) {
          header('Location: index.php?message=cadastroConfirmado');
      }
  }catch(exception $e){
      header('Location: index.php?message='. $e->getMessage());
  }


