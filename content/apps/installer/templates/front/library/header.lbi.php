<div class="ecjia-install-patch">
    <img src="{$logo_pic}" />
  	<ol class="path">
        <li {if $ecjia_step eq 1} class="current"{/if}><span>1</span>{t domain="installer"}欢迎使用{/t}</li>
        <li {if $ecjia_step eq 2} class="current"{/if}><span>2</span>{t domain="installer"}检查环境{/t}</li>
        <li {if $ecjia_step eq 3} class="current"{/if}><span>3</span>{t domain="installer"}初始化配置{/t}</li>
        <li {if $ecjia_step eq 4} class="current"{/if}><span>4</span>{t domain="installer"}开始安装{/t}</li>
        <li {if $ecjia_step eq 5} class="current"{/if}><span>5</span>{t domain="installer"}安装成功{/t}</li>
    </ol>
</div>