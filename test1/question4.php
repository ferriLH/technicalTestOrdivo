<?php

// Base Ship class
class Ship {
    protected $name;
    protected $type;

    public function __construct($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function getType() {
        return $this->type;
    }

    public function sail() {
        return $this->name . " is sailing.";
    }
}

// Motor Boat class (extends Ship)
class MotorBoat extends Ship {
    protected $type = "Motor Boat";

    // Additional properties and methods specific to Motor Boats
    protected $engineType;

    public function __construct($name, $engineType) {
        parent::__construct($name);
        $this->engineType = $engineType;
    }

    public function getEngineType() {
        return $this->engineType;
    }

    public function sail() {
        return $this->name . " (Motor Boat) is sailing with a " . $this->engineType . " engine.";
    }
}

// Sailboat class (extends Ship)
class Sailboat extends Ship {
    protected $type = "Sailboat";

    // Additional properties and methods specific to Sailboats
    protected $sailType;

    public function __construct($name, $sailType) {
        parent::__construct($name);
        $this->sailType = $sailType;
    }

    public function getSailType() {
        return $this->sailType;
    }

    public function sail() {
        return $this->name . " (Sailboat) is sailing with " . $this->sailType . " sails.";
    }
}

// Yacht class (extends Ship)
class Yacht extends Ship {
    protected $type = "Yacht";

    // Additional properties and methods specific to Yachts
    protected $luxuryLevel;

    public function __construct($name, $luxuryLevel) {
        parent::__construct($name);
        $this->luxuryLevel = $luxuryLevel;
    }

    public function getLuxuryLevel() {
        return $this->luxuryLevel;
    }

    public function sail() {
        return $this->name . " (Yacht) is sailing in luxury with a " . $this->luxuryLevel . " level of comfort.";
    }
}

// Usage
$ship1 = new MotorBoat("Speedy", "Outboard");
$ship2 = new Sailboat("SailMaster", "Main and Jib");
$ship3 = new Yacht("Luxury Liner", "High");

echo $ship1->sail() . "\n";
echo $ship2->sail() . "\n";
echo $ship3->sail() . "\n";
