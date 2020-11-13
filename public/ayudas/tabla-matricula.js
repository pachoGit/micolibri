// Estructura para guardar la informacion de un fila de la tabla
class Info
{
    constructor(_idcurso, _idgrado, _idseccion)
    {
	this.idcurso = _idcurso;
	this.idgrado = _idgrado;
	this.idseccion = _idseccion;
	this.id = _idcurso + _idgrado + _idseccion; // Identificador para poder remover del array
    }
    
    traerIdCurso()
    {
	return this.idcurso;
    }

    traerIdGrado()
    {
	return this.idgrado;
    }

    traerIdSeccion()
    {
	return this.idseccion;
    }

    comparar(Info)
    {
	if (this.idcurso === Info.traerIdCurso() &&
	    this.idgrado === Info.traerIdGrado() &&
	    this.idseccion === Info.traerIdSeccion())
	    return true;
	return false;
    }
}

// Tener referencia a los datos seleccionados (el contenido del option)
let curso_actual = "";
let grado_actual = "";
let seccion_actual = "";
let id_curso = "";
let id_grado = "";
let id_seccion = "";

// Lista de informaciones de la tabla
let lista_infos = [];

// Guardar los datos (en los objetos) de la nueva fila a agregar en la tabla
function guardarDatosFila()
{
    let objCurso = "";
    let objGrado = "";
    let objSeccion = "";
    let i;

    // Obtenemos el curso seleccionado
    objCurso = document.getElementById("id_curso");
    id_curso = objCurso.options[objCurso.selectedIndex].value;

    objGrado = document.getElementById("id_grado");
    id_grado = objGrado.options[objGrado.selectedIndex].value;

    objSeccion = document.getElementById("id_seccion");
    id_seccion = objSeccion.options[objSeccion.selectedIndex].value;
    
    if (id_curso === "" || id_grado === "" || id_seccion === "")
	return -1;

    let nuevo = new Info(id_curso, id_grado, id_seccion);

    for (i in lista_infos)
    {
	if (lista_infos[i].comparar(nuevo) === true)
	{
	    return -2;
	}
    }

    lista_infos.push(nuevo); // Agregamos la informacion de la nueva fila

    contenido = objCurso.options[objCurso.selectedIndex].text;
    curso_actual = contenido;

    contenido = objGrado.options[objGrado.selectedIndex].text;
    grado_actual = contenido;

    contenido = objSeccion.options[objSeccion.selectedIndex].text;
    seccion_actual = contenido;
}

function agregarEnTabla()
{
    let tbody = "";
    let cuerpo = document.getElementById("tabla").getElementsByTagName("tbody")[0];
    let nuevaFila = cuerpo.insertRow(cuerpo.rows.length);
    
    switch (guardarDatosFila())
    {
	case -1:
	alert("Hay campos vacios seleccionados");
	return;
	case -2:
	alert("Esta información ya está registrada");
	return;
    }
    
    // Agregamos la nueva fila con los datos
    tbody += "<tr>";
    tbody += "<td>" +  curso_actual + "</td>";
    tbody += "<td>" +  grado_actual + "</td>";
    tbody += "<td>" +  seccion_actual + "</td>"; // Usar atributos para eliminar
    tbody += "<td> <input class='btn btn-outline-danger'curso='"+ id_curso+"' grado='"+ id_grado+"' seccion='"+ id_seccion +"' onclick='eliminar(this)' type='button' value='Quitar'> </td>";
    tbody += "</tr>";
    nuevaFila.innerHTML = tbody;
}

function eliminar(input)
{
    let i;
    let curso = input.getAttribute("curso");
    let grado = input.getAttribute("grado");
    let seccion = input.getAttribute("seccion");

    let borrar = new Info(curso, grado, seccion);

    for (i in lista_infos)
    {
	if (lista_infos[i].comparar(borrar) === true)
	{
	    lista_infos.splice(i, 1);
	    break;
	}
    }
    
    // Eliminamos el tr (fila) de la tabla
    let fila = input.parentNode.parentNode; // LLegamos al tr
    fila.parentNode.removeChild(fila); // Del tbody eliminar el mismo tr
    
}

// Con los datos de la tabla en lista_infos...creamos checkbox invisibles
// para poder obtenerlas con $_POST
function formarCheckboxs()
{
    let i;

    for (i in lista_infos)
    {
	let check = document.createElement("input");
	check.type = "checkbox";
	check.id = lista_infos[i].traerIdCurso();
	check.value = lista_infos[i].traerIdCurso();
	check.checked = "checked";
	check.name = "cursos[]";
	check.style = "opacity:0; position:absolute; left:9999px;"
	document.getElementById("cursos").appendChild(check); // El div

	check = document.createElement("input");
	check.type = "checkbox";
	check.id = lista_infos[i].traerIdSeccion();
	check.value = lista_infos[i].traerIdSeccion();
	check.checked = "checked";
	check.name = "secciones[]";
	check.style = "opacity:0; position:absolute; left:9999px;"
	document.getElementById("secciones").appendChild(check); // El div

    }
}
