<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/11
 * Time: 15:40
 */

namespace Ecjia\System\Admins\Gettext\Smarty;

class SmartyGettextCompiler
{

    // we msgcat found strings from each file.
    // need header for each temporary .pot file to be merged.
    // https://help.launchpad.net/Translations/YourProject/PartialPOExport
    const MSGID_HEADER = 'msgid ""
msgstr "Content-Type: text/plain; charset=UTF-8\n"

';

    // smarty open tag
    protected $ldq = '{';

    // smarty close tag
    protected $rdq = '}';

    // smarty command
    protected $cmd = 't';

    // extensions of smarty files, used when going through a directory
    protected $extensions = array('tpl', 'php');

    protected $outfile;

    protected $temp_directory;

    public function __construct()
    {
        $this->ldq = preg_quote($this->ldq);
        $this->rdq = preg_quote($this->rdq);
        $this->cmd = preg_quote($this->cmd);

        $this->temp_directory = sys_get_temp_dir();
    }

    public function getTempDirectory()
    {
        return $this->temp_directory;
    }

    /**
     * @return array
     */
    public function getExtensions()
    {
        return $this->extensions;
    }

    /**
     * @param $outfile
     * @return $this
     */
    public function setOutFile($outfile)
    {
        $this->outfile = $outfile;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOutFile()
    {
        return $this->outfile;
    }

    public function getLeftDefinedQuote()
    {
        return $this->ldq;
    }

    public function getRightDefinedQuote()
    {
        return $this->rdq;
    }

    public function getCommandTag()
    {
        return $this->cmd;
    }

    public function beautifyFilePath($file)
    {
        return str_replace(SITE_ROOT, '', $file);
    }

    public function msgMerge($data)
    {
        // skip empty
        if (empty($data)) {
            return;
        }

        // write new data to tmp file
        $tmp = tempnam($this->temp_directory, 'tsmarty2c');
        file_put_contents($tmp, $data);

        // temp file for result cat
        $tmp2 = tempnam($this->temp_directory, 'tsmarty2c');
        passthru('msgcat -o ' . escapeshellarg($tmp2) . ' ' . escapeshellarg($this->outfile) . ' ' . escapeshellarg($tmp), $rc);
        unlink($tmp);

        if ($rc) {
            fwrite(STDERR, "msgcat failed with $rc\n");
            exit($rc);
        }

        // rename if output was produced
        if (file_exists($tmp2)) {
            rename($tmp2, $this->outfile);
        }
    }


}