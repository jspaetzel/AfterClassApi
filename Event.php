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

    public function setDateTimes($StartDateTime, $EndDateTime) {
        try {
            $this->EndDatetime = $this->convertDateTimeToTimestamp($EndDateTime);
            $this->StartDatetime = $this->convertDateTimeToTimestamp($StartDateTime);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    private function convertDateTimeToTimestamp($datetime) {
        $format = 'm/d/Y g:i A'; // formatting of input strings
        $timezone = new DateTimeZone('EST');

        $date = date_create_from_format($format, $datetime, $timezone)->getTimestamp();
        return $date;
    }
}