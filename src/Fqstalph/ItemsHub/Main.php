<?php


namespace Fqstalph\ItemsHub;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener
{
    public $myConfig;
	
    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("§ePlugin Enabled!");
        $this->saveDefaultConfig();
    }

    public function onItem(Player $player) {
        $inventory = $player->getInventory();
		# First Item
		$ItemName = $this->getConfig()->get("ItemName");
        $items = Item::get(Item::IRON_SWORD, 0, 1)->setCustomName($ItemName);
        $inventory->setItem(8, $items);
        $inventory->sendContents($player);
		# Second Item
		$ItemName2 = $this->getConfig()->get("ItemName2");
        $items2 = Item::get(Item::GOLD_SWORD, 0, 1)->setCustomName($ItemName2);
        $inventory->setItem(0, $items2);
        $inventory->sendContents($player); 
		# Third Item
		$ItemName3 = $this->getConfig()->get("ItemName3");
        $items3 = Item::get(Item::COMPASS, 0, 1)->setCustomName($ItemName3);
        $inventory->setItem(4, $items3);
        $inventory->sendContents($player);
    }

    public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        $this->onItem($player);
    }
	
	public function onRespawn(PlayerRespawnEvent $event) {
        $player = $event->getPlayer();
        $this->onItem($player);
    }

    public function onInteract(PlayerInteractEvent $event) {
        $player = $event->getPlayer();
        if ($player->getLevel()->getFolderName() == $this->getServer()->getDefaultLevel()->getFolderName()) {
            $item = $event->getItem();
            $itemID = $item->getId();
            $action = $event->getAction();
			# Commands
			$ItemCmd = $this->getConfig()->get("Item1-Command");
			$Item2Cmd = $this->getConfig()->get("Item2-Command");
			$Item3Cmd = $this->getConfig()->get("Item3-Command");
			#
            if ($action == PlayerInteractEvent::RIGHT_CLICK_AIR) {
                switch ($itemID) {
                   case Item::IRON_SWORD:
                        $this->getServer()->dispatchCommand($player, $ItemCmd);
                        break;
	               case Item::GOLD_SWORD:
                        $this->getServer()->dispatchCommand($player, $Item2Cmd);
                        break;
                   case Item::COMPASS:
                        $this->getServer()->dispatchCommand($player, $Item3Cmd);
                        break;
                }
            }
        }
    }
}