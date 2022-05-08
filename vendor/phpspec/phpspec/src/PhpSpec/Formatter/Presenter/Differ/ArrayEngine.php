<?php

/*
 * This file is part of PhpSpec, A php toolset to drive emergent
 * design by specification.
 *
 * (c) Marcello Duarte <marcello.duarte@gmail.com>
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpSpec\Formatter\Presenter\Differ;

<<<<<<< HEAD
class ArrayEngine extends StringEngine
{
    public function supports($expected, $actual)
    {
        return is_array($expected) && is_array($actual);
    }

    public function compare($expected, $actual)
    {
        $expectedString = $this->convertArrayToString($expected);
        $actualString   = $this->convertArrayToString($actual);
=======
use SebastianBergmann\Exporter\Exporter;

final class ArrayEngine extends StringEngine
{
    private const PAD_SIZE = 2;

    private const PAD_STRING = ' ';

    private $exporter;

    public function __construct(Exporter $exporter)
    {
        $this->exporter = $exporter;
    }

    public function supports($expected, $actual): bool
    {
        return \is_array($expected) && \is_array($actual);
    }

    public function compare($expected, $actual): string
    {
        $expectedString = $this->convertArrayToString($expected);
        $actualString = $this->convertArrayToString($actual);
>>>>>>> v2-test

        return parent::compare($expectedString, $actualString);
    }

<<<<<<< HEAD
    private function convertArrayToString(array $a, $pad = 2)
    {
        $str = str_pad('', $pad, ' ').'[';
        foreach ($a as $key => $val) {
            switch ($type = strtolower(gettype($val))) {
=======
    private function convertArrayToString(array $a, $pad = 1): string
    {
        $str = str_pad('', $pad * self::PAD_SIZE, self::PAD_STRING) . '[';
        foreach ($a as $key => $val) {
            switch ($type = strtolower(\gettype($val))) {
>>>>>>> v2-test
                case 'array':
                    $line = sprintf(
                        '%s => %s,',
                        $key,
<<<<<<< HEAD
                        ltrim($this->convertArrayToString($val, $pad+2))
=======
                        ltrim($this->convertArrayToString($val, $pad + 1))
>>>>>>> v2-test
                    );
                    break;
                case 'null':
                    $line = sprintf('%s => null,', $key);
                    break;
                case 'boolean':
                    $line = sprintf('%s => %s,', $key, $val ? 'true' : 'false');
                    break;
                case 'object':
<<<<<<< HEAD
                    $line = sprintf(
                        '%s => %s#%s,',
                        $key,
                        get_class($val),
                        spl_object_hash($val)
=======
                    $exporterPadSize = 4;
                    $padCorrection = self::PAD_SIZE / $exporterPadSize;
                    $line = sprintf(
                        '%s => %s,',
                        $key,
                        $this->exporter->export($val, (int)(($pad + 1) * $padCorrection))
>>>>>>> v2-test
                    );
                    break;
                case 'string':
                    $val = sprintf('"%s"', $val);
                    $line = sprintf('%s => %s,', $key, $val);
                    break;
                case 'integer':
                case 'double':
                    $line = sprintf('%s => %s,', $key, $val);
                    break;
                default:
                    $line = sprintf('%s => %s:%s,', $key, $type, $val);
            }
<<<<<<< HEAD
            $str .= PHP_EOL.str_pad('', $pad+2, ' ').$line;
        }
        $str .= PHP_EOL.str_pad('', $pad, ' ').']';
=======
            $str .= PHP_EOL . str_pad('', ($pad + 1) * self::PAD_SIZE, self::PAD_STRING) . $line;
        }
        $str .= PHP_EOL . str_pad('', $pad * self::PAD_SIZE, self::PAD_STRING) . ']';
>>>>>>> v2-test

        return $str;
    }
}
