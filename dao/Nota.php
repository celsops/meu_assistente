<?php
include '../criarConecxao.php';

class Nota{
    public function criarNota($json){
        session_start();
        $conn = criarConecxao();
        $user = $json->usuario; //$_SESSION['usuario'];
        $dias_da_semana = $json->col_dias_semana;
        $titulo = $json->titulo;
        $descricao = $json->col_descricao;
        $hora = $json->col_hora;
        $id_cor = $json->col_cor;

        $sql = "insert into tbl_notas(col_titulo,col_descricao,col_hora,col_usuario) values(";
        $sql = $sql .'"'.$titulo.'","'.$descricao.'","'.$hora.'","'.$user.'")';

        //echo $id_cor;
        
        $result = $conn->query($sql);
        $erro = $conn->error;
        //$conn->close();

        $sql = "select col_id from tbl_notas where col_titulo='". $titulo."' and col_descricao='".$descricao."'";
        $sql = $sql . "and col_hora='".$hora."' and col_usuario='".$user."';";

        $r = mysqli_query($conn, $sql);
        //$conn->close();

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
            //$conn->close();
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
        session_start();
        //$user = $_SESSION['usuario'];
        $sql = "select * from tbl_notas where col_email='".$user."';";
        echo $sql;
        $array_json = array();

        $result = $conn->query($sql);

        if (mysqli_num_rows($result)==0){
            // Json vazio
            return $array_json;
        }
        else{
            while($row = $result->fetch_assoc()) {
                $json -> id = $row['col_id'];
                $json -> name = $row['col_titulo'];
                array_push($array_json,$json);
            }
            return array_json;
        }

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
    }
} 
?>
