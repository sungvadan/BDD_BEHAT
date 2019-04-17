<?php

require_once __DIR__.'/vendor/autoload.php';

use Behat\Mink\Driver\GoutteDriver;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\Mink\Session;

//$driver = new GoutteDriver();
$driver= new Selenium2Driver('chrome');

$session = new Session($driver);
$session->start();

$session->visit('http://localhost:8000/');

//var_dump($session->getStatusCode(), $session->getCurrentUrl());

//DocumentElement
$page = $session->getPage();

//var_dump(substr($page->getText(), 0, 75));

//NodeElement
$selectorsHandler = $session->getSelectorsHandler();
$linkEl = $page->findLink('KnpUniversity.com');
$url = $linkEl->getAttribute('href');

$linkEl->click();
$page = $session->getPage();

var_dump($session->getCurrentUrl());

$session->stop();