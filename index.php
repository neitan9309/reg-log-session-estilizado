<?php
    include("database.php");

    //Funçaõ que permitirá o armazenamento e o transporte de dados entre páginas.
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/index.css?v=1.0">
    <title>Registre-se no Fakebook!</title>
</head>
<body>

    <!-- Formulário simples com uma auto referência ("PHP_SELF") protegida por um filtro de caracteres. -->
    <div class="box_index">
        <form class="form_index" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <h2>FAKEBOOK</h2>
            <p>Cadastre-se na nossa rede:</p>
            
            usuario:
            <input type="text" name="usuario">
            email:
            <input type="email" name="email">
            senha:
            <input type="password" name="senha">
            
            <div class="botoes_index">
                <a href="login.php">login</a>
                <input type="submit" name="registro" value="registre-se">
            </div>
        </form>
        
    </div>

    <footer>Desenvolvido por <a href="https://www.linkedin.com/in/natanael-pinto-de-andrade-09b401260/" target="_blank">Natanael Pinto de Andrade</a> <br> imagem de background por <a href="https://br.freepik.com/" target="_blank">FreePik</a></footer>

</body>
</html>
<?php

    //Condição if que observa a ação POST do formulário.
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        //Variáveis que recebem os dados inseridos no formulário. Um filtro básico para evitar injeções foi adicionado.
        $usuario = filter_input(INPUT_POST, "usuario", FILTER_SANITIZE_SPECIAL_CHARS);
        $senha = filter_input(INPUT_POST, "senha", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
        
        //Algumas condições aninhadas para evitar que o script seja concluído com algum campo vazio.
        if(empty($usuario)){
            echo"<script> alert('Por favor, insira um nome de usuário.')</script>";
        }
        elseif(empty($senha)){
            echo"<script> alert('Por favor, insira uma senha.')</script>";
        }
        elseif(empty($email)){
            echo"<script> alert('Por favor, insira um email.')</script>";
        }

        /*Condição principal. Caso o formulário seja devidamente
        preenchido, a senha é armazenada na variável $hash, que por sua
        vez chama a função de encriptação desse dado. Em seguida definimos
        a variável $sql, responsável por armazenar o comando SQL (INSERT INTO)
        que irá inserir os dados do formulário no nosso banco de dados.*/
        else{
            $hash = password_hash($senha, PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuarios (usuario, email, senha)
                    VALUES ('$usuario', '$email', '$hash')";

                /*Com a função mysqli_query (e o parâmetro
                de comando SQL preenchido com avariável $sql),
                iniciamos a comunicação com o servidor.*/
                mysqli_query($conn, $sql);

                /*Novo comando SQL, dessa vez para resgatar
                os dados adicionais criados no momento da
                inserção do dado no banco.*/
                $sql_login = "SELECT id, usuario, senha, email, data_reg FROM usuarios WHERE email = '$email'";
                $resultado = mysqli_query($conn, $sql_login);
                
                //O mysqli_fetch_assoc armazenará esses dados numa array associativa.
                $linha = mysqli_fetch_assoc($resultado);

                /*A $_SESSION guarda dados e nos permite usá-los
                em outras páginas. Ela ajudará a transportar os
                dados que nos interessam para a página home.php*/
                $_SESSION["usuario_session"] = $linha["usuario"];
                $_SESSION["email_session"] = $linha["email"];
                $_SESSION["data_reg_session"] = $linha["data_reg"];

                //Script que redireciona o usuário à proxima página.
                echo"<script> alert('Um momentinho, você está sendo redirecionado.')</script>
                    <script>
                    setTimeout(function(){
                    window.location.href = 'home.php';
                    }, 500);
                    </script>";

        }
    }

    mysqli_close($conn);
?>
