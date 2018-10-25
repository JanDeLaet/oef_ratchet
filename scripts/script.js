
//opzetten ws
var conn = new WebSocket('ws://localhost:8080');

//openen ws connectie
conn.onopen = function (e) {
  console.log("Connection established!");
};

//bij ontvangen message
conn.onmessage = function (e) {

  //Parsen werknemers uit message
  var werknemers = JSON.parse(e.data);
  
  //check of er resultaat is -> indien niet, geen match, dus knop tonen om nieuwe werknemer toe te voegen
  if(werknemers.length==0){
      document.getElementById("addwerknemer").style.display = "block";
  }else{
      document.getElementById("addwerknemer").style.display = "none";
  }

  //wegschrijven gevonden werknemers naar html-tabel
  var retString = '';
  for (let werknemer of werknemers) {
    retString += '<tr>';
    retString += '<td><button type="button" class="btn btn-default" onclick="bel(this)">Bel</button></td>';
    retString += '<td>' + werknemer + '</td>';
    retString += '</tr>';
  }
  document.getElementById("resultaat").innerHTML = retString;
  
};

//versturen message
function sendMessage(x) {
  conn.send(x);
}

//alert tonen wanneer op knop bel geklikt wordt
function bel(elem){
  var naam = elem.parentElement.nextSibling.innerHTML;
  alert('We bellen ' + naam);
}

//toevoegen letter aan inputveld bij klikken op toetsenbord + filteren werknemers
function addLetterAndFilterWerknemers(letter){

    var x = document.getElementById("zoekveld").value;

    if(letter=='&lt;'){
        x = x.substring(0,x.length-1);
        document.getElementById("zoekveld").value=x;
    }else if(letter=='SPACE'){
        document.getElementById("zoekveld").value=x + ' ';
    }
    else{
        document.getElementById("zoekveld").value=x + letter;
    }

    filterWerknemers(document.getElementById("zoekveld").value);

}

//werknemers filteren obv zoekveld -> filtering gebeurt backend
function filterWerknemers(str) {
    
  if (str.length==0) { 
    document.getElementById("resultaat").innerHTML="";
    return;
  }

  var msg = {
    action: 'filter',
    message: str
  };
  sendMessage(JSON.stringify(msg));
    
}

//Werknemer toevoegen aan backend array
function addWerknemer() {

  var str = document.getElementById("zoekveld").value;
  var msg = {
    action:'add',
    message:str
  };
  sendMessage(JSON.stringify(msg));

}



  

