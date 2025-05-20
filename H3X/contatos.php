<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactos</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <style>
        :root {
            --dark-bg: #1a1a1a;
            --darker-bg: #121212;
            --lighter-bg: #2a2a2a;
            --primary-color: #6c5ce7;
            --secondary-color: #a29bfe;
            --text-color: #f0f0f0;
            --text-muted: #bbbbbb;
            --road-color: #a0a0a0;
        }
        
        body {
            background-color: var(--dark-bg);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        /* Banner Superior */
        .top-banner {
            background: linear-gradient(135deg, var(--darker-bg) 0%, var(--primary-color) 100%);
            padding: 30px 0;
            margin-bottom: 40px;
            border-bottom: 4px solid var(--secondary-color);
        }
        
        .banner-title {
            font-size: 2.8rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 3px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        .hidden-text {
            opacity: 0;
            height: 0;
            overflow: hidden;
        }
        
        /* Layout Principal */
        .main-container {
            background-color: var(--lighter-bg);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        }
        
        .info-column {
            background-color: var(--darker-bg);
            padding: 40px;
        }
        
        .form-column {
            background-color: var(--lighter-bg);
            padding: 40px;
        }
        
        .section-title {
            color: var(--secondary-color);
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
            margin-bottom: 25px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .contact-icon {
            font-size: 1.5rem;
            margin-right: 10px;
            color: var(--secondary-color);
        }
        
        .info-card {
            background-color: rgba(26, 26, 26, 0.7);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            border-left: 4px solid var(--primary-color);
            transition: transform 0.3s;
        }
        
        .info-card:hover {
            transform: translateY(-5px);
            background-color: rgba(26, 26, 26, 0.9);
        }
        
        .info-title {
            color: var(--secondary-color);
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        /* Estilização do Formulário */
        .form-control {
            background-color: #333;
            border: 1px solid #444;
            color: var(--text-color);
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 20px;
        }
        
        .form-control:focus {
            background-color: #3a3a3a;
            color: white;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(108, 92, 231, 0.25);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 8px;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: #5d4acf;
            border-color: #5d4acf;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.4);
        }
        
        /* Estilização do Mapa */
        #map {
            height: 350px;
            width: 100%;
            border-radius: 10px;
            border: 2px solid #444;
            margin-top: 20px;
        }
        
        /* Estilo personalizado para o mapa */
        .leaflet-container {
            background-color: #2a2a2a !important;
        }
        
        .leaflet-tile {
            filter: brightness(0.7) contrast(0.9) saturate(0.7) !important;
        }
        
        .leaflet-tile-pane {
            filter: hue-rotate(180deg) invert(1) !important;
        }
        
        /* Cor específica para estradas */
        .leaflet-tile-container img[src*="highway"] {
            filter: brightness(1.5) contrast(1.2) saturate(0) !important;
        }
        
        .leaflet-control {
            background-color: rgba(40, 40, 40, 0.9) !important;
            color: var(--text-color) !important;
        }
        
        .leaflet-popup-content {
            color: #333 !important;
        }
        
        /* FAQ Section */
        .faq-section {
            background-color: var(--darker-bg);
            border-radius: 15px;
            padding: 40px;
            margin-top: 40px;
        }
        
        .accordion-button {
            background-color: #2a2a2a;
            color: var(--text-color);
            font-weight: 600;
        }
        
        .accordion-button:not(.collapsed) {
            background-color: #333;
            color: var(--secondary-color);
        }
        
        .accordion-body {
            background-color: #252525;
        }
        
        .focus-badge {
            background-color: var(--primary-color);
            color: white;
            padding: 10px 25px;
            border-radius: 30px;
            display: inline-block;
            margin-top: 40px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.4);
        }
        
        @media (max-width: 992px) {
            .info-column, .form-column {
                padding: 30px;
            }
            
            .banner-title {
                font-size: 2.2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Banner Superior -->
    <div class="top-banner">
        <div class="container text-center">
            <h1 class="banner-title">CONTACTOS</h1>
            <div class="hidden-text"># NOTHIN TO SEE HERE.</div>
        </div>
    </div>
    
    <div class="container mb-5">
        <!-- Layout Principal -->
        <div class="main-container row g-0">
            <!-- Coluna de Informações (Esquerda) -->
            <div class="col-lg-6 info-column">
                <h2 class="section-title"><i class="bi bi-info-circle-fill contact-icon"></i>Informações</h2>
                
                <div class="info-card">
                    <h4 class="info-title"><i class="bi bi-clock-fill"></i> Horário</h4>
                    <p class="mb-2"><strong>Segunda a Quinta:</strong> 18:00 - 02:00</p>
                    <p class="mb-2"><strong>Sexta e Sábado:</strong> 18:00 - 04:00</p>
                    <p><strong>Domingo:</strong> 16:00 - 00:00</p>
                    <p class="small text-muted mt-3">* Horários especiais em eventos</p>
                </div>
                
                <div class="info-card">
                    <h4 class="info-title"><i class="bi bi-geo-alt-fill"></i> Localização</h4>
                    <p class="mb-2"><i class="bi bi-building"></i> Av. Brasília 66, 1201-481 Lisboa</p>
                    <p class="mb-2"><i class="bi bi-phone-fill"></i> 888 888 888 887</p>
                    <p><i class="bi bi-envelope-fill"></i> h3onghtab@gmail.com</p>
                    <p class="small text-muted mt-3">SG-2-000-04</p>
                </div>
                
                <div class="info-card">
                    <h4 class="info-title"><i class="bi bi-music-note-list"></i> Música</h4>
                    <p class="mb-2">Electrónica • Hip-Hop • R&B</p>
                    <p class="mb-2">DJs residentes e convidados especiais</p>
                    <p>Eventos temáticos semanais</p>
                </div>
                
                <!-- Mapa -->
                <h4 class="mt-4"><i class="bi bi-map-fill contact-icon"></i> Mapa</h4>
                <div id="map"></div>
            </div>
            
            <!-- Coluna do Formulário (Direita) -->
            <div class="col-lg-6 form-column">
                <h2 class="section-title"><i class="bi bi-envelope-paper-fill contact-icon"></i>Contacte-nos</h2>
                
                <form>
                    <div class="mb-4">
                        <label for="name" class="form-label mb-2">Nome Completo</label>
                        <input type="text" class="form-control" id="name" placeholder="Introduza o seu nome" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="email" class="form-label mb-2">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="seu@email.com" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="phone" class="form-label mb-2">Telefone (Opcional)</label>
                        <input type="tel" class="form-control" id="phone" placeholder="+351 ...">
                    </div>
                    
                    <div class="mb-4">
                        <label for="subject" class="form-label mb-2">Assunto</label>
                        <select class="form-select" id="subject" required>
                            <option value="" selected disabled>Selecione um assunto</option>
                            <option value="reserva">Reserva/Mesa</option>
                            <option value="evento">Informação de Evento</option>
                            <option value="dj">Atuação/DJ Set</option>
                            <option value="outro">Outro</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="message" class="form-label mb-2">Mensagem</label>
                        <textarea class="form-control" id="message" rows="5" placeholder="Escreva aqui a sua mensagem..." required></textarea>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send-fill me-2"></i> Enviar Mensagem
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- FAQ Section -->
        <div class="faq-section mt-5">
            <h2 class="section-title text-center mb-5"><i class="bi bi-question-circle-fill contact-icon"></i>Perguntas Frequentes</h2>
            
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item border-secondary mb-3">
                    <h3 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            Qual é o horário de funcionamento do HSX?
                        </button>
                    </h3>
                    <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            O HSX está aberto ao quadro para a cidade, das cinco ou cinco. Em épocas especiais ou eventos fundiáveis, chega no plano de máquina.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item border-secondary mb-3">
                    <h3 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            Preciso de comprar bilhete para entrar?
                        </button>
                    </h3>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            A entrada é gratuita até às 23h. Após esta hora, aplica-se uma taxa de entrada que inclui uma bebida.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item border-secondary mb-3">
                    <h3 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                            Qual é a idade mínima para entrar?
                        </button>
                    </h3>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            A idade mínima para entrada é de 18 anos. É necessário apresentar documento de identificação válido.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item border-secondary">
                    <h3 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                            Qual é o tipo de música que tocam?
                        </button>
                    </h3>
                    <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Tocamos principalmente música eletrónica, hip-hop e R&B, com DJs residentes e convidados especiais. Consulte a nossa agenda para eventos temáticos.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5">
            <span class="focus-badge">[FOCUS]</span>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Inicialização do Mapa
        const map = L.map('map').setView([38.71796, -9.09766], 16);
        
        // Camada base do mapa com estradas mais claras
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            className: 'map-tiles'
        }).addTo(map);
        
        // Adiciona marcador customizado
        const marker = L.marker([38.71796, -9.09766], {
            icon: L.divIcon({
                className: 'custom-marker',
                html: '<i class="bi bi-geo-alt-fill" style="font-size: 2rem; color: #6c5ce7; text-shadow: 0 0 8px rgba(0,0,0,0.7);"></i>',
                iconSize: [30, 30],
                iconAnchor: [15, 30]
            })
        }).addTo(map).bindPopup('<b>HSX</b><br>Av. Brasília 66, Lisboa');
        
        // Adiciona círculo de área
        L.circle([38.71796, -9.09766], {
            color: '#6c5ce7',
            fillColor: '#6c5ce7',
            fillOpacity: 0.15,
            radius: 100
        }).addTo(map);
        
        // Aplica filtros específicos para estradas após o carregamento do mapa
        setTimeout(() => {
            document.querySelectorAll('.leaflet-tile').forEach(tile => {
                if (tile.src.includes('openstreetmap')) {
                    tile.style.filter = 'brightness(0.7) contrast(0.9) saturate(0.7)';
                }
            });
        }, 1000);
    </script>
</body>
</html>