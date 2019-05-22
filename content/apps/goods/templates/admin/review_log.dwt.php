<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<style>
.panel-body {
    padding: 10px;
}
.timeline {
    border-collapse: collapse;
    border-spacing: 0;
    display: table;
    position: relative;
    table-layout: fixed;
    width: 100%;
}

.timeline:before {
    background-color: #C7CBD6;
    bottom: 0px;
    content: "";
    left: 50%;
    position: absolute;
    top: 0;
    width: 2px;
    z-index: 0;
}

h3.timeline-title {
    margin: 0;
    color: #C8CCD7;
    font-size: 20px;
    font-weight: 400;
    margin: 0 0 5px;
    text-transform: uppercase;
}

.t-info {
    color: #C8CCD7;
}

.timeline-item:before, .timeline-item.alt:after {
    content: "";
    display: block;
    width: 50%;
}

.timeline-item {
    display: table-row;
}

.timeline-desk {
    display: table-cell;
    vertical-align: top;
    width: 50%;
}

.timeline-desk h1 {
    font-size: 16px;
    font-weight: 300;
    margin: 0 0 5px;
}

.timeline-desk .panel {
    display: block;
    margin-left: 25px;
    position: relative;
    text-align: left;
    background: #F4F4F4;
}

.timeline-item .timeline-desk .arrow {
    border-bottom: 8px solid transparent;
    border-top: 8px solid transparent;
    display: block;
    height: 0;
    left: -7px;
    position: absolute;
    top: 13px;
    width: 0;
}
.timeline-item .timeline-desk .arrow {
    border-right: 8px solid #F4F4F4 !important;
}

.timeline-item.alt .timeline-desk .arrow-alt {
    border-bottom: 8px solid transparent;
    border-top: 8px solid transparent;
    display: block;
    height: 0;
    right: -7px;
    position: absolute;
    top: 13px;
    width: 0;
    left: auto;
}

.timeline-item.alt .timeline-desk .arrow-alt {
    border-left: 8px solid #F4F4F4 !important;
}

.timeline .timeline-icon {
    left: -30px;
    position: absolute;
    top: 15px;
}

.timeline .timeline-icon {
    background: #C7CBD6;
    box-shadow: 0 0 0 3px #C7CBD6;
}

.timeline-desk span a {
    text-transform: uppercase;
}

.timeline-desk h1.red, .timeline-desk span a.red {
    color: #EF6F66;
}

.timeline-desk h1.green, .timeline-desk span a.green  {
    color: #39B6AE;
}
.timeline-desk h1.blue, .timeline-desk span a.blue {
    color: #56C9F5;
}
.timeline-desk h1.purple, .timeline-desk span a.purple {
    color: #8074C6;
}
.timeline-desk h1.light-green, .timeline-desk span a.light-green {
    color: #A8D76F;
}

.timeline .timeline-icon.red {
    background: #EF6F66;
    box-shadow: 0 0 0 3px #EF6F66;
}

.timeline .timeline-icon.green {
    background: #39B6AE;
    box-shadow: 0 0 0 3px #39B6AE;
}

.timeline .timeline-icon.blue {
    background: #56C9F5;
    box-shadow: 0 0 0 3px #56C9F5;
}

.timeline .timeline-icon.purple {
    background: #8074C6;
    box-shadow: 0 0 0 3px #8074C6;
}

.timeline .timeline-icon.light-green {
    background: #A8D76F;
    box-shadow: 0 0 0 3px #A8D76F;
}

.timeline .timeline-icon {
    border: 3px solid #FFFFFF;
    border-radius: 50%;
    -webkit-border-radius: 50%;
       -moz-border-radius: 50%;
        -ms-border-radius: 50%;
         -o-border-radius: 50%;
    display: block;
    height: 6px;
    width: 6px;
}

.timeline-item.alt .timeline-icon {
    left: auto;
    right: -32px;
}

.timeline .time-icon:before {
    font-size: 16px;
    margin-top: 5px;
}
.timeline .timeline-date {
    left: -200px;
    position: absolute;
    text-align: right;
    top: 12px;
    width: 150px;
}

.timeline-desk h5 span {
    color: #999999;
    display: block;
    font-size: 12px;
    margin-bottom: 4px;
}


.timeline-item.alt:before {
    display: none;
}
.timeline-item:before, .timeline-item.alt:after {
    content: "";
    display: block;
    width: 50%;
}

.timeline-desk p {
    font-size: 12px;
    margin-bottom: 0;
}

.timeline-desk a {
    color: #EF6F66;
}

.timeline-desk .panel {
    margin-bottom: 5px;
}

.timeline-desk .album {
    margin-top: 20px;
}

.timeline-desk .album a {
    margin-right: 5px;
    float: left;
}

.timeline-desk .notification {
    background: none repeat scroll 0 0 #FFFFFF;
    margin-top: 20px;
    padding: 8px;
}


.timeline-item.alt .panel {
    margin-left: 0;
    margin-right: 25px;
}

.timeline-item.alt .timeline-date {
    left: auto;
    right: -200px;
    text-align: left;
}

.mbot30 {
    margin-bottom: 30px;
}
</style>

<div class="modal-header">
	<button class="close" data-dismiss="modal">×</button>
	<h3 class="modal-title">{t domain="express"}查看审核{/t}</h3>
</div> 

<div class="modal-body" >
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
