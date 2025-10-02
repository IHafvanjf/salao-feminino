<?php
include 'config.php';
session_start();

$token = $_GET['token'] ?? '';

if (empty($token)) {
    $_SESSION['error_message'] = "Token inválido.";
    header("Location: index.php");
    exit;
}

// Verifica se o token é válido
$stmt = $conn->prepare("SELECT UsuarioID FROM Usuarios WHERE reset_token = ? AND TokenExpiration > NOW()");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if (!$user = $result->fetch_assoc()) {
    $_SESSION['error_message'] = "Token expirado ou inválido.";
    header("Location: index.php");
    exit;
}

$userId = $user['UsuarioID'];
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="container">
        <form class="form" action="update_password.php" method="post">
            <p class="form-title">Definir nova senha</p>
            <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
            <div class="input-container">
                <input type="password" name="new_password" placeholder="Nova senha" required>
            </div>
            <div class="input-container">
                <input type="password" name="confirm_password" placeholder="Confirmar nova senha" required>
            </div>
            <button type="submit" class="submit">Atualizar senha</button>
        </form>
    </div>

</body>
</html>
