<?php namespace Royalcms\Component\WeChat;

/**
 * @file
 *
 * ErrorCode
 */

class ErrorCode {
    public static $OK                     = 0;
    public static $ValidateSignatureError = -40001; //签名验证错误
    public static $ParseXmlError          = -40002; //xml解析失败
    public static $ComputeSignatureError  = -40003; //sha加密生成签名失败
    public static $IllegalAesKey          = -40004; //encodingAesKey非法
    public static $ValidateAppidError     = -40005; //appid校验错误
    public static $EncryptAESError        = -40006; //AES加密失败
    public static $DecryptAESError        = -40007; //AES解密失败
    public static $IllegalBuffer          = -40008; //解密后得到的buffer非法
    public static $EncodeBase64Error      = -40009; //base64加密失败
    public static $DecodeBase64Error      = -40010; //base64解密失败
    public static $GenReturnXmlError      = -40011; //生成xml失败
}