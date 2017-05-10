<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 附件上传
 * @author chenzhejun@ecmoban.com
 *
 */
class add_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
		if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
    	
    	$attach_type	= $this->requestData('attach_type', 'goods_image');
    	$object_id		= $this->requestData('object_id');
    	
    	
    	/* 上传分类图片 */
    	$save_path = 'data/descimg/'.RC_Time::local_date('Ymd');
    	$upload = RC_Upload::uploader('image', array('save_path' => $save_path, 'auto_sub_dirs' => true));
    	$image_url = null;
    	if (isset($_FILES['upload_file']) && $_FILES['upload_file']['error'] == 0) {
    		$image_info = $upload->upload($_FILES['upload_file']);
    		if (!empty($image_info)) {
    			$image_url = $upload->get_position($image_info);
    		} else {
				return new ecjia_error('upload_error', $upload->error());
			}
    	} else {
    	    return new ecjia_error('upload_empty', '请选择上传的文件');
    	}
    	
    	if (empty($image_url)) {
    	    return new ecjia_error('upload_error', '上传失败');
    	}

    	/*插入附件表中*/
    	$data = array(
    			'attach_label'  => $image_info['name'],
    			'attach_description' => '描述图片',
    			'object_app'	=> 'ecjia.goods',
    			'object_group'	=> 'goods_image',
    			'object_id'		=> $object_id,
    			'file_name'     => $image_info['name'],
    			'file_path'		=> $image_url,
    			'file_size'     => $image_info['size'] / 1000,
    			'file_mime'     => $image_info['type'],
    			'file_ext'      => $image_info['ext'],
    			'file_hash'     => $image_info['sha1'],
    			'user_id'		=> $_SESSION['admin_id'],
    			'user_type'     => 'admin',
    			'add_ip'	    => RC_Ip::client_ip(),
    			'add_time'		=> RC_Time::gmtime(),
    			'in_status'     => 0,
    			'is_image'		=> 1,
    	);
    	RC_Model::model('mobile/term_attachment_model')->insert($data);
    	
    	return array('url' => RC_Upload::upload_url($image_url));
    	
    }
    	 
}