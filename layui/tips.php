<script>
	
$("#sortrand_tip").mouseover(function () {
    layer.open({
        type: 4,
        tips: 1,
        closeBtn: 0,
        time: 2000,
        shade: 0,
        content: ['数字越小排在越前面', '#sortrand_tip'] //数组第二项即吸附元素选择器或者DOM
    });
});

</script>