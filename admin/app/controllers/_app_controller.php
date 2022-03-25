<?php

class AppController extends Controller
{
  public $components = array('Security');

  public function beforeFilter() {
    parent::beforeFilter();
    // httpリクエストのときに実行するメソッド
    //$this->Security->blackHoleCallback = 'forceSecure';
    // httpsを強制したいアクション
    // requireSecureメソッドに引数がない場合は全てのアクションでhttpsを強制する
    //$this->Security->requireSecure();
  }

  public function forceSecure() {
    $this->redirect("http://".env('SERVER_NAME').$this->here);
  }
}

?>