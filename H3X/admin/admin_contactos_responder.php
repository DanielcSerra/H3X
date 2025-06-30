<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
session_start();

if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    header("location:login.php");
    exit();
}



$nomeUtilizador = $_SESSION["nome"] ?? "Utilizador";
$tipoUtilizador = $_SESSION["tipo"] ?? "c";

$tipoLabel = match ($tipoUtilizador) {
    'a' => "Administrador",
    'f' => "Funcionário",
    default => "Cliente",
};

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



    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';

    $mail = new PHPMailer(true);

    try {
       
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->Username = '9b6804a0c30337';
        $mail->Password = 'a9cc02c19a0184';
        $mail->CharSet = "UTF-8";
        $mensagem_resposta = $_POST["resposta"] ?? '';
        //Recipients
        $mail->setFrom('from@example.com', 'Mailer');
        $mail->addAddress($_POST["email"] ?? $contacto->email , $contacto->nome );     //Add a recipient
        $mail->addReplyTo('admin@h3x.pt', 'Admin');
       
       //Content
        $mail->Subject = 'Resposta à sua mensagem - H3X';
        $mail->IsHTML(true);  
        $body = "<p>Olá <strong>" . ($contacto->nome ?? '') . "</strong>,</p>";
        $body .= "<p>" . nl2br($mensagem_resposta) . "</p>";
        $body .= "<hr><p>Atenciosamente,<br>Equipa H3X</p>";
        
        $mail->Body    = $body;

        $mail->send();
    
        $_SESSION["success"] = "Resposta enviada com sucesso para {$email_destinatario}.";
    
    } catch (Exception $e) {
    
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
