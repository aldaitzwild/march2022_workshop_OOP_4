<?php

namespace App;

use Exception;

class Arena 
{
    private array $monsters;
    private Hero $hero;

    private int $size = 10;

    public function __construct(Hero $hero, array $monsters)
    {
        $this->hero = $hero;
        $this->monsters = $monsters;
    }

    public function getDistance(Fighter $startFighter, Fighter $endFighter): float
    {
        $Xdistance = $endFighter->getX() - $startFighter->getX();
        $Ydistance = $endFighter->getY() - $startFighter->getY();
        return sqrt($Xdistance ** 2 + $Ydistance ** 2);
    }

    public function touchable(Fighter $attacker, Fighter $defenser): bool 
    {
        return $this->getDistance($attacker, $defenser) <= $attacker->getRange();
    }

    /**
     * Get the value of monsters
     */ 
    public function getMonsters(): array
    {
        return $this->monsters;
    }

    /**
     * Set the value of monsters
     *
     */ 
    public function setMonsters($monsters): void
    {
        $this->monsters = $monsters;
    }

    /**
     * Get the value of hero
     */ 
    public function getHero(): Hero
    {
        return $this->hero;
    }

    /**
     * Set the value of hero
     */ 
    public function setHero($hero): void
    {
        $this->hero = $hero;
    }

    /**
     * Get the value of size
     */ 
    public function getSize(): int
    {
        return $this->size;
    }

    public function move(Fighter $fighter, string $direction): void
    {
        $y = $fighter->getY();
        if($direction == "N") --$y;
        if($direction == "S") ++$y;

        $x = $fighter->getX();
        if($direction == "W") --$x;
        if($direction == "E") ++$x;

        if(
            $x < 0 || $x >= $this->size ||
            $y < 0 || $y >= $this->size
        ) {
            throw new Exception('Ce déplacement sort du cadre de jeu.');
        }

        foreach($this->monsters as $monster) {
            if($monster->getX() == $x && $monster->getY() == $y)
                throw new Exception('La case est déjà occupée.');
        }

        $fighter->setY($y);
        $fighter->setX($x);

    }

    public function battle(int $id): void
    {
        if(!$this->touchable($this->hero, $this->monsters[$id]))
            throw new Exception('Monstre intouchable !');

        $this->hero->fight($this->monsters[$id]);

        if(!$this->monsters[$id]->isAlive()){
            array_splice($this->monsters, $id, 1);
        }
    }
}