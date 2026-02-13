myMap1= new msMap( document.getElementById("dc_mainUpdate"), 'standardRight');
myMap1.setCgi('/cgi-bin/mapserv.exe');
myMap1.setMapFile('/ms4w/Apache/htdocs/geovisor2/Web/assets/js/Visor/mapaUpdateMallanuevo.map');
myMap1.setFullExtent(-76.59995287878888, -76.401923, 3.326555);
myMap1.setLayers('Cali Comunas Barrios Calles Puntos Brujula');

//insertar 
myMap1.redraw();
chgLayers();

var seleclayer=-1;
var lyactive= false;
var lejendactive=false;

function chgLayers()
{
    var list = "Layers ";
    var objForm = document.forms[0];
    for(i=0; i<document.forms[0].length; i++)
{
    if(objForm.elements["layer["+ i +"]"].checked)
    {
    list = list + objForm.elements["layer["+ i +"]"].value + " ";

    }
}
myMap1.setLayers(list);
myMap1.redraw();
}
var seleccionado= false;
       

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
    if (!xmlhttp && typeof XMLHttpRequest != 'undefined');{
            xmlhttp= new XMLHttpRequest();
            return xmlhttp;
    }
}
function propuesta(event,map,x,y,xx,yy)
{
    if(seleccionado){
        consulta2=new objetoAjax();
        consulta2.open("GET","extraerinformacion.php?x="+xx+"&y="+yy,true);
        
        consulta2.onreadystatechange=function()
        {
            if(consulta2.readyState==4){
                var result1 = consulta2.responseText;
                // muestro resultado dse la consulta
                alert(result1);
            }
        }
        consulta2.send(null);
        seleccionado=false;
        map.getTagMap().style.cursor="default";
    }
}

