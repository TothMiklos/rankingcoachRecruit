<?php
/**
 * User: tothm
 * Date: 08-Aug-19
 */

namespace logger\observer;

use const FILE_APPEND;
use function file_put_contents;
use const LOCK_EX;

require_once "Observer.php";

class Logger implements Observer {

    const FILE = "logs.txt";

    public function update(Subject $subject) {
        file_put_contents(self::FILE, date('Y-m-d H:i:s') . ": " . $subject->message() . "\n", FILE_APPEND | LOCK_EX);
    }

}