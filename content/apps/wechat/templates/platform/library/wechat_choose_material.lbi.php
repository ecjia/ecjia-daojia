<div class="modal fade text-left" id="choose_material">
	<div class="modal-dialog modal-lg modal-reset" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">选择素材</h3>
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

			<div class="inner_main">
			</div>

			<div class="modal-footer justify-content-center">
				<input type="button" class="btn btn-success js-btn" {if $errormsg || $wechat_type eq '0'}disabled{/if} value="{lang key='wechat::wechat.ok'}" />
				<input type="button" class="btn btn-outline-primary" data-dismiss="modal" aria-label="Close" value="{lang key='wechat::wechat.cancel'}" />
			</div>
		</div>
	</div>
</div>
