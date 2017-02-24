<?php namespace Royalcms\Component\Model;

class NullModel extends Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = '';
		parent::__construct();
	}

}
