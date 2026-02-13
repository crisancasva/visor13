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
       


