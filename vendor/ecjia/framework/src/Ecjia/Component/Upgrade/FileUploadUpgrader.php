<?php
namespace Ecjia\Component\Upgrade;

/**
 * Upgrade Skin helper for File uploads. This class handles the upload process and passes it as if it's a local file to the Upgrade/Installer functions.
 *
 * @package ECJia
 * @subpackage Upgrader
 * @since 2.8.0
 */
class FileUploadUpgrader
{
    protected $package;
    protected $filename;
    protected $id = 0;
    
    public function __construct($form, $urlholder)
    {
    
        if ( empty($_FILES[$form]['name']) && empty($_GET[$urlholder]) )
            rc_die(__('Please select a file', 'ecjia'));
    
        //Handle a newly uploaded file, Else assume it's already been uploaded
        if ( ! empty($_FILES) ) {
            $overrides = array( 'test_form' => false, 'test_type' => false );
            $file = wp_handle_upload( $_FILES[$form], $overrides );
    
            if ( isset( $file['error'] ) )
                rc_die( $file['error'] );
    
            $this->filename = $_FILES[$form]['name'];
            $this->package = $file['file'];
    
            // Construct the object array
            $object = array(
                'post_title' => $this->filename,
                'post_content' => $file['url'],
                'post_mime_type' => $file['type'],
                'guid' => $file['url'],
                'context' => 'upgrader',
                'post_status' => 'private'
            );
    
            // Save the data
            $this->id = wp_insert_attachment( $object, $file['file'] );
    
            // schedule a cleanup for 2 hours from now in case of failed install
            wp_schedule_single_event( time() + 7200, 'upgrader_scheduled_cleanup', array( $this->id ) );
    
        } elseif ( is_numeric( $_GET[$urlholder] ) ) {
            // Numeric Package = previously uploaded file, see above.
            $this->id = (int) $_GET[$urlholder];
            $attachment = get_post( $this->id );
            if ( empty($attachment) )
                rc_die(__('Please select a file', 'ecjia'));
    
            $this->filename = $attachment->post_title;
            $this->package = get_attached_file( $attachment->ID );
        } else {
            // Else, It's set to something, Back compat for plugins using the old (pre-3.3) File_Uploader handler.
            if ( ! ( ( $uploads = wp_upload_dir() ) && false === $uploads['error'] ) )
                rc_die( $uploads['error'] );
    
            $this->filename = $_GET[$urlholder];
            $this->package = $uploads['basedir'] . '/' . $this->filename;
        }
    }
    
    public function cleanup()
    {
        if ( $this->id )
            wp_delete_attachment( $this->id );
    
        elseif ( file_exists( $this->package ) )
        return @unlink( $this->package );
    
        return true;
    }
    
}

// end