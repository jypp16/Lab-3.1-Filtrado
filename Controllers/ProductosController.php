<?php

class ProductosController extends Controller {

    public function index() {
        $this->views->render($this, "filtrado");
    }

    public function categorias_async() {
        $data = $this->model->getCategorias();
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function atributos_async($id_categoria) {
        $data = $this->model->getAtributosPorCategoria($id_categoria);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function apiGetFiltros($id_categoria) {
        $data = $this->model->getFiltrosPorCategoria($id_categoria);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function filtrar_async($id_categoria) {
        $str_json = file_get_contents("php://input");
        $post = json_decode($str_json, true);
        $filtros = $post['filtros'] ?? [];
        $buscar = $post['buscar'] ?? "";
        $data = $this->model->filtrarProductos($id_categoria, $filtros, $buscar);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
