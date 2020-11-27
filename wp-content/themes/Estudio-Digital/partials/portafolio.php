<section id="Portafolio">
  <div class="portafolio">
    <div class="main-portafolio padding-rl">
      <div class="subtitle-general">
        <p>Portafolio Web</p>
      </div>
      <div class="subtitle-text__clientes">
        Lorem ipsum dolor sit amet consectetur adipisicing elit.
      </div>
      <div class="main-portafolio__content d-none d-lg-flex">
        <?php $args = array( 'post_type' => 'Portafolio');?>   
          <?php $loop = new WP_Query( $args ); ?>
          <?php $contador = 1; ?>
          <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
        <div class="content-portafolio__items">
          <div class="content-portafolio__items--img">
            <?php if(get_the_post_thumbnail_url()): ?>
            <a onclick="openModal();currentSlide(<?php echo $contador ?>)" class="single-slider__img"><img src="<?php echo get_the_post_thumbnail_url(); ?>"></a>
            <?php else: ?>
            <?php endif ?>
          </div>  
          <a onclick="openModal();currentSlide(<?php echo $contador ?>)"  class="btn btn-portafolio"><?php the_title(); ?></a>
          <a onclick="openModal();currentSlide(<?php echo $contador ?>)"  class="btn btn-portafolio-s">Ver más</a>
        </div>
        <?php $contador++; ?>
        <?php endwhile; ?>
        </div>
        <div class="slider-portafolio__responsive d-block d-lg-none">
        <?php $args = array( 'post_type' => 'Portafolio');?>   
          <?php $loop = new WP_Query( $args ); ?>
          <?php $contador = 1; ?>
          <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
        <div class="content-portafolio__items">
          <div class="content-portafolio__items--img">
            <?php if(get_the_post_thumbnail_url()): ?>
            <a onclick="openModal();currentSlide(<?php echo $contador ?>)" class="single-slider__img"><img src="<?php echo get_the_post_thumbnail_url(); ?>"></a>
            <?php else: ?>
            <?php endif ?>
          </div>  
          <a onclick="openModal();currentSlide(<?php echo $contador ?>)"  class="btn btn-portafolio"><?php the_title(); ?></a>
          <a onclick="openModal();currentSlide(<?php echo $contador ?>)"  class="btn btn-portafolio-s">Ver más</a>
        </div>
        <?php $contador++; ?>
        <?php endwhile; ?>
        </div>
    </div>
  </div>
</section>


<div id="myModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-lg">
  <div class="modal-content "  >
    <button aria-label='Close' class='close' data-dismiss='modal' type='button' onclick="closeModal()">
      <span aria-hidden='true' class='fa fa-close'></span>
    </button>
<?php $args = array( 'post_type' => 'Portafolio');?>   
  <?php $loop = new WP_Query( $args ); ?>
  <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
      <?php if(get_the_post_thumbnail_url()): ?>
          <div class="mySlides">      
            <div class="main-details__slick--items" >
              <div class="main-details__slick--img">
                <img style="width:100%;height:100%" class="details-galeria__img" src="<?php echo get_the_post_thumbnail_url(); ?>">
              </div>
            </div>
          </div>
          <?php else: ?>

          <?php endif ?>
 <?php endwhile; ?>
      <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
      <a class="next" onclick="plusSlides(1)">&#10095;</a>
  </div>
  </div>
</div>
