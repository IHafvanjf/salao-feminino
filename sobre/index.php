<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salão de Beleza</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../footer.css">
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
                        <a class="nav-link" href="#"><i class="bi bi-info-circle"></i> Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../produtos/index.php"><i class="bi bi-bag"></i> Produtos</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Seção Hero com a imagem de fundo -->
    <section class="hero">
        <div class="hero-overlay">
            <h1>Beleza e Sofisticação <br> em Cada Atendimento</h1>
            <p>Descubra a excelência em serviços de beleza em um espaço exclusivo.</p>
        </div>
    </section>

    <!-- cards do sobre -->
    <div class="about-cards">
        <div class="about-card">
            <img src="../img/imagemquemsomos.png" alt="Sobre o Salão">
            <div class="about-text">
                <h2>Quem Somos</h2>
                <p>Somos um salão de beleza dedicado ao público feminino, oferecendo um ambiente acolhedor e sofisticado. Priorizamos a qualidade dos serviços, utilizando produtos de alta performance para garantir os melhores resultados. Nosso objetivo é realçar a beleza e elevar a autoestima de cada cliente, proporcionando momentos de cuidado e bem-estar.</p>
            </div>
        </div>

        <!-- Segundo card (Imagem à direita, Texto à esquerda) -->
        <div class="about-card reverse">
            <div class="about-text">
                <h2>Nossa Equipe</h2>
                <p>Nossa equipe é formada por profissionais experientes e dedicados, especializados em diversas áreas da beleza. Oferecemos um atendimento personalizado, sempre alinhado às tendências e técnicas mais recentes. Nosso compromisso é proporcionar uma experiência única, garantindo qualidade e satisfação em cada serviço.</p>
            </div>
            <img id="imgCard2" src="../img/imgCard2.jpg" alt="Sobre o Salão">
        </div>
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
    
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
