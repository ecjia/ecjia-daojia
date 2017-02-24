<?php

/**
 * @file 
 *
 * 类反射-用于自动生成文档
 * @see http://php.net/manual/zh/book.reflection.php
 */

namespace Royalcms\Component\Reflection;

use ReflectionClass as PhpReflectionClass;

/**
 常用格式 []表示可选
 ----------------------------------------------------
    @route  路径             @route /user/add
    @access 权限字符         @access added_user
    @param  类型  参数       @param string $username
    @return 类型 [实体]      @return array [user]
    @notice 特别提醒
    @desc   描述
 */
class ReflectionClass extends PhpReflectionClass {

    /*
     * 解析方法,参数,注释
     */
    public function getMethods($filter = null) {
        $methods = array();
        $reflect = $filter ? parent::getMethods($filter) : parent::getMethods();
        foreach ($reflect as $obj) {
            //Methods
            $methods[$obj->name] = array('type' => '','params' => array(),'comments'=>array());
            if ($obj->isPrivate()) {
                $methods[$obj->name]['type'] = 'private';
            } elseif($obj->isProtected()) {
                $methods[$obj->name]['type'] = 'protected';
            } elseif($obj->isPublic()) {
                $methods[$obj->name]['type'] = 'public';
            }
            //Parameters
            foreach ($obj->getParameters() as $p) {
                $pv = array(
                    'name'          => $p->getName(),
                    'defaultValue'  => $p->isDefaultValueAvailable() ? $p->getDefaultValue() : null,
                    'isOptional'    => $p->isOptional(),
                );
                $pv['valueType'] = strtolower(gettype($pv['defaultValue']));
                $methods[$obj->name]['params'][] = $pv;
            }
            //Comments
            $methods[$obj->name]['comments'] = $this->parserComments($obj->getDocComment());
        }

        return $methods;
    }

    /*
     * 解析注释
     */
    public function parserComments($comments = false) {
        $return = array();
        if ($comments) {
            preg_match_all('/@ *(\w+) *([^\r\n]*?)[\r\n]/isu', $comments, $matches);
            if (isset($matches[1]) && isset($matches[2])) {
                foreach ($matches[1] as $i=>$key) {
                    switch ($key) {
                        case 'param':
                            $return[$key][] = preg_split("/\s+/", trim($matches[2][$i]), 3);
                            break;
                        case 'route':
                        case 'access':
                            $return[$key][] = trim($matches[2][$i]);
                            break;
                        case 'return':
                        case 'notice':
                        case 'desc':
                        default:
                            $return[$key] = trim($matches[2][$i]);
                            break;
                    }
                }
            }
            preg_match('|/\*\* *\r?\n?([^\r\n]+?)[\r\n]|isu', $comments, $match);
            if (isset($match[1])) {
                $return['description'] = trim($match[1], "* \r\n");
            } else {
                $return['description'] = '';
            }
        }
        return $return;
    }
    
}
