function checkIsJSON(a){try{return JSON.parse(a),!0}catch(b){return!1}}jQuery(function(a){a("#ifw-refund-request").on("click",function(){var b={action:_ifw_admin.action,order_id:_ifw_admin.order_id,refund_request:_ifw_admin.nonce};confirm("환불처리를 진행하시겠습니까?")&&(a(this).attr("disabled","true"),a(this).attr("value","처리중..."),a.post(ajaxurl,b,function(b){b?(checkIsJSON(b)&&(b=JSON.parse(b)),"true"==b.success||b.success?(alert(b.data),location.reload()):(alert(b.data),a(this).removeAttr("disabled"),a(this).attr("value","환불하기"))):(alert("환불요청 결과를 수신하지 못하였습니다.\n처리 결과 확인을 위해 영수증을 확인해 보시기 바랍니다."),a(this).removeAttr("disabled"),a(this).attr("value","환불하기"))}))}),a("#ifw-check-receipt").on("click",function(){window.open("https://iniweb.inicis.com/app/publication/apReceipt.jsp?noMethod=1&noTid="+_ifw_admin.tid)})});