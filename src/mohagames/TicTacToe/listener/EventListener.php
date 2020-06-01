<?php


namespace mohagames\TicTacToe\listener;


use mohagames\TicTacToe\arena\Arena;
use mohagames\TicTacToe\arena\ArenaManager;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use mohagames\TicTacToe\handler\SessionHandler;
use pocketmine\event\player\PlayerEvent;
use pocketmine\event\player\PlayerInteractEvent;

class EventListener implements Listener
{


    public function onFirstPosAssign(BlockBreakEvent $e)
    {
        if(isset(SessionHandler::$assignFirstArenaPos[$e->getPlayer()->getName()]))
        {
            $e->setCancelled();
            $block = $e->getBlock();

            if(ArenaManager::getArenaByLocation($block) instanceof Arena)
            {
                $e->getPlayer()->sendMessage("Hier staat al een arena");
                return;
            }

            SessionHandler::$assignFirstArenaPos[$e->getPlayer()->getName()] = $block->asVector3();
            $e->getPlayer()->sendMessage("pos1");
        }

    }

    public function onSecondPosAssing(PlayerInteractEvent $e)
    {
        if($e->getAction() == PlayerInteractEvent::RIGHT_CLICK_BLOCK)
        {
            $player = $e->getPlayer();
            if(isset(SessionHandler::$assignSecondArenaPos[$player->getName()]))
            {
                $block = $e->getBlock();
                if(ArenaManager::getArenaByLocation($block) instanceof Arena)
                {
                    $player->sendMessage("Hier staat al een arena");
                    return;
                }

                SessionHandler::$assignSecondArenaPos[$player->getName()] = $block->asVector3();
                $player->sendMessage("pos2");
            }
        }

    }

    public function onPlotBlockPlacement()
    {

    }



}