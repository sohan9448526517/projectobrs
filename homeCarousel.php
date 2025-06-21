<style>
  /* Keyframe for zoom + fade effect */
  @keyframes zoomFadeIn {
    0% {
      opacity: 0;
      transform: scale(1.1);
    }
    100% {
      opacity: 1;
      transform: scale(1);
    }
  }

  /* Carousel item base style */
  .carousel-item {
    height: 450px;
    overflow: hidden;
    position: relative;
  }

  /* Images fill container with object-fit */
  .carousel-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.3);
    transition: transform 0.6s ease, filter 0.6s ease;
  }

  /* Animate active slide's image */
  .carousel-item.active img {
    animation: zoomFadeIn 1.2s ease forwards;
  }

  /* On hover, slightly zoom image */
  .carousel-item img:hover {
    transform: scale(1.05);
    filter: brightness(1.05);
  }
</style>

<div id="homeCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img/rental 1.png" class="d-block" alt="Slide 1">
    </div>
    <div class="carousel-item">
      <img src="img/rental 2.png" class="d-block" alt="Slide 2">
    </div>
    <div class="carousel-item">
      <img src="img/rental 3.jpg" class="d-block" alt="Slide 3">
    </div>
  </div>

  <!-- Controls -->
  <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>

  <!-- Indicators -->
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
</div>
