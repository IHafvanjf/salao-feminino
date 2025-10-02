<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salão de Beleza</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="../footer.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

</head>

<body>
   <!-- Navbar -->
   <nav class="navbar navbar-expand-md">
        <div class="container">
            <!-- Logo centralizada -->
            <a class="navbar-brand mx-auto" href="#">Salão de Beleza</a>

            <!-- Botão hambúrguer para mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Itens da navbar -->
            <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                <ul class="navbar-nav text-center">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php"><i class="bi bi-house-door"></i> Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../agendamento/index.php"><i class="bi bi-calendar-check"></i> Agendar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../sobre/index.php"><i class="bi bi-info-circle"></i> Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../produtos/index.php"><i class="bi bi-bag"></i> Produtos</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <section class="inputPesquisa">
        <!-- inicio pesquisa -->
        <div class="group">
            <svg viewBox="0 0 24 24" aria-hidden="true" class="search-icon">
            <g>
                <path
                d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"
                ></path>
            </g>
            </svg>
        
            <input
            id="query"
            class="input"
            type="search"
            placeholder="Produto..."
            name="searchbar"
            />
        </div>
        <!-- fim pesquisa -->
    </section>
    
    <section class="catalogo">
        <div class="product-card">
            <img src="../img/imgPrd1.png" alt="img do Produto" class="product-image">
            <div class="product-content">
                <h3 class="product-title"> Máscara de Tratamento</h3>
                <p class="product-description">Hidratação profunda e restauração dos fios.</p>
                <button class="product-button">Adicionar ao carrinho</button>
            </div>
        </div>

        <div class="product-card">
            <img src="../img/imgPrd2.png" alt="img do Produto" class="product-image">
            <div class="product-content">
                <h3 class="product-title">Spray Fixador</h3>
                <p class="product-description">Finalização e fixação duradoura para penteados.</p>
                <button class="product-button">Adicionar ao carrinho</button>
            </div>
        </div>

        <div class="product-card">
            <img src="../img/imgPrd3.png" alt="img do Produto" class="product-image">
            <div class="product-content">
                <h3 class="product-title">Shampoo</h3>
                <p class="product-description">Shampoo para reparação e brilho intenso.</p>
                <button class="product-button">Adicionar ao carrinho</button>
            </div>
        </div>

        <div class="product-card">
            <img src="../img/imgPrd4.png" alt="img do Produto" class="product-image">
            <div class="product-content">
                <h3 class="product-title">Lip Gloss</h3>
                <p class="product-description">Brilho labial hidratante</p>
                <button class="product-button">Adicionar ao carrinho</button>
            </div>
        </div>

        <div class="product-card">
            <img src="../img/imgPrd5.png" alt="img do Produto" class="product-image">
            <div class="product-content">
                <h3 class="product-title">Óleo Capilar</h3>
                <p class="product-description">Nutrição e fortalecimento dos fios.</p>
                <button class="product-button">Adicionar ao carrinho</button>
            </div>
        </div>

        <div class="product-card">
            <img src="../img/imgPrd6.png" alt="img do Produto" class="product-image">
            <div class="product-content">
                <h3 class="product-title"> Shampoo</h3>
                <p class="product-description">Controle do frizz e suavidade para os cabelos.</p>
                <button class="product-button">Adicionar ao carrinho</button>
            </div>
        </div>

        <div class="product-card">
            <img src="../img/imgPrd7.png" alt="img do Produto" class="product-image">
            <div class="product-content">
                <h3 class="product-title">Esmalte Holográfico</h3>
                <p class="product-description">Brilho intenso e efeito cromado nas unhas.</p>
                <button class="product-button">Adicionar ao carrinho</button>
            </div>
        </div>

        <div class="product-card">
            <img src="../img/imgPrd8.png" alt="img do Produto" class="product-image">
            <div class="product-content">
                <h3 class="product-title">Base Fortalecedora</h3>
                <p class="product-description">Proteção e fortalecimento para unhas saudáveis.</p>
                <button class="product-button">Adicionar ao carrinho</button>
            </div>
        </div>

        <div class="product-card">
            <img src="../img/imgPrd9.png" alt="img do Produto" class="product-image">
            <div class="product-content">
                <h3 class="product-title">Kit de Pincéis</h3>
                <p class="product-description">Pincéis para maquiagem completa.</p>
                <button class="product-button">Adicionar ao carrinho</button>
            </div>
        </div>

        <div class="product-card">
            <img src="../img/imgPrd10.png" alt="img do Produto" class="product-image">
            <div class="product-content">
                <h3 class="product-title">Sérum Effect Gold</h3>
                <p class="product-description">Iluminação e hidratação para a pele.</p>
                <button class="product-button">Adicionar ao carrinho</button>
            </div>
        </div>

        <div class="product-card">
            <img src="../img/imgPrd11.png" alt="img do Produto" class="product-image">
            <div class="product-content">
                <h3 class="product-title">Victoria’s Secret Love Spell</h3>
                <p class="product-description">Loção hidratante com fragrância irresistível.</p>
                <button class="product-button">Adicionar ao carrinho</button>
            </div>
        </div>

        <div class="product-card">
            <img src="../img/imgPrd12.png" alt="img do Produto" class="product-image">
            <div class="product-content">
                <h3 class="product-title">Renova Sérum Facial</h3>
                <p class="product-description">Hidratação e ação antienvelhecimento para a pele.</p>
                <button class="product-button">Adicionar ao carrinho</button>
            </div>
        </div>
    </section>

    <!-- Ícone do Carrinho -->
    <div id="cart-icon-container">
        <img id="cart-icon" src="../img/carrinho.png" alt="Carrinho de Compras">
    </div>

    <!-- Carrinho de Compras -->
    <div id="cart-container" class="hidden">
        <h3><i class="bi bi-cart"></i> Carrinho</h3>
        <ul id="cart-items"></ul>
        <button id="checkout-button">Finalizar</button>
    </div>
    <footer class="footer-section">
        <div class="container">
            <div class="footer-cta pt-5 pb-5">
                <div class="row">
                    <div class="col-xl-4 col-md-4 mb-30">
                        <div class="single-cta">
                            <i class="fas fa-map-marker-alt"></i>
                            <div class="cta-text">
                                <h4>Encontre-nos</h4>
                                <span>Belo Horizonte - MG</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4 mb-30">
                        <div class="single-cta">
                            <i class="fas fa-phone"></i>
                            <div class="cta-text">
                                <h4>Telefone</h4>
                                <span>3199794-1735</span><br>
                                <span>3198730-5141</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4 mb-30">
                        <div class="single-cta">
                            <i class="far fa-envelope-open"></i>
                            <div class="cta-text">
                                <h4>Email</h4>
                                <span>techinnova01@gmail.com</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-content pt-5 pb-5">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 mb-50">
                        <div class="footer-widget">
                            <div class="footer-logo">
                                <a><img src="../img/logoAlltech.png" class="img-fluid" alt="logo"></a>
                            </div>
                            <div class="footer-text">
                                <p>A AllTech é a revolução digital que sua empresa precisa! Especialistas em desenvolvimento de sites e aplicações web, transformamos ideias em experiências digitais envolventes, escaláveis e de alto desempenho. Seja para fortalecer sua presença online, aumentar suas conversões ou oferecer uma experiência digital impecável, criamos soluções sob medida para o seu negócio.</p>  
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                    <div class="footer-widget">
                        <div class="footer-widget-heading">
                            <h3>Serviços</h3>
                        </div>
                        <ul>
                            <li><a href="#">Desenvolvimento de Sites</a></li>
                            <li><a href="#">Aplicações Web</a></li>
                            <li><a href="#">E-commerce</a></li>
                            <li><a href="#">Otimização de SEO</a></li>
                            <li><a href="#">Manutenção e Suporte</a></li>
                            <li><a href="#">Integração de APIs</a></li>
                            <li><a href="#">Sistemas Personalizados</a></li>
                            <li><a href="#">UX/UI Design</a></li>
                        </ul>
                    </div>                 
                </div>


                <div class="col-xl-4 col-lg-4 col-md-6 mb-50">
                <div class="footer-widget">
                    <div class="footer-widget-heading">
                        <h3>Fale Conosco</h3>
                            </div>
                            <div class="footer-text mb-25">
                                <p>Precisa de um orçamento ou tem alguma dúvida? Fale conosco agora pelo WhatsApp!</p>
                            </div>
                            <div class="whatsapp-btn">
                                <a href="https://wa.me/31997941735" target="_blank">
                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="copyright-area">
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 text-center text-lg-left">
                                    <div class="copyright-text">
                                        <p>Copyright &copy; 2025, Todos os direitos reservados, AllTech</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </footer>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
