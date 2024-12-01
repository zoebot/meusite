<?php
session_start();

// Configuração do banco de dados
$servername = "hosting.fusioncloud.com.br";
$username = "u1431_eP4igqhtQa";
$password = "okvFE@xr0kUiLbLapNRzEC7^";
$dbname = "s1431_andesron";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Consulta para verificar o usuário no banco de dados
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se o usuário existe e se a senha está correta
        if ($user && password_verify($password, $user['password_hash'])) {
            // Login bem-sucedido, cria sessão
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: painel.php"); // Redireciona para o painel
            exit();
        } else {
            // Credenciais inválidas
            $error_message = "Usuário ou senha incorretos.";
        }
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Fisioterapia Nexus</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($error_message)) { echo "<p style='color:red;'>$error_message</p>"; } ?>
        <form action="login.php" method="POST">
            <label for="username">Usuário:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Entrar</button>
        </form>
        <p>Não tem uma conta? <a href="register.php">Registre-se</a></p>
    </div>
</body>
</html>
