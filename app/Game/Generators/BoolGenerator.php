<?php


namespace App\Game\Generators;


class BoolGenerator
{
    protected $seed;

    public function __construct($seed = 2)
    {
        $this->seed = $seed;
    }

    /** a simple function that returns true with probability 1 / $seed
     * @return bool
     */
    public function generate()
    {
        return (rand() % $this->seed) === 0;
    }
}
