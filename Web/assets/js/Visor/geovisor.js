myMap1 = new msMap(document.getElementById("dc_main"), 'standardRight');
myMap1.setCgi('/cgi-bin/mapserv.exe');
myMap1.setMapFile('/ms4w/Apache/htdocs/geovisor2/Web/assets/js/Visor/geovisor.map');
myMap1.setFullExtent(-76.692645878788, -76.401923, 3.32532);
myMap1.setLayers('Cali Comunas Barrios Calles Via Reductor Accidente Brujula');

var consulta = new msTool('Obtener informacion', consulay,'misc/img/expandir.png',propuesta);
myMap1.getToolbar(0).addMapTool(consulta);



myMap1.redraw(); myMap2.redraw();
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
    myMap2.setLayers(list);
    myMap2.redraw();
}
var seleccionado2 = false;
function consulay(e,map){
    map.getTagMap().style.cursor = "crosshair";
    seleccionado2 = true;
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

function propuesta(event, map, x, y, xx, yy){
    if(seleccionado2){
        consulta2=new objetoAjax();
        consulta2.open("GET", "http://localhost:9000/geovisor2/web/index.php?modulo=Principal&controlador=Principal&funcion=mostrarInfo&x="+xx+"&y="+yy,true);
        consulta2.onreadystatechange=function(){
            if(consulta2.readyState==4){
                var result = consulta2.responseText;
                //muestro el resultado de la consulta
                alert(result);
            }
        }
        consulta2.send(null);
        seleccionado2=false;
        map.getTagMap().style.cursor="default";
    }
}