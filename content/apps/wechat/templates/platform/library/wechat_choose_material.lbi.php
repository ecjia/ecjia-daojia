<div class="modal fade text-left" id="choose_material">
	<div class="modal-dialog modal-lg modal-reset" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">{t domain="wechat"}选择素材{/t}</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">×</span>
				</button>
			</div>

			<!-- {if $errormsg || $wechat_type eq '0'} -->
				<div class="card-body">
					<!-- {if $errormsg} -->
				    <div class="alert alert-danger m_b0">
			            <strong>{t domain="wechat"}温馨提示：{/t}</strong>{$errormsg}
			        </div>
			        <!-- {/if} -->
					<!-- {if $wechat_type eq '0'} -->
					<div class="alert alert-danger m_b0">
						<strong>{t domain="wechat"}温馨提示：{/t}</strong>{$type_error}
					</div>
					<!-- {/if} -->
				</div>
			<!-- {/if} -->

			<div class="inner_main">
			</div>

			<div class="modal-footer justify-content-center">
				<input type="button" class="btn btn-success js-btn" value='{t domain="wechat"}确定{/t}' {if $errormsg || $wechat_type eq '0'}disabled{/if} />
				<input type="button" class="btn btn-outline-primary" data-dismiss="modal" aria-label="Close" value='{t domain="wechat"}取消{/t}' />
			</div>
		</div>
	</div>
</div>
