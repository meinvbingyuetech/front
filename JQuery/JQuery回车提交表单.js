$("body").bind('keyup',function(event) {
if(event.keyCode==13){
document.form.submit();
}
});




<body onkeyup="autosubmit()">//添加监听事件
function autosubmit(){//事件触发函数
  if(event.keyCode==13){
     document.form.submit();
  }
}