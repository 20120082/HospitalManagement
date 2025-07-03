<?php
// models/Medicine.php
class Medicine {
    public $id;
    public $code;
    public $name;
    public $category;
    public $description;
    public $unit;
    public $price;
    public $quantity;
    public $manufacturer;
    public $expiryDate;
    public $createdAt;
    public $updatedAt;

    public function __construct($data = []) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
