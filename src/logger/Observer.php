<?php
/**
 * User: tothm
 * Date: 08-Aug-19
 */

namespace logger\observer;


interface Observer {

    function update(Subject $subject);

}