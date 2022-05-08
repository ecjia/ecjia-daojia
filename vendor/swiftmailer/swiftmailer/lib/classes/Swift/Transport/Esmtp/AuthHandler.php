<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
<<<<<<< HEAD
 * An ESMTP handler for AUTH support.
=======
 * An ESMTP handler for AUTH support (RFC 5248).
>>>>>>> v2-test
 *
 * @author Chris Corbyn
 */
class Swift_Transport_Esmtp_AuthHandler implements Swift_Transport_EsmtpHandler
{
    /**
     * Authenticators available to process the request.
     *
     * @var Swift_Transport_Esmtp_Authenticator[]
     */
<<<<<<< HEAD
    private $_authenticators = array();
=======
    private $authenticators = [];
>>>>>>> v2-test

    /**
     * The username for authentication.
     *
     * @var string
     */
<<<<<<< HEAD
    private $_username;
=======
    private $username;
>>>>>>> v2-test

    /**
     * The password for authentication.
     *
     * @var string
     */
<<<<<<< HEAD
    private $_password;
=======
    private $password;
>>>>>>> v2-test

    /**
     * The auth mode for authentication.
     *
     * @var string
     */
<<<<<<< HEAD
    private $_auth_mode;
=======
    private $auth_mode;
>>>>>>> v2-test

    /**
     * The ESMTP AUTH parameters available.
     *
     * @var string[]
     */
<<<<<<< HEAD
    private $_esmtpParams = array();
=======
    private $esmtpParams = [];
>>>>>>> v2-test

    /**
     * Create a new AuthHandler with $authenticators for support.
     *
     * @param Swift_Transport_Esmtp_Authenticator[] $authenticators
     */
    public function __construct(array $authenticators)
    {
        $this->setAuthenticators($authenticators);
    }

    /**
     * Set the Authenticators which can process a login request.
     *
     * @param Swift_Transport_Esmtp_Authenticator[] $authenticators
     */
    public function setAuthenticators(array $authenticators)
    {
<<<<<<< HEAD
        $this->_authenticators = $authenticators;
=======
        $this->authenticators = $authenticators;
>>>>>>> v2-test
    }

    /**
     * Get the Authenticators which can process a login request.
     *
     * @return Swift_Transport_Esmtp_Authenticator[]
     */
    public function getAuthenticators()
    {
<<<<<<< HEAD
        return $this->_authenticators;
=======
        return $this->authenticators;
>>>>>>> v2-test
    }

    /**
     * Set the username to authenticate with.
     *
     * @param string $username
     */
    public function setUsername($username)
    {
<<<<<<< HEAD
        $this->_username = $username;
=======
        $this->username = $username;
>>>>>>> v2-test
    }

    /**
     * Get the username to authenticate with.
     *
     * @return string
     */
    public function getUsername()
    {
<<<<<<< HEAD
        return $this->_username;
=======
        return $this->username;
>>>>>>> v2-test
    }

    /**
     * Set the password to authenticate with.
     *
     * @param string $password
     */
    public function setPassword($password)
    {
<<<<<<< HEAD
        $this->_password = $password;
=======
        $this->password = $password;
>>>>>>> v2-test
    }

    /**
     * Get the password to authenticate with.
     *
     * @return string
     */
    public function getPassword()
    {
<<<<<<< HEAD
        return $this->_password;
=======
        return $this->password;
>>>>>>> v2-test
    }

    /**
     * Set the auth mode to use to authenticate.
     *
     * @param string $mode
     */
    public function setAuthMode($mode)
    {
<<<<<<< HEAD
        $this->_auth_mode = $mode;
=======
        $this->auth_mode = $mode;
>>>>>>> v2-test
    }

    /**
     * Get the auth mode to use to authenticate.
     *
     * @return string
     */
    public function getAuthMode()
    {
<<<<<<< HEAD
        return $this->_auth_mode;
=======
        return $this->auth_mode;
>>>>>>> v2-test
    }

    /**
     * Get the name of the ESMTP extension this handles.
     *
<<<<<<< HEAD
     * @return bool
=======
     * @return string
>>>>>>> v2-test
     */
    public function getHandledKeyword()
    {
        return 'AUTH';
    }

    /**
     * Set the parameters which the EHLO greeting indicated.
     *
     * @param string[] $parameters
     */
    public function setKeywordParams(array $parameters)
    {
<<<<<<< HEAD
        $this->_esmtpParams = $parameters;
=======
        $this->esmtpParams = $parameters;
>>>>>>> v2-test
    }

    /**
     * Runs immediately after a EHLO has been issued.
     *
     * @param Swift_Transport_SmtpAgent $agent to read/write
     */
    public function afterEhlo(Swift_Transport_SmtpAgent $agent)
    {
<<<<<<< HEAD
        if ($this->_username) {
            $count = 0;
            foreach ($this->_getAuthenticatorsForAgent() as $authenticator) {
                if (in_array(strtolower($authenticator->getAuthKeyword()),
                    array_map('strtolower', $this->_esmtpParams))) {
                    ++$count;
                    if ($authenticator->authenticate($agent, $this->_username, $this->_password)) {
                        return;
                    }
                }
            }
            throw new Swift_TransportException(
                'Failed to authenticate on SMTP server with username "'.
                $this->_username.'" using '.$count.' possible authenticators'
                );
=======
        if ($this->username) {
            $count = 0;
            $errors = [];
            foreach ($this->getAuthenticatorsForAgent() as $authenticator) {
                if (\in_array(strtolower($authenticator->getAuthKeyword()), array_map('strtolower', $this->esmtpParams))) {
                    ++$count;
                    try {
                        if ($authenticator->authenticate($agent, $this->username, $this->password)) {
                            return;
                        }
                    } catch (Swift_TransportException $e) {
                        // keep the error message, but tries the other authenticators
                        $errors[] = [$authenticator->getAuthKeyword(), $e->getMessage()];
                    }
                }
            }

            $message = 'Failed to authenticate on SMTP server with username "'.$this->username.'" using '.$count.' possible authenticators.';
            foreach ($errors as $error) {
                $message .= ' Authenticator '.$error[0].' returned '.$error[1].'.';
            }
            throw new Swift_TransportException($message);
>>>>>>> v2-test
        }
    }

    /**
     * Not used.
     */
    public function getMailParams()
    {
<<<<<<< HEAD
        return array();
=======
        return [];
>>>>>>> v2-test
    }

    /**
     * Not used.
     */
    public function getRcptParams()
    {
<<<<<<< HEAD
        return array();
=======
        return [];
>>>>>>> v2-test
    }

    /**
     * Not used.
     */
<<<<<<< HEAD
    public function onCommand(Swift_Transport_SmtpAgent $agent, $command, $codes = array(), &$failedRecipients = null, &$stop = false)
=======
    public function onCommand(Swift_Transport_SmtpAgent $agent, $command, $codes = [], &$failedRecipients = null, &$stop = false)
>>>>>>> v2-test
    {
    }

    /**
     * Returns +1, -1 or 0 according to the rules for usort().
     *
     * This method is called to ensure extensions can be execute in an appropriate order.
     *
     * @param string $esmtpKeyword to compare with
     *
     * @return int
     */
    public function getPriorityOver($esmtpKeyword)
    {
        return 0;
    }

    /**
     * Returns an array of method names which are exposed to the Esmtp class.
     *
     * @return string[]
     */
    public function exposeMixinMethods()
    {
<<<<<<< HEAD
        return array('setUsername', 'getUsername', 'setPassword', 'getPassword', 'setAuthMode', 'getAuthMode');
=======
        return ['setUsername', 'getUsername', 'setPassword', 'getPassword', 'setAuthMode', 'getAuthMode'];
>>>>>>> v2-test
    }

    /**
     * Not used.
     */
    public function resetState()
    {
    }

    /**
     * Returns the authenticator list for the given agent.
     *
<<<<<<< HEAD
     * @param Swift_Transport_SmtpAgent $agent
     *
     * @return array
     */
    protected function _getAuthenticatorsForAgent()
    {
        if (!$mode = strtolower($this->_auth_mode)) {
            return $this->_authenticators;
        }

        foreach ($this->_authenticators as $authenticator) {
            if (strtolower($authenticator->getAuthKeyword()) == $mode) {
                return array($authenticator);
=======
     * @return array
     */
    protected function getAuthenticatorsForAgent()
    {
        if (!$mode = strtolower($this->auth_mode)) {
            return $this->authenticators;
        }

        foreach ($this->authenticators as $authenticator) {
            if (strtolower($authenticator->getAuthKeyword()) == $mode) {
                return [$authenticator];
>>>>>>> v2-test
            }
        }

        throw new Swift_TransportException('Auth mode '.$mode.' is invalid');
    }
}
