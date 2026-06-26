<?php

class ProductosModel extends Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'productos';
    }

    public function getCategorias() {
        $catModel = new Model();
        $catModel->table = 'categorias';
        return $catModel->orderBy('nombre', 'ASC')->get();
    }

    public function getAtributosPorCategoria($id_categoria) {
        $atrModel = new Model();
        $atrModel->table = 'atributos';
        $atrModel->tableAlias = 'a';
        $all = $atrModel
            ->select(['a.id', 'a.nombre'])
            ->join('valores_productos vp', 'vp.id_atributo = a.id')
            ->join('productos p', 'p.id = vp.id_producto')
            ->where(["p.id_categoria = :id_categoria"], [':id_categoria' => $id_categoria])
            ->orderBy('a.nombre', 'ASC')
            ->get();

        $vistos = [];
        $resultado = [];
        foreach ($all as $fila) {
            if (!in_array($fila['id'], $vistos)) {
                $vistos[] = $fila['id'];
                $resultado[] = $fila;
            }
        }
        return $resultado;
    }

    public function getValoresPorCategoria($id_categoria) {
        require_once "Models/ValoresProductosModel.php";
        $vpModel = new ValoresProductosModel();
        return $vpModel->getPorCategoria($id_categoria);
    }

    public function getFiltrosPorCategoria($id_categoria) {
        $atributos = $this->getAtributosPorCategoria($id_categoria);
        $valores = $this->getValoresPorCategoria($id_categoria);

        $valoresPorAtributo = [];
        foreach ($valores as $v) {
            $id_atr = $v['id_atributo'];
            if (!isset($valoresPorAtributo[$id_atr])) {
                $valoresPorAtributo[$id_atr] = [];
            }
            if (!in_array($v['valor'], $valoresPorAtributo[$id_atr])) {
                $valoresPorAtributo[$id_atr][] = $v['valor'];
            }
        }

        $resultado = [];
        foreach ($atributos as $atr) {
            $valores_unicos = isset($valoresPorAtributo[$atr['id']]) ? $valoresPorAtributo[$atr['id']] : [];
            sort($valores_unicos);
            $resultado[] = [
                'id' => $atr['id'],
                'nombre' => $atr['nombre'],
                'valores' => $valores_unicos
            ];
        }
        return $resultado;
    }

    public function getProductosPorCategoria($id_categoria) {
        return $this
            ->where(["id_categoria = :id_categoria"], [':id_categoria' => $id_categoria])
            ->orderBy('nombre', 'ASC')
            ->get();
    }

    public function filtrarProductos($id_categoria, $filtros, $buscar = "") {
        $this->where(["id_categoria = :id_categoria"], [':id_categoria' => $id_categoria]);

        if ($buscar !== "") {
            $this->where(["nombre LIKE :buscar"], [':buscar' => "%{$buscar}%"]);
        }

        $productos = $this->orderBy('nombre', 'ASC')->get();

        $valores = $this->getValoresPorCategoria($id_categoria);
        $productoValores = [];
        foreach ($valores as $v) {
            $productoValores[$v['id_producto']][$v['id_atributo']] = $v['valor'];
        }

        foreach ($productos as &$producto) {
            $producto['valores'] = $productoValores[$producto['id']] ?? [];
        }
        unset($producto);

        if (empty($filtros)) {
            return $productos;
        }

        $filtrados = [];
        foreach ($productos as $producto) {
            $cumple = true;
            foreach ($filtros as $id_atributo => $valor_buscar) {
                if (!isset($producto['valores'][$id_atributo]) ||
                    $producto['valores'][$id_atributo] !== $valor_buscar) {
                    $cumple = false;
                    break;
                }
            }
            if ($cumple) {
                $filtrados[] = $producto;
            }
        }
        return $filtrados;
    }
}
