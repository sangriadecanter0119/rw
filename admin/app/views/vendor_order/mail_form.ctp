<script type='text/javascript'>
$(function(){

    /* メール送信フォームダイアログ */
	 $("#contact_dialog").dialog({
	             buttons: [{
                   text:"送信",
                   id:"update_button",
                   click:function(){

	               }
		         }],
	             beforeClose:function(){
	                $("#contact_dialog").remove();
	             },
	             draggable: false,
	             autoOpen: true,
	             resizable: false,
	             zIndex: 2000,
	             width:800,
	             height:450,
	          //   position:[($(window).width() / 2) -  (650 / 2) ,($(window).height() / 2) -  (488 / 2)],
	             modal: true,
	             title: "メール送信フォーム"
	 });

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

      /* アドレス帳の表示 */
    $(".address_list").click(function(){

    	$(this).simpleLoading('show');
    	$("#" + $(this).attr("id") +"_mail").addClass("selected");
    	$.post("<?php echo $html->url('addressListForm') ?>" , function(data) {
    		$(this).simpleLoading('hide');
            $("#address_list_dialog_wrapper").html(data);
        });
    });

});
</script>

<div id="contact_dialog">
    <form id="formIDD" class="content" method="post" name="contact" action="">
        <input type="hidden" id="sender_mail" name="data[ContactTrn][sender_email]"    value="<?php echo $user['User']['email']; ?>" />
        <input type="hidden" id="sender_mail" name="data[ContactTrn][sender_nm]"       value="<?php echo $user['User']['username']; ?>" />
		<table class="form" cellspacing="0">
		<tr>
            <th><a href='#'  id="receiver" class='address_list' style="text-decoration:underline;color:#57d">宛先</a><span class="necessary">(必須)</span></th>
            <td><input type="text" id="receiver_mail" name="data[ContactReceiverTrn][receiver_mail]"  class="validate[required] inputlongmailaddress"  value="" /></td>
        </tr>
        <tr>
            <th><a href='#'  id="cc"       class='address_list' style="text-decoration:underline;color:#57d">CC</a></th>
            <td><input type="text" id="cc_mail" name="data[ContactReceiverTrn][cc_mail]"  class="inputlongmailaddress" /></td>
        </tr>
        <tr>
            <th><a href='#'  id="bcc"      class='address_list' style="text-decoration:underline;color:#57d">BCC</a></th>
            <td><input type="text" id="bcc_mail" name="data[ContactReceiverTrn][bcc_mail]" class="inputlongmailaddress" /></td>
        </tr>
        <tr>
            <th>件名<span class="necessary">(必須)</span></th>
            <td><input type="text" id="title" name="data[ContactTrn][title]" class="validate[required,maxSize[40]] inputlongtitle" value="" /></td>
        </tr>
		<tr>
            <th>担当</th>
	   	    <td><?php echo $user['User']['username'] ?>
	   	        <input type="hidden" name="data[ContactTrn][sender_nm]" value="<?php echo $user['User']['username'] ?>" />
	   	    </td>
        </tr>
    	<tr>
              <th>内容</th>
              <td><textarea id="content" name="data[ContactTrn][content]" class="inputlongcomment" rows="5"></textarea></td>
        </tr>
	    </table>
</form>
<div id="address_list_dialog_wrapper"></div>
<div id="partial_result_dialog"  style="display:none"><p id="partial_result_message"><img src="#" alt="" /><span></span></p><p id="partial_error_reason"></p></div>
<div id="partial_critical_error"></div>
</div>









