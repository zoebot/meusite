<?php
$servername = "hosting.fusioncloud.com.br";
$username = "u1431_eP4igqhtQa";
$password = "okvFE@xr0kUiLbLapNRzEC7^";
$dbname = "s1431_andesron";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $age = $_POST['age'];
        $locality = $_POST['locality'];
        $main_complaint = $_POST['main_complaint'];
        $anamnesis = $_POST['anamnesis'];

        $image_path = null;
        if (!empty($_FILES['image']['name'])) {
            $target_dir = "uploads/";
            $image_path = $target_dir . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
        }

        $stmt = $conn->prepare("INSERT INTO patients (name, age, locality, main_complaint, anamnesis, image_path) 
                                VALUES (:name, :age, :locality, :main_complaint, :anamnesis, :image_path)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':locality', $locality);
        $stmt->bindParam(':main_complaint', $main_complaint);
        $stmt->bindParam(':anamnesis', $anamnesis);
        $stmt->bindParam(':image_path', $image_path);
        $stmt->execute();

        echo "Paciente cadastrado com sucesso!";
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
