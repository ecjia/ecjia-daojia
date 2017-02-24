<?php
defined('IN_ROYALCMS') or exit('No permission resources.');

abstract class Component_Editor_Editor {
	abstract public function editor_settings($editor_id, $set);
}

// end