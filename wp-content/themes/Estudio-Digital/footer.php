<footer>
  <div class="footer">
    <div class="main-footer">
      <div class="main-footer__content padding-rl">
        <div class="content-footer__text">
          <div class="subtitle-footer">
            <img src="<?php echo get_template_directory_uri();?>/assets/img/logo-estudio.png" alt=""><p>Estudio Digital</p>
          </div>
          <div class="content-footer__text--text">
            <p>Desde el año 2008 aportamos presencia efectiva en internet a empresas de diferentes sectores y tamaños, hemos crecido con la sociedad, los avances tecnológicos y los constantes cambios y retos del marketing digital.</p>
          </div>
        </div>
        <div class="content-footer__direc">
          <div class="subtitle-footer">
            <img src="<?php echo get_template_directory_uri();?>/assets/img/Unión 1.png" alt=""><p>dirección</p>
          </div>
          <div class="content-footer__direc--text">
            <a target="_blank" href="https://goo.gl/maps/QthBvW4op38peere9">
              Cra 81a 37d 25 int 501
              <br>
              Medellín, Colombia
            </a>
            <a target="_blank" href="tel:5745899320">Tel +574-5899320</a>
            <?php if ( wp_is_mobile() ) : ?>
              <a target="_blank" href="https://api.whatsapp.com/send?phone=573002976970">Mobil +57 300 2976970</a>
            <?php else : ?>
              <a target="_blank" href="https://web.whatsapp.com/send?phone=573002976970">Mobil +57 300 2976970</a>
            <?php endif; ?>
              
            <a target="_blank" href="mailto:marketing@sigmasoft.co">marketing@sigmasoft.co</a>
          </div>
        </div>
        <div class="content-footer__redes">
          <div class="subtitle-footer">
            <p>nuetras redes sociales</p>
          </div>
          <div class="content-footer__redes--content">
             <a target="_blank" href="https://www.facebook.com/estudiodigital.co/">
                <i class="fa fa-facebook" aria-hidden="true"></i>
              </a>
              <a target="_blank" href="https://www.instagram.com/estudiodigital.co/">
                <i class="fa fa-instagram" aria-hidden="true"></i>
              </a>
              <a target="_blank" href="">
                <i class="fa fa-linkedin" aria-hidden="true"></i>
              </a>
              <a target="_blank" href="https://www.youtube.com/channel/UCo3zvcAHbe2vQbIaws9t5AA/">
                <i class="fa fa-youtube-play" aria-hidden="true"></i>
              </a>
              <a target="_blank" href="https://twitter.com/GrupoEDigital">
                <i class="fa fa-twitter" aria-hidden="true"></i>
              </a>
              <?php if ( wp_is_mobile() ) : ?>
                <a target="_blank" href="https://api.whatsapp.com/send?phone=573002976970">
                  <i class="fa fa-whatsapp" aria-hidden="true"></i>
                </a>
              <?php else : ?>
                <a target="_blank" href="https://web.whatsapp.com/send?phone=573002976970">
                  <i class="fa fa-whatsapp" aria-hidden="true"></i>
                </a>
              <?php endif; ?>
              
              <a target="_blank" href="mailto:marketing@sigmasoft.co">
                <i class="fa fa-envelope-o" aria-hidden="true"></i>
              </a>   
          </div>
        </div>
      </div>
    </div>
    <div class="pie-footer">
        <p> © Copyright 2020 Estudio Digital<a href="#"></a></p>
      </div>
  </div>
</footer>










<script crossorigin="anonymous" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="<?php echo get_template_directory_uri();?>/assets/js/bootstrap.min.js"></script>
<script src="<?php echo get_template_directory_uri();?>/assets/js/popper.min.js"></script>
<script src="<?php echo get_template_directory_uri();?>/assets/js/slick.min.js"></script>
<script src="<?php echo get_template_directory_uri();?>/assets/js/setting-slick.js"></script>
<script src="<?php echo get_template_directory_uri();?>/assets/js/main.js"></script>
<?php wp_footer(); ?>
</body>
</html>