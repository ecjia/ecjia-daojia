<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\VarDumper\Caster;

use Symfony\Component\VarDumper\Cloner\Stub;

/**
 * Casts Reflector related classes to array representation.
 *
 * @author Nicolas Grekas <p@tchwork.com>
<<<<<<< HEAD
 */
class ReflectionCaster
{
    private static $extraMap = array(
=======
 *
 * @final
 */
class ReflectionCaster
{
    public const UNSET_CLOSURE_FILE_INFO = ['Closure' => __CLASS__.'::unsetClosureFileInfo'];

    private const EXTRA_MAP = [
>>>>>>> v2-test
        'docComment' => 'getDocComment',
        'extension' => 'getExtensionName',
        'isDisabled' => 'isDisabled',
        'isDeprecated' => 'isDeprecated',
        'isInternal' => 'isInternal',
        'isUserDefined' => 'isUserDefined',
        'isGenerator' => 'isGenerator',
        'isVariadic' => 'isVariadic',
<<<<<<< HEAD
    );

    /**
     * @deprecated since Symfony 2.7, to be removed in 3.0.
     */
    public static function castReflector(\Reflector $c, array $a, Stub $stub, $isNested)
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since Symfony 2.7 and will be removed in 3.0.', E_USER_DEPRECATED);
        $a[Caster::PREFIX_VIRTUAL.'reflection'] = $c->__toString();
=======
    ];

    public static function castClosure(\Closure $c, array $a, Stub $stub, bool $isNested, int $filter = 0)
    {
        $prefix = Caster::PREFIX_VIRTUAL;
        $c = new \ReflectionFunction($c);

        $a = static::castFunctionAbstract($c, $a, $stub, $isNested, $filter);

        if (false === strpos($c->name, '{closure}')) {
            $stub->class = isset($a[$prefix.'class']) ? $a[$prefix.'class']->value.'::'.$c->name : $c->name;
            unset($a[$prefix.'class']);
        }
        unset($a[$prefix.'extra']);

        $stub->class .= self::getSignature($a);

        if ($f = $c->getFileName()) {
            $stub->attr['file'] = $f;
            $stub->attr['line'] = $c->getStartLine();
        }

        unset($a[$prefix.'parameters']);

        if ($filter & Caster::EXCLUDE_VERBOSE) {
            $stub->cut += ($c->getFileName() ? 2 : 0) + \count($a);

            return [];
        }

        if ($f) {
            $a[$prefix.'file'] = new LinkStub($f, $c->getStartLine());
            $a[$prefix.'line'] = $c->getStartLine().' to '.$c->getEndLine();
        }
>>>>>>> v2-test

        return $a;
    }

<<<<<<< HEAD
    public static function castClosure(\Closure $c, array $a, Stub $stub, $isNested)
    {
        $prefix = Caster::PREFIX_VIRTUAL;
        $c = new \ReflectionFunction($c);

        $stub->class = 'Closure'; // HHVM generates unique class names for closures
        $a = static::castFunctionAbstract($c, $a, $stub, $isNested);

        if (isset($a[$prefix.'parameters'])) {
            foreach ($a[$prefix.'parameters'] as &$v) {
                $param = $v;
                $v = array();
                foreach (static::castParameter($param, array(), $stub, true) as $k => $param) {
                    if ("\0" === $k[0]) {
                        $v[substr($k, 3)] = $param;
                    }
                }
                unset($v['position'], $v['isVariadic'], $v['byReference'], $v);
            }
        }

        if ($f = $c->getFileName()) {
            $a[$prefix.'file'] = $f;
            $a[$prefix.'line'] = $c->getStartLine().' to '.$c->getEndLine();
        }

        $prefix = Caster::PREFIX_DYNAMIC;
        unset($a['name'], $a[$prefix.'this'], $a[$prefix.'parameter'], $a[Caster::PREFIX_VIRTUAL.'extra']);
=======
    public static function unsetClosureFileInfo(\Closure $c, array $a)
    {
        unset($a[Caster::PREFIX_VIRTUAL.'file'], $a[Caster::PREFIX_VIRTUAL.'line']);

        return $a;
    }

    public static function castGenerator(\Generator $c, array $a, Stub $stub, bool $isNested)
    {
        // Cannot create ReflectionGenerator based on a terminated Generator
        try {
            $reflectionGenerator = new \ReflectionGenerator($c);
        } catch (\Exception $e) {
            $a[Caster::PREFIX_VIRTUAL.'closed'] = true;

            return $a;
        }

        return self::castReflectionGenerator($reflectionGenerator, $a, $stub, $isNested);
    }

    public static function castType(\ReflectionType $c, array $a, Stub $stub, bool $isNested)
    {
        $prefix = Caster::PREFIX_VIRTUAL;

        $a += [
            $prefix.'name' => $c instanceof \ReflectionNamedType ? $c->getName() : (string) $c,
            $prefix.'allowsNull' => $c->allowsNull(),
            $prefix.'isBuiltin' => $c->isBuiltin(),
        ];

        return $a;
    }

    public static function castAttribute(\ReflectionAttribute $c, array $a, Stub $stub, bool $isNested)
    {
        self::addMap($a, $c, [
            'name' => 'getName',
            'arguments' => 'getArguments',
        ]);

        return $a;
    }

    public static function castReflectionGenerator(\ReflectionGenerator $c, array $a, Stub $stub, bool $isNested)
    {
        $prefix = Caster::PREFIX_VIRTUAL;

        if ($c->getThis()) {
            $a[$prefix.'this'] = new CutStub($c->getThis());
        }
        $function = $c->getFunction();
        $frame = [
            'class' => $function->class ?? null,
            'type' => isset($function->class) ? ($function->isStatic() ? '::' : '->') : null,
            'function' => $function->name,
            'file' => $c->getExecutingFile(),
            'line' => $c->getExecutingLine(),
        ];
        if ($trace = $c->getTrace(\DEBUG_BACKTRACE_IGNORE_ARGS)) {
            $function = new \ReflectionGenerator($c->getExecutingGenerator());
            array_unshift($trace, [
                'function' => 'yield',
                'file' => $function->getExecutingFile(),
                'line' => $function->getExecutingLine() - 1,
            ]);
            $trace[] = $frame;
            $a[$prefix.'trace'] = new TraceStub($trace, false, 0, -1, -1);
        } else {
            $function = new FrameStub($frame, false, true);
            $function = ExceptionCaster::castFrameStub($function, [], $function, true);
            $a[$prefix.'executing'] = $function[$prefix.'src'];
        }

        $a[Caster::PREFIX_VIRTUAL.'closed'] = false;
>>>>>>> v2-test

        return $a;
    }

<<<<<<< HEAD
    public static function castClass(\ReflectionClass $c, array $a, Stub $stub, $isNested, $filter = 0)
=======
    public static function castClass(\ReflectionClass $c, array $a, Stub $stub, bool $isNested, int $filter = 0)
>>>>>>> v2-test
    {
        $prefix = Caster::PREFIX_VIRTUAL;

        if ($n = \Reflection::getModifierNames($c->getModifiers())) {
            $a[$prefix.'modifiers'] = implode(' ', $n);
        }

<<<<<<< HEAD
        self::addMap($a, $c, array(
            'extends' => 'getParentClass',
            'implements' => 'getInterfaceNames',
            'constants' => 'getConstants',
        ));
=======
        self::addMap($a, $c, [
            'extends' => 'getParentClass',
            'implements' => 'getInterfaceNames',
            'constants' => 'getReflectionConstants',
        ]);
>>>>>>> v2-test

        foreach ($c->getProperties() as $n) {
            $a[$prefix.'properties'][$n->name] = $n;
        }

        foreach ($c->getMethods() as $n) {
            $a[$prefix.'methods'][$n->name] = $n;
        }

<<<<<<< HEAD
=======
        self::addAttributes($a, $c, $prefix);

>>>>>>> v2-test
        if (!($filter & Caster::EXCLUDE_VERBOSE) && !$isNested) {
            self::addExtra($a, $c);
        }

        return $a;
    }

<<<<<<< HEAD
    public static function castFunctionAbstract(\ReflectionFunctionAbstract $c, array $a, Stub $stub, $isNested, $filter = 0)
    {
        $prefix = Caster::PREFIX_VIRTUAL;

        self::addMap($a, $c, array(
=======
    public static function castFunctionAbstract(\ReflectionFunctionAbstract $c, array $a, Stub $stub, bool $isNested, int $filter = 0)
    {
        $prefix = Caster::PREFIX_VIRTUAL;

        self::addMap($a, $c, [
>>>>>>> v2-test
            'returnsReference' => 'returnsReference',
            'returnType' => 'getReturnType',
            'class' => 'getClosureScopeClass',
            'this' => 'getClosureThis',
<<<<<<< HEAD
        ));

        if (isset($a[$prefix.'returnType'])) {
            $a[$prefix.'returnType'] = (string) $a[$prefix.'returnType'];
=======
        ]);

        if (isset($a[$prefix.'returnType'])) {
            $v = $a[$prefix.'returnType'];
            $v = $v instanceof \ReflectionNamedType ? $v->getName() : (string) $v;
            $a[$prefix.'returnType'] = new ClassStub($a[$prefix.'returnType'] instanceof \ReflectionNamedType && $a[$prefix.'returnType']->allowsNull() && 'mixed' !== $v ? '?'.$v : $v, [class_exists($v, false) || interface_exists($v, false) || trait_exists($v, false) ? $v : '', '']);
        }
        if (isset($a[$prefix.'class'])) {
            $a[$prefix.'class'] = new ClassStub($a[$prefix.'class']);
>>>>>>> v2-test
        }
        if (isset($a[$prefix.'this'])) {
            $a[$prefix.'this'] = new CutStub($a[$prefix.'this']);
        }

        foreach ($c->getParameters() as $v) {
            $k = '$'.$v->name;
<<<<<<< HEAD
            if ($v->isPassedByReference()) {
                $k = '&'.$k;
            }
            if (method_exists($v, 'isVariadic') && $v->isVariadic()) {
                $k = '...'.$k;
            }
            $a[$prefix.'parameters'][$k] = $v;
        }

        if ($v = $c->getStaticVariables()) {
            foreach ($v as $k => &$v) {
                $a[$prefix.'use']['$'.$k] = &$v;
            }
            unset($v);
=======
            if ($v->isVariadic()) {
                $k = '...'.$k;
            }
            if ($v->isPassedByReference()) {
                $k = '&'.$k;
            }
            $a[$prefix.'parameters'][$k] = $v;
        }
        if (isset($a[$prefix.'parameters'])) {
            $a[$prefix.'parameters'] = new EnumStub($a[$prefix.'parameters']);
        }

        self::addAttributes($a, $c, $prefix);

        if (!($filter & Caster::EXCLUDE_VERBOSE) && $v = $c->getStaticVariables()) {
            foreach ($v as $k => &$v) {
                if (\is_object($v)) {
                    $a[$prefix.'use']['$'.$k] = new CutStub($v);
                } else {
                    $a[$prefix.'use']['$'.$k] = &$v;
                }
            }
            unset($v);
            $a[$prefix.'use'] = new EnumStub($a[$prefix.'use']);
>>>>>>> v2-test
        }

        if (!($filter & Caster::EXCLUDE_VERBOSE) && !$isNested) {
            self::addExtra($a, $c);
        }

        return $a;
    }

<<<<<<< HEAD
    public static function castMethod(\ReflectionMethod $c, array $a, Stub $stub, $isNested)
    {
        $a[Caster::PREFIX_VIRTUAL.'modifiers'] = implode(' ', \Reflection::getModifierNames($c->getModifiers()));
=======
    public static function castClassConstant(\ReflectionClassConstant $c, array $a, Stub $stub, bool $isNested)
    {
        $a[Caster::PREFIX_VIRTUAL.'modifiers'] = implode(' ', \Reflection::getModifierNames($c->getModifiers()));
        $a[Caster::PREFIX_VIRTUAL.'value'] = $c->getValue();

        self::addAttributes($a, $c);
>>>>>>> v2-test

        return $a;
    }

<<<<<<< HEAD
    public static function castParameter(\ReflectionParameter $c, array $a, Stub $stub, $isNested)
    {
        $prefix = Caster::PREFIX_VIRTUAL;

        // Added by HHVM
        unset($a['info']);

        self::addMap($a, $c, array(
            'position' => 'getPosition',
            'isVariadic' => 'isVariadic',
            'byReference' => 'isPassedByReference',
        ));

        try {
            if (method_exists($c, 'hasType')) {
                if ($c->hasType()) {
                    $a[$prefix.'typeHint'] = $c->getType()->__toString();
                }
            } else {
                $v = explode(' ', $c->__toString(), 6);
                if (isset($v[5]) && 0 === strspn($v[4], '.&$')) {
                    $a[$prefix.'typeHint'] = $v[4];
                }
            }
        } catch (\ReflectionException $e) {
            if (preg_match('/^Class ([^ ]++) does not exist$/', $e->getMessage(), $m)) {
                $a[$prefix.'typeHint'] = $m[1];
            }
=======
    public static function castMethod(\ReflectionMethod $c, array $a, Stub $stub, bool $isNested)
    {
        $a[Caster::PREFIX_VIRTUAL.'modifiers'] = implode(' ', \Reflection::getModifierNames($c->getModifiers()));

        return $a;
    }

    public static function castParameter(\ReflectionParameter $c, array $a, Stub $stub, bool $isNested)
    {
        $prefix = Caster::PREFIX_VIRTUAL;

        self::addMap($a, $c, [
            'position' => 'getPosition',
            'isVariadic' => 'isVariadic',
            'byReference' => 'isPassedByReference',
            'allowsNull' => 'allowsNull',
        ]);

        self::addAttributes($a, $c, $prefix);

        if ($v = $c->getType()) {
            $a[$prefix.'typeHint'] = $v instanceof \ReflectionNamedType ? $v->getName() : (string) $v;
        }

        if (isset($a[$prefix.'typeHint'])) {
            $v = $a[$prefix.'typeHint'];
            $a[$prefix.'typeHint'] = new ClassStub($v, [class_exists($v, false) || interface_exists($v, false) || trait_exists($v, false) ? $v : '', '']);
        } else {
            unset($a[$prefix.'allowsNull']);
>>>>>>> v2-test
        }

        try {
            $a[$prefix.'default'] = $v = $c->getDefaultValue();
<<<<<<< HEAD
            if (method_exists($c, 'isDefaultValueConstant') && $c->isDefaultValueConstant()) {
                $a[$prefix.'default'] = new ConstStub($c->getDefaultValueConstantName(), $v);
            }
        } catch (\ReflectionException $e) {
            if (isset($a[$prefix.'typeHint']) && $c->allowsNull()) {
                $a[$prefix.'default'] = null;
            }
=======
            if ($c->isDefaultValueConstant()) {
                $a[$prefix.'default'] = new ConstStub($c->getDefaultValueConstantName(), $v);
            }
            if (null === $v) {
                unset($a[$prefix.'allowsNull']);
            }
        } catch (\ReflectionException $e) {
>>>>>>> v2-test
        }

        return $a;
    }

<<<<<<< HEAD
    public static function castProperty(\ReflectionProperty $c, array $a, Stub $stub, $isNested)
    {
        $a[Caster::PREFIX_VIRTUAL.'modifiers'] = implode(' ', \Reflection::getModifierNames($c->getModifiers()));
=======
    public static function castProperty(\ReflectionProperty $c, array $a, Stub $stub, bool $isNested)
    {
        $a[Caster::PREFIX_VIRTUAL.'modifiers'] = implode(' ', \Reflection::getModifierNames($c->getModifiers()));

        self::addAttributes($a, $c);
>>>>>>> v2-test
        self::addExtra($a, $c);

        return $a;
    }

<<<<<<< HEAD
    public static function castExtension(\ReflectionExtension $c, array $a, Stub $stub, $isNested)
    {
        self::addMap($a, $c, array(
=======
    public static function castReference(\ReflectionReference $c, array $a, Stub $stub, bool $isNested)
    {
        $a[Caster::PREFIX_VIRTUAL.'id'] = $c->getId();

        return $a;
    }

    public static function castExtension(\ReflectionExtension $c, array $a, Stub $stub, bool $isNested)
    {
        self::addMap($a, $c, [
>>>>>>> v2-test
            'version' => 'getVersion',
            'dependencies' => 'getDependencies',
            'iniEntries' => 'getIniEntries',
            'isPersistent' => 'isPersistent',
            'isTemporary' => 'isTemporary',
            'constants' => 'getConstants',
            'functions' => 'getFunctions',
            'classes' => 'getClasses',
<<<<<<< HEAD
        ));
=======
        ]);
>>>>>>> v2-test

        return $a;
    }

<<<<<<< HEAD
    public static function castZendExtension(\ReflectionZendExtension $c, array $a, Stub $stub, $isNested)
    {
        self::addMap($a, $c, array(
=======
    public static function castZendExtension(\ReflectionZendExtension $c, array $a, Stub $stub, bool $isNested)
    {
        self::addMap($a, $c, [
>>>>>>> v2-test
            'version' => 'getVersion',
            'author' => 'getAuthor',
            'copyright' => 'getCopyright',
            'url' => 'getURL',
<<<<<<< HEAD
        ));
=======
        ]);
>>>>>>> v2-test

        return $a;
    }

<<<<<<< HEAD
    private static function addExtra(&$a, \Reflector $c)
    {
        $a = &$a[Caster::PREFIX_VIRTUAL.'extra'];

        if (method_exists($c, 'getFileName') && $m = $c->getFileName()) {
            $a['file'] = $m;
            $a['line'] = $c->getStartLine().' to '.$c->getEndLine();
        }

        self::addMap($a, $c, self::$extraMap, '');
    }

    private static function addMap(&$a, \Reflector $c, $map, $prefix = Caster::PREFIX_VIRTUAL)
    {
        foreach ($map as $k => $m) {
=======
    public static function getSignature(array $a)
    {
        $prefix = Caster::PREFIX_VIRTUAL;
        $signature = '';

        if (isset($a[$prefix.'parameters'])) {
            foreach ($a[$prefix.'parameters']->value as $k => $param) {
                $signature .= ', ';
                if ($type = $param->getType()) {
                    if (!$type instanceof \ReflectionNamedType) {
                        $signature .= $type.' ';
                    } else {
                        if (!$param->isOptional() && $param->allowsNull() && 'mixed' !== $type->getName()) {
                            $signature .= '?';
                        }
                        $signature .= substr(strrchr('\\'.$type->getName(), '\\'), 1).' ';
                    }
                }
                $signature .= $k;

                if (!$param->isDefaultValueAvailable()) {
                    continue;
                }
                $v = $param->getDefaultValue();
                $signature .= ' = ';

                if ($param->isDefaultValueConstant()) {
                    $signature .= substr(strrchr('\\'.$param->getDefaultValueConstantName(), '\\'), 1);
                } elseif (null === $v) {
                    $signature .= 'null';
                } elseif (\is_array($v)) {
                    $signature .= $v ? '[…'.\count($v).']' : '[]';
                } elseif (\is_string($v)) {
                    $signature .= 10 > \strlen($v) && false === strpos($v, '\\') ? "'{$v}'" : "'…".\strlen($v)."'";
                } elseif (\is_bool($v)) {
                    $signature .= $v ? 'true' : 'false';
                } else {
                    $signature .= $v;
                }
            }
        }
        $signature = (empty($a[$prefix.'returnsReference']) ? '' : '&').'('.substr($signature, 2).')';

        if (isset($a[$prefix.'returnType'])) {
            $signature .= ': '.substr(strrchr('\\'.$a[$prefix.'returnType'], '\\'), 1);
        }

        return $signature;
    }

    private static function addExtra(array &$a, \Reflector $c)
    {
        $x = isset($a[Caster::PREFIX_VIRTUAL.'extra']) ? $a[Caster::PREFIX_VIRTUAL.'extra']->value : [];

        if (method_exists($c, 'getFileName') && $m = $c->getFileName()) {
            $x['file'] = new LinkStub($m, $c->getStartLine());
            $x['line'] = $c->getStartLine().' to '.$c->getEndLine();
        }

        self::addMap($x, $c, self::EXTRA_MAP, '');

        if ($x) {
            $a[Caster::PREFIX_VIRTUAL.'extra'] = new EnumStub($x);
        }
    }

    private static function addMap(array &$a, object $c, array $map, string $prefix = Caster::PREFIX_VIRTUAL)
    {
        foreach ($map as $k => $m) {
            if (\PHP_VERSION_ID >= 80000 && 'isDisabled' === $k) {
                continue;
            }

>>>>>>> v2-test
            if (method_exists($c, $m) && false !== ($m = $c->$m()) && null !== $m) {
                $a[$prefix.$k] = $m instanceof \Reflector ? $m->name : $m;
            }
        }
    }
<<<<<<< HEAD
=======

    private static function addAttributes(array &$a, \Reflector $c, string $prefix = Caster::PREFIX_VIRTUAL): void
    {
        if (\PHP_VERSION_ID >= 80000) {
            foreach ($c->getAttributes() as $n) {
                $a[$prefix.'attributes'][] = $n;
            }
        }
    }
>>>>>>> v2-test
}
