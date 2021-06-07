<?php

namespace StickEffect\refaltor\event;

use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;
use pocketmine\Player;
use StickEffect\refaltor\Stick;

class StickListener implements Listener
{
    public array $cooldown = [];
    public function onInteract(PlayerInteractEvent $event){
        $player = $event->getPlayer();
        $item = $event->getItem();
        $all = Stick::getStick()->getConfig()->getAll();
        $in = array_keys($all);
        if ($event->getAction() === PlayerInteractEvent::RIGHT_CLICK_BLOCK || $event->getAction() === PlayerInteractEvent::RIGHT_CLICK_AIR) {
			if (in_array("{$item->getId()}:{$item->getDamage()}", $in)) {
				$stick = $all["{$item->getId()}:{$item->getDamage()}"];
				$effect = $stick["effect"];
				$bool = $stick["remove"];
				if (!isset($this->cooldown[$player->getName()])) {
					$this->cooldown[$player->getName()] = time() + intval($stick["cooldown"]);
					foreach ($effect as $id => $values) {
						$player->addEffect(new EffectInstance(Effect::getEffect($id), $values["duration"], $values["niveau"], $values["visible"]));
						if ($bool === true) $player->getInventory()->removeItem(Item::get($item->getId(), $item->getDamage()));
					}
				} elseif (time() < $this->cooldown[$player->getName()]) {
					$time = $this->cooldown[$player->getName()] - time();
					$player->sendMessage(str_replace("{time}", $time, $stick["message"]));
				} else {
					unset($this->cooldown[$player->getName()]);
				}
			}
		}
    }
}
