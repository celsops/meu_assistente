<?php
include '../criarConecxao.php';

class Usuario{
    public function login($props){
        $conn = criarConecxao();
        $email = $props ->col_email;
		$senha = md5($props -> col_senha);

		$sql = "select * from tbl_usuario where col_email='". $email."';";

		$r = mysqli_query($conn, $sql);
		$conn->close();

		if ( mysqli_num_rows($r)==0){ //Tamanho
			return "Usuário não cadastrado.";
		}

		while($row = $r->fetch_assoc()) {
			if($row['col_senha'] == $senha){
                session_start();
                $_SESSION['usuario'] = $email;
				return "OK!";
			}
		}
		return "Usuario ou senha incorreto.";
    }
    public function cadastro($props){
        $conn = criarConecxao();
        $email = $props ->col_email;
        $senha = md5($props -> col_senha);
        
        $sql = "insert into tbl_usuario(col_email,col_senha) values(";
        $sql = $sql.'"' .$email. '","'.$senha.'");';

        $result = $conn->query($sql);
        
        if ($result){
            // Usuário cadastrado com sucesso
            $conn->close();
            session_start();
            $_SESSION['usuario'] = $email;
            return "OK!";
        }
        else{
            $erro = $conn->error;
            return error;
        }
    }

} 
?>
