<?php

namespace mohagames\TicTacToe;

use mohagames\TicTacToe\arena\Arena;
use mohagames\TicTacToe\arena\ArenaManager;
use mohagames\TicTacToe\handler\SessionHandler;
use mohagames\TicTacToe\listener\EventListener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase{


    private static $db;
    private static $instance;

    public function onEnable()
    {
        self::$db = new \SQLite3($this->getDataFolder() . "TicTacToe.db");
        self::$db->query("CREATE TABLE IF NOT EXISTS arenas(arena_id INTEGER PRIMARY KEY NOT NULL, arena_bb TEXT, arena_level TEXT)");

        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);

        self::$instance = $this;

    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        if($command->getName() == "tictactoe")
        {
            if(!isset($args[0]))
            {
                return false;
            }

            switch ($args[0])
            {
                case "test":
                    SessionHandler::$assignFirstArenaPos[$sender->getName()] = true;
                    SessionHandler::$assignSecondArenaPos[$sender->getName()] = true;

                    $sender->sendMessage("Gelieve de posities te bepalen!");

                    break;

                case "save":
                    $pos1 = SessionHandler::$assignFirstArenaPos[$sender->getName()];
                    $pos2 = SessionHandler::$assignSecondArenaPos[$sender->getName()];

                    if(!$pos1 instanceof Vector3 || !$pos2 instanceof Vector3)
                    {
                        $sender->sendMessage("Gelieve alle locaties aan te duiden.");
                        return true;
                    }

                    $bb = new AxisAlignedBB(min($pos1->getX(), $pos2->getX()), min($pos1->getY(), $pos2->getY()), min($pos1->getZ(), $pos2->getZ()), max($pos1->getX(), $pos2->getX()), max($pos1->getY(), $pos2->getY()), max($pos1->getZ(), $pos2->getZ()));
                    ArenaManager::createArena($bb, $sender->getLevel());

                    SessionHandler::clearPositions($sender->getName());

                    break;


                case "init":
                    if(!isset($args[1]))
                    {
                        return false;
                    }

                    $arena = ArenaManager::getArenaById((int)$args[1]);
                    if($arena instanceof Arena)
                    {
                        $arena->initBlocks();
                    }

                case "join":
                    if(!isset($args[1]))
                    {
                        return false;
                    }



                    break;

                case "clear":
                    SessionHandler::clearPositions($sender->getName());
                    $sender->sendMessage("Cleared!");
                    break;

                default:
                    return false;

            }
            return true;

        }

    }



    public static function getDb() : \SQLite3
    {
        return self::$db;
    }

    public static function getInstance() : Main
    {
        return self::$instance;
    }


}
