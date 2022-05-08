<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/7/17
 * Time: 3:18 PM
 */

namespace Royalcms\Component\Foundation\Compatible;

use Throwable;
/**
 * Error is the base class for all internal PHP error exceptions.
 * @link http://php.net/manual/en/class.error.php
 * @since 7.0
 */
class Error implements Throwable {

    /**
     * Construct the error object.
     * @link http://php.net/manual/en/error.construct.php
     * @param string $message [optional] The Error message to throw.
     * @param int $code [optional] The Error code.
     * @param Throwable $previous [optional] The previous throwable used for the exception chaining.
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
    }

    /***
     * Gets the message
     * @link http://php.net/manual/en/throwable.getmessage.php
     * @return string
     * @since 7.0
     */
    public function getMessage()
    {
    }

    /**
     * Gets the exception code
     * @link http://php.net/manual/en/throwable.getcode.php
     * @return int <p>
     * Returns the exception code as integer in
     * {@see Exception} but possibly as other type in
     * {@see Exception} descendants (for example as
     * string in {@see PDOException}).
     * </p>
     * @since 7.0
     */
    public function getCode(){}


    /**
     * Gets the file in which the exception occurred
     * @link http://php.net/manual/en/throwable.getfile.php
     * @return string Returns the name of the file from which the object was thrown.
     * @since 7.0
     */
    public function getFile(){}


    /**
     * Gets the line on which the object was instantiated
     * @link http://php.net/manual/en/throwable.getline.php
     * @return int Returns the line number where the thrown object was instantiated.
     * @since 7.0
     */
    public  function getLine(){}


    /**
     * Gets the stack trace
     * @link http://php.net/manual/en/throwable.gettrace.php
     * @return array <p>
     * Returns the stack trace as an array in the same format as
     * {@see debug_backtrace()}.
     * </p>
     * @since 7.0
     */
    public function getTrace(){}

    /**
     * Gets the stack trace as a string
     * @link http://php.net/manual/en/throwable.gettraceasstring.php
     * @return string Returns the stack trace as a string.
     * @since 7.0
     */
    public function getTraceAsString(){}

    /**
     * Returns the previous Throwable
     * @link http://php.net/manual/en/throwable.getprevious.php
     * @return Throwable Returns the previous {@see Throwable} if available, or <b>NULL</b> otherwise.
     * @since 7.0
     */
    public function getPrevious(){}
    /**
     * Gets a string representation of the thrown object
     * @link http://php.net/manual/en/throwable.tostring.php
     * @return string <p>Returns the string representation of the thrown object.</p>
     * @since 7.0
     */
    public function __toString(){}
}