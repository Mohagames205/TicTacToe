<?php


namespace mohagames\TicTacToe\arena;


use mohagames\TicTacToe\Main;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\math\AxisAlignedBB;
use pocketmine\Server;

class ArenaManager
{


    public static function getArenaByLocation(Position $position) : ?Arena
    {

        foreach (self::getArenas() as $arena)
        {
            $bb = $arena->getBoundingBox();
            if($bb->isVectorInXZ($position) && $arena->getLevel()->getFolderName() == $position->getLevel()->getFolderName()) return $arena;

        }

        return null;

    }

    public static function createArena(AxisAlignedBB $alignedBB, Level $level)
    {
        $bbArray = serialize($alignedBB);
        $levelString = $level->getFolderName();

        $stmt = Main::getDb()->prepare("INSERT INTO arenas (arena_bb, arena_level) values (:arena_bb, :arena_level)");
        $stmt->bindParam("arena_bb", $bbArray);
        $stmt->bindParam("arena_level", $levelString);
        $stmt->execute();
        $stmt->close();

    }


    /**
     * @return Arena[]
     */
    public static function getArenas() : ?array
    {
        $stmt = Main::getDb()->prepare("SELECT arena_id FROM arenas");
        $res = $stmt->execute();

        while($row = $res->fetchArray())
        {
            $arenas[] = self::getArenaById($row["arena_id"]);
        }
        return $arenas ?? [];
    }


    public static function getArenaById(int $id) : ?Arena
    {
        $stmt = Main::getDb()->prepare("SELECT * FROM arenas WHERE arena_id = :arena_id");
        $stmt->bindParam("arena_id", $id);
        $res = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
        $stmt->close();

        $level = Server::getInstance()->getLevelByName($res["arena_level"]);


        return new Arena($res["arena_id"], unserialize($res["arena_bb"]), $level);


    }




}