<?php defined('IN_ECJIA') or exit('No permission resources.');?>

<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
		    <button data-dismiss="modal" class="close" type="button">×</button>
		    <h4 class="modal-title">{t domain="goods"}查看审核{/t}</h4>
		</div>

		<div class="modal-body">
			<div class="review-box" style="background-color: #f9f9f9;border-radius: 4px; margin-bottom:50px;">    
				<div class="review-title" style="padding:10px;"><strong>原因</strong></div>   
				<div class="review-content" style="padding:10px;">{$goods_info.review_content}</div>   
			</div>	
			
			<div class="review-box" style="background-color: #f9f9f9;border-radius: 4px">     
				<div class="review-title" style="padding:10px;"><strong>审核日志</strong></div>
				<div class="timeline" style="width: 88%;">            
				    <article class="timeline-item">
				        <div class="timeline-desk">
				            <!-- {foreach from=$list_log item=val} --> 
				            <div class="panel">
				                <div class="panel-body">
				                    <span class="arrow"></span>
				                    <span class="timeline-icon light-green"></span>
				                    <span class="timeline-date">{$val.add_time}</span>
				                    <h1 class="light-green">{$val.action_user_name}</h1>
				                    <p>{$val.action_note}</p>
				                  
				                </div>
				            </div>
				            <!-- {/foreach} -->
				        </div>
				    </article>
				</div>
			</div>	
		</div>
	</div>
</div>