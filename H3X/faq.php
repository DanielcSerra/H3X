<?php
session_start();
?>
<?php include 'partials/head.php'; ?>
<title>H3X - Pagina</title>
<link rel="stylesheet" href="css/faq.css">
</head>

<body>
    <?php include 'partials/navbar.php'; ?>
    <div class="contain">
        <section class="faq-container">
            <div class="faq-header">FAQ</div>

            <?php
            require_once 'db_config.php';
            require_once "admin/ultima_atividade.php";

            $sql = "SELECT * FROM faq ORDER BY id";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                $first = true;
                $count = 0;
                $total = $result->num_rows;

                while ($faq = $result->fetch_assoc()) {
                    echo '<div class="faq-item' . ($first ? ' active' : '') . '">';
                    echo '<div class="faq-question">' . htmlspecialchars($faq['titulo']) . '</div>';
                    echo '<div class="faq-answer">' . htmlspecialchars($faq['resposta']) . '</div>';
                    echo '</div>';

                    $count++;
                    if ($count < $total) {
                        echo '<div class="faq-divider"></div>';
                    }

                    $first = false;
                }

                echo '<div class="faq-spacer"></div>';
            } else {
                echo '<div class="faq-item">';
                echo '<div class="faq-question">FAQ vazio</div>';
                echo '<div class="faq-answer">Nenhuma pergunta frequente encontrada.</div>';
                echo '</div>';
            }

            $conn->close();
            ?>
        </section>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const faqItems = document.querySelectorAll('.faq-item');

            faqItems.forEach(item => {
                item.addEventListener('click', function () {
                    this.classList.toggle('active');
                    faqItems.forEach(otherItem => {
                        if (otherItem !== this) {
                            otherItem.classList.remove('active');
                        }
                    });
                });
            });

            if (faqItems.length > 0) {
                faqItems[0].classList.add('active');
            }
        });
    </script>
    <?php include 'partials/footer.php'; ?>
</body>

</html>