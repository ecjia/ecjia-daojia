<?php namespace Royalcms\Component\Foundation;
defined('IN_ROYALCMS') or exit('No permission resources.');

class Kses extends RoyalcmsObject {

    /**
     * function kses
     * 
     * This function makes sure that only the allowed HTML element names, attribute
     * names and attribute values plus only sane HTML entities will occur in
     * $string. You have to remove any slashes from PHP's magic quotes before you
     * call this function.
     */
    public static function kses($string, $allowed_html, $allowed_protocols =
               array('http', 'https', 'ftp', 'news', 'nntp', 'telnet',
                     'gopher', 'mailto'))
    {
      $string = self::no_null($string);
      $string = self::js_entities($string);
      $string = self::normalize_entities($string);
      $string = self::hook($string);
      $allowed_html_fixed = self::array_lc($allowed_html);
      return self::split($string, $allowed_html_fixed, $allowed_protocols);
    }
    
    /**
     * function kses_hook
     * 
     * You add any kses hooks here.
     */
    public static function hook($string)
    {
        return $string;
    }
    
    
    /**
     * function kses_version
     * 
     * This function returns kses' version number.
     * @return string
     */
    public static function version()
    {
        return '0.2.2';
    }
    
    
    /**
     * function kses_split
     * 
     * This function searches for HTML tags, no matter how malformed. It also
     * matches stray ">" characters.
     */
    public static function split($string, $allowed_html, $allowed_protocols)
    {
        /*
        return preg_replace('%(<'.   # EITHER: <
            '[^>]*'. # things that aren't >
            '(>|$)'. # > or end of string
            '|>)%e', # OR: just a >
            "RC_Kses::split2('\\1', \$allowed_html, ".
            '$allowed_protocols)',
            $string);
        */
//         return preg_replace_callback('%(<'.   # EITHER: <
//             '[^>]*'. # things that aren't >
//             '(>|$)'. # > or end of string
//             '|>)%', # OR: just a >
//             function ($matches) {
//                 return 'RC_Kses::split2($matches[1], \$allowed_html, $allowed_protocols)';
//             },
//             $string);
        
        global $pass_allowed_html, $pass_allowed_protocols;
        $pass_allowed_html = $allowed_html;
        $pass_allowed_protocols = $allowed_protocols;
        return preg_replace_callback( '%(<!--.*?(-->|$))|(<[^>]*(>|$)|>)%', array(__CLASS__, '_split_callback'), $string );
        
    }
    
    /**
     * Callback for wp_kses_split.
     *
     * @since 3.1.0
     * @access private
     *
     * @global array $pass_allowed_html
     * @global array $pass_allowed_protocols
     *
     * @return string
     */
    public static function _split_callback( $match ) {
        global $pass_allowed_html, $pass_allowed_protocols;
        return self::split2( $match[0], $pass_allowed_html, $pass_allowed_protocols );
    }
    
    
    /**
     * function kses_split2
     * 
     * This function does a lot of work. It rejects some very malformed things
     * like <:::>. It returns an empty string, if the element isn't allowed (look
        # ma, no strip_tags()!). Otherwise it splits the tag into an element and an
        attribute list.
     */ 
    public static function split2($string, $allowed_html, $allowed_protocols)
    {
        $string = self::stripslashes($string);
    
        if (substr($string, 0, 1) != '<')
            return '&gt;';
        # It matched a ">" character
    
        if (!preg_match('%^<\s*(/\s*)?([a-zA-Z0-9]+)([^>]*)>?$%', $string, $matches))
            return '';
        # It's seriously malformed
    
        $slash = trim($matches[1]);
        $elem = $matches[2];
        $attrlist = $matches[3];
    
        if (!@isset($allowed_html[strtolower($elem)]))
            return '';
        # They are using a not allowed HTML element
    
        if ($slash != '')
            return "<$slash$elem>";
        # No attributes are allowed for closing elements
    
        return self::attr("$slash$elem", $attrlist, $allowed_html,
        $allowed_protocols);
    }
    
    
    /**
     * function kses_attr
     * 
     * This function removes all attributes, if none are allowed for this element.
     * If some are allowed it calls kses_hair() to split them further, and then it
     * builds up new HTML code from the data that kses_hair() returns. It also
     * removes "<" and ">" characters, if there are any left. One more thing it
     * does is to check if the tag has a closing XHTML slash, and if it does,
     * it puts one in the returned code as well.
     */
    public static function attr($element, $attr, $allowed_html, $allowed_protocols)
    {
        # Is there a closing XHTML slash at the end of the attributes?
    
        $xhtml_slash = '';
        if (preg_match('%\s/\s*$%', $attr))
            $xhtml_slash = ' /';
    
        # Are any attributes allowed at all for this element?
    
        if (@count($allowed_html[strtolower($element)]) == 0)
            return "<$element$xhtml_slash>";
    
        # Split it
    
        $attrarr = self::hair($attr, $allowed_protocols);
    
        # Go through $attrarr, and save the allowed attributes for this element
        # in $attr2
    
        $attr2 = '';
    
        foreach ($attrarr as $arreach)
        {
        if (!@isset($allowed_html[strtolower($element)]
            [strtolower($arreach['name'])]))
            continue; # the attribute is not allowed
    
        $current = $allowed_html[strtolower($element)]
        [strtolower($arreach['name'])];
    
        if (!is_array($current))
        $attr2 .= ' '.$arreach['whole'];
        # there are no checks
    
        else
        {
        # there are some checks
            $ok = true;
            foreach ($current as $currkey => $currval)
            if (!self::check_attr_val($arreach['value'], $arreach['vless'],
                $currkey, $currval))
            { $ok = false; break; }
    
            if ($ok)
                $attr2 .= ' '.$arreach['whole']; # it passed them
        } # if !is_array($current)
        } # foreach
    
        # Remove any "<" or ">" characters
    
        $attr2 = preg_replace('/[<>]/', '', $attr2);
    
        return "<$element$attr2$xhtml_slash>";
    }
    
    
    /**
     * function kses_hair
     * 
     * This function does a lot of work. It parses an attribute list into an array
     * with attribute data, and tries to do the right thing even if it gets weird
     * input. It will add quotes around attribute values that don't have any quotes
     * or apostrophes around them, to make it easier to produce HTML code that will
     * conform to W3C's HTML specification. It will also remove bad URL protocols
     * from attribute values.
     */ 
    public static function hair($attr, $allowed_protocols)
    {
        $attrarr = array();
        $mode = 0;
        $attrname = '';
    
        # Loop through the whole attribute list
    
        while (strlen($attr) != 0)
        {
            $working = 0; # Was the last operation successful?
    
            switch ($mode)
            {
            	case 0: # attribute name, href for instance
    
            	    if (preg_match('/^([-a-zA-Z]+)/', $attr, $match))
            	    {
            	        $attrname = $match[1];
            	        $working = $mode = 1;
            	        $attr = preg_replace('/^[-a-zA-Z]+/', '', $attr);
            	    }
    
            	    break;
    
            	case 1: # equals sign or valueless ("selected")
    
            	    if (preg_match('/^\s*=\s*/', $attr)) # equals sign
            	    {
            	        $working = 1; $mode = 2;
            	        $attr = preg_replace('/^\s*=\s*/', '', $attr);
            	        break;
            	    }
    
            	    if (preg_match('/^\s+/', $attr)) # valueless
            	    {
            	        $working = 1; $mode = 0;
            	        $attrarr[] = array
            	        ('name'  => $attrname,
            	            'value' => '',
            	            'whole' => $attrname,
            	            'vless' => 'y');
            	        $attr = preg_replace('/^\s+/', '', $attr);
            	    }
    
            	    break;
    
            	case 2: # attribute value, a URL after href= for instance
    
            	    if (preg_match('/^"([^"]*)"(\s+|$)/', $attr, $match))
            	        # "value"
            	    {
            	        $thisval = self::bad_protocol($match[1], $allowed_protocols);
    
            	        $attrarr[] = array
            	        ('name'  => $attrname,
            	            'value' => $thisval,
            	            'whole' => "$attrname=\"$thisval\"",
            	            'vless' => 'n');
            	        $working = 1; $mode = 0;
            	        $attr = preg_replace('/^"[^"]*"(\s+|$)/', '', $attr);
            	        break;
            	    }
    
            	    if (preg_match("/^'([^']*)'(\s+|$)/", $attr, $match))
            	        # 'value'
            	    {
            	        $thisval = self::bad_protocol($match[1], $allowed_protocols);
    
            	        $attrarr[] = array
            	        ('name'  => $attrname,
            	            'value' => $thisval,
            	            'whole' => "$attrname='$thisval'",
            	            'vless' => 'n');
            	        $working = 1; $mode = 0;
            	        $attr = preg_replace("/^'[^']*'(\s+|$)/", '', $attr);
            	        break;
            	    }
    
            	    if (preg_match("%^([^\s\"']+)(\s+|$)%", $attr, $match))
            	        # value
            	    {
            	        $thisval = self::bad_protocol($match[1], $allowed_protocols);
    
            	        $attrarr[] = array
            	        ('name'  => $attrname,
            	            'value' => $thisval,
            	            'whole' => "$attrname=\"$thisval\"",
            	            'vless' => 'n');
            	        # We add quotes to conform to W3C's HTML spec.
            	        $working = 1; $mode = 0;
            	        $attr = preg_replace("%^[^\s\"']+(\s+|$)%", '', $attr);
            	    }
    
            	    break;
            } # switch
    
            if ($working == 0) # not well formed, remove and try again
                {
                $attr = self::html_error($attr);
                $mode = 0;
        }
    } # while
    
    if ($mode == 1)
        # special case, for when the attribute list ends with a valueless
        # attribute like "selected"
        $attrarr[] = array
        (
            'name'  => $attrname,
            'value' => '',
            'whole' => $attrname,
            'vless' => 'y'
        );
    
        return $attrarr;
    }
    
    
    /**
     * function kses_check_attr_val
     * 
     * This function performs different checks for attribute values. The currently
     * implemented checks are "maxlen", "minlen", "maxval", "minval" and "valueless"
     * with even more checks to come soon.
     */ 
    public static function check_attr_val($value, $vless, $checkname, $checkvalue)
    {
        $ok = true;
    
        switch (strtolower($checkname))
        {
        	case 'maxlen':
        	    # The maxlen check makes sure that the attribute value has a length not
        	    # greater than the given value. This can be used to avoid Buffer Overflows
        	    # in WWW clients and various Internet servers.
    
        	    if (strlen($value) > $checkvalue)
        	        $ok = false;
        	    break;
    
        	case 'minlen':
        	    # The minlen check makes sure that the attribute value has a length not
        	    # smaller than the given value.
    
        	    if (strlen($value) < $checkvalue)
        	        $ok = false;
        	    break;
    
        	case 'maxval':
        	    # The maxval check does two things: it checks that the attribute value is
        	    # an integer from 0 and up, without an excessive amount of zeroes or
        	    # whitespace (to avoid Buffer Overflows). It also checks that the attribute
        	    # value is not greater than the given value.
        	    # This check can be used to avoid Denial of Service attacks.
    
        	    if (!preg_match('/^\s{0,6}[0-9]{1,6}\s{0,6}$/', $value))
        	        $ok = false;
        	    if ($value > $checkvalue)
        	        $ok = false;
        	    break;
    
        	case 'minval':
        	    # The minval check checks that the attribute value is a positive integer,
        	    # and that it is not smaller than the given value.
    
        	    if (!preg_match('/^\s{0,6}[0-9]{1,6}\s{0,6}$/', $value))
        	        $ok = false;
        	    if ($value < $checkvalue)
        	        $ok = false;
        	    break;
    
        	case 'valueless':
        	    # The valueless check checks if the attribute has a value
        	    # (like <a href="blah">) or not (<option selected>). If the given value
        	    # is a "y" or a "Y", the attribute must not have a value.
        	    # If the given value is an "n" or an "N", the attribute must have one.
    
        	    if (strtolower($checkvalue) != $vless)
        	        $ok = false;
        	    break;
        } # switch
    
        return $ok;
    }
    
    
    /**
     * function kses_bad_protocol
     * 
     * This function removes all non-allowed protocols from the beginning of
     * $string. It ignores whitespace and the case of the letters, and it does
     * understand HTML entities. It does its work in a while loop, so it won't be
     * fooled by a string like "javascript:javascript:alert(57)".
     */ 
    public static function bad_protocol($string, $allowed_protocols)
    {
        $string = self::no_null($string);
        $string = preg_replace('/\xad+/', '', $string); # deals with Opera "feature"
        $string2 = $string.'a';
    
        while ($string != $string2)
        {
            $string2 = $string;
            $string = self::bad_protocol_once($string, $allowed_protocols);
        } # while
    
        return $string;
    }
    
    
    /**
     * function kses_no_null
     * 
     * Removes any invalid control characters in $string.
     *
     * Also removes any instance of the '\0' string.
     * 
     * This function removes any NULL characters in $string.
     * @since 1.0.0
     * @param string $string
     * @param array $options Set 'slash_zero' => 'keep' when '\0' is allowed. Default is 'remove'.
     * @return string
     */ 
    public static function no_null($string, $options = null)
    {
        if ( ! isset( $options['slash_zero'] ) ) {
    		$options = array( 'slash_zero' => 'remove' );
    	}
    
    	$string = preg_replace( '/[\x00-\x08\x0B\x0C\x0E-\x1F]/', '', $string );
    	if ( 'remove' == $options['slash_zero'] ) {
    		$string = preg_replace( '/\\\\+0+/', '', $string );
    	}
    
    	return $string;
    } 
    
    
    /**
     * function kses_stripslashes
     * 
     * This function changes the character sequence  \"  to just  "
     * It leaves all other slashes alone. It's really weird, but the quoting from
     * preg_replace(//e) seems to require this.
     */ 
    public static function stripslashes($string)
    {
        return preg_replace('%\\\\"%', '"', $string);
    }
    
    
    
    /**
     * function kses_array_lc
     * 
     * This function goes through an array, and changes the keys to all lower case.
     */ 
    public static function array_lc($inarray)
    {
        $outarray = array();
    
        foreach ($inarray as $inkey => $inval)
        {
            $outkey = strtolower($inkey);
            $outarray[$outkey] = array();
            
            if (is_array($inval)) {
                foreach ($inval as $inkey2 => $inval2)
                {
                    $outkey2 = strtolower($inkey2);
                    $outarray[$outkey][$outkey2] = $inval2;
                } # foreach $inval
            }
            
        } # foreach $inarray
    
        return $outarray;
    }
    
    
    
    /**
     * function kses_js_entities
     * 
     * This function removes the HTML JavaScript entities found in early versions of
     * Netscape 4.
     */ 
    public static function js_entities($string)
    {
        return preg_replace('%&\s*\{[^}]*(\}\s*;?|$)%', '', $string);
    }
    
    
    /**
     * function kses_html_error
     * 
     * This function deals with parsing errors in kses_hair(). The general plan is
     * to remove everything to and including some whitespace, but it deals with
     * quotes and apostrophes as well.
     */ 
    public static function html_error($string)
    {
        return preg_replace('/^("[^"]*("|$)|\'[^\']*(\'|$)|\S)*\s*/', '', $string);
    }
    
    
    /**
     * function kses_bad_protocol_once
     * 
     * This function searches for URL protocols at the beginning of $string, while
     * handling whitespace and HTML entities.
     */ 
    public static function bad_protocol_once($string, $allowed_protocols)
    {
//         return preg_replace('/^((&[^;]*;|[\sA-Za-z0-9])*)'.
//             '(:|&#58;|&#[Xx]3[Aa];)\s*/e',
//             'RC_Kses::bad_protocol_once2("\\1", $allowed_protocols)',
//             $string);
        
//         return preg_replace_callback('/^((&[^;]*;|[\sA-Za-z0-9])*)'.
//             '(:|&#58;|&#[Xx]3[Aa];)\s*/',
//             function ($matches) {
//                 return "\RC_Kses::bad_protocol_once2($matches[1], $allowed_protocols)";
//             },
//             $string);
        
        
        $string2 = preg_split( '/:|&#0*58;|&#x0*3a;/i', $string, 2 );
        if ( isset($string2[1]) && ! preg_match('%/\?%', $string2[0]) ) {
            $string = trim( $string2[1] );
            $protocol = self::bad_protocol_once2( $string2[0], $allowed_protocols );
           
            $string = $protocol . $string;
        }
        
        return $string;
    }
    
    
    
    /**
     * function kses_bad_protocol_once2
     * 
     * This function processes URL protocols, checks to see if they're in the white-
     * list or not, and returns different data depending on the answer.
     * @param unknown $string
     * @param unknown $allowed_protocols
     * @return string
     */
    public static function bad_protocol_once2($string, $allowed_protocols)
    {
        $string2 = self::decode_entities($string);
        $string2 = preg_replace('/\s/', '', $string2);
        $string2 = self::no_null($string2);
        $string2 = preg_replace('/\xad+/', '', $string2);
        # deals with Opera "feature"
        $string2 = strtolower($string2);
    
        $allowed = false;
        foreach ($allowed_protocols as $one_protocol)
        if (strtolower($one_protocol) == $string2)
        {
            $allowed = true;
            break;
        }
    
        if ($allowed)
            return "$string2:";
            else
            return '';
    }
    
    
    /**
     * function kses_normalize_entities
     * 
     * This function normalizes HTML entities. It will convert "AT&T" to the correct
     * "AT&amp;T", "&#00058;" to "&#58;", "&#XYZZY;" to "&amp;#XYZZY;" and so on.
     * 
     * @param unknown $string
     * @return mixed
     */
    public static function normalize_entities($string)
    {
        # Disarm all entities by converting & to &amp;
    
        $string = str_replace('&', '&amp;', $string);
    
        # Change back the allowed entities in our entity whitelist
    
//         $string = preg_replace('/&amp;([A-Za-z][A-Za-z0-9]{0,19});/',
//         '&\\1;', $string);
// //         $string = preg_replace('/&amp;#0*([0-9]{1,5});/e',
// //             'kses_normalize_entities2("\\1")', $string);
        
//         $string = preg_replace_callback('/&amp;#0*([0-9]{1,5});/',
//             function ($matches) {
//                 return 'self::normalize_entities2($matches[1])';
//             },
//             $string);
        
//         $string = preg_replace('/&amp;#([Xx])0*(([0-9A-Fa-f]{2}){1,2});/',
//             '&#\\1\\2;', $string);
        
        $string = preg_replace_callback('/&amp;([A-Za-z]{2,8}[0-9]{0,2});/', array(__CLASS__, 'named_entities'), $string);
        $string = preg_replace_callback('/&amp;#(0*[0-9]{1,7});/', array(__CLASS__, 'normalize_entities2'), $string);
        $string = preg_replace_callback('/&amp;#[Xx](0*[0-9A-Fa-f]{1,6});/', array(__CLASS__, 'normalize_entities3'), $string);
    
        return $string;
    }
    
    /**
     * Callback for wp_kses_normalize_entities() regular expression.
     *
     * This function only accepts valid named entity references, which are finite,
     * case-sensitive, and highly scrutinized by HTML and XML validators.
     *
     * @since 3.0.0
     *
     * @global array $allowedentitynames
     *
     * @param array $matches preg_replace_callback() matches array
     * @return string Correctly encoded entity
     */
    public static function named_entities($matches) {
        global $allowedentitynames;
    
        if ( empty($matches[1]) )
            return '';
    
        $i = $matches[1];
        return ( ! in_array( $i, $allowedentitynames ) ) ? "&amp;$i;" : "&$i;";
    }
    
    
    /**
     * Callback for wp_kses_normalize_entities() regular expression.
     *
     * This function helps wp_kses_normalize_entities() to only accept 16-bit
     * values and nothing more for `&#number;` entities.
     *
     * @access private
     * @since 1.0.0
     *
     * @param array $matches preg_replace_callback() matches array
     * @return string Correctly encoded entity
     */
    public static function normalize_entities2($matches) {
        if ( empty($matches[1]) )
            return '';
    
        $i = $matches[1];
        if (self::valid_unicode($i)) {
            $i = str_pad(ltrim($i,'0'), 3, '0', STR_PAD_LEFT);
            $i = "&#$i;";
        } else {
            $i = "&amp;#$i;";
        }
    
        return $i;
    }
    
    /**
     * Callback for wp_kses_normalize_entities() for regular expression.
     *
     * This function helps wp_kses_normalize_entities() to only accept valid Unicode
     * numeric entities in hex form.
     *
     * @access private
     *
     * @param array $matches preg_replace_callback() matches array
     * @return string Correctly encoded entity
     */
    public static function normalize_entities3($matches) {
        if ( empty($matches[1]) )
            return '';
    
        $hexchars = $matches[1];
        return ( ! self::valid_unicode( hexdec( $hexchars ) ) ) ? "&amp;#x$hexchars;" : '&#x'.ltrim($hexchars,'0').';';
    }
    
    /**
     * Helper function to determine if a Unicode value is valid.
     *
     * @param int $i Unicode value
     * @return bool True if the value was a valid Unicode number
     */
    public static function valid_unicode($i) {
        return ( $i == 0x9 || $i == 0xa || $i == 0xd ||
            ($i >= 0x20 && $i <= 0xd7ff) ||
            ($i >= 0xe000 && $i <= 0xfffd) ||
            ($i >= 0x10000 && $i <= 0x10ffff) );
    }
    
    
//     /**
//      * function kses_normalize_entities2
//      * 
//      * This function helps kses_normalize_entities() to only accept 16 bit values
//      * and nothing more for &#number; entities.
//      * 
//      * @param unknown $i
//      * @return string
//      */
//     public static function normalize_entities2($i)
//     {
//         return (($i > 65535) ? "&amp;#$i;" : "&#$i;");
//     }
    
    
    /**
     * function kses_decode_entities
     * 
     * This function decodes numeric HTML entities (&#65; and &#x41;). It doesn't
     * do anything with other entities like &auml;, but we don't need them in the
     * URL protocol whitelisting system anyway.
     * 
     * @param unknown $string
     * @return mixed
     */
    public static function decode_entities($string)
    {
//         $string = preg_replace('/&#([0-9]+);/e', 'chr("\\1")', $string);
//         $string = preg_replace('/&#[Xx]([0-9A-Fa-f]+);/e', 'chr(hexdec("\\1"))',
//             $string);
        
        $string = preg_replace_callback('/&#([0-9]+);/',
            array(__CLASS__, '_decode_entities_chr'),
            $string);
        
        $string = preg_replace_callback('/&#[Xx]([0-9A-Fa-f]+);/',
            array(__CLASS__, '_decode_entities_chr_hexdec'),
            $string);
    
        return $string;
    }
    
    
    /**
     * Regex callback for wp_kses_decode_entities()
     *
     * @param array $match preg match
     * @return string
     */
    public static function _decode_entities_chr( $match ) {
        return chr( $match[1] );
    }
    
    /**
     * Regex callback for wp_kses_decode_entities()
     *
     * @param array $match preg match
     * @return string
     */
    public static function _decode_entities_chr_hexdec( $match ) {
        return chr( hexdec( $match[1] ) );
    }
}

// end