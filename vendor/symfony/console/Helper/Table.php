<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Helper;

use Symfony\Component\Console\Exception\InvalidArgumentException;
<<<<<<< HEAD
=======
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Formatter\WrappableOutputFormatterInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;
>>>>>>> v2-test
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Provides helpers to display a table.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Саша Стаменковић <umpirsky@gmail.com>
 * @author Abdellatif Ait boudad <a.aitboudad@gmail.com>
 * @author Max Grigorian <maxakawizard@gmail.com>
<<<<<<< HEAD
 */
class Table
{
    /**
     * Table headers.
     */
    private $headers = array();
=======
 * @author Dany Maillard <danymaillard93b@gmail.com>
 */
class Table
{
    private const SEPARATOR_TOP = 0;
    private const SEPARATOR_TOP_BOTTOM = 1;
    private const SEPARATOR_MID = 2;
    private const SEPARATOR_BOTTOM = 3;
    private const BORDER_OUTSIDE = 0;
    private const BORDER_INSIDE = 1;

    private $headerTitle;
    private $footerTitle;

    /**
     * Table headers.
     */
    private $headers = [];
>>>>>>> v2-test

    /**
     * Table rows.
     */
<<<<<<< HEAD
    private $rows = array();
=======
    private $rows = [];
    private $horizontal = false;
>>>>>>> v2-test

    /**
     * Column widths cache.
     */
<<<<<<< HEAD
    private $effectiveColumnWidths = array();
=======
    private $effectiveColumnWidths = [];
>>>>>>> v2-test

    /**
     * Number of columns cache.
     *
     * @var int
     */
    private $numberOfColumns;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var TableStyle
     */
    private $style;

    /**
     * @var array
     */
<<<<<<< HEAD
    private $columnStyles = array();
=======
    private $columnStyles = [];
>>>>>>> v2-test

    /**
     * User set column widths.
     *
     * @var array
     */
<<<<<<< HEAD
    private $columnWidths = array();

    private static $styles;

=======
    private $columnWidths = [];
    private $columnMaxWidths = [];

    private static $styles;

    private $rendered = false;

>>>>>>> v2-test
    public function __construct(OutputInterface $output)
    {
        $this->output = $output;

        if (!self::$styles) {
            self::$styles = self::initStyles();
        }

        $this->setStyle('default');
    }

    /**
     * Sets a style definition.
<<<<<<< HEAD
     *
     * @param string     $name  The style name
     * @param TableStyle $style A TableStyle instance
     */
    public static function setStyleDefinition($name, TableStyle $style)
=======
     */
    public static function setStyleDefinition(string $name, TableStyle $style)
>>>>>>> v2-test
    {
        if (!self::$styles) {
            self::$styles = self::initStyles();
        }

        self::$styles[$name] = $style;
    }

    /**
     * Gets a style definition by name.
     *
<<<<<<< HEAD
     * @param string $name The style name
     *
     * @return TableStyle
     */
    public static function getStyleDefinition($name)
=======
     * @return TableStyle
     */
    public static function getStyleDefinition(string $name)
>>>>>>> v2-test
    {
        if (!self::$styles) {
            self::$styles = self::initStyles();
        }

        if (isset(self::$styles[$name])) {
            return self::$styles[$name];
        }

        throw new InvalidArgumentException(sprintf('Style "%s" is not defined.', $name));
    }

    /**
     * Sets table style.
     *
     * @param TableStyle|string $name The style name or a TableStyle instance
     *
     * @return $this
     */
    public function setStyle($name)
    {
        $this->style = $this->resolveStyle($name);

        return $this;
    }

    /**
     * Gets the current table style.
     *
     * @return TableStyle
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Sets table column style.
     *
<<<<<<< HEAD
     * @param int               $columnIndex Column index
     * @param TableStyle|string $name        The style name or a TableStyle instance
     *
     * @return $this
     */
    public function setColumnStyle($columnIndex, $name)
    {
        $columnIndex = (int) $columnIndex;

=======
     * @param TableStyle|string $name The style name or a TableStyle instance
     *
     * @return $this
     */
    public function setColumnStyle(int $columnIndex, $name)
    {
>>>>>>> v2-test
        $this->columnStyles[$columnIndex] = $this->resolveStyle($name);

        return $this;
    }

    /**
     * Gets the current style for a column.
     *
     * If style was not set, it returns the global table style.
     *
<<<<<<< HEAD
     * @param int $columnIndex Column index
     *
     * @return TableStyle
     */
    public function getColumnStyle($columnIndex)
    {
        if (isset($this->columnStyles[$columnIndex])) {
            return $this->columnStyles[$columnIndex];
        }

        return $this->getStyle();
=======
     * @return TableStyle
     */
    public function getColumnStyle(int $columnIndex)
    {
        return $this->columnStyles[$columnIndex] ?? $this->getStyle();
>>>>>>> v2-test
    }

    /**
     * Sets the minimum width of a column.
     *
<<<<<<< HEAD
     * @param int $columnIndex Column index
     * @param int $width       Minimum column width in characters
     *
     * @return $this
     */
    public function setColumnWidth($columnIndex, $width)
    {
        $this->columnWidths[(int) $columnIndex] = (int) $width;
=======
     * @return $this
     */
    public function setColumnWidth(int $columnIndex, int $width)
    {
        $this->columnWidths[$columnIndex] = $width;
>>>>>>> v2-test

        return $this;
    }

    /**
     * Sets the minimum width of all columns.
     *
<<<<<<< HEAD
     * @param array $widths
     *
=======
>>>>>>> v2-test
     * @return $this
     */
    public function setColumnWidths(array $widths)
    {
<<<<<<< HEAD
        $this->columnWidths = array();
=======
        $this->columnWidths = [];
>>>>>>> v2-test
        foreach ($widths as $index => $width) {
            $this->setColumnWidth($index, $width);
        }

        return $this;
    }

<<<<<<< HEAD
=======
    /**
     * Sets the maximum width of a column.
     *
     * Any cell within this column which contents exceeds the specified width will be wrapped into multiple lines, while
     * formatted strings are preserved.
     *
     * @return $this
     */
    public function setColumnMaxWidth(int $columnIndex, int $width): self
    {
        if (!$this->output->getFormatter() instanceof WrappableOutputFormatterInterface) {
            throw new \LogicException(sprintf('Setting a maximum column width is only supported when using a "%s" formatter, got "%s".', WrappableOutputFormatterInterface::class, get_debug_type($this->output->getFormatter())));
        }

        $this->columnMaxWidths[$columnIndex] = $width;

        return $this;
    }

>>>>>>> v2-test
    public function setHeaders(array $headers)
    {
        $headers = array_values($headers);
        if (!empty($headers) && !\is_array($headers[0])) {
<<<<<<< HEAD
            $headers = array($headers);
=======
            $headers = [$headers];
>>>>>>> v2-test
        }

        $this->headers = $headers;

        return $this;
    }

    public function setRows(array $rows)
    {
<<<<<<< HEAD
        $this->rows = array();
=======
        $this->rows = [];
>>>>>>> v2-test

        return $this->addRows($rows);
    }

    public function addRows(array $rows)
    {
        foreach ($rows as $row) {
            $this->addRow($row);
        }

        return $this;
    }

    public function addRow($row)
    {
        if ($row instanceof TableSeparator) {
            $this->rows[] = $row;

            return $this;
        }

        if (!\is_array($row)) {
            throw new InvalidArgumentException('A row must be an array or a TableSeparator instance.');
        }

        $this->rows[] = array_values($row);

        return $this;
    }

<<<<<<< HEAD
=======
    /**
     * Adds a row to the table, and re-renders the table.
     */
    public function appendRow($row): self
    {
        if (!$this->output instanceof ConsoleSectionOutput) {
            throw new RuntimeException(sprintf('Output should be an instance of "%s" when calling "%s".', ConsoleSectionOutput::class, __METHOD__));
        }

        if ($this->rendered) {
            $this->output->clear($this->calculateRowCount());
        }

        $this->addRow($row);
        $this->render();

        return $this;
    }

>>>>>>> v2-test
    public function setRow($column, array $row)
    {
        $this->rows[$column] = $row;

        return $this;
    }

<<<<<<< HEAD
=======
    public function setHeaderTitle(?string $title): self
    {
        $this->headerTitle = $title;

        return $this;
    }

    public function setFooterTitle(?string $title): self
    {
        $this->footerTitle = $title;

        return $this;
    }

    public function setHorizontal(bool $horizontal = true): self
    {
        $this->horizontal = $horizontal;

        return $this;
    }

>>>>>>> v2-test
    /**
     * Renders table to output.
     *
     * Example:
<<<<<<< HEAD
     * <code>
     * +---------------+-----------------------+------------------+
     * | ISBN          | Title                 | Author           |
     * +---------------+-----------------------+------------------+
     * | 99921-58-10-7 | Divine Comedy         | Dante Alighieri  |
     * | 9971-5-0210-0 | A Tale of Two Cities  | Charles Dickens  |
     * | 960-425-059-0 | The Lord of the Rings | J. R. R. Tolkien |
     * +---------------+-----------------------+------------------+
     * </code>
     */
    public function render()
    {
        $this->calculateNumberOfColumns();
        $rows = $this->buildTableRows($this->rows);
        $headers = $this->buildTableRows($this->headers);

        $this->calculateColumnsWidth(array_merge($headers, $rows));

        $this->renderRowSeparator();
        if (!empty($headers)) {
            foreach ($headers as $header) {
                $this->renderRow($header, $this->style->getCellHeaderFormat());
                $this->renderRowSeparator();
            }
        }
        foreach ($rows as $row) {
            if ($row instanceof TableSeparator) {
                $this->renderRowSeparator();
            } else {
                $this->renderRow($row, $this->style->getCellRowFormat());
            }
        }
        if (!empty($rows)) {
            $this->renderRowSeparator();
        }

        $this->cleanup();
=======
     *
     *     +---------------+-----------------------+------------------+
     *     | ISBN          | Title                 | Author           |
     *     +---------------+-----------------------+------------------+
     *     | 99921-58-10-7 | Divine Comedy         | Dante Alighieri  |
     *     | 9971-5-0210-0 | A Tale of Two Cities  | Charles Dickens  |
     *     | 960-425-059-0 | The Lord of the Rings | J. R. R. Tolkien |
     *     +---------------+-----------------------+------------------+
     */
    public function render()
    {
        $divider = new TableSeparator();
        if ($this->horizontal) {
            $rows = [];
            foreach ($this->headers[0] ?? [] as $i => $header) {
                $rows[$i] = [$header];
                foreach ($this->rows as $row) {
                    if ($row instanceof TableSeparator) {
                        continue;
                    }
                    if (isset($row[$i])) {
                        $rows[$i][] = $row[$i];
                    } elseif ($rows[$i][0] instanceof TableCell && $rows[$i][0]->getColspan() >= 2) {
                        // Noop, there is a "title"
                    } else {
                        $rows[$i][] = null;
                    }
                }
            }
        } else {
            $rows = array_merge($this->headers, [$divider], $this->rows);
        }

        $this->calculateNumberOfColumns($rows);

        $rows = $this->buildTableRows($rows);
        $this->calculateColumnsWidth($rows);

        $isHeader = !$this->horizontal;
        $isFirstRow = $this->horizontal;
        foreach ($rows as $row) {
            if ($divider === $row) {
                $isHeader = false;
                $isFirstRow = true;

                continue;
            }
            if ($row instanceof TableSeparator) {
                $this->renderRowSeparator();

                continue;
            }
            if (!$row) {
                continue;
            }

            if ($isHeader || $isFirstRow) {
                if ($isFirstRow) {
                    $this->renderRowSeparator(self::SEPARATOR_TOP_BOTTOM);
                    $isFirstRow = false;
                } else {
                    $this->renderRowSeparator(self::SEPARATOR_TOP, $this->headerTitle, $this->style->getHeaderTitleFormat());
                }
            }
            if ($this->horizontal) {
                $this->renderRow($row, $this->style->getCellRowFormat(), $this->style->getCellHeaderFormat());
            } else {
                $this->renderRow($row, $isHeader ? $this->style->getCellHeaderFormat() : $this->style->getCellRowFormat());
            }
        }
        $this->renderRowSeparator(self::SEPARATOR_BOTTOM, $this->footerTitle, $this->style->getFooterTitleFormat());

        $this->cleanup();
        $this->rendered = true;
>>>>>>> v2-test
    }

    /**
     * Renders horizontal header separator.
     *
<<<<<<< HEAD
     * Example: <code>+-----+-----------+-------+</code>
     */
    private function renderRowSeparator()
=======
     * Example:
     *
     *     +-----+-----------+-------+
     */
    private function renderRowSeparator(int $type = self::SEPARATOR_MID, string $title = null, string $titleFormat = null)
>>>>>>> v2-test
    {
        if (0 === $count = $this->numberOfColumns) {
            return;
        }

<<<<<<< HEAD
        if (!$this->style->getHorizontalBorderChar() && !$this->style->getCrossingChar()) {
            return;
        }

        $markup = $this->style->getCrossingChar();
        for ($column = 0; $column < $count; ++$column) {
            $markup .= str_repeat($this->style->getHorizontalBorderChar(), $this->effectiveColumnWidths[$column]).$this->style->getCrossingChar();
=======
        $borders = $this->style->getBorderChars();
        if (!$borders[0] && !$borders[2] && !$this->style->getCrossingChar()) {
            return;
        }

        $crossings = $this->style->getCrossingChars();
        if (self::SEPARATOR_MID === $type) {
            [$horizontal, $leftChar, $midChar, $rightChar] = [$borders[2], $crossings[8], $crossings[0], $crossings[4]];
        } elseif (self::SEPARATOR_TOP === $type) {
            [$horizontal, $leftChar, $midChar, $rightChar] = [$borders[0], $crossings[1], $crossings[2], $crossings[3]];
        } elseif (self::SEPARATOR_TOP_BOTTOM === $type) {
            [$horizontal, $leftChar, $midChar, $rightChar] = [$borders[0], $crossings[9], $crossings[10], $crossings[11]];
        } else {
            [$horizontal, $leftChar, $midChar, $rightChar] = [$borders[0], $crossings[7], $crossings[6], $crossings[5]];
        }

        $markup = $leftChar;
        for ($column = 0; $column < $count; ++$column) {
            $markup .= str_repeat($horizontal, $this->effectiveColumnWidths[$column]);
            $markup .= $column === $count - 1 ? $rightChar : $midChar;
        }

        if (null !== $title) {
            $titleLength = Helper::strlenWithoutDecoration($formatter = $this->output->getFormatter(), $formattedTitle = sprintf($titleFormat, $title));
            $markupLength = Helper::strlen($markup);
            if ($titleLength > $limit = $markupLength - 4) {
                $titleLength = $limit;
                $formatLength = Helper::strlenWithoutDecoration($formatter, sprintf($titleFormat, ''));
                $formattedTitle = sprintf($titleFormat, Helper::substr($title, 0, $limit - $formatLength - 3).'...');
            }

            $titleStart = ($markupLength - $titleLength) / 2;
            if (false === mb_detect_encoding($markup, null, true)) {
                $markup = substr_replace($markup, $formattedTitle, $titleStart, $titleLength);
            } else {
                $markup = mb_substr($markup, 0, $titleStart).$formattedTitle.mb_substr($markup, $titleStart + $titleLength);
            }
>>>>>>> v2-test
        }

        $this->output->writeln(sprintf($this->style->getBorderFormat(), $markup));
    }

    /**
     * Renders vertical column separator.
     */
<<<<<<< HEAD
    private function renderColumnSeparator()
    {
        return sprintf($this->style->getBorderFormat(), $this->style->getVerticalBorderChar());
=======
    private function renderColumnSeparator(int $type = self::BORDER_OUTSIDE): string
    {
        $borders = $this->style->getBorderChars();

        return sprintf($this->style->getBorderFormat(), self::BORDER_OUTSIDE === $type ? $borders[1] : $borders[3]);
>>>>>>> v2-test
    }

    /**
     * Renders table row.
     *
<<<<<<< HEAD
     * Example: <code>| 9971-5-0210-0 | A Tale of Two Cities  | Charles Dickens  |</code>
     *
     * @param array  $row
     * @param string $cellFormat
     */
    private function renderRow(array $row, $cellFormat)
    {
        if (empty($row)) {
            return;
        }

        $rowContent = $this->renderColumnSeparator();
        foreach ($this->getRowColumns($row) as $column) {
            $rowContent .= $this->renderCell($row, $column, $cellFormat);
            $rowContent .= $this->renderColumnSeparator();
=======
     * Example:
     *
     *     | 9971-5-0210-0 | A Tale of Two Cities  | Charles Dickens  |
     */
    private function renderRow(array $row, string $cellFormat, string $firstCellFormat = null)
    {
        $rowContent = $this->renderColumnSeparator(self::BORDER_OUTSIDE);
        $columns = $this->getRowColumns($row);
        $last = \count($columns) - 1;
        foreach ($columns as $i => $column) {
            if ($firstCellFormat && 0 === $i) {
                $rowContent .= $this->renderCell($row, $column, $firstCellFormat);
            } else {
                $rowContent .= $this->renderCell($row, $column, $cellFormat);
            }
            $rowContent .= $this->renderColumnSeparator($last === $i ? self::BORDER_OUTSIDE : self::BORDER_INSIDE);
>>>>>>> v2-test
        }
        $this->output->writeln($rowContent);
    }

    /**
     * Renders table cell with padding.
<<<<<<< HEAD
     *
     * @param array  $row
     * @param int    $column
     * @param string $cellFormat
     */
    private function renderCell(array $row, $column, $cellFormat)
    {
        $cell = isset($row[$column]) ? $row[$column] : '';
=======
     */
    private function renderCell(array $row, int $column, string $cellFormat): string
    {
        $cell = $row[$column] ?? '';
>>>>>>> v2-test
        $width = $this->effectiveColumnWidths[$column];
        if ($cell instanceof TableCell && $cell->getColspan() > 1) {
            // add the width of the following columns(numbers of colspan).
            foreach (range($column + 1, $column + $cell->getColspan() - 1) as $nextColumn) {
                $width += $this->getColumnSeparatorWidth() + $this->effectiveColumnWidths[$nextColumn];
            }
        }

        // str_pad won't work properly with multi-byte strings, we need to fix the padding
        if (false !== $encoding = mb_detect_encoding($cell, null, true)) {
            $width += \strlen($cell) - mb_strwidth($cell, $encoding);
        }

        $style = $this->getColumnStyle($column);

        if ($cell instanceof TableSeparator) {
<<<<<<< HEAD
            return sprintf($style->getBorderFormat(), str_repeat($style->getHorizontalBorderChar(), $width));
=======
            return sprintf($style->getBorderFormat(), str_repeat($style->getBorderChars()[2], $width));
>>>>>>> v2-test
        }

        $width += Helper::strlen($cell) - Helper::strlenWithoutDecoration($this->output->getFormatter(), $cell);
        $content = sprintf($style->getCellRowContentFormat(), $cell);

<<<<<<< HEAD
        return sprintf($cellFormat, str_pad($content, $width, $style->getPaddingChar(), $style->getPadType()));
=======
        $padType = $style->getPadType();
        if ($cell instanceof TableCell && $cell->getStyle() instanceof TableCellStyle) {
            $isNotStyledByTag = !preg_match('/^<(\w+|(\w+=[\w,]+;?)*)>.+<\/(\w+|(\w+=\w+;?)*)?>$/', $cell);
            if ($isNotStyledByTag) {
                $cellFormat = $cell->getStyle()->getCellFormat();
                if (!\is_string($cellFormat)) {
                    $tag = http_build_query($cell->getStyle()->getTagOptions(), null, ';');
                    $cellFormat = '<'.$tag.'>%s</>';
                }

                if (strstr($content, '</>')) {
                    $content = str_replace('</>', '', $content);
                    $width -= 3;
                }
                if (strstr($content, '<fg=default;bg=default>')) {
                    $content = str_replace('<fg=default;bg=default>', '', $content);
                    $width -= \strlen('<fg=default;bg=default>');
                }
            }

            $padType = $cell->getStyle()->getPadByAlign();
        }

        return sprintf($cellFormat, str_pad($content, $width, $style->getPaddingChar(), $padType));
>>>>>>> v2-test
    }

    /**
     * Calculate number of columns for this table.
     */
<<<<<<< HEAD
    private function calculateNumberOfColumns()
    {
        if (null !== $this->numberOfColumns) {
            return;
        }

        $columns = array(0);
        foreach (array_merge($this->headers, $this->rows) as $row) {
=======
    private function calculateNumberOfColumns(array $rows)
    {
        $columns = [0];
        foreach ($rows as $row) {
>>>>>>> v2-test
            if ($row instanceof TableSeparator) {
                continue;
            }

            $columns[] = $this->getNumberOfColumns($row);
        }

        $this->numberOfColumns = max($columns);
    }

<<<<<<< HEAD
    private function buildTableRows($rows)
    {
        $unmergedRows = array();
=======
    private function buildTableRows(array $rows): TableRows
    {
        /** @var WrappableOutputFormatterInterface $formatter */
        $formatter = $this->output->getFormatter();
        $unmergedRows = [];
>>>>>>> v2-test
        for ($rowKey = 0; $rowKey < \count($rows); ++$rowKey) {
            $rows = $this->fillNextRows($rows, $rowKey);

            // Remove any new line breaks and replace it with a new line
            foreach ($rows[$rowKey] as $column => $cell) {
<<<<<<< HEAD
                if (!strstr($cell, "\n")) {
                    continue;
                }
                $lines = explode("\n", str_replace("\n", "<fg=default;bg=default>\n</>", $cell));
                foreach ($lines as $lineKey => $line) {
                    if ($cell instanceof TableCell) {
                        $line = new TableCell($line, array('colspan' => $cell->getColspan()));
=======
                $colspan = $cell instanceof TableCell ? $cell->getColspan() : 1;

                if (isset($this->columnMaxWidths[$column]) && Helper::strlenWithoutDecoration($formatter, $cell) > $this->columnMaxWidths[$column]) {
                    $cell = $formatter->formatAndWrap($cell, $this->columnMaxWidths[$column] * $colspan);
                }
                if (!strstr($cell, "\n")) {
                    continue;
                }
                $escaped = implode("\n", array_map([OutputFormatter::class, 'escapeTrailingBackslash'], explode("\n", $cell)));
                $cell = $cell instanceof TableCell ? new TableCell($escaped, ['colspan' => $cell->getColspan()]) : $escaped;
                $lines = explode("\n", str_replace("\n", "<fg=default;bg=default>\n</>", $cell));
                foreach ($lines as $lineKey => $line) {
                    if ($colspan > 1) {
                        $line = new TableCell($line, ['colspan' => $colspan]);
>>>>>>> v2-test
                    }
                    if (0 === $lineKey) {
                        $rows[$rowKey][$column] = $line;
                    } else {
<<<<<<< HEAD
=======
                        if (!\array_key_exists($rowKey, $unmergedRows) || !\array_key_exists($lineKey, $unmergedRows[$rowKey])) {
                            $unmergedRows[$rowKey][$lineKey] = $this->copyRow($rows, $rowKey);
                        }
>>>>>>> v2-test
                        $unmergedRows[$rowKey][$lineKey][$column] = $line;
                    }
                }
            }
        }

<<<<<<< HEAD
        $tableRows = array();
        foreach ($rows as $rowKey => $row) {
            $tableRows[] = $this->fillCells($row);
            if (isset($unmergedRows[$rowKey])) {
                $tableRows = array_merge($tableRows, $unmergedRows[$rowKey]);
            }
        }

        return $tableRows;
=======
        return new TableRows(function () use ($rows, $unmergedRows): \Traversable {
            foreach ($rows as $rowKey => $row) {
                yield $this->fillCells($row);

                if (isset($unmergedRows[$rowKey])) {
                    foreach ($unmergedRows[$rowKey] as $unmergedRow) {
                        yield $this->fillCells($unmergedRow);
                    }
                }
            }
        });
    }

    private function calculateRowCount(): int
    {
        $numberOfRows = \count(iterator_to_array($this->buildTableRows(array_merge($this->headers, [new TableSeparator()], $this->rows))));

        if ($this->headers) {
            ++$numberOfRows; // Add row for header separator
        }

        if (\count($this->rows) > 0) {
            ++$numberOfRows; // Add row for footer separator
        }

        return $numberOfRows;
>>>>>>> v2-test
    }

    /**
     * fill rows that contains rowspan > 1.
     *
<<<<<<< HEAD
     * @param array $rows
     * @param int   $line
     *
     * @return array
     *
     * @throws InvalidArgumentException
     */
    private function fillNextRows(array $rows, $line)
    {
        $unmergedRows = array();
        foreach ($rows[$line] as $column => $cell) {
            if (null !== $cell && !$cell instanceof TableCell && !is_scalar($cell) && !(\is_object($cell) && method_exists($cell, '__toString'))) {
                throw new InvalidArgumentException(sprintf('A cell must be a TableCell, a scalar or an object implementing __toString, %s given.', \gettype($cell)));
            }
            if ($cell instanceof TableCell && $cell->getRowspan() > 1) {
                $nbLines = $cell->getRowspan() - 1;
                $lines = array($cell);
=======
     * @throws InvalidArgumentException
     */
    private function fillNextRows(array $rows, int $line): array
    {
        $unmergedRows = [];
        foreach ($rows[$line] as $column => $cell) {
            if (null !== $cell && !$cell instanceof TableCell && !is_scalar($cell) && !(\is_object($cell) && method_exists($cell, '__toString'))) {
                throw new InvalidArgumentException(sprintf('A cell must be a TableCell, a scalar or an object implementing "__toString()", "%s" given.', get_debug_type($cell)));
            }
            if ($cell instanceof TableCell && $cell->getRowspan() > 1) {
                $nbLines = $cell->getRowspan() - 1;
                $lines = [$cell];
>>>>>>> v2-test
                if (strstr($cell, "\n")) {
                    $lines = explode("\n", str_replace("\n", "<fg=default;bg=default>\n</>", $cell));
                    $nbLines = \count($lines) > $nbLines ? substr_count($cell, "\n") : $nbLines;

<<<<<<< HEAD
                    $rows[$line][$column] = new TableCell($lines[0], array('colspan' => $cell->getColspan()));
=======
                    $rows[$line][$column] = new TableCell($lines[0], ['colspan' => $cell->getColspan(), 'style' => $cell->getStyle()]);
>>>>>>> v2-test
                    unset($lines[0]);
                }

                // create a two dimensional array (rowspan x colspan)
<<<<<<< HEAD
                $unmergedRows = array_replace_recursive(array_fill($line + 1, $nbLines, array()), $unmergedRows);
                foreach ($unmergedRows as $unmergedRowKey => $unmergedRow) {
                    $value = isset($lines[$unmergedRowKey - $line]) ? $lines[$unmergedRowKey - $line] : '';
                    $unmergedRows[$unmergedRowKey][$column] = new TableCell($value, array('colspan' => $cell->getColspan()));
=======
                $unmergedRows = array_replace_recursive(array_fill($line + 1, $nbLines, []), $unmergedRows);
                foreach ($unmergedRows as $unmergedRowKey => $unmergedRow) {
                    $value = $lines[$unmergedRowKey - $line] ?? '';
                    $unmergedRows[$unmergedRowKey][$column] = new TableCell($value, ['colspan' => $cell->getColspan(), 'style' => $cell->getStyle()]);
>>>>>>> v2-test
                    if ($nbLines === $unmergedRowKey - $line) {
                        break;
                    }
                }
            }
        }

        foreach ($unmergedRows as $unmergedRowKey => $unmergedRow) {
            // we need to know if $unmergedRow will be merged or inserted into $rows
            if (isset($rows[$unmergedRowKey]) && \is_array($rows[$unmergedRowKey]) && ($this->getNumberOfColumns($rows[$unmergedRowKey]) + $this->getNumberOfColumns($unmergedRows[$unmergedRowKey]) <= $this->numberOfColumns)) {
                foreach ($unmergedRow as $cellKey => $cell) {
                    // insert cell into row at cellKey position
<<<<<<< HEAD
                    array_splice($rows[$unmergedRowKey], $cellKey, 0, array($cell));
=======
                    array_splice($rows[$unmergedRowKey], $cellKey, 0, [$cell]);
>>>>>>> v2-test
                }
            } else {
                $row = $this->copyRow($rows, $unmergedRowKey - 1);
                foreach ($unmergedRow as $column => $cell) {
                    if (!empty($cell)) {
                        $row[$column] = $unmergedRow[$column];
                    }
                }
<<<<<<< HEAD
                array_splice($rows, $unmergedRowKey, 0, array($row));
=======
                array_splice($rows, $unmergedRowKey, 0, [$row]);
>>>>>>> v2-test
            }
        }

        return $rows;
    }

    /**
     * fill cells for a row that contains colspan > 1.
<<<<<<< HEAD
     *
     * @return array
     */
    private function fillCells($row)
    {
        $newRow = array();
=======
     */
    private function fillCells($row)
    {
        $newRow = [];

>>>>>>> v2-test
        foreach ($row as $column => $cell) {
            $newRow[] = $cell;
            if ($cell instanceof TableCell && $cell->getColspan() > 1) {
                foreach (range($column + 1, $column + $cell->getColspan() - 1) as $position) {
                    // insert empty value at column position
                    $newRow[] = '';
                }
            }
        }

        return $newRow ?: $row;
    }

<<<<<<< HEAD
    /**
     * @param array $rows
     * @param int   $line
     *
     * @return array
     */
    private function copyRow(array $rows, $line)
=======
    private function copyRow(array $rows, int $line): array
>>>>>>> v2-test
    {
        $row = $rows[$line];
        foreach ($row as $cellKey => $cellValue) {
            $row[$cellKey] = '';
            if ($cellValue instanceof TableCell) {
<<<<<<< HEAD
                $row[$cellKey] = new TableCell('', array('colspan' => $cellValue->getColspan()));
=======
                $row[$cellKey] = new TableCell('', ['colspan' => $cellValue->getColspan()]);
>>>>>>> v2-test
            }
        }

        return $row;
    }

    /**
     * Gets number of columns by row.
<<<<<<< HEAD
     *
     * @return int
     */
    private function getNumberOfColumns(array $row)
=======
     */
    private function getNumberOfColumns(array $row): int
>>>>>>> v2-test
    {
        $columns = \count($row);
        foreach ($row as $column) {
            $columns += $column instanceof TableCell ? ($column->getColspan() - 1) : 0;
        }

        return $columns;
    }

    /**
     * Gets list of columns for the given row.
<<<<<<< HEAD
     *
     * @return array
     */
    private function getRowColumns(array $row)
=======
     */
    private function getRowColumns(array $row): array
>>>>>>> v2-test
    {
        $columns = range(0, $this->numberOfColumns - 1);
        foreach ($row as $cellKey => $cell) {
            if ($cell instanceof TableCell && $cell->getColspan() > 1) {
                // exclude grouped columns.
                $columns = array_diff($columns, range($cellKey + 1, $cellKey + $cell->getColspan() - 1));
            }
        }

        return $columns;
    }

    /**
     * Calculates columns widths.
     */
<<<<<<< HEAD
    private function calculateColumnsWidth(array $rows)
    {
        for ($column = 0; $column < $this->numberOfColumns; ++$column) {
            $lengths = array();
=======
    private function calculateColumnsWidth(iterable $rows)
    {
        for ($column = 0; $column < $this->numberOfColumns; ++$column) {
            $lengths = [];
>>>>>>> v2-test
            foreach ($rows as $row) {
                if ($row instanceof TableSeparator) {
                    continue;
                }

                foreach ($row as $i => $cell) {
                    if ($cell instanceof TableCell) {
                        $textContent = Helper::removeDecoration($this->output->getFormatter(), $cell);
                        $textLength = Helper::strlen($textContent);
                        if ($textLength > 0) {
                            $contentColumns = str_split($textContent, ceil($textLength / $cell->getColspan()));
                            foreach ($contentColumns as $position => $content) {
                                $row[$i + $position] = $content;
                            }
                        }
                    }
                }

                $lengths[] = $this->getCellWidth($row, $column);
            }

<<<<<<< HEAD
            $this->effectiveColumnWidths[$column] = max($lengths) + \strlen($this->style->getCellRowContentFormat()) - 2;
        }
    }

    /**
     * Gets column width.
     *
     * @return int
     */
    private function getColumnSeparatorWidth()
    {
        return \strlen(sprintf($this->style->getBorderFormat(), $this->style->getVerticalBorderChar()));
    }

    /**
     * Gets cell width.
     *
     * @param array $row
     * @param int   $column
     *
     * @return int
     */
    private function getCellWidth(array $row, $column)
=======
            $this->effectiveColumnWidths[$column] = max($lengths) + Helper::strlen($this->style->getCellRowContentFormat()) - 2;
        }
    }

    private function getColumnSeparatorWidth(): int
    {
        return Helper::strlen(sprintf($this->style->getBorderFormat(), $this->style->getBorderChars()[3]));
    }

    private function getCellWidth(array $row, int $column): int
>>>>>>> v2-test
    {
        $cellWidth = 0;

        if (isset($row[$column])) {
            $cell = $row[$column];
            $cellWidth = Helper::strlenWithoutDecoration($this->output->getFormatter(), $cell);
        }

<<<<<<< HEAD
        $columnWidth = isset($this->columnWidths[$column]) ? $this->columnWidths[$column] : 0;

        return max($cellWidth, $columnWidth);
=======
        $columnWidth = $this->columnWidths[$column] ?? 0;
        $cellWidth = max($cellWidth, $columnWidth);

        return isset($this->columnMaxWidths[$column]) ? min($this->columnMaxWidths[$column], $cellWidth) : $cellWidth;
>>>>>>> v2-test
    }

    /**
     * Called after rendering to cleanup cache data.
     */
    private function cleanup()
    {
<<<<<<< HEAD
        $this->effectiveColumnWidths = array();
        $this->numberOfColumns = null;
    }

    private static function initStyles()
    {
        $borderless = new TableStyle();
        $borderless
            ->setHorizontalBorderChar('=')
            ->setVerticalBorderChar(' ')
            ->setCrossingChar(' ')
=======
        $this->effectiveColumnWidths = [];
        $this->numberOfColumns = null;
    }

    private static function initStyles(): array
    {
        $borderless = new TableStyle();
        $borderless
            ->setHorizontalBorderChars('=')
            ->setVerticalBorderChars(' ')
            ->setDefaultCrossingChar(' ')
>>>>>>> v2-test
        ;

        $compact = new TableStyle();
        $compact
<<<<<<< HEAD
            ->setHorizontalBorderChar('')
            ->setVerticalBorderChar(' ')
            ->setCrossingChar('')
=======
            ->setHorizontalBorderChars('')
            ->setVerticalBorderChars(' ')
            ->setDefaultCrossingChar('')
>>>>>>> v2-test
            ->setCellRowContentFormat('%s')
        ;

        $styleGuide = new TableStyle();
        $styleGuide
<<<<<<< HEAD
            ->setHorizontalBorderChar('-')
            ->setVerticalBorderChar(' ')
            ->setCrossingChar(' ')
            ->setCellHeaderFormat('%s')
        ;

        return array(
=======
            ->setHorizontalBorderChars('-')
            ->setVerticalBorderChars(' ')
            ->setDefaultCrossingChar(' ')
            ->setCellHeaderFormat('%s')
        ;

        $box = (new TableStyle())
            ->setHorizontalBorderChars('─')
            ->setVerticalBorderChars('│')
            ->setCrossingChars('┼', '┌', '┬', '┐', '┤', '┘', '┴', '└', '├')
        ;

        $boxDouble = (new TableStyle())
            ->setHorizontalBorderChars('═', '─')
            ->setVerticalBorderChars('║', '│')
            ->setCrossingChars('┼', '╔', '╤', '╗', '╢', '╝', '╧', '╚', '╟', '╠', '╪', '╣')
        ;

        return [
>>>>>>> v2-test
            'default' => new TableStyle(),
            'borderless' => $borderless,
            'compact' => $compact,
            'symfony-style-guide' => $styleGuide,
<<<<<<< HEAD
        );
    }

    private function resolveStyle($name)
=======
            'box' => $box,
            'box-double' => $boxDouble,
        ];
    }

    private function resolveStyle($name): TableStyle
>>>>>>> v2-test
    {
        if ($name instanceof TableStyle) {
            return $name;
        }

        if (isset(self::$styles[$name])) {
            return self::$styles[$name];
        }

        throw new InvalidArgumentException(sprintf('Style "%s" is not defined.', $name));
    }
}
