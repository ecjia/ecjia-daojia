<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="modal hide fade" id="myModal2" >
    <div class="modal-header">
        <button class="close" data-dismiss="modal">×</button>
        <h3 class="modal-title">{t domain='goods'}审核{/t}</h3>
    </div>
    <div class="modal-body" >
        <form class="form-horizontal" action='{url path="goods/admin/goods_review" args="page={$page}"}' method="post" name="checkForm">
            <div class="control-group control-group-small">
                <label class="control-label">{t domain='goods'}审核备注：{/t}</label>
                <div class="controls">
                   <textarea class="w350" id="review_content" name="review_content" rows="6" cols="48" placeholder="请输入审核备注信息"></textarea>
                </div>
            </div>
            
            <div class="control-group control-group-small">
                <div class="controls">
					<select class="w350" id="check_review_log" name="check_review_log">
						<option value="0">{t domain='goods'}请选择……{/t}</option>
						<option value="1">{t domain='goods'}审核通过{/t}</option>
						<option value="2">{t domain='goods'}审核通过，商品符合商城规定，允许上架售卖{/t}</option>
						<option value="3">{t domain='goods'}审核未通过，您的商品存在违规行为{/t}</option>
						<option value="4">{t domain='goods'}商品信息不全或图片不清晰，请补充后再提交{/t}</option>
						<option value="5">{t domain='goods'}所上传商品名称及文字内容触犯广告法,不能使用国家级、最高级、最佳等敏感性用语{/t}</option>
					</select>
				</div>
            </div>
            
            <div class="control-group control-group-small">
	            <div class="controls">
	                 <a class="change_status btn btn-gebo" review_status="3" href="javascript:;">{t domain='goods'}通过{/t}</a>
	                 <a class="change_status btn " review_status="2" href="javascript:;">{t domain='goods'}拒绝{/t}</a>
	            </div>
            </div>
        </form>
    </div>
</div>