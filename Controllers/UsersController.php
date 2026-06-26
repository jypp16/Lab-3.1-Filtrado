<?php

class UsersController extends Controller {

    public function index() {
        $this->views->render($this, "listado_async");
    }

    public function listado_async(){
        $data = $this->model->where(["estado = 1"])->orderBy("users.id", "ASC")->get();
        $json_resp = json_encode($data);
        header('Content-Type: application/json');
        echo $json_resp;
    }

    public function guardar_async() {
        $str_json = file_get_contents("php://input");
        $post = json_decode($str_json, true);
        $data = [
            "correo" => $post['correo'],
            "clave" => password_hash($post['clave'], PASSWORD_DEFAULT)
        ];

        if ($this->model->insert($data)) {
            $resp = [
                "code" => 200,
                "status" => "success",
                "message" => "Usuario guardado correctamente"
            ];
            header('Content-Type: application/json');
            echo json_encode($resp);
        } else {
            $resp = [
                "code" => 500,
                "status" => "error",
                "message" => "Error al guardar el usuario"
            ];
            header('Content-Type: application/json');
            echo json_encode($resp);
        }

    }

    public function ver($id){
        $data = $this->model->where(["id = ".$id, "estado = 1"])->first();
        
        echo json_encode($data);
        print_r("<pre>"); var_dump($data); print_r("</pre>");#test
        echo json_encode($data);
        var_dump($id);

    }

    public function crear(){
        $this->views->render($this, "formulario");
    }

    public function guardar() {
        $data = [
            "correo" => $_POST['correo'],
            "clave" => password_hash($_POST['clave'], PASSWORD_DEFAULT)
        ];

        if ($this->model->insert($data)) {
            header("Location: " . BASE_URL . "/users");
        } else {
            echo "Error al guardar el usuario.";
        }

    }


}