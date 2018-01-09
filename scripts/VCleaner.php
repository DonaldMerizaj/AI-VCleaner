<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/18/2017
 * Time: 11:44 PM
 */

class VCleaner
{
    public $currentPos;
    public $vcRoom;
    public $vcEnergySpent;

    public function __construct($vcroom)
    {
        // vcRoom = 0/1 (in room A/B)
        // currentPos[ x, y] = coordinates in room
        $this->currentPos = [0,0];
        $this->vcRoom = $vcroom;
        $this->vcEnergySpent = 0;

    }

    public function update_vcPos($x, $y)
    {
       return $this->currentPos = [$x,$y];
    }

    /**
     * @return array
     */
    public function getCurrentPos()
    {
        return $this->currentPos;
    }

    public function getEnergySpent(){
        return $this->vcEnergySpent;
    }

}