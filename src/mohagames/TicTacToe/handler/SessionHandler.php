<?php

namespace mohagames\TicTacToe\handler;

class SessionHandler  {

    public static $assignFirstArenaPos;
    public static $assignSecondArenaPos;

    public static function clearPositions(string $player)
    {
        if(isset(self::$assignSecondArenaPos[$player])) unset(self::$assignSecondArenaPos[$player]);
        if(isset(self::$assignFirstArenaPos[$player])) unset(self::$assignFirstArenaPos[$player]);
    }







}