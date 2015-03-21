<?php
class Event
{
    public $Id;
    public $Name;
    public $Description;
    public $StartDatetime;
    public $EndDatetime;
    public $LocationName;
    public $Latitude;
    public $Longitude;

    public function getArray() {
        return array(
                "Id" => $this->Id,
                "Name"=> $this->Name,
                "Description" => $this->Description,
                "StartDatetime" => $this->StartDatetime,
                "EndDatetime" => $this->EndDatetime,
                "LocationName" => $this->LocationName,
                "Latitude" => $this->Latitude,
                "Longitude" => $this->Longitude
            );
    }
}