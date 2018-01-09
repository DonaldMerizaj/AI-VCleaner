<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/17/2017
 * Time: 6:02 PM
 */

class Room
{
    public $width;
    public $height;
    public $dirtLevel;
    public $matrix;
    public $dirtRate, $dirtVector;

    const CLEAN_CELL = 3, MOVE = 1, CHANGE_ROOM = 2;

    public function __construct($width, $height, $dirtLevel, $vc_obj)
    {
        $this->width = $width;
        $this->height = $height;
        $this->dirtLevel = $dirtLevel;
        $this->setDirty($dirtLevel);
//        $this->cleanRoom($vc_obj);
    }

    public function setDirty($dirtLevel)
    {
        $temp_dirt_rate = 0;
        $vector_index = 0;
        try {
            for ($j = 0; $j < $this->height; $j++) {
                for ($i = 0; $i < $this->width; $i++) {
                    //gjenerohet nje numer random midis 0-1
                    $temp_rand = rand(0, 9);
//                    if ($i % 2 != 0) {
//                        $this->matrix[$j][$i] = 1;
//                        $this->dirtVector[$vector_index] = [$j,$i];
//                        $vector_index++;
//                    } else {
//                        $this->matrix[$j][$i] = 1;
//                        $this->dirtVector[$vector_index] = [$j,$i];
//                        $vector_index++;
//                    }
                    //nese niveli i ndotjes eshte i ulet, gjenerohet me pak vlera '1'
                    //perndryshe vlera e qelizes eshte '0'
                    if ($dirtLevel == 1) {
                        if ($temp_rand > 7) {
                            $this->matrix[$i][$j] = 1;
                            $this->dirtVector[$vector_index] = [$i, $j];
                            $vector_index++;
                            $temp_dirt_rate++;
                        } else {
                            $this->matrix[$i][$j] = 0;
                        }
                    } else if ($dirtLevel == 2) {
                        if ($temp_rand > 4) {
                            $this->matrix[$i][$j] = 1;
                            $this->dirtVector[$vector_index] = [$i, $j];
                            $vector_index++;
                            $temp_dirt_rate++;
                        } else {
                            $this->matrix[$i][$j] = 0;
                        }
                    } else if ($dirtLevel == 0) {
                        $this->matrix[$i][$j] = 0;
                    }
                    //krijon nje vektor me koordinatat e qelizave te papastra
                }
            }
            $this->dirtRate = ($temp_dirt_rate / ($this->width * $this->height)) * 100;
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }

    public function getDirty()
    {
        return $this->dirtRate;
    }

    public function printMatrixRoom()
    {
        try {
            $matrix_string = "";
            for ($j = 0; $j < $this->height; $j++) {
                $matrix_string .= "<tr>";
                for ($i = 0; $i < $this->width; $i++) {
                    if ($this->matrix[$j][$i] == 1) {
                        $matrix_string .= '<td><i class="fa fa-eercast"></i></td>';
                    } else {
                        $matrix_string .= '<td></td>';
                    }
                }
                $matrix_string .= "</tr>";
            }

            return [
                'table' => $matrix_string,
                'dirt_rate' => $this->dirtRate
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    public function cleanRoom(VCleaner $vc_obj)
    {
//        Pozicioni fillestar i Vacuum cleaner
        $vcPos = $vc_obj->getCurrentPos();
        $energy_spent = 0;
        echo "\n Vector" . json_encode($this->dirtVector);
        $temp_nearest = $this->width + $this->height;
        $vector = $this->dirtVector;
        $cleaned_cells = 0;

        //trendi, nese gjen dy qeliza me largesi te njejte,
        // ne menyre random zgjedh nje prej tyre, dhe me pas ruan nje trend,
        // 1- down - majtas
        // 2- up - djathtas

        while (count($vector) > $cleaned_cells) {
            $cell_cleaned = -1;
            $temp_energy_spent = 0;
//          Llogaris piken me te afert e cila ndodhet ne vektorin e pikave te pista
            for ($index = 0; $index < count($vector); $index++) {
                if ($vector[$index] && !is_array($vector[$index])) {
                    continue;
                }

                $x_real = $vector[$index][0] - $vcPos[0];
                $y_real = $vector[$index][1] - $vcPos[1];

                //distanca ne vlere absolute e pikes
                $x_nearest = abs($x_real);
                $y_nearest = abs($y_real);

                echo "\n --------------" . $index . '-------------';
                echo "\n x_c:" . $vector[$index][0] . ' + y_c:' . $vector[$index][1];
                echo "\n x:" . $x_nearest . ' + y:' . $y_nearest;

                echo "\n temp_nearest: " . $temp_nearest;
                echo " \n cell_distance: " . ($x_nearest + $y_nearest);

                if ($temp_nearest > ($x_nearest + $y_nearest)) {

                    $temp_nearest = $x_nearest + $y_nearest;
                    $temp_energy_spent = $temp_nearest * self::MOVE;
                    echo "\n temp_nearest_after = " . $temp_nearest;
                    $cell_cleaned = $index;
                    echo " -> " . json_encode($vector[$index]);
                } else
                    if ($temp_nearest == (($x_nearest + $y_nearest))) {
                        //nese dy qeliza jane njisoj larg nga VCleaner
                        //zgjedh te leviz te njere prej tyre ne menyre random
                        if (rand(1, 6) >= 4) {
                            $temp_nearest = $x_nearest + $y_nearest;
                            $temp_energy_spent = $temp_nearest * self::MOVE;
                            echo "\n temp_nearest_after _random = " . $temp_nearest;
                            $cell_cleaned = $index;
                            echo " -> " . json_encode($vector[$index]);
                        }
                    }
            }
            $temp_nearest = $this->width + $this->height;
            echo "\n ** REZ::";
            echo "\n cleaned at: " . $cell_cleaned;
            echo "\n curr_VC: [ " . $vcPos[0] . "; " . $vcPos[1] . " ] ";

            if ($cell_cleaned > -1) {
                $vcPos = $vc_obj->update_vcPos($vector[$cell_cleaned][0], $vector[$cell_cleaned][1]);
//                per pastrimin e nje qelize shpenzon 3 energji
                $temp_energy_spent += self::CLEAN_CELL;
                $energy_spent += $temp_energy_spent;

                $vc_obj->vcEnergySpent = $energy_spent;

//                $temp_vector = [];
//                for($x = 0; $x < $cell_cleaned; $x++){
//                    $temp_vector[$x][0] = $vector[$x][0];
//                    $temp_vector[$x][1] = $vector[$x][1];
//                }
//                for ($x = $cell_cleaned; $x < count($vector)-1; $x++) {
//                    $temp_vector = $vector[$x + 1];
//                }
                $vector[$cell_cleaned] = true;
                $cleaned_cells++;

                echo "\n VC_POS_after:" . json_encode($vcPos);
                echo "\n vector_after_clean:" . json_encode($vector);
//                echo "\n length:" . count($vector);
                echo "\n ENERGY SPENT:" . $temp_energy_spent;
                echo "\n TOTAL EN SPENT:" . $energy_spent;
            }
        }
    }

}