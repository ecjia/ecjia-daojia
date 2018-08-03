<div class="modal fade text-left" id="preview_msg">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">发送预览</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">×</span>
				</button>
			</div>

			<!-- {if $errormsg || $wechat_type eq '0'} -->
				<div class="card-body">
					<!-- {if $errormsg} -->
				    <div class="alert alert-danger m_b0">
			            <strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
			        </div>
			        <!-- {/if} -->
					<!-- {if $wechat_type eq '0'} -->
					<div class="alert alert-danger m_b0">
						<strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
					</div>
					<!-- {/if} -->
				</div>
			<!-- {/if} -->

			<div class="inner_main inner_reset">
				<div class="dialog_bd">
					<div class="js_preview_dialog_content simple_dialog_content send_preview">
					    <div class="preview_form_box">
					        <form class="form" onsubmit="return false;">
					            <div class="frm_control_group">
					                <label class="frm_label">关注公众号后，才能接收图文消息预览</label>
					                <span class="frm_input_box">
					                    <input type="text" class="frm_input jsAccountInput form-control" name="wechat_account" placeholder="请输入微信号">
					                </span>
					                <p class="frm_tips">预览功能仅用于公众号查看文章效果，不适用于公众传播，预览链接会在短期内失效</p>
					                <p class="frm_msg fail jsAccountFail"></p>
					            </div>
					        </form>
					    </div>
					</div>
				</div>
			</div>

			<div class="modal-footer justify-content-center">
				<input type="button" class="btn btn-success confirm-send" {if $errormsg || $wechat_type eq '0'}disabled{/if} value="{lang key='wechat::wechat.ok'}" />
				<input type="button" class="btn btn-outline-primary" data-dismiss="modal" aria-label="Close" value="{lang key='wechat::wechat.cancel'}" />
			</div>
		</div>
	</div>
</div>
