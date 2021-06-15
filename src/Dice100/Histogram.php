<?php

namespace Magm19\Dice100;

/**
 * Generating histogram data.
 */
class Histogram
{
    /**
     * @var array $serie  The numbers stored in sequence.
     * @var int   $min    The lowest possible number.
     * @var int   $max    The highest possible number.
     */
    private $serie = [];
    private $min;
    private $max;



    /**
     * Get the serie.
     *
     * @return array with the serie.
     */
    public function getSerie()
    {
        return $this->serie;
    }



    /**
     * Inject the object to use as base for the histogram data.
     *
     * @param HistogramInterface $object The object holding the serie.
     *
     * @return void.
     */
    public function injectData(HistogramInterface $object)
    {
        $this->serie = $object->getHistogramSerie();
        $this->min   = $object->getHistogramMin();
        $this->max   = $object->getHistogramMax();
    }



    /**
     * Return a string with a textual representation of the histogram.
     *
     * @return string representing the histogram.
     */
    public function getAsText()
    {
        $result = "";
        $numList = array_count_values($this->serie);

        if ($this->min && $this->max) {
            for ($i = $this->min; $i <= $this->max; $i++) {
                if (!array_key_exists($i, $numList)) {
                    $numList[$i] = 0;
                }
            }

            foreach ($numList as $num) {
                if ($num < $this->min || $num > $this->max) {
                    unset($numList[$num]);
                }
            }
        }

        ksort($numList);

        foreach ($numList as $num => $val) {
            $result .= $num . ": " . str_repeat("*", $val) . "<br>";
        }

        return $result;
    }
}