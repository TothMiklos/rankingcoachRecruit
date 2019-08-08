<?php
/**
 * User: tothm
 * Date: 08-Aug-19
 */

namespace logger\observer;


interface Subject {

    function attach(Observer $observer);

    function detach(Observer $observer);

    function notity();

    function message();

}