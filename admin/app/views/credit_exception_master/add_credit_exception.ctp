<script type='text/javascript'>
$(function(){
    $("input:submit").button();

     /* 処理結果用ダイアログ */
    $("#result_dialog").dialog({
             buttons: [{
                 text: "OK",
                 click: function () {
                     $("#result_dialog").dialog('close');
                 }
             }],
              beforeClose: function (event, ui) {
                  $("#result_message span").text("");
		          $("#error_reason").text("");
             },
             draggable: false,
             autoOpen: false,
             resizable: false,
             zIndex: 2000,
             modal: true,
             title: "処理結果"
    });

    /* 登録処理開始 */
    $("#formID").submit(function(){

       if( $("#formID").validationEngine('validate')==false){ return false; }
       $(this).simpleLoading('show');

	   var formData = $("#formID").serialize();

	   $.post(<?php echo "'".$html->url('addCreditException')."'" ?>,formData , function(result) {

	      $(this).simpleLoading('hide');

		  var obj = null;
	      try {
            obj = $.parseJSON(result);
          } catch(e) {
            obj = {};
            obj.result = false;
		    obj.message = "致命的なエラーが発生しました。";
		    obj.reason  = "このダイアログを閉じた後、画面のスクリーンショットを保存して管理者にお問い合わせ下さい。";
		    $("#critical_error").text(result);
          }

		  if(obj.result == true){
		      $("#result_message img").attr('src',<?php echo "'".$html->webroot("/images/confirm_result.png")."'" ?>);
		  }else{
		      $("#result_message img").attr('src',<?php echo "'".$html->webroot("/images/error_result.png")."'" ?>);
		  }
	   $("#result_message span").text(obj.message);
	   $("#error_reason").text(obj.reason);
       $("#result_dialog").dialog('open');
     });
      return false;
    });
});
</script>

<ul class="operate">
   <li><a href="<?php echo $html->url('.') ?>">一覧に戻る</a></li>
</ul>

    <form id="formID" class="content" method="post" name="CreditException" action="" >

		<table class="form" cellspacing="0">
	  	  <tr>
             <th>種別<span class="necessary">(必須)</span></th>
             <td>
                 <select name="data[CreditExceptionMst][credit_type_id]" id="credit_type_id" class="validate[required] inputvalue" style="width:100px;">
                     <option value='<?php echo NC_TRAVEL ?>'>旅行</option>
                     <option value='<?php echo NC_DRESS  ?>'>ドレス</option>
                     <option value='<?php echo NC_VENDOR  ?>'>業者</option>
                 </select>
             </td>
          </tr>
          <tr>
             <th>銀行入金名<span class="necessary">(必須)</span></th>
             <td><input type="text" name="data[CreditExceptionMst][credit_customer_nm]" id="credit_customer_nm" class="validate[required,maxSize[30]] inputvalue" value="" /></td>
          </tr>
	    </table>

	<div class="submit">
		<input type="submit" class='inputbutton' value="追加" />
	</div>
   </form>
<div id="result_dialog"  style="display:none"><p id="result_message"><img src="#" alt="" /><span></span></p><p id="error_reason"></p></div>
<div id="critical_error"></div>
