<?php
try {
    $settings = require 'settings.php';
    $pdo = new PDO($settings["conectionData"]["dns"],$settings["conectionData"]["user"], $settings["conectionData"]["pass"]);
    return $fluent = new \Envms\FluentPDO\Query($pdo);
} catch (\Exception $e) {
    return $e->getMessage();
}


    