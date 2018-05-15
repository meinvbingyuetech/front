<script>
	layui.layer.open({
        title: '提交确认',
        content: '确定要执行生成缓存的操作吗？',
        btn: ['确定', '取消'],
        yes: function(index, layero){

            //关闭提示窗
            layer.close(index);

            //提交请求
            $.ajax({
                url:"{{action('Admin\ArctypeController@makeCache')}}",
                type:"post",
                dataType:"json",
                async:"true",
                data:{'_token':$token},
                success:function (result) {
                    if (result.code == 0) {
                        layui.use('layer', function(){
                            layui.layer.msg('缓存创建成功！', {icon: 1,time: 2000},function () {

                            });
                        });
                    } else {
                        layui.use('layer', function(){
                            layui.layer.msg(result.msg, {icon: 5,time: 4000});
                        });
                    }
                }
            });
        },
        btn2: function(index, layero){}
    });
</script>