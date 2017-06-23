<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * block.t.php - Smarty gettext block plugin
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @package   smarty-gettext
 * @link      https://github.com/glensc/smarty-gettext
 * @author    Sagi Bashari <sagi@boom.org.il>
 * @author    Elan Ruusamäe <glen@delfi.ee>
 * @copyright 2004-2005 Sagi Bashari
 * @copyright 2010-2013 Elan Ruusamäe
 */

/**
 * Replaces arguments in a string with their values.
 * Arguments are represented by % followed by their number.
 *
 * @param string $str Source string
 * @param mixed mixed Arguments, can be passed in an array or through single variables.
 * @return string Modified string
 */
function smarty_gettext_strarg($str/*, $varargs... */) {
	$tr = array();
	$p = 0;

	$nargs = func_num_args();
	for ($i = 1; $i < $nargs; $i++) {
		$arg = func_get_arg($i);

		if (is_array($arg)) {
			foreach ($arg as $aarg) {
				$tr['%' . ++$p] = $aarg;
			}
		} else {
			$tr['%' . ++$p] = $arg;
		}
	}

	return strtr($str, $tr);
}

/**
 * Smarty block function, provides gettext support for smarty.
 *
 * The block content is the text that should be translated.
 *
 * Any parameter that is sent to the function will be represented as %n in the translation text,
 * where n is 1 for the first parameter. The following parameters are reserved:
 *   - escape - sets escape mode:
 *       - 'html' for HTML escaping, this is the default.
 *       - 'js' for javascript escaping.
 *       - 'url' for url escaping.
 *       - 'no'/'off'/0 - turns off escaping
 *   - plural - The plural version of the text (2nd parameter of ngettext())
 *   - count - The item count for plural mode (3rd parameter of ngettext())
 *   - domain - Textdomain to be used, default if skipped (dgettext() instead of gettext())
 *
 * @param array $params
 * @param string $text
 * @link http://www.smarty.net/docs/en/plugins.block.functions.tpl
 * @return string
 */
function smarty_block_t($params, $text) {
	if (!isset($text)) {
		return $text;
	}

	// set escape mode, default html escape
	if (isset($params['escape'])) {
		$escape = $params['escape'];
		unset($params['escape']);
	} else {
		$escape = 'html';
	}

	// set plural version
	if (isset($params['plural'])) {
		$plural = $params['plural'];
		unset($params['plural']);

		// set count
		if (isset($params['count'])) {
			$count = $params['count'];
			unset($params['count']);
		}
	}

	// set domain
	if (isset($params['domain'])) {
		$domain = $params['domain'];
		unset($params['domain']);
	} else {
		$domain = null;
	}

	// use plural if required parameters are set
	if (isset($count) && isset($plural)) {
		// use specified textdomain if available
		if (isset($domain)) {
			$text = RC_Locale::_n($text, $plural, $count, $domain);//dngettext($domain, $text, $plural, $count);
		} else {
			$text = RC_Locale::_n($text, $plural, $count);//ngettext($text, $plural, $count);
		}
	} else {
		// use specified textdomain if available
		if (isset($domain)) {
			$text = __($text, $domain);//dgettext($domain, $text);
		} else {
			$text = __($text);//gettext($text);
		}
	}

	// run strarg if there are parameters
	if (count($params)) {
		$text = smarty_gettext_strarg($text, $params);
	}

	switch ($escape) {
	case 'html':
		$text = nl2br(htmlspecialchars($text));
		break;
	case 'javascript':
	case 'js':
		// javascript escape
		$text = strtr($text, array('\\' => '\\\\', "'" => "\\'", '"' => '\\"', "\r" => '\\r', "\n" => '\\n', '</' => '<\/'));
		break;
	case 'url':
		// url escape
		$text = urlencode($text);
		break;
	}

	return $text;
}
