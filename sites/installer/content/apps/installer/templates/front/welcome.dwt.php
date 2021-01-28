<?php defined('IN_ECJIA') or exit('No permission resources.');?>
{extends file="./ecjia_installer.dwt.php"}

{block name="main_content"}
<div class="container">
    <div class="row">
        <div class="col-mb-12 col-tb-8 col-tb-offset-2">
            <div class="column-14 start-06 ecjia-install">
                <form method="post" id="install_check_agree" action="{RC_Uri::url('installer/index/check_agree')}">
                    <h3 class="ecjia-install-title">{t domain="installer"}欢迎使用{/t} {$product_name}</h3>
                    <div class="ecjia-install-body">
                        {$install_license}
                    </div>
                    <p class="description"><label><input type="checkbox" class="p" name="agree" id="agree">{t domain="installer"}我已仔细阅读，并同意上述条款中的所有内容{/t}</label></p>
                    <p class="submit">
                        <button type="submit" class="btn primary" id="ecjia_install" data-url="{RC_Uri::url("installer/index/check_agree")}" disabled="disabled">{t domain="installer"}我准备好了，开始下一步{/t} &raquo;</button>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
{/block}
