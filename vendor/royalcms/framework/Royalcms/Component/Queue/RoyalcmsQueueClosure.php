<?php

class RoyalcmsQueueClosure {

	/**
	 * Fire the Closure based queue job.
	 *
	 * @param  \Royalcms\Component\Queue\Jobs\Job  $job
	 * @param  array  $data
	 * @return void
	 */
	public function fire($job, $data)
	{
		$closure = unserialize($data['closure']);

		$closure($job);
	}

}
