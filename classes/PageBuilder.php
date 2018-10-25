<?php

/**Klasse om pagina op te bouwen*/
class PageBuilder {

    public function printHead(){
        $retString='
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">

		        <!--jquery-->
		        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

		        <!--bootstrap-->
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css">
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

                <!--Include fonts-->
                <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,600">

                <!--Include font awesome-->
                <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

                <!--Own stylesheets-->
                <link rel="stylesheet" href="styles/style.css">';

        return $retString;
   }


   public function printZoekVeld(){
    $retString = '
        <form>
        <input type="text" id="zoekveld" class="form-control" placeholder="Zoek een werknemer" onkeyup="filterWerknemers(this.value)">
        </form>
        <form>
        <button id="addwerknemer" style="display:none" onclick="addWerknemer()">Voeg werknemer toe</button>
        </form>';

        return $retString;
   }

   public function printResultaat(){
    $retString = '
        <p id="testresult"></p>
        <table class="table">
        <thead>
        <tr>
        <th width="10%"></th>
        <th width="50%">Naam</th>
        </tr>
        </thead>
        <tbody id="resultaat">
        </tbody>';
    return $retString;
   }

   public function printToetsenbord(){
    $alfabet=['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','<'];
    
    $retString = '';
    foreach ($alfabet as $letter) {
        $retString .= '<button type="button" class="toetsenbord btn btn-default" onclick="addLetterAndFilterWerknemers(this.innerHTML)">' . strtoupper($letter) . '</button>';
    }
    $retString .= '<button type="button" class="toetsenbord-space btn btn-default" onclick="addLetterAndFilterWerknemers(this.innerHTML)">SPACE</button>';
    return $retString;
   }

   public function printFooter(){
        $retString='

                <!--Own scripts-->
                <script src="scripts/script.js"></script>';

        return $retString;
   }



}


?>