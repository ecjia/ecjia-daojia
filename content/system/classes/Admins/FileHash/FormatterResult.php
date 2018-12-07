<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/30
 * Time: 10:05
 */

namespace Ecjia\System\Admins\FileHash;

use Royalcms\Component\DirectoryHasher\Comparator\Result;
use Royalcms\Component\DirectoryHasher\Comparator\Difference\WrongHash;
use Royalcms\Component\DirectoryHasher\Comparator\Difference\NewFile;
use Royalcms\Component\DirectoryHasher\Comparator\Difference\MissingFile;
use Royalcms\Component\DirectoryHasher\Comparator\Difference\MissingHash;

class FormatterResult
{

    protected $result;

    protected $modifyFileList = [];

    protected $missingFileList = [];

    protected $newFileList = [];

    public function __construct(Result $result)
    {
        $this->result = $result;
    }

    public function formatter()
    {
        //一周前的时间
        $weekbefore = SYS_TIME - 604800;
        $result = null;
        collect($this->result->getDifferences())->each(function($item) use ($weekbefore, &$result) {
            $file = str_replace(base_path(), '', $item->getFile());
            $key = dirname($file) . DS;
            $key = str_replace('\\', '/', $key);

            $result[$key]['modify'] = !empty($result[$key]['modify']) ? $result[$key]['modify'] : 0;
            $result[$key]['missing'] = !empty($result[$key]['missing']) ? $result[$key]['missing'] : 0;
            $result[$key]['new'] = !empty($result[$key]['new']) ? $result[$key]['new'] : 0;
            $result[$key]['marker'] = !empty($result[$key]['marker']) ? $result[$key]['marker'] : substr(md5($key),0,3);

            $result[$key]['files'][] = [
                'file' => basename($file),
                'filemtime' => $this->_formatterTime($item->getFile(), $weekbefore),
                'size' => $this->_formatterFileMTime($item->getFile()),
                'status' => $this->_formatterFileStatus($item, $result[$key]),
            ];
        });

        return $result;
    }

    public function counter()
    {
        return [
            'modifyfile' => count($this->modifyFileList),
            'missingfile' => count($this->missingFileList),
            'newfile' => count($this->newFileList)
        ];

    }


    public function counterLabel()
    {
        return [
            'modifyfile' => '被修改',
            'missingfile' => '被删除',
            'newfile' => '未知'
        ];
    }


    private function _formatterTime($file, $weekbefore)
    {
        //对一周之内发生修改的文件日期加粗显示
        $filemtime = filemtime($file);
        if ($filemtime > $weekbefore) {
            $filemtime = '<b>'.date("Y-m-d H:i:s", $filemtime).'</b>';
        } else {
            $filemtime = date("Y-m-d H:i:s", $filemtime);
        }

        return $filemtime;
    }


    private function _formatterFileMTime($file)
    {
        return number_format(filesize($file)).' Bytes';
    }

    private function _formatterFileStatus($item, & $dir)
    {
        //统计“被修改”的文件
        if ($item instanceof WrongHash) {
            $this->modifyFileList[] = $item;
            $dir['modify']++;
            $status = __('<span class="stop_color"><i class="fontello-icon-attention-circled"></i>被修改</span>');
        }
        elseif ($item instanceof NewFile) {
            $this->newFileList[] = $item;
            $dir['new']++;
            $status = __('<span class="ok_color"><i class="fontello-icon-help-circled"></i>未知</span>');
        }
        //统计“被删除”的文件
        elseif ($item instanceof  MissingFile) {
            $this->missingFileList[] = $item;
            $dir['missing']++;
            $status = __('<span class="error_color"><i class="fontello-icon-minus-circled"></i>被删除</span>');
        }
        //统计“未知”的文件
        elseif ($item instanceof  MissingHash) {
            $status = __('<span class="ok_color"><i class="fontello-icon-help-circled"></i>未知</span>');
        } else {
            $status = __('<span class="ok_color"><i class="fontello-icon-ok-circled"></i>正确</span>');
        }

        return $status;
    }

}