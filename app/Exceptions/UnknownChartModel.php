<?php

namespace App\Exceptions;

use Exception;

class UnknownChartModel extends Exception
{
    public function errorMessage() {
        //error message
        $errorMsg = 'Error on line '.$this->getLine().' in '.$this->getFile()
            .': <b>'.$this->getMessage().'</b> is not a valid Eloquent Model for a Chart';
        return $errorMsg;
    }
}
