<?php
$servername = "hosting.fusioncloud.com.br";
$username = "u1431_eP4igqhtQa";
$password = "okvFE@xr0kUiLbLapNRzEC7^";
$dbname = "s1431_andesron";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $new_username = "admin";  // Altere conforme necessário
    $new_password = "admin123";  // Altere conforme necessário

    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, password_hash) VALUES (:username, :password_hash)");
    $stmt->bindParam(':username', $new_username);
    $stmt->bindParam(':password_hash', $password_hash);
    $stmt->execute();

    echo "Usuário registrado com sucesso!";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
