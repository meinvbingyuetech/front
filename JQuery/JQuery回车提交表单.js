$("body").bind('keyup',function(event) {
if(event.keyCode==13){
document.form.submit();
}
});




<body onkeyup="autosubmit()">//��Ӽ����¼�
function autosubmit(){//�¼���������
  if(event.keyCode==13){
     document.form.submit();
  }
}