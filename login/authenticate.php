<?php
include 'config.php';

function registerUser($email, $password, $name) {
    global $conn;
    session_start();

    // Verifica se os campos estão preenchidos
    if (empty($email) || empty($password) || empty($name)) {
        $_SESSION['register_error_message'] = "Todos os campos são obrigatórios.";
        header("Location: index.php");
        exit;
    }

    // Verifica se o email já está cadastrado
    $stmt = $conn->prepare("SELECT * FROM Usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['register_error_message'] = "Usuário já cadastrado com este email.";
        $stmt->close();
        header("Location: index.php");
        exit;
    }
    $stmt->close();

    // Criptografia da senha
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insere o usuário no banco
    $stmt = $conn->prepare("INSERT INTO Usuarios (email, password, nome) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $hashedPassword, $name);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Cadastro realizado com sucesso! Faça login.";
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['register_error_message'] = "Erro ao cadastrar usuário.";
    }

    $stmt->close();
    header("Location: index.php");
    exit;
}




function loginUser($email, $password) {
    global $conn;
    session_start();

    $stmt = $conn->prepare("SELECT * FROM Usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['UsuarioID'];
            $_SESSION['nome'] = $user['nome']; // Pegando nome corretamente

            header("Location: ../agendamento/index.php");
            exit;
        } else {
            $_SESSION['error_message'] = "Senha incorreta.";
        }
    } else {
        $_SESSION['error_message'] = "Usuário não encontrado.";
    }

    header("Location: index.php"); // Redireciona para exibir a mensagem
    exit;
}



function checkRememberMe() {
    global $conn;

    if (isset($_COOKIE['user_token'])) {
        $token = $_COOKIE['user_token'];

        // Verifica o token no banco de dados
        $stmt = $conn->prepare("SELECT * FROM Usuarios WHERE Token = ? AND TokenExpiration > NOW()");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            // Autentica o usuário
            session_start();
            $_SESSION['user_id'] = $user['UsuarioID'];
            $_SESSION['nome'] = $user['email'];

            // Atualiza a validade do token para mais 1 ano
            $newExpiration = date('Y-m-d H:i:s', strtotime('+1 year'));
            $stmt = $conn->prepare("UPDATE Usuarios SET TokenExpiration = ? WHERE UsuarioID = ?");
            $stmt->bind_param("si", $newExpiration, $user['UsuarioID']);
            $stmt->execute();

            // Atualiza o cookie
            setcookie("user_token", $token, time() + (365 * 24 * 60 * 60), "/", "", false, true);

            header("Location: ../Agendamento/index.php");
            exit;
        }
    }
}


?>
