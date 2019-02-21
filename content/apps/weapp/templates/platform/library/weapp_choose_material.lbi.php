<div class="modal fade text-left" id="choose_material">
    <div class="modal-dialog modal-lg modal-reset" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{t domain="weapp"}选择素材{/t}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <!-- {if $errormsg} -->
            <div class="card-body">
                <div class="alert alert-danger m_b0">
                    <strong>{t domain="weapp"}温馨提示：{/t}</strong>{$errormsg}
                </div>
            </div>
            <!-- {/if} -->

            <div class="inner_main">
            </div>

            <div class="modal-footer justify-content-center">
                <input type="button" class="btn btn-success js-btn" {if $errormsg}disabled{/if} value='{t domain="weapp"}确定{/t}' />
                <input type="button" class="btn btn-outline-primary" data-dismiss="modal" aria-label="Close" value='{t domain="weapp"}取消{/t}' />
            </div>
        </div>
    </div>
</div>
