<?php
require ("connect.php");
require_once ("Event.php");

class EventRepository {
    function addEvent(Event $event) {
        $SQL = "INSERT INTO `Events`" .
            "(`Name`, `Description`, `StartDatetime`, `EndDatetime`, `LocationName`)" .
            "VALUES ('" . $event->Name . "','" . $event->Description . "','" . $event->StartDatetime .
            "','" . $event->EndDatetime . "','" . $event->LocationName . "')";
        return query($SQL);
    }

    function getEvent($id) {
        $SQL = "SELECT * FROM `Events` WHERE Id='$id'";

        $result = select_query($SQL)[0];
        return $this->toEvent($result);
    }

    function getLatestEvents() {
        $datetime = time();
        $SQL = "SELECT * FROM `Events` WHERE EndDatetime > '$datetime' ORDER BY StartDatetime ASC";
        $results = select_query($SQL);

        $events = array();
        foreach ($results as $result ) {
            if ( $result != null ) {
                $events[] = $this->toEvent($result);;
            }
        }
        return $events;
    }

    private function toEvent($result) {
        $event = new Event();
        $event->Id = $result['Id'];
        $event->Name = $result['Name'];
        $event->Description = $result['Description'];
        $event->EndDatetime = $result['EndDatetime'];
        $event->StartDatetime = $result['StartDatetime'];
        $event->Latitude = $result['Latitude'];
        $event->Longitude = $result['Longitude'];
        $event->LocationName = $result['LocationName'];
        return $event;
    }
}