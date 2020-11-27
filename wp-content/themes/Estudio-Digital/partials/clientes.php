<section>
  <div class="clientes">
    <div class="main-clientes padding-rl">
      <div class="subtitle-general">
        <p>Clientes</p>
      </div>
      <div class="subtitle-text__clientes">
        Lorem ipsum dolor sit amet consectetur adipisicing elit.
      </div>
      <div class="main-clientes__content ">
      	<?php $args = array( 'post_type' => 'Clientes', 'posts_per_page' => 20);?>   
        <?php $loop = new WP_Query( $args ); ?>
        <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
        <div class="content-clientes__items">
          <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
        </div>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
</section>
