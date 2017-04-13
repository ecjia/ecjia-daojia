<?php namespace Royalcms\Component\Timer;

class Timer
{
    /**
	 * All of the stored timers.
	 *
	 * @var array
	 */
	protected $timers = array();
	
	public function __construct($startTime = null)
	{
	    $this->start('royalcms', $startTime, 'Timer since ROYALCMS_START.');
	}
    
    /**
     * Handles the creation of a new timer. Simply supply a name and an
     * optional description.
     *
     * @access  public static
     * @param   string  $name
     * @return  void
    */
    public function start($name, $startTime = null, $description = null)
    {
        // early calculation of start time
        $start = $startTime ?: microtime(true);
        
        $this->timers[$name] = array(
            'description'   => $description,
            'start'         => $start,
            'end'           => null,
            'time'          => null,
            'checkpoints'   => array()
        );
    }
    
    /**
     * Handles the stopping an existing timer. Simply supply a name and an
     * optional number of decimal places. Will return the finalized timer values.
     *
     * @access  public static
     * @param   string  $name
     * @param   int     $decimals
     * @return  array
     */
    public function stop($name, $endTime = null, $decimals = 6)
    {
        // early calculation of stop time
        $end = $endTime ?: microtime(true);
    
        // calculate elapsed time
        $this->timers[$name] = $this->getTimer($name);
        $this->timers[$name]['end'] = $end;
        $this->timers[$name]['time'] =
        round(
            ($end - $this->timers[$name]['start']) * 1000,
            $decimals
        );
    
        return $this->timers[$name];
    }
    
    /**
     * A special timer endpoint which will allow for the creation of several
     * checkpoints based on a singular start timer. To use, specify a start
     * timer name, a unique checkpoint name, an optional checkpoint description
     * describing the timer purpose, and an optional number of decimal places
     * to use for calculating the number of seconds since start time.
     *
     * @access  public
     * @param   string  $name               The start timer name
     * @param   string  $checkpointName     The unique name of the checkpoint
     * @param   mixed   $description        An optional description of the checkpoint
     * @param   int     $decimals           The number of decimal places to include
     */
    public function checkpoint($name, $description = null, $decimals = 6)
    {
        // early calculation of stop time
        $end = microtime(true);
    
        $this->timers[$name] = $this->getTimer($name);
    
        $count = count($this->timers[$name]['checkpoints']);
    
        $this->timers[$name]['checkpoints'][$count] = array(
            'description' => $description,
            'end' => $end,
        );
    
        // calculate elapsed time
        $this->timers[$name]['checkpoints'][$count]['timeFromStart'] =
        round(
            $end - $this->timers[$name]['start'],
            $decimals
        );
    
        if ($count > 0) {
            $this->timers[$name]['checkpoints'][$count]['timeFromLastCheckpoint'] =
            round(
                $end - $this->timers[$name]['checkpoints'][$count - 1]['end'],
                $decimals
            );
        }
    }
    
    /**
     * Helper to retrieve a timer. If none exists, we assume that the timer start
     * time is equivalent to ROYALCMS_START.
     *
     * @access  public
     * @param   string  $name
     * @return  array
     */
    public function getTimer($name)
    {
        if (!empty($this->timers[$name])) {
            return $this->timers[$name];
        }
    
        return array(
            'description' => 'Timer since ROYALCMS_START.',
            'start' => defined('ROYALCMS_START') ? ROYALCMS_START : microtime(true),
            'end' => null,
            'time' => null,
            'checkpoints' => array()
        );
    }
    
    /**
     * Get all of the executed timers.
     *
     * @return array
     */
    public function getTimers()
    {
        // early calculation of stop time
        $end = microtime(true);
        $decimals = 6;
    
        // ensure we end all timers
        foreach ($this->timers as $name => $timer) {
            if ($this->timers[$name]['end'] == null) {
                $this->timers[$name]['end'] = $end;
                $this->timers[$name]['time'] =
                round(
                    $end - $this->timers[$name]['start'],
                    $decimals
                );
            }
        }
    
        return $this->timers;
    }
    
    /**
     * Get the current royalcms application execution time in milliseconds.
     *
     * @return int
     */
    public function getLoadTime()
    {
        return $this->stop('royalcms');
    }
    
    public function formatTimer($timer)
    {
        return number_format($timer['time'] / 1000, 6);
    }
    
    /**
     * A quick method for returning all existing timers in the event you have
     * a problem/error/exception and need to do something with your timers.
     *
     * @access  public
     * @param   bool    $toFile
     * @return  array
     */
    public function dump($toFile = false)
    {
        // if logging to file
        if ($toFile) {
            $this->write();
        }
    
        return $this->getTimers();
    }
    
    /**
     * Attempts to pretty print the timer data to a file for later parsing.
     *
     * @access  public
     * @param   string  $dir
     * @return  void
     */
    public function write()
    {
        $json           = $this->dump();
        $json           = json_encode($json);
        $result         = '';
        $pos            = 0;
        $strLen         = strlen($json);
        $indentStr      = "\t";
        $newLine        = "\n";
        $prevChar       = '';
        $outOfQuotes    = true;
    
        for ($i = 0; $i <= $strLen; $i++) {
            // grab the next character in the string
            $char = substr($json, $i, 1);
    
            // are we inside a quoted string?
            if ($char == '"' && $prevChar != '\\') {
                $outOfQuotes = !$outOfQuotes;
    
                // if this character is the end of an element,
                // output a new line and indent the next line.
            } else if(($char == '}' || $char == ']') && $outOfQuotes) {
                $result .= $newLine;
                $pos--;
                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }
    
            // add the character to the result string.
            $result .= $char;
    
            // if the last character was the beginning of an element,
            // output a new line and indent the next line.
            if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
                $result .= $newLine;
                if ($char == '{' || $char == '[') {
                    $pos ++;
                }
    
                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }
    
            $prevChar = $char;
        }
    
        \RC_Logger::getLogger('timer')->info($result);
    }
    
    /**
     * Clears out all existing timers. Consider this a reset.
     *
     * @access  public
     * @return  void
     */
    public function clear()
    {
        $this->timers = array();
    }
    
}
