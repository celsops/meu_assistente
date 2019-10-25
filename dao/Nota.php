<?php
include '../criarConecxao.php';

class Nota{
    public function criarNota($json){
        $conn = criarConecxao();
        $user = $json->usuario;
        $dias_da_semana = $json->col_dias_semana;
        $titulo = $json->titulo;
        $descricao = $json->col_descricao;
        $hora = $json->col_hora;
        $id_cor = $json->col_cor;
        $data = $json->col_data;

        $sql = "insert into tbl_notas(col_titulo,col_descricao,col_hora,col_usuario,col_data) values(";
        $sql = $sql .'"'.$titulo.'","'.$descricao.'","'.$hora.'","'.$user.'",'.$data.')';

        $result = $conn->query($sql);
        $erro = $conn->error;

        $sql = "select col_id from tbl_notas where col_titulo='". $titulo."' and col_descricao='".$descricao."'";
        $sql = $sql . "and col_hora='".$hora."' and col_usuario='".$user."';";

        $r = mysqli_query($conn, $sql);

        if ( mysqli_num_rows($r)==0){ //Tamanho
            return "Dados invalidos.";
        }
        $row = $r->fetch_assoc();
        $id_nota = $row['col_id'];

        foreach ($dias_da_semana as $id_dia) {
            $sql = "insert into tbl_dia_semana_nota(col_id_nota,col_id_dia) values (";
            $sql = $sql . $id_nota.",".$id_dia.");";

            $result = $conn->query($sql);
            $erro = $conn->error;
            if ($result===false){
                return "Erro ao cadastrar dias.";
            }
        }
        $sql = "insert into tbl_cor_nota(col_id_nota,col_cod_cor) values (";
        $sql = $sql . $id_nota.",".$id_cor.");";

        $result = $conn->query($sql);
        if ($result){
            $conn->close();
            return "OK!";
        }
        else{
            $conn->close();
            return "Erro ao cadastrar cor.";
        }

    }
    public function getNotas($user){
        $conn = criarConecxao();

        $sql = "select * from tbl_notas where col_usuario='".$user."';";

        $array_json = array();

        $result = $conn->query($sql);
        if (mysqli_num_rows($result)==0){
            return $array_json;
        }
        else{
            while($row = $result->fetch_assoc()) {
                $json =  new STDClass();
                $json -> id = $row['col_id'];
                $json -> name = $row['col_titulo'];

                $sql = "select * from tbl_dia_semana_nota where col_id_nota=".$row['col_id'].";";

                $result = $conn->query($sql);
                $arr = array();
                if (mysqli_num_rows($result)==0){
                    $json -> dias = $arr;
                    // return $json;
                }
                else{
                    while($row = $result->fetch_assoc()){
                       array_push($arr,$row['col_id_dia']);
                    }
                    $json -> dias = $arr;
                }
                array_push($array_json,$json);
            }
            return $array_json;
        }
    }
    public function getNotasDescricao($id){
        $conn = criarConecxao();

        $sql = "select * from tbl_notas where col_id=".$id.";";

        $json =  new STDClass();

        $result = $conn->query($sql);

        if (mysqli_num_rows($result)==0){
            return $json;
        }
        else{
            $row = $result->fetch_assoc();
            $json -> id = $row['col_id'];
            $json -> name = $row['col_titulo'];
            $json -> descricao = $row['col_descricao'];
            $json -> hora = $row['col_hora'];
            $json -> data = $row['col_data'];
            $json -> usuario = $row['col_usuario'];

        }

        $sql = "select * from tbl_dia_semana_nota where col_id_nota=".$id.";";

        $result = $conn->query($sql);
        $arr = array();
        if (mysqli_num_rows($result)==0){
            $json -> dias = $arr;
            return $json;
        }
        else{
            while($row = $result->fetch_assoc()){
               array_push($arr,$row['col_id_dia']);
            }
            $json -> dias = $arr;
        }
        return $json;
        
    }
    public function delNotas($json){
        $conn = criarConecxao();
        $lista = $json->dados;
        foreach ($lista as $id) {
            $sql = "delete from tbl_notas where col_id=".$id;
            $result = $conn->query($sql);
            if ($result===false){
                $erro = $conn->error;
                return $erro;
            }
            $conn->close();
        }
        return "OK!";
    }
}
?>
	