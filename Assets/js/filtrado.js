const selectCategoria = document.getElementById("selectCategoria");
const cardFiltros = document.getElementById("cardFiltros");
const filtrosContainer = document.getElementById("filtrosContainer");
const tblProductos = document.getElementById("tblProductos");
const tblProductos_body = document.getElementById("tblProductos_body");
const mensajeInicial = document.getElementById("mensajeInicial");
const buscador = document.getElementById("buscador");

function debounce(fn, delay) {
    let timer;
    return function (...args) {
        clearTimeout(timer);
        timer = setTimeout(() => fn.apply(this, args), delay);
    };
}

const buscarDebounced = debounce(() => {
    const id = selectCategoria.value;
    if (id) cargarProductos(id);
}, 400);

document.addEventListener("DOMContentLoaded", () => {
    cargarCategorias();
    selectCategoria.addEventListener("change", () => {
        const id = selectCategoria.value;
        if (id) {
            buscador.disabled = false;
            cargarFiltros(id);
            cargarProductos(id);
        } else {
            buscador.disabled = true;
            buscador.value = "";
            cardFiltros.style.display = "none";
            filtrosContainer.innerHTML = "";
            tblProductos.style.display = "none";
            mensajeInicial.style.display = "block";
        }
    });
    buscador.addEventListener("input", buscarDebounced);
});

async function cargarCategorias() {
    const response = await fetch(BASE_URL + "/productos/categorias_async");
    const data = await response.json();
    data.forEach(cat => {
        const option = document.createElement("option");
        option.value = cat.id;
        option.textContent = cat.nombre;
        selectCategoria.appendChild(option);
    });
}

async function cargarFiltros(id_categoria) {
    const response = await fetch(BASE_URL + "/productos/apiGetFiltros/" + id_categoria);
    const atributos = await response.json();

    filtrosContainer.innerHTML = "";

    if (atributos.length === 0) {
        const p = document.createElement("p");
        p.className = "text-muted";
        p.textContent = "No hay filtros disponibles.";
        filtrosContainer.appendChild(p);
        cardFiltros.style.display = "block";
        return;
    }

    atributos.forEach(atr => {
        const div = document.createElement("div");
        div.className = "mb-2";

        const label = document.createElement("label");
        label.className = "form-label fw-bold";
        label.textContent = atr.nombre;

        const select = document.createElement("select");
        select.className = "form-select form-select-sm filtro-select";
        select.dataset.id = atr.id;
        select.addEventListener("change", () => aplicarFiltros());

        const defaultOpt = document.createElement("option");
        defaultOpt.value = "";
        defaultOpt.textContent = "Todos";
        select.appendChild(defaultOpt);

        if (atr.valores && atr.valores.length > 0) {
            atr.valores.sort().forEach(valor => {
                const option = document.createElement("option");
                option.value = valor;
                option.textContent = valor;
                select.appendChild(option);
            });
        }

        div.appendChild(label);
        div.appendChild(select);
        filtrosContainer.appendChild(div);
    });

    cardFiltros.style.display = "block";
}

async function cargarProductos(id_categoria) {
    const filtros = {};
    document.querySelectorAll(".filtro-select").forEach(sel => {
        if (sel.value) {
            filtros[sel.dataset.id] = sel.value;
        }
    });

    const buscar = buscador.value.trim();

    const response = await fetch(BASE_URL + "/productos/filtrar_async/" + id_categoria, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ filtros, buscar })
    });

    const productos = await response.json();

    tblProductos_body.innerHTML = "";

    if (productos.length === 0) {
        const tr = document.createElement("tr");
        const td = document.createElement("td");
        td.colSpan = 3;
        td.className = "text-center text-muted";
        td.textContent = "No se encontraron productos.";
        tr.appendChild(td);
        tblProductos_body.appendChild(tr);
    } else {
        productos.forEach(p => {
            const tr = document.createElement("tr");

            const tdId = document.createElement("td");
            tdId.textContent = p.id;
            tr.appendChild(tdId);

            const tdNombre = document.createElement("td");
            tdNombre.textContent = p.nombre;
            tr.appendChild(tdNombre);

            const tdValores = document.createElement("td");
            if (p.valores) {
                Object.entries(p.valores).forEach(([k, v]) => {
                    const badge = document.createElement("span");
                    badge.className = "badge bg-info me-1";
                    badge.textContent = v;
                    tdValores.appendChild(badge);
                });
            }
            tr.appendChild(tdValores);

            tblProductos_body.appendChild(tr);
        });
    }

    tblProductos.style.display = "table";
    mensajeInicial.style.display = "none";
}

async function aplicarFiltros() {
    const id = selectCategoria.value;
    if (id) {
        await cargarProductos(id);
    }
}
