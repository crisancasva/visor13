

myMap1 = new msMap(document.getElementById("dc_main"), 'standardRight');
myMap1.setCgi('/cgi-bin/mapserv.exe');
myMap1.setMapFile('/ms4w/Apache/htdocs/geovisor2/Web/assets/js/Visor/mapacali.map');
myMap1.setFullExtent(-76.59995287878888, -76.401923, 3.326555);
myMap1.setLayers('Cali Comunas Barrios Calles Puntos Brujula');


//insertar 
var insertar= new msTool('crear punto', infolay,'../Web/assets/js/Visor/misc/img/insert_.png',investiguen);
myMap1.getToolbar(0).addMapTool(insertar);

myMap1.redraw();
chgLayers();


var seleclayer = -1;
var lyactive = false;
var lejendactive = false;

function chgLayers(){
    var list= "Layers ";
    var objForm = document.forms[0];
    for(i=0; i<document.forms[0].length; i++){
        if(objForm.elements["layer[" + i + "]"].checked){
            list = list + objForm.elements["layer[" + i + "]"].value + " ";
        }
    }
    myMap1.setLayers(list);
    myMap1.redraw();
}

var seleccionado= false;
function infolay(e,map){
    map.getTagMap().style.cursor="crosshair";
    seleccionado= true;
}


function objetoAjax(){
    var xmlhttp= false;
    try{
        xmlhttp= new ActiveXObject("Msxm2.XMLHttpRequest");
    }catch(e){

        try{
            xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
        }catch(E){
            xmlhttp= false;
        }
        
    }
    if (!xmlhttp && typeof XMLHttpRequest != 'undefined'){
            xmlhttp= new XMLHttpRequest();
            return xmlhttp;
    }
}

function investiguen(event, map, x, y, xx, yy) {
    if(seleccionado){
        alert ("Click sobre las coordenadas: x "+x+" y: "+y+" y reales: x"+xx+" y: " +yy);
        consultar1= new objetoAjax();
        document.getElementById("x_input").value = xx;
        document.getElementById("y_input").value = yy;
        seleccionado=false;
        map.getTagMap().style.cursor="default";

    }
}



                