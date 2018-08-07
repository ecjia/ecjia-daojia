<!DOCTYPE html>
<html lang="zh-CN">

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{$title}</title>

	<link rel="stylesheet" type="text/css" href="{$bootstrap_min_css}">
	<script type="text/javascript" src="{$bootstrap_min_js}"></script>
	<script type="text/javascript" src="{$jquery_min_js}"></script>
</head>

<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">获奖用户资料登记</div>
					<div class="panel-body">
						<form action="" method="post" class="form-horizontal validforms">
							<div class="form-group">
								<label class="col-sm-2 control-label">姓名</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="姓名" name="data[name]" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">手机号</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="手机号" name="data[phone]" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">收货地址</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="详细收货地址" name="data[address]" />
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<input type="hidden" name="id" value="{$id}" />
									<input type="submit" class="btn btn-primary" value="确认" />
									<input type="reset" class="btn btn-default" value="重置" />
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>