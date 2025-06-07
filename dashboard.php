<?php
// --- INICIO SECCIÓN SIN CAMBIOS ---
require_once './Midware/auth_usuario.php';
require_once 'php/get_posts.php';
// --- FIN SECCIÓN SIN CAMBIOS ---


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link rel="stylesheet" href="css/background.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/iconsreverse.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="icon" type="image/png" href="images/CHATTERBOX.png">

    <style>
        .trivia-card {
            background-color: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 20px auto;
            text-align: center;
            border: 1px solid #e0e0e0;
        }

        .trivia-card h3 {
            margin-top: 0;
            color: #333;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .trivia-question {
            font-size: 1.1rem;
            color: #555;
            min-height: 40px;
        }

        .trivia-buttons {
            margin: 15px 0;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .trivia-btn {
            padding: 10px 25px;
            border: 2px solid;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .trivia-btn:first-of-type {
            border-color: #28a745;
            color: #28a745;
            background-color: #fff;
        }

        .trivia-btn:first-of-type:hover {
            background-color: #28a745;
            color: #fff;
        }

        .trivia-btn:last-of-type {
            border-color: #dc3545;
            color: #dc3545;
            background-color: #fff;
        }

        .trivia-btn:last-of-type:hover {
            background-color: #dc3545;
            color: #fff;
        }

        .trivia-btn:disabled {
            cursor: not-allowed;
            opacity: 0.7;
        }

        .trivia-result {
            margin-top: 15px;
            font-size: 1.2rem;
            font-weight: bold;
            min-height: 25px;
        }

        .trivia-options-grid {
            display: grid;
            grid-template-columns: 1fr 1fr; /* 2 columnas */
            gap: 10px; /* Espacio entre botones */
            margin: 15px 0;
        }

        .option-btn {
            padding: 12px 8px;
            border-radius: 8px;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .option-btn:hover {
            border-color: #007bff;
            background-color: #e9f2ff;
        }

        .option-btn:disabled {
            cursor: not-allowed;
            opacity: 0.7;
        }
    </style>
</head>

<body>

    <iframe src="navbar.php" class="navbar-frame"></iframe>
    <link rel="stylesheet" href="css/navbar.css">

    <button class="create-post-btn">
        <i class="bi bi-plus-lg"></i>
        <span class="create-text">CREAR POST</span>
    </button>
    <div id="overlay" class="overlay"></div>
    <form id="create-post-form" class="create-post-container" enctype="multipart/form-data">
        <div class="form-header">
            <div class="titles">
                <div class="title-login">CREAR POST</div>
            </div>
        </div>
        <div class="post-content">
            <div class="image-preview-container"></div>
            <div class="post-inputs">
                <div class="input-box-big">
                    <textarea class="input-field" id="post-description" name="contenido" required></textarea>
                    <label for="post-description" class="label">Descripción</label>
                </div>
                <input type="file" id="post-image-upload" name="media" class="post-upload" accept="image/*,video/*" hidden>
                <button type="button" class="btn-change-photo" onclick="document.getElementById('post-image-upload').click()">
                    <i class="bi bi-upload"></i> Subir Archivo
                </button>
                <div class="container-navbuttons">
                    <button class="Btn" id="publish-post">
                        <div class="sign"><i class="bi bi-check"></i></div>
                        <div class="text">Publicar</div>
                    </button>
                    <button class="RedBtn" id="cancel-post">
                        <div class="sign"><i class="bi bi-x"></i></div>
                        <div class="text">Cancelar</div>
                    </button>
                </div>
            </div>
        </div>
    </form>

    <div class="trivia-card" style="display: none;">
        <h3><i class="bi bi-patch-question-fill"></i> Trivia del Día</h3>
        <p class="trivia-question">Cargando trivia en español...</p>
        <div class="trivia-options-grid"> 
            </div>
        <p class="trivia-result"></p>
    </div>
    <main class="post-container">
        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $post): ?>
                <div class="post-card">
                    <div class="post-header">
                        <div class="post-author-info">
                            <?php if (!empty($post['imagen_perfil'])): ?>
                                <img src="data:image/jpeg;base64,<?= base64_encode($post['imagen_perfil']) ?>" alt="Foto de perfil" class="author-avatar">
                            <?php else: ?>
                                <img src="images/PorfileP.png" alt="Foto de perfil" class="author-avatar">
                            <?php endif; ?>
                            <span class="author-name"><?= htmlspecialchars($post['nom_usuario']) ?></span>
                        </div>
                        <span class="post-time"><?= date('d M Y, H:i', strtotime($post['fecha'])) ?></span>
                    </div>

                    <div class="post-body">
                        <p><?= htmlspecialchars($post['contenido']) ?></p>
                    </div>

                    <?php if (!empty($post['MultImagen'])): ?>
                        <div class="post-image-container">
                            <?php if ($post['tipo'] === 'video'): ?>
                                <video controls class="post-video">
                                    <source src="data:video/mp4;base64,<?= base64_encode($post['MultImagen']) ?>">
                                    Tu navegador no soporta la etiqueta de video.
                                </video>
                            <?php else: ?>
                                <img src="data:image/jpeg;base64,<?= base64_encode($post['MultImagen']) ?>" alt="Imagen del post" class="post-image">
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="post-footer">
                        <?php
                        $likedClass = $post['user_has_liked'] ? 'liked' : '';
                        $iconClass = $post['user_has_liked'] ? 'bi-heart-fill' : 'bi-heart';
                        ?>
                        <button class="footer-btn like-btn <?= $likedClass ?>" data-post-id="<?= $post['id_Publi'] ?>">
                            <i class="bi <?= $iconClass ?>"></i>
                            <span class="like-count"><?= $post['total_likes'] ?></span>
                        </button>

                        <?php if (!empty($post['MultImagen'])):
                            $dataSrc = ($post['tipo'] === 'video' ? 'data:video/mp4;base64,' : 'data:image/jpeg;base64,') . base64_encode($post['MultImagen']);
                            $downloadFilename = 'Chatterbox-Post.' . ($post['tipo'] === 'video' ? 'mp4' : 'jpg');
                        ?>
                            <a href="<?= htmlspecialchars($dataSrc) ?>" download="<?= htmlspecialchars($downloadFilename) ?>" class="footer-btn">
                                <i class="bi bi-download"></i> Descargar
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">No hay publicaciones para mostrar. ¡Sé el primero en publicar!</p>
        <?php endif; ?>
    </main>

    <script src="js/dashboard.js"></script>

    <script>
document.addEventListener('DOMContentLoaded', () => {
    const triviaCard = document.querySelector('.trivia-card');
    if (!triviaCard) return;

    const questionText = triviaCard.querySelector('.trivia-question');
    const optionsGrid = triviaCard.querySelector('.trivia-options-grid');
    const resultText = triviaCard.querySelector('.trivia-result');
    
    let triviaQuestions = []; 
    let currentTriviaIndex = 0; 
    
    // Nueva URL de la API con idioma español (es) y región México (MX)
    const apiUrl = 'https://the-trivia-api.com/v2/questions?limit=10&region=MX&lang=es';

    /**
     * Pide un nuevo lote de preguntas a la nueva API.
     */
    async function fetchTriviaBatch() {
        triviaCard.style.display = 'block';
        questionText.textContent = 'Cargando trivia en español...';
        optionsGrid.innerHTML = ''; // Limpiar botones viejos
        resultText.textContent = '';

        try {
            const response = await fetch(apiUrl);
            const data = await response.json();

            if (data && data.length > 0) {
                triviaQuestions = data;
                currentTriviaIndex = 0;
                displayCurrentQuestion();
            } else {
                questionText.textContent = 'No se pudo cargar la trivia en español.';
            }
        } catch (error) {
            console.error('Error al cargar la trivia:', error);
            questionText.textContent = 'Error de conexión. Intenta recargar la página.';
        }
    }

    /**
     * Muestra la pregunta actual y sus opciones.
     */
    function displayCurrentQuestion() {
        if (currentTriviaIndex >= triviaQuestions.length) {
            questionText.textContent = '¡Excelente! Cargando más preguntas...';
            fetchTriviaBatch();
            return;
        }

        const currentQuestion = triviaQuestions[currentTriviaIndex];
        
        // El formato de la nueva API es un poco diferente
        questionText.textContent = currentQuestion.question.text;
        
        // Juntar la respuesta correcta y las incorrectas en un solo array
        const allAnswers = [...currentQuestion.incorrectAnswers, currentQuestion.correctAnswer];
        
        // Mezclar las respuestas para que la correcta no aparezca siempre al final
        allAnswers.sort(() => Math.random() - 0.5);

        // Limpiar botones anteriores y crear los nuevos
        optionsGrid.innerHTML = '';
        allAnswers.forEach(answer => {
            const button = document.createElement('button');
            button.className = 'option-btn';
            button.textContent = answer;
            button.addEventListener('click', handleAnswer);
            optionsGrid.appendChild(button);
        });
        
        // Guardar la respuesta correcta en la tarjeta para poder verificarla luego
        triviaCard.dataset.correctAnswer = currentQuestion.correctAnswer;
        resultText.textContent = '';
    }

    /**
     * Maneja la respuesta del usuario para opción múltiple.
     */
    function handleAnswer(event) {
        const userAnswer = event.target.textContent;
        const correctAnswer = triviaCard.dataset.correctAnswer;
        
        // Deshabilitar todos los botones
        document.querySelectorAll('.option-btn').forEach(btn => {
            btn.disabled = true;
            // Opcional: Marcar visualmente la respuesta correcta e incorrecta
            if (btn.textContent === correctAnswer) {
                btn.style.borderColor = '#28a745';
                btn.style.backgroundColor = '#d4edda';
            } else if (btn.textContent === userAnswer) {
                btn.style.borderColor = '#dc3545';
                btn.style.backgroundColor = '#f8d7da';
            }
        });
        
        if (userAnswer === correctAnswer) {
            resultText.textContent = '¡Correcto!';
            resultText.style.color = '#28a745';
        } else {
            resultText.textContent = `Incorrecto. La respuesta era: ${correctAnswer}`;
            resultText.style.color = '#dc3545';
        }

        currentTriviaIndex++;
        setTimeout(displayCurrentQuestion, 2500); // Dar un poco más de tiempo para ver la respuesta
    }

    // --- Iniciar todo ---
    fetchTriviaBatch();
});
</script>


    <footer class="footer">
        <p>&copy; 2024 CHATTERBOX | Todos los derechos reservados.</p>
    </footer>
    <link rel="stylesheet" href="css/footer.css">

</body>

</html>