<?php
include '../criarConecxao.php';

class Usuario{
    public function login($props){
        $conn = criarConecxao();
        $email = $props ->col_email;
		$senha = md5($props -> col_senha);

		$sql = "select * from tbl_usuario where col_email='". $email."';";
        //echo $sql;
		$r = mysqli_query($conn, $sql);
		

		if ( mysqli_num_rows($r)==0){ //Tamanho
			$conn->close();
            return "Usuário não cadastrado.";
        }

		while($row = $r->fetch_assoc()) {
			if($row['col_senha'] == $senha){
                session_start();
                $_SESSION['usuario'] = $email;
                $conn->close();
				return "OK!";
			}
		}
        $conn->close();
		return "Usuario ou senha incorreto.";
    }
    public function cadastro($props){ 
        $conn = criarConecxao();
        $email = $props ->col_email;
        $senha = md5($props -> col_senha);

        $sql = "select col_email from tbl_usuario where col_email=='".$email."';";
        $sql = $sql.'"' .$email. '","'.$senha.'");';

        $result = $conn->query($sql);
        
        if ($result){
            // Usuário já está cadastrado
            $conn->close();
            return "Usuário já está cadastrado";
        }
        else{
            $erro = $conn->error;
            return $erro;
        }
        
        $sql = "insert into tbl_usuario(col_email,col_senha) values(";
        $sql = $sql.'"' .$email. '","'.$senha.'");';

        $result = $conn->query($sql);
        
        if ($result){
            // Usuário cadastrado com sucesso
            $conn->close();
            return "OK!";
        }
        else{
            $erro = $conn->error;
            return $erro;
        }
    }
} 
?>
