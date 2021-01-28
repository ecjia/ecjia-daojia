<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.admin_logs.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>

<ul class="nav nav-pills">
    <!-- {foreach $navs as $item} -->
    <li class="{if $item.type eq $current_type}active{/if}"><a class="data-pjax" href='{$item.url}'>{$item.label} <span class="badge badge-info">{$item.count}</span></a></li>
    <!-- {/foreach} -->
</ul>

<div class="row-fluid">
    <div class="control-group form-horizontal choose_list span12">
        <form class="f_r" name="searchForm" method="post" action="{url path='@admin_session_login/init'}">
            <!-- 关键字 -->
            <input type="text" name="keyword" size="15" placeholder="{t}请输入Session Key{/t}" value="{if $keyword}{$keyword}{/if}" />
            <button class="btn" type="submit">{t}搜索{/t}</button>
        </form>
    </div>
    <table class="table table-striped" id="smpl_tbl">
        <thead>
            <tr>
                <th class="w100">{t}Session Key{/t}</th>
                <th class="w100">{t}用户类型{/t}</th>
                <th class="w50">{t}用户ID{/t}</th>
                <th>{t}User Agent{/t}</th>
                <th>{t}登录时间{/t}</th>
                <th>{t}登录IP{/t}</th>
                <th>{t}来源{/t}</th>
                <th class="w50">{t}操作{/t}</th>
            </tr>
        </thead>
        <tbody>
            <!-- {foreach $logs.list as $key => $item} -->
            <tr>
                <td class="first-cell" >{$item.id}</td>
                <td align="left">{$item.user_type}</td>
                <td align="left">{$item.user_id}</td>
                <td align="left">{$item.user_agent}</td>
                <td align="left">{$item.login_time|ecjia_time_display}</td>
                <td align="left">{$item.login_ip} ({$item.login_ip_location})</td>
                <td align="left">{$item.from_type} {if $item.from_value}({$item.from_value}){/if}</td>
                <td align="center">
                    <a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg="{t}您确定要删除该会话吗？{/t}" href='{url path="@admin_session_login/remove" args="key={$item.id}"}' title="{t}移除{/t}"><i class="fontello-icon-trash"></i></a>
                </td>
            </tr>
            <!-- {foreachelse} -->
            <tr>
                <td class="no-records" colspan="8">{t}没有找到任何记录{/t}</td>
            </tr>
            <!-- {/foreach} -->
        </tbody>
    </table>
    <!-- {$logs.page} -->
</div>

<div id="myModal1" class="modal hide fade view-session-detail" style="height:490px;width:790px;"></div>
<!-- {/block} -->