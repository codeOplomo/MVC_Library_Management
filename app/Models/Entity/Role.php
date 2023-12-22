<?php
class Role{
    private $name;
    
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        // Add any validation logic if needed
        $this->name = $name;
    }
}
