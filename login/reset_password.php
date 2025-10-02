<?php
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';

    if (empty($email)) {
        $_SESSION['error_message'] = "Digite seu e-mail.";
        header("Location: index.php");
        exit;
    }

    // Verifica se o e-mail existe no banco
    $stmt = $conn->prepare("SELECT UsuarioID FROM Usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        $userId = $user['UsuarioID'];
        
        // Gera um token único
        $resetToken = bin2hex(random_bytes(32));
        $tokenExpiration = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token válido por 1 hora

        // Atualiza o banco com o token
        $stmt = $conn->prepare("UPDATE Usuarios SET reset_token = ?, TokenExpiration = ? WHERE UsuarioID = ?");
        $stmt->bind_param("ssi", $resetToken, $tokenExpiration, $userId);
        
        if ($stmt->execute()) {
            // Monta o link de redefinição de senha
            $resetLink = "http://localhost/salao/login/reset.php?token=$resetToken";
            $subject = "Redefinição de Senha";
            $message = "Clique no link para redefinir sua senha: $resetLink\n\nEsse link expira em 1 hora.";
            $headers = "From: no-reply@seusite.com\r\n";
            $headers .= "Reply-To: no-reply@seusite.com\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

            // Envia o e-mail
            if (mail($email, $subject, $message, $headers)) {
                $_SESSION['success_message'] = "E-mail de redefinição enviado! Verifique sua caixa de entrada.";
            } else {
                $_SESSION['error_message'] = "Erro ao enviar e-mail. Tente novamente.";
            }
        } else {
            $_SESSION['error_message'] = "Erro ao salvar token no banco.";
        }
    } else {
        $_SESSION['error_message'] = "E-mail não encontrado.";
    }

    $stmt->close();
    header("Location: index.php");
    exit;
}
?>
