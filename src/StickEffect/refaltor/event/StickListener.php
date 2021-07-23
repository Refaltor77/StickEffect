<?php

namespace StickEffect\refaltor\event;

use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;
use StickEffect\refaltor\Stick;

class StickListener implements Listener
{
    public $time = [];

    public function onInteract(PlayerInteractEvent $event)
    {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $all = Stick::getStick()->getConfig()->getAll();
        $in = array_keys($all);
        if ($event->getAction() === PlayerInteractEvent::RIGHT_CLICK_BLOCK) {
            if (in_array("{$item->getId()}:{$item->getDamage()}", $in)) {
                $stick = $all["{$item->getId()}:{$item->getDamage()}"];
                $effect = $stick["effect"];
                $bool = $stick["remove"];

                if (array_key_exists('permission', $stick)){
                    if ($stick['permission']['enable']){
                        if (!$player->hasPermission($stick['permission']['perm'])){
                            $player->sendMessage(str_replace('{player}', $player->getName(), $stick['permission']['message_perm']));
                            return;
                        }
                    }
                }

                if (!isset($this->time[$player->getName()])) {
                    $this->time[$player->getName()] = time() + intval($stick["cooldown"]);
                    foreach ($effect as $id => $values) {
                        $player->addEffect(new EffectInstance(Effect::getEffect($id), intval($values["duration"]) * 20, intval($values["niveau"]) + 1, $values["visible"]));
                        if ($bool === true) $player->getInventory()->removeItem(Item::get($item->getId(), $item->getDamage()));
                    }
                } elseif (time() < $this->time[$player->getName()]) {
                    $time = $this->time[$player->getName()] - time();
                    if (isset($stick["message"])) $player->sendMessage(str_replace("{time}", $time, $stick["message"]));
                } else {
                    unset($this->time[$player->getName()]);
                }
            }
        }
    }
}
