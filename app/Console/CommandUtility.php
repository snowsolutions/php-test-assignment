<?php

namespace App\Console;

trait CommandUtility
{
    public function echo($message, $type = 'info' , $items = []) {
        switch ($type) {
            case 'info' : {
                $this->echoInfo($message);
                break;
            }
            case 'success' : {
                $this->echoSuccess($message);
                break;
            }
            case 'error' : {
                $this->echoError($message);
                break;
            }
        }
        if (count($items)) {
            foreach ($items as $item) {
                $this->echoItem($item);
            }
        }
    }

    public function echoSuccess($message) {
        echo "\e[32m$message\e[39m\n";
    }

    public function echoInfo($message) {
        echo "$message\n";
    }

    public function echoError($message) {
        echo "\e[31m$message\e[39m\n";
    }

    public function echoItem($item) {
        $this->echoInfo("- $item");
    }
}
