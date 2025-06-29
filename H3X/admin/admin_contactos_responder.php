<?php
session_start();

if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    header("location:login.php");
    exit();
}

require_once "../db_config.php";
require_once 'ultima_atividade.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: admin_contactos.php");
    exit();
}

$sql = "SELECT * FROM contactos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: admin_contactos.php");
    exit();
}

$contacto = $result->fetch_object();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mensagem_resposta = $_POST["resposta"] ?? '';
    $email_destinatario = $_POST["email"] ?? $contacto->email; 
    $assunto = "Resposta à sua mensagem - H3X";

    $headers = "From: suporte@h3x.pt\r\n";
    $headers .= "Reply-To: suporte@h3x.pt\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $body = "<p>Olá <strong>" . htmlspecialchars($contacto->nome ?? '') . "</strong>,</p>";
    $body .= "<p>" . nl2br(htmlspecialchars($mensagem_resposta)) . "</p>";
    $body .= "<hr><p>Atenciosamente,<br>Equipa H3X</p>";

    if (mail($email_destinatario, $assunto, $body, $headers)) {
        $_SESSION["success"] = "Resposta enviada com sucesso para {$email_destinatario}.";
    } else {
        $_SESSION["error"] = "Erro ao enviar o email para {$email_destinatario}.";
    }

    header("Location: admin_contactos.php");
    exit();
}

require 'partials/header.php';
?>

<div class="d-flex">
    <?php require 'partials/sidebar.php'; ?>

    <div class="content">
        <h2 class="mb-4">Responder a mensagem criada pelo contacto</h2>
        <form method="POST">
            <div class="d-flex gap-4">
                <div class="bg-white shadow p-4 rounded" style="flex: 1">
                    <p><strong>ID</strong><br><?= $contacto->id ?></p>
                    <p><strong>Nome</strong><br><?= htmlspecialchars($contacto->nome ?? '') ?></p>
                    <p><strong>Assunto</strong><br><?= htmlspecialchars($contacto->assunto ?? '') ?></p>
                    <p><strong>Email</strong><br><?= htmlspecialchars($contacto->email ?? '') ?></p>
                    <p><strong>Telefone</strong><br><?= htmlspecialchars($contacto->telefone ?? '') ?></p>
                    <p><strong>Mensagem</strong><br><?= nl2br(htmlspecialchars($contacto->mensagem ?? '')) ?></p>
                </div>

                <div class="bg-white shadow p-4 rounded" style="flex: 1">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email do destinatário</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($contacto->email ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="resposta" class="form-label">Resposta</label>
                        <textarea name="resposta" class="form-control" rows="12" placeholder="Escreve a tua resposta aqui..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-dark float-end">ENVIAR</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require 'partials/footer.php'; ?>
