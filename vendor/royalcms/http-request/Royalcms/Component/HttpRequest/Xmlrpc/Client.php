<?php

namespace Royalcms\Component\HttpRequest\Xmlrpc;

use Royalcms\Component\Xmlrpc\Client as IXRClient;
use Royalcms\Component\Xmlrpc\Request;
use Royalcms\Component\Xmlrpc\Error;
use Royalcms\Component\Xmlrpc\Message;
use RC_Error;
use RC_Hook;
use Royalcms\Component\HttpRequest\HttpRequest;

/**
 * @since 3.1.0
 */
class Client extends IXRClient {
	public $scheme;
	/**
	 * @var IXR_Error
	 */
	public $error;

	/**
	 * @param string $server
	 * @param string|bool $path
	 * @param int|bool $port
	 * @param int $timeout
	 */
	public function __construct($server, $path = false, $port = false, $timeout = 15) {
		if ( ! $path ) {
			// Assume we have been given a URL instead
			$bits = parse_url($server);
			$this->scheme = $bits['scheme'];
			$this->server = $bits['host'];
			$this->port = isset($bits['port']) ? $bits['port'] : $port;
			$this->path = !empty($bits['path']) ? $bits['path'] : '/';

			// Make absolutely sure we have a path
			if ( ! $this->path ) {
				$this->path = '/';
			}

			if ( ! empty( $bits['query'] ) ) {
				$this->path .= '?' . $bits['query'];
			}
		} else {
			$this->scheme = 'http';
			$this->server = $server;
			$this->path = $path;
			$this->port = $port;
		}
		$this->useragent = 'The Royalcms XML-RPC PHP Library';
		$this->timeout = $timeout;
	}

	/**
	 * @return bool
	 */
	public function query() {
		$args = func_get_args();
		$method = array_shift($args);
		$request = new Request($method, $args);
		$xml = $request->getXml();

		$port = $this->port ? ":$this->port" : '';
		$url = $this->scheme . '://' . $this->server . $port . $this->path;
		$args = array(
			'headers'    => array('Content-Type' => 'text/xml'),
			'user-agent' => $this->useragent,
			'body'       => $xml,
		);

		// Merge Custom headers ala #8145
		foreach ( $this->headers as $header => $value ) {
			$args['headers'][$header] = $value;
		}

		/**
		 * Filters the headers collection to be sent to the XML-RPC server.
		 *
		 * @since 4.4.0
		 *
		 * @param array $headers Array of headers to be sent.
		 */
		$args['headers'] = RC_Hook::apply_filters( 'rc_http_xmlrpc_client_headers', $args['headers'] );

		if ( $this->timeout !== false ) {
			$args['timeout'] = $this->timeout;
		}

		// Now send the request
		if ( $this->debug ) {
			echo '<pre class="ixr_request">' . htmlspecialchars($xml) . "\n</pre>\n\n";
		}

		$response = HttpRequest::remote_post($url, $args);

		if ( RC_Error::is_error($response) ) {
			$errno    = $response->get_error_code();
			$errorstr = $response->get_error_message();
			$this->error = new Error(-32300, "transport error: $errno $errorstr");
			return false;
		}

		if ( 200 != HttpRequest::remote_retrieve_response_code( $response ) ) {
			$this->error = new Error(-32301, 'transport error - HTTP status code was not 200 (' . HttpRequest::remote_retrieve_response_code( $response ) . ')');
			return false;
		}

		if ( $this->debug ) {
			echo '<pre class="ixr_response">' . htmlspecialchars( HttpRequest::remote_retrieve_body( $response ) ) . "\n</pre>\n\n";
		}

		// Now parse what we've got back
		$this->message = new Message( HttpRequest::remote_retrieve_body( $response ) );
		if ( ! $this->message->parse() ) {
			// XML error
			$this->error = new Error(-32700, 'parse error. not well formed');
			return false;
		}

		// Is the message a fault?
		if ( $this->message->messageType == 'fault' ) {
			$this->error = new Error($this->message->faultCode, $this->message->faultString);
			return false;
		}

		// Message must be OK
		return true;
	}
}
