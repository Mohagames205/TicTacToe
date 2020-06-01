<?php


namespace mohagames\TicTacToe\game;


use mohagames\TicTacToe\arena\Arena;
use mohagames\TicTacToe\Main;
use pocketmine\Server;

class GameManager
{

    protected $runningGames;

    public static function createGame(Arena $arena, $minPlayers = 1, $maxPlayers = 1)
    {
        Main::getInstance()->getScheduler()->scheduleTask();

    }



}