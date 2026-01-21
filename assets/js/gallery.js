// Simple, rock-solid gallery auto-rotate
document.addEventListener('DOMContentLoaded', function() {
  const galleries = document.querySelectorAll('figure[data-ratio] ul');

  galleries.forEach(function(gallery) {
    const items = gallery.querySelectorAll('li');
    if (items.length === 0) return;

    let currentIndex = 0;
    const rotateInterval = 4000; // 4 seconds per image

    function scrollToIndex(index) {
      const item = items[index];
      if (item) {
        item.scrollIntoView({
          behavior: 'smooth',
          block: 'nearest',
          inline: 'start'
        });
      }
    }

    function nextImage() {
      currentIndex = (currentIndex + 1) % items.length;
      scrollToIndex(currentIndex);
    }

    // Auto-rotate
    const autoRotate = setInterval(nextImage, rotateInterval);

    // Pause on hover
    gallery.addEventListener('mouseenter', function() {
      clearInterval(autoRotate);
    });

    // Resume on mouse leave (restart from current position)
    gallery.addEventListener('mouseleave', function() {
      setInterval(nextImage, rotateInterval);
    });

    // Update current index when user manually scrolls
    gallery.addEventListener('scroll', function() {
      const scrollLeft = gallery.scrollLeft;
      const itemWidth = items[0].offsetWidth;
      currentIndex = Math.round(scrollLeft / (itemWidth + 16)); // 16 is gap
    });
  });
});
