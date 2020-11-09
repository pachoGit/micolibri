/* Funciones para obtener el las secciones de un determinado grado */

const ruta = "http://colibri.informaticapp.com/funcsAjax/seccionesDeGrado";

function ponerSecciones(respuesta)
{
    let secciones;
    let option = ""; // El tag option del select de secciones
    // Si no tiene ninguna seccion registrada, limpiar el select
    if (respuesta.length <= 2)
    {
	option += "<option value=''> No hay secciones </option>";
	document.getElementById("id_seccion").innerHTML = option;
	return;
    }

    secciones = JSON.parse(respuesta);
    for (let seccion in secciones)
    {
	option += "<option value='" + secciones[seccion].idSeccion + "'>" + secciones[seccion].seccion + " </option>";
	document.getElementById("id_seccion").innerHTML = option;
    }
}

function secciones()
{
    let grado = document.getElementById("id_grado");
    let idgrado = grado.options[grado.selectedIndex].value;

    ajax(idgrado, ruta, ponerSecciones);
}

