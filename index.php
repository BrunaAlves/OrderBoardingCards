<?php
    function findIndexInArray($array, $parameter, $value){
        $index = -1;
        for($i =0; $i < sizeof($array); $i++){
            if($parameter != null){
                if($array[$i]->$parameter == $value){
                    $index = $i;
                    break;
                }
            }else{
                if($array[$i] == $value){
                    $index = $i;
                    break;
                }
            }
        }
        return $index;
    }

    function processRoute($tickets){
        $arrives = array();
        $departures = array();
        for($i =0; $i < sizeof($tickets); $i++){
            $departures[] = $tickets[$i]->Departure;
            $arrives[] = $tickets[$i]->Arrive;
        }

        $firstStep = -1;
        for($i =0; $i < sizeof($departures); $i++){
            if(findIndexInArray($arrives, null, $departures[$i]) == -1){
                $firstStep = $i;
            }
        }

        if($firstStep > -1){
            $route = array();
            $firstIndex = findIndexInArray($tickets, "Departure", $departures[$firstStep]);
            $route[] = $tickets[$firstIndex];
            while($firstIndex > -1){
                $firstIndex = findIndexInArray($tickets, "Departure", $route[sizeof($route)-1]->Arrive);
                if($firstIndex > -1){
                    $route[] = $tickets[$firstIndex];
                }
            }
            return $route;
        }else{
            throw new Exception("Impossible to find the first step!");
        }

        return null;
    }

    
    /*$data = '[{
        "Departure": "Lviv",
        "Arrive":"Lviv Danylo Halytsky",
        "Type": "BUS"
    },{
        "Departure": "Kiev",
        "Arrive":"Lviv",
        "Type": "TRAIN",
        "Details": {
            "TrainNumber": "X12",
            "Seat": "18C"
        }
    },{
        "Departure": "Stockholm",
        "Arrive":"Amsterdam Schiphol",
        "Type": "FLIGHT",
        "Details": {
            "FlightNumber": "SK22",
            "Gate": "18",
            "Seat": "7B",
            "BaggageTicket": "TRANSFER"
        }
    },{
        "Departure": "Lviv Danylo Halytsky",
        "Arrive":"Stockholm",
        "Type": "FLIGHT",
        "Details": {
            "FlightNumber": "BF134",
            "Gate": "45B",
            "Seat": "3A",
            "BaggageTicket": "344"
        }
    },{
        "Departure": "Amsterdam Schiphol",
        "Arrive":"Rotterdam",
        "Type": "TRAIN",
        "Details": {
            "TrainNumber": "T13",
            "Seat": "12B"
        }
    }]';*/
    if(isset($_GET['tickets'])){
        $data = $_GET['tickets'];
        echo json_encode(processRoute(json_decode($data)));
    }else{
        throw new Exception("tickets not defined!");
    }
?>