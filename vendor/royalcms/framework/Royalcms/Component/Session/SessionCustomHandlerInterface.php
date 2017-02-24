<?php namespace Royalcms\Component\Session;

interface SessionCustomHandlerInterface
{
/**
	 * Initialize session
	 * @link http://www.php.net/manual/en/sessionhandlerinterface.open.php
	 * @param save_path string <p>
	 * The path where to store/retrieve the session.
	 * </p>
	 * @param name string <p>
	 * The session name.
	 * </p>
	 * @return bool &returns.session.storage.retval;
	 */
	public function open ($save_path, $name);

	/**
	 * Close the session
	 * @link http://www.php.net/manual/en/sessionhandlerinterface.close.php
	 * @return bool &returns.session.storage.retval;
	 */
	public function close ();

	/**
	 * Read session data
	 * @link http://www.php.net/manual/en/sessionhandlerinterface.read.php
	 * @param session_id string <p>
	 * The session id.
	 * </p>
	 * @return string an encoded string of the read data. If nothing was read, it must return an empty string. Note this value is returned internally to PHP for processing.
	 */
	public function read ($session_id);

	/**
	 * Write session data
	 * @link http://www.php.net/manual/en/sessionhandlerinterface.write.php
	 * @param session_id string <p>
	 * The session id.
	 * </p>
	 * @param session_data string <p>
	 * The encoded session data. This data is the result of the PHP internally encoding the $_SESSION superglobal to a serialized
	 * string and passing it as this parameter. Please note sessions use an alternative serialization method.
	 * </p>
	 * @return bool &returns.session.storage.retval;
	 */
	public function write ($session_id, $session_data);

	/**
	 * Destroy a session
	 * @link http://www.php.net/manual/en/sessionhandlerinterface.destroy.php
	 * @param session_id string <p>
	 * The session ID being destroyed.
	 * </p>
	 * @return bool &returns.session.storage.retval;
	 */
	public function destroy ($session_id);

	/**
	 * Cleanup old sessions
	 * @link http://www.php.net/manual/en/sessionhandlerinterface.gc.php
	 * @param maxlifetime string <p>
	 * Sessions that have not updated for the last maxlifetime seconds will be removed.
	 * </p>
	 * @return bool &returns.session.storage.retval;
	 */
	public function gc ($maxlifetime);
}

// end