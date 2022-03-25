<?php
class UsersController extends AppController
{

 public $name = 'Users';
 public $uses = array('User','UserKbnMst','UserView','LoginHistoryTrn');
 public $components = array('Auth');
 public $layout = 'edit_mode';
 public $helpers = array('Html','common','javascript');

 function index()
 {
    //$this->redirect(array('action' => 'login'));
    $this->redirect('http://'.$_SERVER['HTTP_HOST'].'/rw/admin/users/login');
 }

 /**
  *
  *  ログイン開始
  */
 function login()
 {
   $this->layout = null;

   //if(env("SERVER_NAME") == 'realweddingshi.com'){
     $this->set("server_mode",SM_PRODUCTION);
   //}else{
   //  $this->set("server_mode",SM_DEVELOPMENT);
   //}

   //セッションのリファラにデータが入っているとログアウト時の
   //リダイレクトの制御がきかないので削除する
   if($this->Session->check('Auth.redirect')){
      $this->Session->delete('Auth.redirect');
   }
 }

 /**
  *
  *  ログアウト開始
  */
 function logout()
 {
 	$this->Session->setFlash(array('auth','ログアウトしました。'));
    $this->Auth->logout();
    $this->redirect('http://'.$_SERVER['HTTP_HOST'].'/rw/admin/users/login');
 }

 /**
  *
  * ユーザー新規登録
  */
 function addUser()
 {
 	if(!empty($this->data))
 	{
 		$tr = ClassRegistry::init('TransactionManager');
 		$tr->begin();

 		$this->layout = '';
 		$this->autoRender =false;
 		configure::write('debug', 0);

 		$this->data['User']['id'] = null;
 		$this->data['User']['reg_nm'] = $this->Auth->user('username');
 		$this->data['User']['reg_dt'] = date('Y-m-d H:i:s');
 		$this->User->create();

 		if($this->User->save($this->data)){
 			$tr->commit();
 			return json_encode(array('result'=>true,'message'=>'登録完了しました。'));
 		}else{
 			return json_encode(array('result'=>false,'message'=>"登録に失敗しました。",'reason'=>$this->User->getDbo()->error."[".date('Y-m-d H:i:s')."]"));
 		}
 		//初回ログイン用
 		// $this->redirect(array('action'=>'login'));
 	}else{

 		//メニューとサブメニューのアクティブ化
 		$this->set("menu_customers","");
 		$this->set("menu_customer","");
 		$this->set("menu_fund","");
 		$this->set("sub_title","ユーザー追加");
 		$this->set("user",$this->Auth->user());
 		$this->set("user_kbn_list",$this->UserKbnMst->find('all'));
 	}
 }

 /**
  *
  * ログイン履歴表示
  */
 function history()
 {
 	$search = array();

 	if (!empty($this->data)) {
 		$this->Session->write('filter_username',$this->data['UserHistoryTrn']['user_name']);
 	}
 	/* ソートリンクからフィルタ条件を引き継ぐ場合(GET) */
 	else if(isset($this->params['named']['user_name'])) {

 		$this->Session->write('filter_username',$this->params['named']['user_name']);
 	}

	if($this->Session->read('filter_username') != -1){
 				$search += array("user_id"=>$this->Session->read('filter_username'));
	}

	$this->paginate = array (
			'LoginHistoryTrn' => array(
					'limit' => 50,
					'order'=>array('id'=>'desc')
			)
	);

	$this->set("user_id" ,!isset($search["user_id"]) ? "-1" : $search["user_id"]);

	if(empty($search["user_id"])){
		$this->set("data",$this->paginate('LoginHistoryTrn'));
	}else{
		$this->set("data",$this->paginate('LoginHistoryTrn',$search));
	}

    $this->set("user_names",$this->LoginHistoryTrn->getUserList());

 	//メニューとサブメニューのアクティブ化
    $this->set("menu_customers","");
 	$this->set("menu_customer","");
 	$this->set("menu_fund","");
  	$this->set("sub_title","ログイン履歴");
  	$this->set("user",$this->Auth->user());
 }

 /**
  *  ユーザー編集・削除画面表示及び実行
  */
 function editUser($id=null)
 {
 	if(!empty($this->data))
 	{
 	   $tr = ClassRegistry::init('TransactionManager');
	   $tr->begin();

	   $this->layout = 'ajax';
 	   $this->autoRender =false;
 	   configure::write('debug', 0);

 	  /* 削除 */
      if(strtoupper($this->params['form']['submit'])  ==  "DELETE")
      {
         if($this->User->delete($this->data['User']['id'])==false){
        	  return json_encode(array('result'=>false,'message'=>"削除に失敗しました。",'reason'=>$this->User->getDbo()->error."[".date('Y-m-d H:i:s')."]"));
         }
      }
      /* 更新 */
      else if(strtoupper($this->params['form']['submit'])  ==  "UPDATE")
      {
     	/*
     	 *  パスワードフィールドが空でない場合は変更
     	 *  [説明]
     	 *  passwordフィールドが空でもハッシュ化してパスワードが変更されてしまうため
     	 *  仮の配列に一旦保持して変更なら正規の配列に代入する
     	 */
     	if (!empty($this->data['User']['new_password'])){
                $this->data['User']['password'] = $this->Auth->password($this->data['User']['new_password']);
        }
        if (!empty($this->data['User']['new_email_password'])){
                $this->data['User']['email_password'] = $this->data['User']['new_email_password'];
        }
     	 $this->data['User']['upd_nm'] = $this->Auth->user('username');
         $this->data['User']['upd_dt'] = date('Y-m-d H:i:s');
         $this->User->id = $this->data['User']['id'];
 	    if($this->User->save($this->data['User'])==false){
 	    	return json_encode(array('result'=>false,'message'=>"更新に失敗しました。",'reason'=>$this->User->getDbo()->error."[".date('Y-m-d H:i:s')."]"));
 	    }

 	  /* 異常パラメーター */
      }else{
      	    return json_encode(array('result'=>false,'message'=>"処理が失敗しました。",'reason'=>"予期しないコード[".$this->params['form']['submit']."]です。 "));
      }
      $tr->commit();
      return json_encode(array('result'=>true,'message'=>'処理完了しました。'));
 	}else{

 	  $this->set("data", $this->UserView->findById($id));

 	  $this->set("menu_customers","");
 	  $this->set("menu_customer","disable");
 	  $this->set("menu_fund","");

   	  $this->set("sub_title","ユーザー編集");
 	  $this->set("user",$this->Auth->user());
 	  $this->set("user_kbn_list",$this->UserKbnMst->find('all'));
 	}
 }

 /**
  * ログイン前の初期設定
  *
  */
 function beforeFilter()
 {
 	$this->Auth->loginError = "ログイン情報に誤りがあります。";
 	//$this->Auth->loginRedirect = array('controller' => 'Users',  'action' => 'loginStart');
 	$this->Auth->loginRedirect = 'http://'.$_SERVER['HTTP_HOST'].'/rw/admin/users/loginStart';

  //初回ログイン用
  //$this->Auth->allow('add');
  //$this->Auth->allow('logout');
 }

 /**
  * ログイン後の初期設定
  */
 function loginStart()
 {
 	//最終ログイン日を更新
 	$this->User->create();
 	$this->User->id = $this->Auth->user('id');
 	$this->User->saveField('last_login_dt',date('Y/m/d H:i:s'));

 	$this->LoginHistoryTrn->Add($this->Auth->user('id'));

 	//初期画面へ移動
 	//$this->redirect(array('controller' => 'customersList',  'action' => 'index'));
 	$this->redirect('http://'.$_SERVER['HTTP_HOST'].'/rw/admin/customersList');
 }

}
?>