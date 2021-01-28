<?php


namespace Ecjia\App\Api\Jobs;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TestDumpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var array $request
     */
    protected $request;

    /**
     * Create a new job instance.
     *
     * @param array $request
     */
    public function __construct(array $request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data['x-original-uri']    = array_get($this->request, 'x-original-uri.0', $this->request['REQUEST_URI']);
        $data['x-scheme']          = array_get($this->request, 'x-scheme.0', $this->request['REQUEST_SCHEME']);
        $data['x-forwarded-proto'] = array_get($this->request, 'x-forwarded-proto.0', $this->request['REQUEST_SCHEME']);
        $data['x-forwarded-port']  = array_get($this->request, 'x-forwarded-port.0', $this->request['SERVER_PORT']);
        $data['x-forwarded-host']  = array_get($this->request, 'x-forwarded-host.0', $this->request['host']);
        $data['x-forwarded-for']   = array_get($this->request, 'x-forwarded-for.0', $this->request['REMOTE_ADDR']);
        $data['x-real-ip']         = array_get($this->request, 'x-real-ip.0', $this->request['REMOTE_ADDR']);
        $data['x-request-id']      = array_get($this->request, 'x-request-id.0');
        $data['host']              = array_get($this->request, 'host.0', $this->request['SERVER_NAME']);
        $data['referer']           = array_get($this->request, 'referer.0');
        $data['request-method']    = array_get($this->request, 'REQUEST_METHOD');
        $data['device-udid']       = array_get($this->request, 'device-udid.0');
        $data['device-sn']         = array_get($this->request, 'device-sn.0');
        $data['content-type']      = array_get($this->request, 'content-type.0');
        $data['api-version']       = array_get($this->request, 'api-version.0');
        $data['device-code']       = array_get($this->request, 'device-code.0');
        $data['device-client']     = array_get($this->request, 'device-client.0');
        $data['user-agent']        = array_get($this->request, 'user-agent.0');
        $data['content-length']    = array_get($this->request, 'content-length.0');
        $data['url']               = array_get($this->request, 'url');
        $data['timestamp']         = array_get($this->request, 'timestamp', $this->request['REQUEST_TIME']);

        $id      = $data['device-udid'] ?: $data['x-request-id'];
        $url     = $data['url'] ?: $data['x-original-uri'];
        $message = sprintf("%s: %s", $id, $url);

        try {
            \RC_Log::driver('elastic')->info($message, $data);
        } catch (\Exception $e) {
            dump($e);
        }

        echo $message . PHP_EOL;
    }

}