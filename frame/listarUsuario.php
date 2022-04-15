<?php
session_start();
include("../script/php/conexao.php");
include("../frame/verifica_fraude.php");

$sql = "select * from pessoa order by id desc";

$query = mysqli_query($con, $sql);
$nivel = $_SESSION['adm'];
$dis = "";
if ($nivel == 1) {
    $nivel = " Administrador";
} else {
    $nivel = "";
    $dis = "disabled";
}


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Usuários</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script defer src="../script/vue/app4.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/visual.css" />
</head>

<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">

            <a class="navbar-brand">Olá<?php echo $nivel . ', ' .  $_SESSION['nome'] ?>!</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="main.php">Início</a>

                    <li class="nav-item dropdown ">
                        <a class="nav-link dropdown-toggle <?php echo $dis ?>" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Cadastrar
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <form action="pessoa.php" method="post">
                                <li><a class="dropdown-item" href="pessoa.php">Pessoa</a></li>
                            </form>

                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Listar
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="listarPessoas.php">Pessoa</a></li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="listarUsuario.php">Usuário</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="d-grid gap-2 d-md-block">
                    <a href="main.php">
                        <button class="btn btn-secondary" type="button">Voltar</button></a>
                    <a href="logout.php">
                        <button class="btn btn-secondary" type="button">Sair</button></a>
                </div>
            </div>

        </nav>


        <div class="container-fluid">
            <div class="p-4 mt-1 p-md-5 mb-2 text-white rounded bg-dark">
                <div class="col-md-6 px-0">
                    <h2 class="display-10 fst-italic">Lista de Usuários Cadastrados</h2>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <table class="table table-striped">

                <thead>
                    <tr>
                        <th scope="col">Cod:</th>
                        <th scope="col">Nome:</th>
                        <th scope="col">E-Mail:</th>
                        <th scope="col">Nível:</th>
                        <th scope="col">Situação:</th>
                        <?php

                        if ($nivel == " Administrador") {
                            echo '<th scope="col">Ação:</th>';
                        }
                        ?>


                    </tr>
                </thead>
                <tbody>
                    <?php

                    while ($user_data = mysqli_fetch_assoc($query)) {


                        $status = "";

                        if ($user_data['status'] != 3) {

                            if ($user_data['status'] == 1) {
                                $status = "Ativo";
                            } else {
                                $status = "Inativo";
                            }

                            $adm = "";
                            if ($user_data['adm'] == 1) {
                                $adm = "Administrador";
                            } else {
                                $adm = "Comum";
                            }



                            echo "<tr>";
                            echo "<th scope='row' id='id' >" . $user_data['id'] . "</th>";
                            echo "<td id='nome'>" . $user_data['nome'] . "</td>";
                            echo "<td id='email'>" . $user_data['email'] . "</td>";

                            echo "<td id='adm'>" . $adm . "</td>";
                            echo "<td id='status'>" . $status . "</td>";


                            if ($nivel == " Administrador") {
                                echo "<th scope='row' id='fun' >
                            <a href='viewUser.php?id=$user_data[id]' >
                            <img src='../img/view.png' >
                            </a>
                    <a href='editUser.php?id=$user_data[id]'>
                    <img src='../img/edit.png' >
                    </a>
                    <a href='deletPessoaaa.php?id=$user_data[id]'>
                    <img src='../img/delet.png' >
                    </a></th>";
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

</body>

</html>