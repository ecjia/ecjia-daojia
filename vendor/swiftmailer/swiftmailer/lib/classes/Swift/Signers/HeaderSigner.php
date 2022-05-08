<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Header Signer Interface used to apply Header-Based Signature to a message.
 *
 * @author Xavier De Cock <xdecock@gmail.com>
 */
interface Swift_Signers_HeaderSigner extends Swift_Signer, Swift_InputByteStream
{
    /**
     * Exclude an header from the signed headers.
     *
     * @param string $header_name
     *
<<<<<<< HEAD
     * @return Swift_Signers_HeaderSigner
=======
     * @return self
>>>>>>> v2-test
     */
    public function ignoreHeader($header_name);

    /**
     * Prepare the Signer to get a new Body.
     *
<<<<<<< HEAD
     * @return Swift_Signers_HeaderSigner
=======
     * @return self
>>>>>>> v2-test
     */
    public function startBody();

    /**
     * Give the signal that the body has finished streaming.
     *
<<<<<<< HEAD
     * @return Swift_Signers_HeaderSigner
=======
     * @return self
>>>>>>> v2-test
     */
    public function endBody();

    /**
     * Give the headers already given.
     *
<<<<<<< HEAD
     * @param Swift_Mime_SimpleHeaderSet $headers
     *
     * @return Swift_Signers_HeaderSigner
     */
    public function setHeaders(Swift_Mime_HeaderSet $headers);
=======
     * @return self
     */
    public function setHeaders(Swift_Mime_SimpleHeaderSet $headers);
>>>>>>> v2-test

    /**
     * Add the header(s) to the headerSet.
     *
<<<<<<< HEAD
     * @param Swift_Mime_HeaderSet $headers
     *
     * @return Swift_Signers_HeaderSigner
     */
    public function addSignature(Swift_Mime_HeaderSet $headers);
=======
     * @return self
     */
    public function addSignature(Swift_Mime_SimpleHeaderSet $headers);
>>>>>>> v2-test

    /**
     * Return the list of header a signer might tamper.
     *
     * @return array
     */
    public function getAlteredHeaders();
}
