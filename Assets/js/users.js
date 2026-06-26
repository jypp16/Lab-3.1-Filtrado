
const tblUsuarios_body = document.getElementById("tblUsuarios_body");
const btnGuardar = document.getElementById("btnGuardar");
const correo = document.getElementById("correo");
const clave = document.getElementById("clave");

document.addEventListener("DOMContentLoaded", () => {
    cargarUsuarios();
    btnGuardar.addEventListener("click", async ()=>{
        var data = {
            correo: correo.value,
            clave: clave.value
        }
        var response = await fetch(BASE_URL + "/users/guardar_async", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        }).then( (response)=>{return response.json();} );
    });
});

async function cargarUsuarios(){
    var data = await fetch(BASE_URL + "/users/listado_async").then( (response)=>{return response.json();} );
    var str_html = "";
    data.forEach(elem => {
        str_html += "<tr>" + "<td>" + elem.id + "</td>"+ "<td>" + elem.correo + "</td>"+"</tr>";
    });
    tblUsuarios_body.innerHTML = str_html;
}

async function guardar_async() {

}
