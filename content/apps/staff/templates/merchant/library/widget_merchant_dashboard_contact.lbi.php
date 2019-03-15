<?php defined('IN_ECJIA') or exit('No permission resources.');?> 
<!-- start:user info table -->
<section class="panel">
    <div class="task-thumb-details">
        <h1>{t domain="staff"}联系平台{/t}</h1>
    </div>
    <table class="table table-hover personal-task">
        <tbody>
            <tr>
                <td>
                    <i class="fa fa-phone"></i>
                </td>
                <td>{ecjia::config('service_phone')}</td>
            </tr>
            <tr>
                <td>
                    <i class="fa fa-envelope"></i>
                </td>
                <td>{ecjia::config('service_email')}</td>
            </tr>
        </tbody>
    </table>
</section>
<!-- end:user info table -->