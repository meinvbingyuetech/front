<form class="form-horizontal" role="form"> 
	<div class="form-group"> 
		<label class="col-sm-2 control-label">Email</label> 
		<div class="col-sm-10"> 
			<p class="form-control-static">email@example.com</p> 
		</div> 
	</div>

	<div class="form-group"> 
		<label for="inputPassword" class="col-sm-2 control-label">用户</label> 
		<div class="col-sm-10"> 
			<div class="input-group"> 
				<input type="text" class="form-control" placeholder="请输入用户名"> 
				<span class="input-group-btn"> 
					<button class="btn btn-default" type="button">搜索</button> 
				</span> 
			</div>
		</div> 
	</div> 

	<div class="form-group"> 
		<label for="firstname" class="col-sm-2 control-label">名字</label> 
		<div class="col-sm-10"> 
			<input type="text" class="form-control" id="firstname" placeholder="请输入名字"> 
		</div> 
	</div> 
	<div class="form-group"> 
		<label for="lastname" class="col-sm-2 control-label">姓</label> 
		<div class="col-sm-10"> 
			<input type="text" class="form-control" id="lastname" placeholder="请输入姓">
		</div> 
	</div> 
	<div class="form-group"> 
		<label for="inputPassword" class="col-sm-2 control-label">密码</label> 
		<div class="col-sm-10"> 
			<input type="password" class="form-control" id="inputPassword" placeholder="请输入密码"> 
		</div> 
	</div>  
	<div class="form-group"> 
		<label for="inputPassword" class="col-sm-2 control-label">选择列表</label> 
		<div class="col-sm-10"> 
			<select class="form-control"> 
				<option>1</option> 
				<option>2</option> 
				<option>3</option> 
				<option>4</option> 
				<option>5</option> 
			</select> 
		</div> 
	</div>  
	<div class="form-group"> 
		<label for="inputPassword" class="col-sm-2 control-label">可多选的选择列表</label> 
		<div class="col-sm-10"> 
			<select multiple class="form-control"> 
				<option>1</option> 
				<option>2</option> 
				<option>3</option> 
				<option>4</option> 
				<option>5</option> 
			</select> 
		</div> 
	</div>   

	<div class="form-group"> 
		<label for="lastname" class="col-sm-2 control-label">文本框</label> 
		<div class="col-sm-10"> 
			<textarea class="form-control" rows="3"></textarea> 
			<span class="help-block">这里可以写些注释之类的。</span>
		</div> 
	</div> 

	<div class="form-group"> 
		<div class="col-sm-offset-2 col-sm-10"> 
			<div class="checkbox"> 
				<label> 
					<input type="checkbox">请记住我 
				</label> 
			</div> 
		</div> 
	</div> 
	
	<div class="form-group"> 
		<div class="col-sm-offset-2 col-sm-10"> 
			<button type="submit" class="btn btn-default">登录</button> 
		</div> 
	</div> 
</form>