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
        $sql = $sql .'"'.$titulo.'","'.$descricao.'","'.$hora.'","'.$user.'","'.$data.'")';

        // echo $sql;
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

                $result2 = $conn->query($sql);
                $arr = array();
                if (mysqli_num_rows($result2)==0){
                    $json -> dias = $arr;
                    
                }
                else{
                    while($row2 = $result2->fetch_assoc()){
                       array_push($arr,$row2['col_id_dia']);
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

        $sql = "select * from tbl_cor_nota where col_id_nota=".$id.";";

        $result = $conn->query($sql);
        if (mysqli_num_rows($result)==0){
            $json -> cor = "";
            return $json;
        }
        else{
            $row = $result->fetch_assoc();
            $json -> cor = $row['col_cod_cor'];
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
        }
        $conn->close();
        return "OK!";
    }
    public function updateNotas($json){
        $conn = criarConecxao();
        $dias_da_semana = $json->col_dias_semana;
        $titulo = $json->titulo;
        $descricao = $json->col_descricao;
        $hora = $json->col_hora;
        $id_cor = $json->col_cor;
        $data = $json->col_data;
        $id = $json->col_id;
        
        $sql = "update tbl_notas set col_titulo = '".$titulo."',col_descricao = '".$descricao."',col_hora = '".$hora."',col_data = '".$data."' where col_id =".$id.";";

        $result = $conn->query($sql);
        
        if ($result===false){
            // var_dump($conn->error);
            return "Erro ao atualizar tbl_notas";
        }
        
        // Cor
        // Verifica se já há uma cor adicionada
        $sql = "select * from  tbl_cor_nota where col_id_nota =".$id.";";
        $result = $conn->query($sql);
        $row = $result-> fetch_assoc();
        // var_dump($result-> fetch_assoc());
        // echo $sql."\n";
        if ($result===false){
            // var_dump($conn->error);
            return "Erro ao buscar tbl_cor_nota";
        }
        if ($row==NULL){
            $sql = "insert into tbl_cor_nota(col_cod_cor,col_id_nota) values(".$id_cor.",".$id.");";
            $result = $conn->query($sql);
            if ($result===false){
                // var_dump($conn->error);
                return "Erro ao atualizar tbl_cor_nota";
            }    
        }
        else{
            $sql = "update tbl_cor_nota set col_cod_cor =".$id_cor." where col_id_nota=".$id.";";
            $result = $conn->query($sql);
            if ($result===false){
                // var_dump($conn->error);
                return "Erro ao atualizar tbl_cor_nota";
            }
        }

        // Dia da semana
        $sql = "select * from tbl_dia_semana_nota where col_id_nota=".$id.";";
        $reuslt = $conn->query($sql);

        
        if ($result===false){
            return "Erro ao buscar notas";
        }
        else{
            $lista_dias = array();
            if ($result){}
            else{
                while ($row = $result->fetch_assoc()){
                    array_push($lista_dias,$row['col_id_dia']);
                }
            }

            foreach ($dias_da_semana as $id_dia) {
                if (in_array($id_dia,$lista_dias)){ }
                else{
                    
                    $sql = "insert into tbl_dia_semana_nota(col_id_nota,col_id_dia) values (".$id.",".$id_dia.");";
                    // echo $sql."\n";
                    $reuslt = $conn-> query($sql);
                    if($result==false){
                        return "Erro ao add dia";
                    }
                }
            }
            foreach ($lista_dias as $id_dia) {
                if (in_array($id_dia,$dias_da_semana)){}
                else{
                    $sql = "delete from tbl_dia_semana_nota where col_id_nota=".$id." and col_id_dia=".$id_dia.");";
                    $reuslt = $conn-> query($sql);
                    if($result==false){
                        return "Erro ao deletar dia";
                    }
                }
            
            }
        }
        return "OK!";


    }
}
?>
	