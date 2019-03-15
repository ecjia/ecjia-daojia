<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/11
 * Time: 15:45
 */
namespace Ecjia\System\Admins\Gettext\Smarty;

class CompileFile
{

    protected $file;

    protected $domain;

    protected $compiler;

    public function __construct(SmartyGettextCompiler $compiler, $file, $domain = null)
    {
        $this->compiler = $compiler;
        $this->file = $file;
        $this->domain = $domain;
    }

    /**
     * rips gettext strings from $file and prints them in C format
     */
    public function compile()
    {
        $content = file_get_contents($this->file);

        if (empty($content)) {
            return;
        }

        preg_match_all(
            "/{$this->compiler->getLeftDefinedQuote()}\s*({$this->compiler->getCommandTag()})\s*([^{$this->compiler->getRightDefinedQuote()}]*){$this->compiler->getRightDefinedQuote()}+([^{$this->compiler->getLeftDefinedQuote()}]*){$this->compiler->getLeftDefinedQuote()}\/\\1{$this->compiler->getRightDefinedQuote()}/",
            $content,
            $matches,
            PREG_OFFSET_CAPTURE
        );


        $result_msgctxt = array(); //msgctxt -> msgid based content
        $result_msgid = array(); //only msgid based content

        for ($i = 0; $i < count($matches[0]); $i++) {
            $msg_ctxt = null;
            $plural = null;

            if ($this->domain) {
                if (preg_match('/domain\s*=\s*["\']?\s*(.[^\"\']*)\s*["\']?/', $matches[2][$i][0], $match)) {
                    if($match[1] != $this->domain) {
                        continue; // Skip strings with domain, if not matching domain to extract
                    }
                } elseif ($this->domain != '') {
                    continue; // Skip strings without domain, if domain to extract is not default/empty
                }
            }

            if (preg_match('/context\s*=\s*["\']?\s*(.[^\"\']*)\s*["\']?/', $matches[2][$i][0], $match)) {
                $msg_ctxt = $match[1];
            }

            if (preg_match('/plural\s*=\s*["\']?\s*(.[^\"\']*)\s*["\']?/', $matches[2][$i][0], $match)) {
                $msgid = $matches[3][$i][0];
                $plural = $match[1];
            } else {
                $msgid = $matches[3][$i][0];
            }

            if ($msg_ctxt && empty($result_msgctxt[$msg_ctxt])) {
                $result_msgctxt[$msg_ctxt] = array();
            }

            if ($msg_ctxt && empty($result_msgctxt[$msg_ctxt][$msgid])) {
                $result_msgctxt[$msg_ctxt][$msgid] = array();
            } elseif (empty($result_msgid[$msgid])) {
                $result_msgid[$msgid] = array();
            }

            if ($plural) {
                if ($msg_ctxt) {
                    $result_msgctxt[$msg_ctxt][$msgid]['plural'] = $plural;
                } else {
                    $result_msgid[$msgid]['plural'] = $plural;
                }
            }

            $lineno = $this->lineno_from_offset($content, $matches[2][$i][1]);
            $file = $this->compiler->beautifyFilePath($this->file);
            if ($msg_ctxt) {
                $result_msgctxt[$msg_ctxt][$msgid]['lineno'][] = "$file:$lineno";
            } else {
                $result_msgid[$msgid]['lineno'][] = "$file:$lineno";
            }
        }

        $this->generateOutData($result_msgctxt, $result_msgid);
    }

    protected function lineno_from_offset($content, $offset)
    {
        return substr_count($content, "\n", 0, $offset) + 1;
    }

    // "fix" string - strip slashes, escape and convert new lines to \n
    protected function fs($str)
    {
        $str = stripslashes($str);
        $str = str_replace('"', '\"', $str);
        $str = str_replace("\n", '\n', $str);

        return $str;
    }

    /**
     * 生成输出文件
     */
    protected function generateOutData(array $result_msgctxt, array $result_msgid)
    {
        ob_start();
        echo SmartyGettextCompiler::MSGID_HEADER;
        foreach($result_msgctxt as $msgctxt => $data_msgid) {
            foreach($data_msgid as $msgid => $data) {
                echo "#: ", join(' ', $data['lineno']), "\n";
                echo 'msgctxt "' . $this->fs($msgctxt) . '"', "\n";
                echo 'msgid "' . $this->fs($msgid) . '"', "\n";
                if (isset($data['plural'])) {
                    echo 'msgid_plural "' . $this->fs($data['plural']) . '"', "\n";
                    echo 'msgstr[0] ""', "\n";
                    echo 'msgstr[1] ""', "\n";
                } else {
                    echo 'msgstr ""', "\n";
                }
                echo "\n";
            }
        }
        //without msgctxt
        foreach($result_msgid as $msgid => $data) {
            echo "#: ", join(' ', $data['lineno']), "\n";
            echo 'msgid "' . $this->fs($msgid) . '"', "\n";
            if (isset($data['plural'])) {
                echo 'msgid_plural "' . $this->fs($data['plural']) . '"', "\n";
                echo 'msgstr[0] ""', "\n";
                echo 'msgstr[1] ""', "\n";
            } else {
                echo 'msgstr ""', "\n";
            }
            echo "\n";
        }

        $out = ob_get_contents();
        ob_end_clean();
        $this->compiler->msgMerge($out);
    }

}