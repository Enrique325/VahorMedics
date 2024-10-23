<?php  
if(isset($_POST['add_profileM'])) {
    $idodc = $_POST['mid'];
    $corr = $_POST['come'];
    $username = $_POST['namedc'];
    $password = MD5($_POST['pwdm']);
    $rol = $_POST['rlm'];
    
    try {
        $query_doctor = "UPDATE doctor SET corr=:corr, username=:username, password=:password, rol=:rol WHERE idodc=:idodc LIMIT 1";
        $statement = $connect->prepare($query_doctor);
        $data_doctor = [
            ':corr' => $corr,
            ':username' => $username,
            ':password' => $password,
            ':rol' => $rol,
            ':idodc' => $idodc
        ];
        $query_execute_doctor = $statement->execute($data_doctor);

        // Inserta los datos también en la tabla users
        $query_user = "INSERT INTO users (username, name, email, password, rol) VALUES (:username,:name, :corr, :password, :rol)";
        $statement_user = $connect->prepare($query_user);
        $data_user = [
            ':username' => $username,
            ':name' => $d->nodoc . ' ' . $d->apdoc,
            ':corr' => $corr,
            ':password' => $password,
            ':rol' => $rol
        ];
        $query_execute_user = $statement_user->execute($data_user);

        if ($query_execute_doctor && $query_execute_user) {
            echo '<div class="alert-success"><strong>Success!</strong> Perfil creado correctamente</div>';
            exit(0);
        } else {
            echo '<div class="alert-error"><strong>Error!</strong> No se pudo crear el perfil</div>';
        }

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>



