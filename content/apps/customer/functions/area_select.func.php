<?php

/**
 * 获得指定国家的所有省份
 *
 * @access      public
 * @param       int     country    国家的编号
 * @return      array
 */
function get_regions($type = 0, $parent = 0)
{
	$region_db=RC_Loader::load_app_model('region_model');
	$countries= $region_db->field('region_id,region_name')->where(array('region_type' =>$type,'parent_id' =>$parent))->select();
	
	return $countries;
}

//end