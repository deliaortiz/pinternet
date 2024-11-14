<?php
//Esto es el back end de php

// inicia una nueva seccion o reanuda una existente
session_start();
 
// verifica que el usuario ya ha iniciado seción, si es asi dirige a la pagina principal
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
 
// incluye la configuracion de la base de datos
require_once "conexion.php";
 
// se definen las variables para user y pass y una variable que maneja errores que es login_error
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// se comprueba si fue enviado el formulario, recordar que el login es un formulario
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // se validan los campo , trim recorta los espacio en blanco
    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor ingrese su Usuario.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // se valida la contraseña igual que el user
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor ingrese su contraseña.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // se valida si con correctos los campos introducidos
    if(empty($username_err) && empty($password_err)){
        // se llama a la base de datos, para buscar el usuario
        $sql = "SELECT u.personaId ,u.username , u.passw , r.rol_desc FROM usuarios u inner join roles r on u.id_rol = r.id_rol WHERE username = ?";
        //prepara y ejecuta la consulta 
        if($stmt = mysqli_prepare($con, $sql)){
           
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            
            $param_username = $username;
            
            
            if(mysqli_stmt_execute($stmt)){
                // devuelve el resultado
                mysqli_stmt_store_result($stmt);
                
                // se encuentra el usuario y se verifica que la contraseña este correcta 
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id_user, $user_name, $hashed_password,$rol_desc);
                    if(mysqli_stmt_fetch($stmt)){
                        if(($password == $hashed_password)){
                            // si no se encuentra el user y pass se debe inciar nuevamente la sesion 
                            session_start();
                            
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id_user"] = $id_user;
                            $_SESSION["user_name"] = $user_name;                            
                            $_SESSION["rol_desc"] = $rol_desc;  
                            echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
                            //redireccionad al login 
                            header("location: index.php");
                        } else{
                            // genera un mensaje de error
                            $login_err = "Usuario o contraseña invalida.";
                        }
                    }
                } else{
                    
                    $login_err = "Usuario o contraseña invalida.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Cierra la conexion
            mysqli_stmt_close($stmt);
        }
    }
    
    // Cierra la conexion 
    mysqli_close($con);
}
//codigo de html
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
<!-- estos son los estilos del css-->
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="login-box">
    
        <h2>Login</h2>


        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Usuario</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Ingresar">
            </div>
        </form>
    </div>
</body>
</html>
