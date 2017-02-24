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
 * Geohash generation class
 * http://blog.dixo.net/downloads/
 *
 * This file copyright (C) 2008 Paul Dixon (paul@elphin.com)
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 3
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */



/**
* Encode and decode geohashes
*
*/
class Geohash
{
	private $coding="0123456789bcdefghjkmnpqrstuvwxyz";
	private $codingMap=array();
	
	public function Geohash()
	{
		//build map from encoding char to 0 padded bitfield
		for ($i = 0; $i < 32; $i++) {
			$this->codingMap[substr($this->coding,$i,1)]=str_pad(decbin($i), 5, "0", STR_PAD_LEFT);
		}
		
	}
	
	/**
	* Decode a geohash and return an array with decimal lat,long in it
	*/
	public function decode($hash)
	{
		//decode hash into binary string
		$binary = "";
		$hl	= strlen($hash);
		for ($i = 0; $i < $hl; $i++) {
			$binary .= $this->codingMap[substr($hash,$i,1)];
		}
		
		//split the binary into lat and log binary strings
		$bl		= strlen($binary);
		$blat	= "";
		$blong	= "";
		for ($i = 0; $i < $bl; $i++) {
			if ($i%2)
				$blat	= $blat.substr($binary, $i, 1);
			else
				$blong	= $blong.substr($binary, $i, 1);
		}
		
		//now concert to decimal
		$lat	= $this->binDecode($blat, -90, 90);
		$long	= $this->binDecode($blong, -180, 180);
		
		//figure out how precise the bit count makes this calculation
		$latErr		= $this->calcError(strlen($blat), -90, 90);
		$longErr	= $this->calcError(strlen($blong), -180, 180);
				
		//how many decimal places should we use? There's a little art to
		//this to ensure I get the same roundings as geohash.org
		$latPlaces	= max(1, -round(log10($latErr))) - 1;
		$longPlaces	= max(1, -round(log10($longErr))) - 1;
		
		//round it
		$lat	= round($lat, $latPlaces);
		$long	= round($long, $longPlaces);
		
		return array($lat, $long);
	}

	
	/**
	* Encode a hash from given lat and long
	*/
	public function encode($lat, $long)
	{
		//how many bits does latitude need?	
		$plat	= $this->precision($lat);
		$latbits = 1;
		$err	= 45;
		while ($err > $plat) {
			$latbits++;
			$err/=2;
		}
		
		//how many bits does longitude need?
		$plong		= $this->precision($long);
		$longbits	= 1;
		$err		= 90;
		while ($err > $plong) {
			$longbits++;
			$err/=2;
		}
		
		//bit counts need to be equal
		$bits	= max($latbits, $longbits);
		
		//as the hash create bits in groups of 5, lets not
		//waste any bits - lets bulk it up to a multiple of 5
		//and favour the longitude for any odd bits
		$longbits	= $bits;
		$latbits	= $bits;
		$addlong	= 1;
		while (($longbits+$latbits)%5 != 0) {
			$longbits += $addlong;
			$latbits+=!$addlong;
			$addlong=!$addlong;
		}
		
		
		//encode each as binary string
		$blat	= $this->binEncode($lat, -90, 90, $latbits);
		$blong	= $this->binEncode($long, -180, 180, $longbits);
		
		//merge lat and long together
		$binary	    = "";
		$uselong	= 1;
		while (strlen($blat) + strlen($blong)) {
			if ($uselong) {
				$binary	= $binary.substr($blong, 0, 1);
				$blong	= substr($blong,1);
			} else {
				$binary	= $binary.substr($blat, 0, 1);
				$blat	= substr($blat, 1);
			}
			$uselong=!$uselong;
		}
		
		//convert binary string to hash
		$hash="";
		for ($i = 0; $i < strlen($binary); $i += 5) {
			$n		= bindec(substr($binary, $i, 5));
			$hash	= $hash.$this->coding[$n];
		}
		
		return $hash;
	}
	
	public function geo_neighbors($hash)
	{
		//decode hash into binary string
		$binary = "";
		$hl		= strlen($hash);
		for ($i = 0; $i < $hl; $i++) {
			$binary .= $this->codingMap[substr($hash, $i, 1)];
		}
	
		//split the binary into lat and log binary strings
		/* 获取中心点的二进制 */
		$bl		= strlen($binary);
		$blat	= "";
		$blong	= "";
		for ($i=0; $i < $bl; $i++) {
			if ($i%2) {
				$blat	= $blat.substr($binary, $i, 1);
			} else {
				$blong	= $blong.substr($binary, $i, 1);
			}
		}
	
		/* 将中心点转换成十进制*/
		$ten_lat	= bindec($blat);//纬度
		$ten_long	= bindec($blong);//经度
	
		/* 获取左右经度二进制*/
		$left_blong		= decbin($ten_long-1);
		$right_blong	= decbin($ten_long+1);
	
		/* 转换成经度*/
		//$long		= $this->binDecode($blong, -180, 180);
		//$left_long	= $this->binDecode($left_blong, -180, 180);
		//$right_long	= $this->binDecode($right_blong, -180, 180);
	
		/* 获取上下纬度二进制*/
		$top_blat		= decbin($ten_lat+1);
		$bottom_blat	= decbin($ten_lat-1);
	
		//$lat		= $this->binDecode($blat, -90, 90);
		//$top_lat	= $this->binDecode($top_blat, -90, 90);
		//$bottom_lat	= $this->binDecode($bottom_blat, -90, 90);
	
		$neighbors = array();
		$neighbors[] = $this->get_hash($top_blat, $left_blong);
		$neighbors[] = $this->get_hash($top_blat, $blong);
		$neighbors[] = $this->get_hash($top_blat, $right_blong);
		$neighbors[] = $this->get_hash($blat, 	   $left_blong);
		$neighbors[] = $this->get_hash($blat,     $right_blong);
		$neighbors[] = $this->get_hash($bottom_blat, $left_blong);
		$neighbors[] = $this->get_hash($bottom_blat, $blong);
		$neighbors[] = $this->get_hash($bottom_blat, $right_blong);
	
	
		return $neighbors;
	
	}
	
	private function get_hash($blat, $blong)
	{
		$binary  = "";
		$uselong = 1;
		while (strlen($blat) + strlen($blong)) {
			if ($uselong) {
				$binary	= $binary.substr($blong, 0, 1);
				$blong	= substr($blong, 1);
			} else {
				$binary	= $binary.substr($blat, 0, 1);
				$blat	= substr($blat, 1);
			}
			$uselong=!$uselong;
		}
	
		//convert binary string to hash
		$hash = "";
		for ($i = 0; $i < strlen($binary); $i += 5) {
			$n		= bindec(substr($binary, $i, 5));
			$hash	= $hash.$this->coding[$n];
		}
	
		return $hash;
	}
	
	/**
	* What's the maximum error for $bits bits covering a range $min to $max
	*/
	private function calcError($bits, $min, $max)
	{
		$err = ($max-$min)/2;
		while ($bits--)
			$err/=2;
		return $err;
	}
	
	/*
	* returns precision of number
	* precision of 42 is 0.5
	* precision of 42.4 is 0.05
	* precision of 42.41 is 0.005 etc
	*/
	private function precision($number)
	{
		$precision = 0;
		$pt        = strpos($number,'.');
		if ($pt!==false) {
			$precision=-(strlen($number)-$pt-1);
		}
		
		return pow(10,$precision)/2;
	}
	
	
	/**
	* create binary encoding of number as detailed in http://en.wikipedia.org/wiki/Geohash#Example
	* removing the tail recursion is left an exercise for the reader
	*/
	private function binEncode($number, $min, $max, $bitcount)
	{
		if ($bitcount==0)
			return "";
		
		#echo "$bitcount: $min $max<br>";
			
		//this is our mid point - we will produce a bit to say
		//whether $number is above or below this mid point
		$mid = ($min+$max)/2;
		if ($number > $mid)
			return "1".$this->binEncode($number, $mid, $max, $bitcount-1);
		else
			return "0".$this->binEncode($number, $min, $mid, $bitcount-1);
	}
	

	/**
	* decodes binary encoding of number as detailed in http://en.wikipedia.org/wiki/Geohash#Example
	* removing the tail recursion is left an exercise for the reader
	*/
	private function binDecode($binary, $min, $max)
	{
		$mid = ($min+$max)/2;
		
		if (strlen($binary)==0)
			return $mid;
			
		$bit = substr($binary, 0, 1);
		$binary = substr($binary, 1);
		
		if ($bit==1)
			return $this->binDecode($binary, $mid, $max);
		else
			return $this->binDecode($binary, $min, $mid);
	}
}

//end