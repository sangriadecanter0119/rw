<?php
class AppController extends Controller {

	public $components = array('Auth','Session');

	function beforeFilter()
	{
		parent::beforeFilter();

	//if(env("SERVER_NAME") == 'realweddingshi.com'){
          $this->set("server_mode",SM_PRODUCTION);
        //}else{
        //  $this->set("server_mode",SM_DEVELOPMENT);
        //}

		$this->Auth->loginAction = 'http://'.$_SERVER['HTTP_HOST'].'/rw/admin/users/login';
	}
}
?>