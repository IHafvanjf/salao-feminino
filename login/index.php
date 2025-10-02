<?php
include 'authenticate.php';
session_start();

$errorMessage = $registerErrorMessage = $successMessage = '';
$showRegister = false; // Define se deve mostrar a aba de cadastro

// Captura mensagens de erro da sessão (se existirem)
if (isset($_SESSION['error_message'])) {
    $errorMessage = $_SESSION['error_message'];
    unset($_SESSION['error_message']); // Remove a mensagem após exibir
}

if (isset($_SESSION['register_error_message'])) {
    $registerErrorMessage = $_SESSION['register_error_message'];
    unset($_SESSION['register_error_message']);
    $showRegister = true; // Indica que deve mostrar a aba de cadastro
}

if (isset($_GET['success']) && $_GET['success'] == 1) {
    $successMessage = 'Sua senha foi redefinida com sucesso!';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register'])) {
        registerUser($_POST['email'], $_POST['password'], $_POST['name']);
    } elseif (isset($_POST['login'])) {
        loginUser($_POST['email'], $_POST['password']);
    }
}

if (isset($_SESSION['success_message'])) {
    echo "<div class='alert success'>" . $_SESSION['success_message'] . "</div>";
    unset($_SESSION['success_message']); // Remove após exibir
}

if (isset($_SESSION['error_message'])) {
    echo "<div class='alert error'>" . $_SESSION['error_message'] . "</div>";
    unset($_SESSION['error_message']); // Remove após exibir
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <form class="form login-form  <?php echo !$showRegister ? 'active' : ''; ?>" action="index.php" method="post">
    <?php if (!empty($errorMessage)) : ?>
        <div class="alert error" style="color: red; text-align: center;"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

    <?php if (!empty($registerErrorMessage)) : ?>
        <div class="alert error" style="color: red; text-align: center;"><?php echo $registerErrorMessage; ?></div>
    <?php endif; ?>

    <?php if (!empty($successMessage)) : ?>
        <div class="alert success" style="color: green; text-align: center;"><?php echo $successMessage; ?></div>
    <?php endif; ?>

    <!-- entrar -->
        <p class="form-title">Entrar na sua conta</p>
        <div class="input-container">
            <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="input-container">
            <input type="password" name="password" placeholder="Senha" required>
        </div>
        <button type="submit" name="login" class="submit">Entrar</button>

        <p class="signup-link">
            Não tem conta?
            <a href="#" class="go-to-signup">Criar conta</a>
        </p>
        <p class="signup-link">
            <a href="#" class="go-to-forgot-password">Esqueci minha senha</a>
        </p>
    </form>

    <!-- criar conta -->
    <form class="form signup-form <?php echo $showRegister ? 'active' : ''; ?>" action="index.php" method="post">
        <p class="form-title">Criar sua conta</p>
        <div class="input-container">
            <input type="text" name="name" placeholder="Nome" required>
        </div>
        <div class="input-container">
            <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="input-container">
            <input type="password" name="password" placeholder="Senha" required>
        </div>
        <div class="input-container">
            <input type="password" name="confirm_password" placeholder="Confirme sua senha" required>
        </div>
        <button type="submit" name="register" class="submit">Criar Conta</button>

        <p class="signup-link">
            Já tem uma conta?
            <a href="#" class="go-to-login">Entrar</a>
        </p>
    </form>

    <!-- Esqueci minha senha -->
<form class="form forgot-password-form" action="reset_password.php" method="post">
    <p class="form-title">Recuperar sua senha</p>
    <div class="input-container">
        <input type="email" name="email" placeholder="Digite seu email" required>
    </div>
    <button type="submit" class="submit">Enviar link de recuperação</button>

    <p class="signup-link">
        Lembrou sua senha?
        <a href="#" class="go-to-login">Entrar</a>
    </p>
</form>


    <!-- nova senha -->
    <form class="form new-password-form" action="update_password.php" method="post">
        <p class="form-title">Definir nova senha</p>
        <div class="input-container">
            <input type="password" name="new_password" placeholder="Nova senha" required>
        </div>
        <div class="input-container">
            <input type="password" name="confirm_new_password" placeholder="Confirmar nova senha" required>
        </div>
        <button type="submit" class="submit">Atualizar senha</button>

        <p class="signup-link">
            Lembrou sua senha?
            <a href="#" class="go-to-login">Entrar</a>
        </p>
    </form>

    <script src="script.js"></script>
</body>
</html>
