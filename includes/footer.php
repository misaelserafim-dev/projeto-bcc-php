<?php include_once 'footer-data.php'; ?>
<footer>
    <div class="content-footer container">
        <div class="grid-tens">
            <h2>Contato</h2>
            <div class="flex-item-menu">
                <nav class="col-span-1" aria-label="Menu rodapé principal">
                    <h3>Menu</h3>
                    <ul>
                        <?php echo render_footer_menu($footer_menu); ?>
                    </ul>
                </nav>
                <nav class="col-span-1" aria-label="links rodapé">
                    <h3>Links</h3>
                    <ul>
                        <?php echo render_footer_links($footer_links); ?>
                    </ul>
                </nav>
            </div>   
        </div>

        <div class="grid-full">
            <address>
                <a href="mailto:<?php echo $footer_contact['email']; ?>" class="icon-left" rel="noopener noreferrer">
                    <?php echo $footer_contact['email']; ?>
                </a> 
            </address>
            <div class="footer-social-links">
                <div class="limit-card-infos">
                    <div>
                        <a href="<?php echo $footer_contact['instagram']; ?>" target="_blank">
                            <img src="assets/instagram-white.png" alt="ícone da rede social instagram">
                        </a>
                        <a href="mailto:<?php echo $footer_contact['email']; ?>">
                            <img src="assets/mail-white.png" alt="ícone do e-mail" aria-hidden="true">
                        </a>
                    </div>
                    <a href="/">
                        <img src="images/logo-white.svg" alt="Logotipo da Brasil Center Comunicações" />
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="crypt">
        <div class="container">
            <p>BrasilCenter © <?php echo get_current_year(); ?> - Todos os direitos reservados</p>
        </div>
    </div>
</footer>

<!-- script do HandTalk -->
<script src="https://plugin.handtalk.me/web/latest/handtalk.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  setTimeout(function() {
    var ht = new HT({
      avatar: "MAYA",
      token: "" // token aqui
    });
  }, 500);
});
</script>