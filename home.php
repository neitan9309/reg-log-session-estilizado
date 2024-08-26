<?php
    include("database.php");
    
    //Funçaõ que permitirá o armazenamento e o transporte de dados entre páginas.
    session_start();
?>

<?php

    //Variável do tipo boolean, que possibilitará a troca entre os botões login e logout.
    $mostrarBotao = false;

    //Condicional que confere se a $_SESSION da sessão foi preenchida.
    if(isset($_SESSION["usuario_session"])){
        
        //Se tudo ocorrer bem nossa variável boolean é ativada e as variáveis de dados do usuário são preenchidas.
        $mostrarBotao = true;
        $nome_usuario = $_SESSION["usuario_session"];
        $email_usuario = $_SESSION["email_session"];
        $data_reg_usuario = $_SESSION["data_reg_session"];

        //E alguns textos, contendo também os dados registrados na sessão, são imprimidos na tela.
        echo"
        <div class='box_home'>
            <h2>Bem vindo(a), $nome_usuario!<br></h2>
            <p>Aqui está seu e-mail: $email_usuario <br>
            e aqui está a data do seu ingresso na nossa rede: $data_reg_usuario</p>
        </div>";
    }
    else{
        echo"Você não está logado.";
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fakebook Home Page</title>
    <link rel="stylesheet" href="estilos/home.css?v=1.0">
</head>
<body>
    
    <!-- Trecho de código PHP que confere o estado da variável boolean definida anteriormente. -->
    <?php if($mostrarBotao == true): ?>
        
        <!-- Caso o valor seja true, imprimimos
         o form (com o auto endereçamento e filtro
         de caracteres) mostrando o botão logout -->
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <button class="botao_home" type="submit" name="logout">logout</button>
        </form>

    <?php else: ?>

        <!-- Caso o valor seja false, imprimimos
            o form mostrando o botão login -->
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <button class="botao_home" type="submit" name="login">login</button>
        </form>

    <?php endif; ?>

    <footer>Desenvolvido por <a href="https://www.linkedin.com/in/natanael-pinto-de-andrade-09b401260/" target="_blank">Natanael Pinto de Andrade</a> <br> imagem de background por <a href="https://br.freepik.com/" target="_blank">FreePik</a></footer>

</body>
</html>

<?php

    //Condicional que observa o POST do botão da página.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        //Caso ativado, a sessão é esvaziada e destruida.
        session_unset();
        session_destroy();
        
        //E o usuário é redirecionado para a página de login.
        echo"<script> alert('Um momentinho, você está sendo redirecionado.')</script>
            <script>
                setTimeout(function(){
                window.location.href = 'login.php';
                }, 500);
            </script>";
    }

    mysqli_close($conn);
?>