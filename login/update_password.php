<?php
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (empty($newPassword) || empty($confirmPassword)) {
        $_SESSION['error_message'] = "Todos os campos são obrigatórios.";
        header("Location: reset.php?token=" . $_POST['token']);
        exit;
    }

    if ($newPassword !== $confirmPassword) {
        $_SESSION['error_message'] = "As senhas não coincidem.";
        header("Location: reset.php?token=" . $_POST['token']);
        exit;
    }

    // Hash da nova senha
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Atualiza a senha no banco e remove o token
    $stmt = $conn->prepare("UPDATE Usuarios SET password = ?, reset_token = NULL, TokenExpiration = NULL WHERE UsuarioID = ?");
    $stmt->bind_param("si", $hashedPassword, $userId);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Senha redefinida com sucesso!";
    } else {
        $_SESSION['error_message'] = "Erro ao atualizar a senha.";
    }

    $stmt->close();
    header("Location: index.php");
    exit;
}
?>
