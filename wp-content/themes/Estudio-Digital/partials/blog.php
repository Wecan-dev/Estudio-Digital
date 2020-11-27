<section>
  <div class="blog">
    <div class="main-blog">
      <div class="subtitle-general">
        <p>Blog</p>
      </div>
      <div class="subtitle-text__clientes">
        Lorem ipsum dolor sit amet consectetur adipisicing elit.
      </div>
      <div class="main-blog__content">
      	<?php $args = array( 'post_type' => 'Blog');?>   
          <?php $loop = new WP_Query( $args ); ?>
          <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
        <div class="blog-slider__content">
          <div class="blog-slider__img">
            <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
          </div>
          <div class="blog-slider__text">
            <div class="blog-slider__text--title"><?php the_title(); ?></div>
            <div class="blog-slider__text--text">
              <?php the_content(); ?>
            </div>
            <div class="blog-slider__text--btn">
              <a href="#">Ver más <i class="fa fa-arrow-right " arial-hidden="true"></i></a>
            </div>
          </div>
        </div>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
</section>