<?php

namespace StickEffect\refaltor;

use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use StickEffect\refaltor\event\StickListener;

class Stick extends PluginBase
{
    /** @var Stick  */
    public static Stick $instance;

    public function onEnable()
    {
        self::$instance = $this;
        $this->saveDefaultConfig();
        Server::getInstance()->getPluginManager()->registerEvents(new StickListener(), $this);
    }

    public static function getStick(){
        return self::$instance;
    }
}