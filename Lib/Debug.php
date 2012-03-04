<?php

namespace COil\ToolsBundle\Lib;

use Doctrine\Common\Util\Debug as DoctrineDebug;

class Debug
{
    /**
     * Function that dumps an array or object. It uses the Doctrine dumper so we don't
     * get annoyed by Doctrine objects recursions.
     *
     * @param  $var          mixed   Variable to dump
     * @param  $name         string  Name of the var to dump
     * @param  $die          Boolean Tells the function to stop the process or not
     * @param  $maxDepth     integer Max depth allowed when debugging objects
     * @param  $returnBuffer Boolean Tells if the debug must be returned as a string
     *
     * @return string|null
     */
    public function dump($var, $name = 'var', $die = false, $maxDepth = 2, $returnBuffer = false)
    {
        ob_start();
        echo '<br/><pre>'. $name . (is_object($var) ? ' ('. get_class($var). ')' : ''). ' :<br/>';
        DoctrineDebug::dump($var, $maxDepth);
        echo '</pre>';
        $buffer = ob_get_contents();
        ob_end_clean();

        $backtrace = debug_backtrace();
        $dieMsg  = '<pre><b>Process stopped by "coils.tools.debug" service</b>'. PHP_EOL;
        $dieMsg .= isset($backtrace[0]['file']) ?     '&raquo; file     : <b>'.
            $backtrace[0]['file'] .'</b>'. PHP_EOL : '';

        $dieMsg .= isset($backtrace[0]['line']) ?     '&raquo; line     : <b>'.
            $backtrace[0]['line'] .'</b>'. PHP_EOL : '';

        $dieMsg .= isset($backtrace[1]['class']) ?    '&raquo; class    : <b>'.
            $backtrace[1]['class'] .'</b>'. PHP_EOL : '';

        $dieMsg .= isset($backtrace[1]['function']) ? '&raquo; function : <b>'.
            $backtrace[1]['function'] .'</b>'. PHP_EOL : '';

        $dieMsg .= '</pre>';

        if ($returnBuffer) {
            return $buffer;
        } else {
            echo $buffer;
        }

        if (true == $die) {
            die($dieMsg);
        } else {
            echo $dieMsg;
        }
    }

    /**
     * Same function as dump but more suitable for console debug.
     *
     * @see dump()
     * @return string|null
     */
    public function dumpConsole($var, $name = 'var',  $maxDepth = 2, $die = false, $returnBuffer = false)
    {
        ob_start();
        print($name . ' : >');
        DoctrineDebug::dump($var, $maxDepth);
        print('<'. PHP_EOL);

        $buffer = ob_get_contents();
        ob_end_clean();

        if($returnBuffer) {
            return $buffer;
        }

        if ($die == true) {
            die($buffer);
        } else {
            echo $buffer;
        }
    }
}