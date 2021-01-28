<?php


namespace Ecjia\System\Hookers;


class AdminDashboardHeaderCodesAction
{

    /**
     * Handle the event.
     * hook:admin_dashboard_header_codes
     * @return void
     */
    public function handle()
    {

        echo <<<EOF
	<div class="modal hide fade" id="myMail">
		<div class="modal-header">
			<button class="close" data-dismiss="modal">×</button>
			<h3>New messages</h3>
		</div>
		<div class="modal-body">
			<div class="alert alert-info">In this table jquery plugin turns a table row into a clickable link.</div>
			<table class="table table-condensed table-striped" data-provides="rowlink">
				<thead>
					<tr>
						<th>Sender</th>
						<th>Subject</th>
						<th>Date</th>
						<th>Size</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Declan Pamphlett</td>
						<td><a href="javascript:void(0)">Lorem ipsum dolor sit amet</a></td>
						<td>23/05/2012</td>
						<td>25KB</td>
					</tr>
					<tr>
						<td>Erin Church</td>
						<td><a href="javascript:void(0)">Lorem ipsum dolor sit amet</a></td>
						<td>24/05/2012</td>
						<td>15KB</td>
					</tr>
					<tr>
						<td>Koby Auld</td>
						<td><a href="javascript:void(0)">Lorem ipsum dolor sit amet</a></td>
						<td>25/05/2012</td>
						<td>28KB</td>
					</tr>
					<tr>
						<td>Anthony Pound</td>
						<td><a href="javascript:void(0)">Lorem ipsum dolor sit amet</a></td>
						<td>25/05/2012</td>
						<td>33KB</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="modal-footer">
			<a href="javascript:void(0)" class="btn">Go to mailbox</a>
		</div>
	</div>
	<div class="modal hide fade" id="myTasks">
		<div class="modal-header">
			<button class="close" data-dismiss="modal">×</button>
			<h3>New Tasks</h3>
		</div>
		<div class="modal-body">
			<div class="alert alert-info">In this table jquery plugin turns a table row into a clickable link.</div>
			<table class="table table-condensed table-striped" data-provides="rowlink">
				<thead>
					<tr>
						<th>id</th>
						<th>Summary</th>
						<th>Updated</th>
						<th>Priority</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>P-23</td>
						<td><a href="javascript:void(0)">Admin should not break if URL&hellip;</a></td>
						<td>23/05/2012</td>
						<td class="tac"><span class="label label-important">High</span></td>
						<td>Open</td>
					</tr>
					<tr>
						<td>P-18</td>
						<td><a href="javascript:void(0)">Displaying submenus in custom&hellip;</a></td>
						<td>22/05/2012</td>
						<td class="tac"><span class="label label-warning">Medium</span></td>
						<td>Reopen</td>
					</tr>
					<tr>
						<td>P-25</td>
						<td><a href="javascript:void(0)">Featured image on post types&hellip;</a></td>
						<td>22/05/2012</td>
						<td class="tac"><span class="label label-success">Low</span></td>
						<td>Updated</td>
					</tr>
					<tr>
						<td>P-10</td>
						<td><a href="javascript:void(0)">Multiple feed fixes and&hellip;</a></td>
						<td>17/05/2012</td>
						<td class="tac"><span class="label label-warning">Medium</span></td>
						<td>Open</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="modal-footer">
			<a href="javascript:void(0)" class="btn">Go to task manager</a>
		</div>
	</div>	
EOF;

    }

}