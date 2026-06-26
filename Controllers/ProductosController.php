<?php

class ProductosController extends Controller
{

    public function index()
    {
        echo "Módulo Productos";
    }

    public function apiGetFiltros()
    {
        if (!isset($_GET['categoria_id'])) {
            header('Content-Type: application/json');

            echo json_encode([
                "success" => false,
                "message" => "Debe enviar categoria_id"
            ]);

            return;
        }

        $categoria_id = intval($_GET['categoria_id']);

        $filtros = [];

        switch ($categoria_id) {

            case 1:

                $filtros = [
                    "Talla" => ["S","M","L","XL"],
                    "Color" => ["Rojo","Azul","Negro"]
                ];

            break;

            case 2:

                $filtros = [
                    "Almacenamiento" => ["64 GB","128 GB","256 GB"],
                    "RAM" => ["4 GB","8 GB"]
                ];

            break;

            default:

                $filtros = [];

            break;
        }

        header('Content-Type: application/json');
        echo json_encode($filtros);
    }

}