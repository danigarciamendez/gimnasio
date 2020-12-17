function añadirUsuario(opcion){
    var xmlhttp;
    
    if(window.XMLHttpRequest){
        xmlhttp= new XMLHttpRequest();
    }else{
        xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange=function(){
        
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
            
        document.getElementById('panelAdmin').innerHTML = xmlhttp.responseText;

    }
    
    }
    
    xmlhttp.open("POST","vistas/cPanelFunciones.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("añadirUser="+opcion);
}

function subMenuUsuario(opcion){
    var xmlhttp;
    
    if(window.XMLHttpRequest){
        xmlhttp= new XMLHttpRequest();
    }else{
        xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange=function(){
        
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
            
        document.getElementById('subMenu').innerHTML = xmlhttp.responseText;

    }
    
    }
    
    xmlhttp.open("POST","vistas/cPanelFunciones.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("opcUser="+opcion);
}

function modificarUsuario(opcion){
    var xmlhttp;
    
    if(window.XMLHttpRequest){
        xmlhttp= new XMLHttpRequest();
    }else{
        xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange=function(){
        
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
            
        document.getElementById('panelAdmin').innerHTML = xmlhttp.responseText;

    }
    
    }
    
    xmlhttp.open("POST","vistas/cPanelFunciones.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("modUser="+opcion);
}

