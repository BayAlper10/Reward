<?php

namespace BayAlper10\Reward;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\{Player, Server};
use pocketmine\utils\Config;
use pocketmine\event\player\PlayerJoinEvent;
use BayAlper10\Reward\formapi\SimpleForm;
use pocketmine\item\Item;

class RewardClass extends PluginBase implements Listener{

  public function onEnable(): void{
    $this->getLogger()->info("Eklenti aktif.");
    $this->cfg = new Config($this->getDataFolder() . "reward.yml", Config::YAML);
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
  }

  public function onJoin(PlayerJoinEvent $event): void{
    $player = $event->getPlayer();
    $name = $player->getName();

    if(!$this->cfg->exists($name)){
      $this->hediyeVer($player);
      $zaman = strtotime("+1 day", time());
      $this->cfg->set($name, $zaman);
      $this->cfg->save();
    }

    if($this->cfg->get($name) < time()){
      $this->hediyeVer($player);
      $zaman = strtotime("+1 day", time());
      $this->cfg->set($name, $zaman);
      $this->cfg->save();
    }
  }

  public function hediyeVer($player){
    $form = new SimpleForm(function (Player $event, $data){
      $player = $event->getPlayer();
      $oyuncu = $player->getName();

      if($data === null){
        return;
      }

      switch($data){
        case 0:
        break;
      }
    });
    $form->setTitle("Hediye Menüsü");
    $rand = mt_rand(1, 1);
    switch($rand){
      case 1:
      $hediye = "Toprak 1 Adet";
      $miktar = 1;
      $this->hediyeAlma($player, $miktar);
      break;
    }
    $form->setContent("Bugün aldığın hediye $hediye");
    $form->addButton("Devam");
    $form->sendToPlayer($player);
  }

  public function hediyeAlma($player, $miktar){
    $player->getInventory()->addItem(Item::get(3,0,$miktar));
  }
}
