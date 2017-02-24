<?php

/**
 * @file
 *
 * 反射类
 */

namespace Royalcms\Component\Reflection;

use ReflectionClass;

class Reflection {  
    
    /**
     * 反射对象
     *
     * @var object
     */
    protected $reflector;   
    
    /**
     * 方法
     *
     * @var array
     */
    protected $methods  = array();
    
    /**
     * 方法Gearman
     *
     * @var array
     */
    protected $functions  = array();
    
    /**
     * 属性
     *
     * @var array
     */
    protected $properties = array();
    
    /**
     * 反射类的唯一码
     *
     * @var string
     */
    protected $classHash = '';
    
    /**
     * 被反射的类名
     *
     * @var string
     */
    protected $className;
    
    /**
     * 属性前缀
     *
     * @var string
     */
    protected $prefixProperty;
    
    /**
     * 方法前缀
     *
     * @var string
     */
    protected $prefixMethod;
    
    /**
     * 获取反射对象
     *
     * @param string
     *   类名
     */
    public function init($classname, $options = array()) {
        $options += array('prefixProperty'=>'', 'prefixMethod'=>'');
        if ( !class_exists($classname) ) return $this;
        $this->className  = substr($classname, 0, strrpos($classname,'\\'));        
        $this->classHash  = uniqid();
        $this->prefixProperty = $options['prefixProperty'];
        $this->prefixMethod   = $options['prefixMethod'];
        $this->methods    = array();
        $this->properties = array();
        $this->reflector = new ReflectionClass($classname);      
    
        return $this;
    }
    
    //解析方法
    public function parserMethods() {
        if (!$this->reflector) return $this;
        foreach ($this->reflector->getMethods() as $obj) {
            $this->methods[$this->prefixMethod . $obj->name]['class'] = $obj->class;
            $this->methods[$this->prefixMethod . $obj->name]['name']  = $obj->name;  
            $this->methods[$this->prefixMethod . $obj->name]['comments']  = $obj->getDocComment();
            if ($obj->isPrivate()) {
                $this->methods[$this->prefixMethod . $obj->name]['type'] = 'private';
            } elseif($obj->isProtected()) {
                $this->methods[$this->prefixMethod . $obj->name]['type'] = 'protected';
            } else {
                $this->methods[$this->prefixMethod . $obj->name]['type'] = 'public';
                $this->functions[$this->className . '\\' . $obj->name]['type'] = 'public';
                $this->functions[$this->className . '\\' . $obj->name]['class'] = $obj->class;
                $this->functions[$this->className . '\\' . $obj->name]['name']  = $obj->name;
            }
        }
        
        return $this;
    }
    
    //解析属性
    public function parserProperties() {
        if (!$this->reflector) return $this;
        foreach($this->reflector->getProperties() as $obj) {
            $p = $this->reflector->getProperty($obj->name);
            $p->setAccessible(true);
            $this->properties[$this->prefixProperty . $obj->name] = $p->getValue();
        }
    
        return $this;
    }
    
    //获取方法信息
    public function getMethods() {
        return $this->methods;
    }
    
    //获取属性信息
    public function getProperties() {
        return $this->properties;
    }
    
    //获取Gearman方法
    public function getFunctions() {
        return $this->functions;
    }
    
    //显示HTML文档
    public function showHTML($methods, $properties) {
        $functions = '';
        foreach($methods as $method=>$v) {
            if (!isset($v['type']) || $v['type'] != 'public') { CONTINUE; }            
            if (isset($properties[$method]) && is_array($properties[$method])) {
                $testcase = $properties[$method];
                $desc   = '<h5><p>' . (isset($testcase['description']) ? $testcase['description'] : '') . '</p></h5>';
                $inputs = '<div class="parameters">';
                $inputs .= '<h5><i>Input Example:</i></h5><pre>' . 
                            (isset($testcase['request']) ? $this->highlightString(var_export($testcase['request'],true)) : '') .
                            '</pre>';
                $inputs .= '</div>';                
                $outputs = '<div class="parameters">';
                $outputs .= '<h5><i>Output Example:</i></h5><pre>' . 
                            (isset($testcase['response']) ? $this->highlightString(var_export($testcase['response'],true)) : '') . 
                            '</pre>';
                $outputs .= '</div>';
            }
            else {
                $desc = $inputs = $outputs = '';
            }
            $method = strtr($method,'\\','_');
            $functions .= "
              <li id='{$method}'>
                <a href='javascript:void(0);' onclick='toggle(\"{$method}_{$this->classHash}\");'>{$method} </a>
                {$desc}
                <div id='{$method}_{$this->classHash}' class='desc'>                  
                  {$inputs}
                  {$outputs}
                </div>
              </li>";
        }
    
        return "
          <html>
          <head>
          <title> Helper </title>
          <meta http-equiv='content-type' content='text/html;charset=utf-8'>
          <style type='text/css'>
            BODY { color: #000000; background-color: white; font-family: Verdana; margin:0px;}        
            A:link { color: #336699; font-weight: bold; text-decoration: none; }
            A:visited { color: #6699cc; font-weight: bold; text-decoration: none; }
            A:active { color: #336699; font-weight: bold; text-decoration: underline; }
            A:hover { color: cc3300; font-weight: bold; text-decoration: none; }
            P { color: #000000; margin-top: 0px; margin-bottom: 12px; font-family: Verdana; }
            pre { background-color: #efefdc; padding: 5px; font-family: Courier New; font-size: 11px; border: 1px #f0f0e0 solid; margin:0; }
            ul { margin-top: 10px; margin-left: 20px; }
            li { margin-top: 10px; color: #000; list-style-type:circle;}
            .heading1 { color: #ffffff; font-family: Tahoma; font-size: 26px; background-color: #003366; padding:10px 0px 8px 20px;}
            #content {font-size: .80em; padding:8px 16px;}
            .intro { margin-left: 10px; }
            h5 {margin:5px 0px 2px 0px;font-size:12px;}
            h5 i {color:#888;}
            h5 p {color:#666;}
            pre { background-color:#efefdc; color:#555; padding: 5px; font-family: Courier New; font-size: 11px; border: 1px #999 dashed; margin:0; }
            pre b {color:#992222;}
            .parameters {color:#666;font-size:11px;padding:5px;line-height:150%;border:1px #999 solid;background-color: #f2f2f2;}
            .desc {display:none;color:#333;}
          </style>
          <script>
            function toggle(div) {
              var d = document.getElementById(div);
              if(d.style.display=='block')
                d.style.display = 'none';
              else
                d.style.display = 'block';
            }
          </script>
          </head>
          <body>
          <p class='heading1'> Helper </p>
          <div id='content'>
          <p class='intro'></p>
          <ul>" . $functions .
          "</ul>
          </div>
          </body>
          </html>
          ";
    }
    
    //高亮设定的文本
    protected function highlightString($string, $options = array()) {
        $options += array(
            'int:'    => '<b>int:</b>',
            'string:' => '<b>string:</b>',
        );
        return strtr(preg_replace('/\n\s+(array\s\()/is', '$1', $string), $options);
    }
    
}
