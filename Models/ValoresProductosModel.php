<?php

class ValoresProductosModel extends Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'valores_productos';
        $this->tableAlias = 'vp';
    }

    public function getPorCategoria($id_categoria) {
        return $this
            ->select(['vp.id_producto', 'vp.id_atributo', 'vp.valor'])
            ->join('productos p', 'p.id = vp.id_producto')
            ->where(["p.id_categoria = :id_categoria"], [':id_categoria' => $id_categoria])
            ->get();
    }
}
