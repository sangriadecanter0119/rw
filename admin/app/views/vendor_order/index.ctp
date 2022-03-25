<script type='text/javascript'>
$(function(){
    $("input:submit").button();
    $("search_customer_button").button();
    $(".inputdate").mask("9999-99-99");
    $(".inputtime").mask("99:99");

    /* メール送信画面表示 */
    $("#mail_link").click(function(){

       $(this).simpleLoading('show');
	   $.post(<?php echo "'".$html->url('mailForm')."'" ?> , function(html) {
		  $(this).simpleLoading('hide');
		  $("body").append(html);
       });
      return false;
    });

    /* 更新処理開始 */
    $("#ReportForm").submit(function(){

       $(this).simpleLoading('show');

	   var formData = $("#ReportForm").serialize();

	   $.post(<?php echo "'".$html->url('editReport')."'" ?>,formData , function(result) {

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

    $("#search_customer_button").click(function(){
        $("#company").val("UI Prodaction. Inc.");
        $("#final_date").val("2017-08-20");
        $("#coordinator").val("Mayumi");
        $("#phone").val("808-561-0789");
        $("#fax").val("808-949-7800");
        $("#celemony_day").val("sunday");
        $("#celemony_date").val("2017-09-20");
        $("#celemony_time").val("14:00");
        $("#sanctuary").val("");
        $("#atherton").val("");
        $("#bridal_party").val("house");
        $("#groom").val("Mr. Kenta Fukui");
        $("#bride").val("Ms. Ayako Yamanaka");
        $("#number_guest").val("5");
        $("#guest_comming_by").val("Limo");
        $("#bride_escorted_by").val("Bride");
        $("#note").val("This is special wedding.");
        $("#photo_yes").prop("checked",true);
        $("#video_yes").prop("checked",true);
        $("#flower_yes").prop("checked",true);
        $("#ring_church").prop("checked",true);
    });
    $("input,textarea").css("font-size","12px");

    ShowForm();

    $("#order_form").change(function(){
        ShowForm();
    });

    function ShowForm(){
       var sel = $("#order_form").val();
       if(sel == 1){
          $("#cuc").css("display","block");
          $("#ui_production").css("display","none");
        }else if(sel== 2){
          $("#cuc").css("display","none");
          $("#ui_production").css("display","block");
        }else{
          $("#ui_production").css("display","none");
          $("#cuc").css("display","none");
        }
    }
});
</script>
<style type='text/css'>


</style>

<ul class="operate">
   <li><a href="<?php echo $html->url('/systemManager') ?>">戻る</a></li>
   <li><a href=''>EXCEL</a></li>
   <li><a id="mail_link" href='#'>MAIL</a></li>
   <li><a href=''>ドラフト保存</a></li>
</ul>

<div class="message warning_message" style="clear:both;font-size:14px;font-weight:bold"><img src="<?php echo $html->webroot("/images/warning.png") ?>" alt="" /><span>この画面はてすと用です。</span></div>


<div class='notation'>
   <label style="margin-left:10px;font-size:14px;">ベンダーフォーム：</label>
   <select id="order_form" style="width:150px;">
       <option value='' selected>選択して下さい</option>
       <option value='1' selected>Central Union Curch</option>
       <option value='2' selected>UI Production</option>
   </select>
   <label style="margin-left:10px;font-size:14px;">対象顧客名：</label>
   <input type="text" id="customer_name" value="" />
   <input id="search_customer_button" type="button" style="margin-left:3px;" value="表示する" />
</div>

<div>
<form id="formID" class="content" method="post" name="VendorOrder" action="<?php echo $html->url('') ?>" >
<table id="cuc" class="form" cellspacing="0" style="margin-top:20px;">
   <tr>
      <td>Company:</td><td><input type="text" id="company" style="width:200px;"></td>
      <td>Final Date:</td><td><input type="text" id="final_date" class="inputdate" style="width:100px;"></td>
      <td>&nbsp;</td>
   </tr>
   <tr colspan="3">
      <td>Coordinator(Planner) for this wedding:</td><td><input type="text" id="coordinator" style="width:200px;"></td>
   </tr>
   <tr>
      <td>Phone#</td><td><input type="text" id="phone" style="width:200px;"></td>
      <td>Fax#:</td><td><input type="text" id="fax" style="width:200px;"></td>
      <td>&nbsp;</td>
   </tr>
   <tr>
      <td>Celemony Day:</td><td><input type="text" id="celemony_day" style="width:100px;"></td>
      <td>Date:</td><td><input type="text" id="celemony_date" class="inputdate" style="width:100px;"></td>
      <td>Time:</td><td><input type="text" id="celemony_time" class="inputtime" style="width:100px;"></td>
   </tr>
   <tr>
      <td>Sanctuary:</td><td><input type="text" id="sanctuary" style="width:200px;"></td>
      <td>Atherton:</td><td><input type="text" id="atherton" style="width:200px;"></td>
      <td>&nbsp;</td>
   </tr>
   <tr colspan="3">
      <td>Groom:</td><td><input type="text" id="groom" style="width:200px;"></td>
   </tr>
   <tr colspan="3">
      <td>Bride:</td><td><input type="text" id="bride" style="width:200px;"></td>
   </tr>

   <tr colspan="3">
      <td>Total# of guests:</td><td><input type="text" id="number_guest" style="width:200px;"></td>
   </tr>
   <tr colspan="3">
      <td>Guests comming by:</td><td><input type="text" id="guest_comming_by" style="width:200px;"></td>
   </tr>
   <tr colspan="3">
      <td>Bride escorted by:</td><td><input type="text" id="bride_escorted_by" style="width:200px;"></td>
   </tr>
   <tr colspan="3">
      <td>Photo:</td><td><span>Check one:</span><label style="margin-left:10px;">Yes</lable><input type="checkbox" id="photo_yes"><label style="margin-left:10px;">No</lable><input type="checkbox" id="photo_no"></td>
   </tr>
   <tr colspan="3">
      <td>Video:</td><td><span>Check one:</span><label style="margin-left:10px;">Yes</lable><input type="checkbox" id="video_yes"><label style="margin-left:10px;">No</lable><input type="checkbox" id="video_no"></td>
   </tr>
   <tr colspan="3">
      <td>Bridal Party:</td><td><input type="text" id="bridal_party" style="width:200px;"></td>
   </tr>
   <tr colspan="3">
      <td>Flower Shower:</td><td><span>Check one:</span><label style="margin-left:10px;">Yes</lable><input type="checkbox" id="flower_yes"><label style="margin-left:10px;">No</lable><input type="checkbox" id="flower_no"></td>
   </tr>
   <tr colspan="3">
      <td>Ring Pillow:</td><td><span>Check one:</span><label style="margin-left:10px;">Own</lable><input type="checkbox" id="ring_own"><label style="margin-left:10px;">Church</lable><input type="checkbox" id="ring_church"></td>
   </tr>
   <tr colspan="3">
      <td>Special Instructions:</td><td><textarea id="note" cols="45" rows="5"></textarea></td>
   </tr>
</table>

<table id="ui_production" class="form" cellspacing="0" style="margin-top:20px;">
   <tr>
      <td>Wedding Date:</td>
      <td><input type="text" id="" class="inputdate" style="width:100px;">
          <span style="margin-left:20px;">Time:</span><input type="text" id="" class="inputtime" style="width:100px;">
      </td>
   </tr>
   <tr>
      <td>Groom:</td>
      <td><input type="text" id="groom" style="width:200px;">
          <span style="margin-left:40px;">Bride:</span><input type="text" id="bride" style="width:200px;">
      </td>
   </tr>

   <tr colspan="2">
      <td>Hotel:</td><td><input type="text" id="groom" style="width:200px;"></td>
   </tr>
   <tr colspan="2">
      <td>Couple’s Limo:</td>
      <td><label>Total Passenger Count</label>
          <select style="width:50px;margin-left:5px;">
            <option>-</option>
            <?php
              for($i=1;$i < 100; $i++){ echo "<option value='".$i."'>".$i."</option>"; }
            ?>
          </select>

          <label style="margin-left:10px;">pax / B&G</label>
          <select style="width:50px;margin-left:5px;">
            <option>-</option>
            <?php
              for($i=1;$i < 100; $i++){ echo "<option value='".$i."'>".$i."</option>"; }
            ?>
          </select>

          <label style="margin-left:10px;">with PH</label>
          <select style="width:50px;margin-left:5px;">
            <option>-</option>
            <?php
              for($i=1;$i < 100; $i++){ echo "<option value='".$i."'>".$i."</option>"; }
            ?>
          </select>

          <label style="margin-left:10px;">H&M</label>
          <select style="width:50px;margin-left:5px;">
            <option>-</option>
            <?php
              for($i=1;$i < 100; $i++){ echo "<option value='".$i."'>".$i."</option>"; }
            ?>
          </select>

          <label style="margin-left:10px;">ATT</label>
          <select style="width:50px;margin-left:5px;">
            <option>-</option>
            <?php
              for($i=1;$i < 100; $i++){ echo "<option value='".$i."'>".$i."</option>"; }
            ?>
          </select>

          <label style="margin-left:10px;">Guest</label>
          <select style="width:50px;margin-left:5px;">
            <option>-</option>
            <?php
              for($i=1;$i < 100; $i++){ echo "<option value='".$i."'>".$i."</option>"; }
            ?>
          </select>
   </tr>
   <tr>
      <td>Guest Count:</td>
      <td><label>pax / Adult</label>
          <select style="width:50px;margin-left:5px;">
            <option>-</option>
            <?php
              for($i=1;$i < 100; $i++){ echo "<option value='".$i."'>".$i."</option>"; }
            ?>
          </select>

          <label style="margin-left:10px;">Child</label>
          <select style="width:50px;margin-left:5px;">
            <option>-</option>
            <?php
              for($i=1;$i < 100; $i++){ echo "<option value='".$i."'>".$i."</option>"; }
            ?>
          </select>

          <label style="margin-left:10px;">Infant</label>
          <select style="width:50px;margin-left:5px;">
            <option>-</option>
            <?php
              for($i=1;$i < 100; $i++){ echo "<option value='".$i."'>".$i."</option>"; }
            ?>
          </select>
      </td>
   </tr>

   <tr>
       <td>Guest Transportation:</td>
       <td><label>Limo</lable><input type="checkbox" id="">
           <label style="margin-left:10px;">Van</lable><input type="checkbox" id="">
           <label style="margin-left:10px;">Mini-Bus</lable><input type="checkbox" id="">
           <label style="margin-left:10px;">Taxi</lable><input type="checkbox" id="">
      </td>
   </tr>

   <tr>
      <td>Bouquet Deliver to:</td>
      <td><label>Hotel</lable><input type="checkbox" id="">
          <label style="margin-left:10px;">Church</lable><input type="checkbox" id="">
      </td>
   </tr>
   <tr>
      <td>Flower Petals Deliver to:</td>
      <td><label>Hotel</lable><input type="checkbox" id="">
          <label style="margin-left:10px;">Church</lable><input type="checkbox" id="">
      </td>
   </tr>
   <tr>
      <td>Bride Escort:</td>
      <td><label>Groom</lable><input type="checkbox" id=""><label style="margin-left:10px;">Father</lable><input type="checkbox" id="">
          <label style="margin-left:10px;">Mother</lable><input type="checkbox" id=""><label style="margin-left:10px;">Other</lable><input type="checkbox" id="">
      </td>
   </tr>
   <tr>
      <td>Ring Pillow:</td>
      <td><label>Own</lable><input type="checkbox" id="">
          <label style="margin-left:10px;">Church</lable><input type="checkbox" id="">
      </td>
   </tr>
   <tr>
      <td>Flower Girl:</td>
      <td><label>Yes</lable><input type="checkbox" id="">
          <span>[
              <select style="width:50px;margin-left:5px;">
                  <option>-</option>
                  <?php
                      for($i=1;$i < 100; $i++){ echo "<option value='".$i."'>".$i."</option>"; }
                  ?>
              </select>
          years old]</span>
          <label style="margin-left:10px;">No</lable><input type="checkbox" id="">
      </td>
   </tr>
   <tr>
      <td>Ring Boy:</td>
      <td><label>Yes</lable><input type="checkbox" id="">
          <span>[
              <select style="width:50px;margin-left:5px;">
                  <option>-</option>
                  <?php
                      for($i=1;$i < 100; $i++){ echo "<option value='".$i."'>".$i."</option>"; }
                  ?>
              </select>
          years old]</span>
          <label style="margin-left:10px;">No</lable><input type="checkbox" id="">
      </td>
   </tr>
   <tr>
      <td>Flower Shower:</td>
      <td><label>Yes</lable><input type="checkbox" id="">
          <span>#Bags</span>
          <select style="width:50px;margin-left:5px;">
              <option>-</option>
               <?php
                  for($i=1;$i < 100; $i++){ echo "<option value='".$i."'>".$i."</option>"; }
               ?>
          </select>

          <span>[Clean Up:
             <lable>RW</label><input type="checkbox" id="">
             <lable style="margin-left:10px;">UI Production</label><input type="checkbox" id="">]
          </span>

          <label style="margin-left:10px;">No</lable><input type="checkbox" id="">
      </td>
   </tr>
   <tr>
      <td>Bubble Shower:</td>
      <td><label>Yes</lable><input type="checkbox" id="">
         <span>[Clean Up:
             <lable>RW</label><input type="checkbox" id="">
             <lable style="margin-left:10px;">UI Production</label><input type="checkbox" id="">]
          </span>
          <label style="margin-left:10px;">No</lable><input type="checkbox" id="">
      </td>
   </tr>
   <tr>
      <td>Bridesmaids:</td>
      <td><label>Yes</lable><input type="checkbox" id="">
          <span>[#
          <select style="width:50px;margin-left:5px;">
              <option>-</option>
               <?php
                  for($i=1;$i < 100; $i++){ echo "<option value='".$i."'>".$i."</option>"; }
               ?>
          </select>]
          </span>
          <label style="margin-left:10px;">No</lable><input type="checkbox" id="">
      </td>
   </tr>
   <tr>
      <td>Best Man:</td>
      <td><label>Yes</lable><input type="checkbox" id="">
          <span>[#
          <select style="width:50px;margin-left:5px;">
              <option>-</option>
               <?php
                  for($i=1;$i < 100; $i++){ echo "<option value='".$i."'>".$i."</option>"; }
               ?>
          </select>]
          </span>
          <label style="margin-left:10px;">No</lable><input type="checkbox" id="">
      </td>
   </tr>
   <tr>
      <td>White Carpet:</td>
      <td><label>Yes</lable><input type="checkbox" id="">
          <label style="margin-left:10px;">No</lable><input type="checkbox" id="">
      </td>
   </tr>
   <tr>
      <td>Champagne:</td>
      <td><label>Yes</lable><input type="checkbox" id="">
          <span>/# Glasses[
          <select style="width:50px;margin-left:5px;">
              <option>-</option>
               <?php
                  for($i=1;$i < 100; $i++){ echo "<option value='".$i."'>".$i."</option>"; }
               ?>
          </select>]
          </span>
          <label style="margin-left:10px;">No</lable><input type="checkbox" id="">
      </td>
   </tr>
   <tr>
      <td>Cake Cut:</td>
      <td><label>Yes</lable><input type="checkbox" id="">
          <label style="margin-left:10px;">No</lable><input type="checkbox" id="">
      </td>
   </tr>
   <tr>
      <td>Lei Ceremony:</td>
      <td><label>Yes</lable><input type="checkbox" id="">
          <span>[#
          <select style="width:50px;margin-left:5px;">
              <option>-</option>
               <?php
                  for($i=1;$i < 100; $i++){ echo "<option value='".$i."'>".$i."</option>"; }
               ?>
          </select>]
          <span>[Presentation:
             <lable>Before</label><input type="checkbox" id="">
             <lable style="margin-left:10px;">After Ceremony</label><input type="checkbox" id="">]
          </span>
          <label style="margin-left:10px;">No</lable><input type="checkbox" id="">
      </td>
   </tr>
   <tr>
      <td>Legal Wedding:</td>
      <td><label>Yes</lable><input type="checkbox" id="">
          <label style="margin-left:10px;">No</lable><input type="checkbox" id="">
      </td>
   </tr>
   <tr>
      <td>Photographer:</td>
      <td><label>Yes</lable><input type="checkbox" id="">
          <span>[Name:<input type="text" id="" style="width:100px;">]</span>
          <span>[Coming on <input type="text" id="" style="width:50px;">own or <input type="text" id="" style="width:50px;">with couple]</span>

          <label style="margin-left:10px;">No</lable><input type="checkbox" id="">
      </td>
   </tr>
   <tr>
      <td>Videographer:</td>
      <td><label>Yes</lable><input type="checkbox" id="">
          <span>[Name:<input type="text" id="" style="width:150px;">]</span>
          <span>DVD<input type="checkox id="">/Blu-rey<input type="checkox id=""></span>
          <label style="margin-left:10px;">No</lable><input type="checkbox" id="">
      </td>
   </tr>
   <tr>
      <td>Hair & Make to attend:</td>
      <td><label>Yes</lable><input type="checkbox" id="">
          <span>[Coming on <input type="text" id="" style="width:50px;">own or <input type="text" id="" style="width:50px;">with couple]</span>
          <label style="margin-left:10px;">No</lable><input type="checkbox" id="">
      </td>
   </tr>
   <tr>
      <td>Coordinator to attend:</td>
      <td><label>Yes</lable><input type="checkbox" id="">
          <span>[Name:<input type="text" id="" style="width:150px;">/Cell#<input type="text" id="" style="width:150px;">]</span>/
          <span>[Coming on <input type="text" id="" style="width:50px;">own or <input type="text" id="" style="width:50px;">with couple]</span>
          <label style="margin-left:10px;">No</lable><input type="checkbox" id="">
      </td>
   </tr>
   <tr>
      <td>Reception after ceremony:</td>
      <td><label>Yes</lable><input type="checkbox" id="">
          <span>[Start Time:<input type="text" id="" class="inputtime" style="width:80px;">/Place:<input type="text" id="" style="width:150px;">]</span>
          <label style="margin-left:10px;">No</lable><input type="checkbox" id="">
      </td>
   </tr>
   <tr>
      <td>Photo Tour after ceremony:</td>
      <td><label>Yes</lable><input type="checkbox" id="">
          <label style="margin-left:10px;">No</lable><input type="checkbox" id="">
      </td>
   </tr>
   <tr>
      <td>Rehearsal showing to guests:</td>
      <td><label>Yes</lable><input type="checkbox" id="">
          <label style="margin-left:10px;">No</lable><input type="checkbox" id="">
      </td>
   </tr>
</table>
</form>
</div>
































