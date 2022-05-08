<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Handles LOGIN authentication.
 *
 * @author Chris Corbyn
 */
class Swift_Transport_Esmtp_Auth_LoginAuthenticator implements Swift_Transport_Esmtp_Authenticator
{
    /**
     * Get the name of the AUTH mechanism this Authenticator handles.
     *
     * @return string
     */
    public function getAuthKeyword()
    {
        return 'LOGIN';
    }

    /**
<<<<<<< HEAD
     * Try to authenticate the user with $username and $password.
     *
     * @param Swift_Transport_SmtpAgent $agent
     * @param string                    $username
     * @param string                    $password
     *
     * @return bool
=======
     * {@inheritdoc}
>>>>>>> v2-test
     */
    public function authenticate(Swift_Transport_SmtpAgent $agent, $username, $password)
    {
        try {
<<<<<<< HEAD
            $agent->executeCommand("AUTH LOGIN\r\n", array(334));
            $agent->executeCommand(sprintf("%s\r\n", base64_encode($username)), array(334));
            $agent->executeCommand(sprintf("%s\r\n", base64_encode($password)), array(235));

            return true;
        } catch (Swift_TransportException $e) {
            $agent->executeCommand("RSET\r\n", array(250));

            return false;
=======
            $agent->executeCommand("AUTH LOGIN\r\n", [334]);
            $agent->executeCommand(sprintf("%s\r\n", base64_encode($username)), [334]);
            $agent->executeCommand(sprintf("%s\r\n", base64_encode($password)), [235]);

            return true;
        } catch (Swift_TransportException $e) {
            $agent->executeCommand("RSET\r\n", [250]);

            throw $e;
>>>>>>> v2-test
        }
    }
}
