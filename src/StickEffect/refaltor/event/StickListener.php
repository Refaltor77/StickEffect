<?php

namespace StickEffect\refaltor\event;

use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\Player;
use StickEffect\refaltor\Stick;

class StickListener implements Listener
{
    public array $cooldown = [];
    public function onInteract(PlayerInteractEvent $event){
        $player = $event->getPlayer();
        $item = $event->getItem();
        $all = Stick::getStick()->getConfig()->getAll();
        if ($player instanceof Player){
            $in = array_keys($all);
            if (in_array($item->getId(), $in)){
                $stick = $all[$item->getId()];
                $effect = $stick["effect"];
                if (!isset($this->cooldown[$player->getName()])) {
                    $this->cooldown[$player->getName()] = time() + $stick["cooldown"];
                    foreach ($effect as $id => $values) {
                        $player->addEffect(new EffectInstance(Effect::getEffect($id), $values["duration"], $values["niveau"], $values["visible"]));
                    }
                }elseif(time() < $this->cooldown[$player->getName()]){
                    $time = $this->cooldown[$player->getName()] - time();
                    $player->sendMessage(str_replace("{time}", $time, $stick["message"]));
                }else{
                    unset($this->cooldown[$player->getName()]);
                }
            }
        }
    }
}