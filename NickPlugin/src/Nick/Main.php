<?php

namespace Nick;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use jojoe77777\FormAPI;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener {

    public  $p = "§3[§bNickUI§r§3] §r§f> ";

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getLogger()->notice("§3[§bNickUI§3] §aPlugin wurde geladen!");
    }

    public function onDisable(): void {
        $this->getServer()->getLogger()->error("§3[§bNickUI§3] Plugin wurde entladen!");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool{
        switch ($command->getName()) {
            case "nick":
                if($sender instanceof Player) {
                    if ($sender->hasPermission("nickui.use")) {
                        $this->openNickUI($sender);
                    } else {
                        $sender->sendMessage(TextFormat::DARK_RED . "Du hast dafür keine Rechte!");
                    }
                } else {
                    $sender->sendMessage(TextFormat::DARK_RED . "Bitte benutze den Command In-Game!");
                }
                break;

            case "unnick":
                If ($sender instanceof Player) {
                    if ($sender->hasPermission("nickui.use")) {
                        $sender->sendMessage($this->p . "§aDu hast dich entnickt!");
                        $sender->setNameTag($sender->getName());
                        $sender->setDisplayName($sender->getName());
                    } else {
                        $sender->sendMessage(TextFormat::DARK_RED . "Du hast dafür keine Rechte!");
                    }
                } else {
                    $sender->sendMessage(TextFormat::DARK_RED . "Bitte benutze den Command In-Game!");
                }
                break;
        }
        return true;
    }

    public function openNickUI($player)
    {
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $player, $data) {
            if ($data[0] === null) {
                return true;
            }
            if ($data[0] !== null) {
                $player->setDisplayName($data[0]);
                $player->setNameTag($data[0]);
                $player->sendMessage($this->p . "§aDein Nickname wurde zu §e" . $data[0] . " §ageändert!");
            }
        });
        $form->setTitle("§bNickUI");
        $form->addInput("Nickname", "Nick", $player->getName());
        $form->sendToPlayer($player);
        return $form;
    }
}
