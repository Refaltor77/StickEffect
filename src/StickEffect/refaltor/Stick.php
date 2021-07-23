<?php


/*
 *
 *   ad88888ba 888888888888 88   ,ad8888ba,  88      a8P     88888888888 88888888888 88888888888 88888888888 ,ad8888ba, 888888888888
 *  d8"     "8b     88      88  d8"'    `"8b 88    ,88'      88          88          88          88         d8"'    `"8b     88
 *  Y8,             88      88 d8'           88  ,88"        88          88          88          88        d8'               88
 *  `Y8aaaaa,       88      88 88            88,d88'         88aaaaa     88aaaaa     88aaaaa     88aaaaa   88                88
 *    `"""""8b,     88      88 88            8888"88,        88"""""     88"""""     88"""""     88"""""   88                88
 *          `8b     88      88 Y8,           88P   Y8b       88          88          88          88        Y8,               88
 *  Y8a     a8P     88      88  Y8a.    .a8P 88     "88,     88          88          88          88         Y8a.    .a8P     88
 *   "Y88888P"      88      88   `"Y8888Y"'  88       Y8b    88888888888 88          88          88888888888 `"Y8888Y"'      88
 *                       by refaltor - PocketMine-MP Plugin Free (https://github.com/Refaltor77/StickEffect)
 */







namespace StickEffect\refaltor;

use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use StickEffect\refaltor\event\StickListener;

class Stick extends PluginBase
{
    /** @var Stick */
    public static $instance;

    public static function getStick(): Stick
    {
        return self::$instance;
    }

    protected function onEnable(): void
    {
        if (!$this->getConfig()->exists('version')) {
            rename($this->getDataFolder() . 'config.yml', $this->getDataFolder() . 'old_config.yml');
            $this->saveResource('config.yml');
            $this->getLogger()->warning('Config.yml is a lower version, config.yml to -> old_config.yml and new config.yml is saved.');
        }elseif ($this->getConfig()->get('version') !== 3.0){
            rename($this->getDataFolder() . 'config.yml', $this->getDataFolder() . 'old_config.yml');
            $this->saveResource('config.yml');
            $this->getLogger()->warning('Config.yml is a lower version, config.yml to -> old_config.yml and new config.yml is saved.');
        }
        self::$instance = $this;
        Server::getInstance()->getPluginManager()->registerEvents(new StickListener(), $this);
    }




/*
 *
 *            db        88888888ba  88
 *           d88b       88      "8b 88
 *          d8'`8b      88      ,8P 88
 *         d8'  `8b     88aaaaaa8P' 88
 *        d8YaaaaY8b    88""""""'   88
 *       d8""""""""8b   88          88
 *      d8'        `8b  88          88
 *     d8'          `8b 88          88
 *
 *
 */


    /**
     * Allows you to have all the sticks in an array.
     *
     * @return array
     */
    public function getAllStick(): array{
        return $this->getConfig()->getAll();
    }

    /**
     * Allows to have a stick thanks to an id "id:meta".
     *
     * @param string $string
     * @return array
     */
    public function getStickFromString(string $string): array{
        return $this->getConfig()->get($string);
    }


    /**
     * Gives you all the effects of a stick.
     *
     * @param string $string
     * @return array
     */
    public function getAllEffectFromStick(string $string): array{
        return $this->getConfig()->get($string)['effect'];
    }


    /**
     * Lets you know if a stick has permission.
     *
     * @param string $stick
     * @return bool
     */
    public function hasPermInStick(string $stick): bool{
        if (array_key_exists('permission', $this->getConfig()->get($stick))){
            if ($this->getConfig()->get($stick)['permission']['enable']) return true;
        }
        return false;
    }


    /**
     * Lets know the permission of a stick.
     * /!\ CAREFUL ! (Check if the stick has permission before.)
     *
     * @param string $stick
     * @return string
     */
    public function getPermissionInStick(string $stick): string{
        return $this->getConfig()->get($stick)['permission']['perm'];
    }
}
