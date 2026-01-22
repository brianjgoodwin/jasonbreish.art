// Enhanced gallery with auto-rotate, navigation, lightbox, and touch support
document.addEventListener('DOMContentLoaded', function() {
  // Initialize GLightbox for all galleries
  const lightbox = GLightbox({
    touchNavigation: true,
    loop: true,
    autoplayVideos: false
  });

  const galleries = document.querySelectorAll('figure.gallery-block[data-ratio] ul');

  galleries.forEach(function(gallery) {
    const items = gallery.querySelectorAll('li');
    if (items.length === 0) return;

    const figure = gallery.closest('figure.gallery-block');
    const autorotateEnabled = figure.getAttribute('data-autorotate') === 'true';
    const rotateInterval = parseInt(figure.getAttribute('data-rotate-interval')) || 4000;
    const showNavigation = figure.getAttribute('data-show-navigation') === 'true';

    let currentIndex = 0;
    let autoRotateTimer = null;
    let isPaused = false;

    // Scroll to specific index
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

    // Navigate to next image
    function nextImage() {
      currentIndex = (currentIndex + 1) % items.length;
      scrollToIndex(currentIndex);
    }

    // Navigate to previous image
    function prevImage() {
      currentIndex = (currentIndex - 1 + items.length) % items.length;
      scrollToIndex(currentIndex);
    }

    // Start auto-rotate
    function startAutoRotate() {
      if (autorotateEnabled && !isPaused) {
        stopAutoRotate(); // Clear any existing timer
        autoRotateTimer = setInterval(nextImage, rotateInterval);
      }
    }

    // Stop auto-rotate
    function stopAutoRotate() {
      if (autoRotateTimer) {
        clearInterval(autoRotateTimer);
        autoRotateTimer = null;
      }
    }

    // Pause auto-rotate (used for hover)
    function pauseAutoRotate() {
      isPaused = true;
      stopAutoRotate();
    }

    // Resume auto-rotate (used for mouse leave)
    function resumeAutoRotate() {
      isPaused = false;
      startAutoRotate();
    }

    // Update current index when user manually scrolls
    gallery.addEventListener('scroll', function() {
      const scrollLeft = gallery.scrollLeft;
      const itemWidth = items[0].offsetWidth;
      const gap = 16; // Must match CSS gap
      currentIndex = Math.round(scrollLeft / (itemWidth + gap));
    });

    // Pause auto-rotate on hover
    gallery.addEventListener('mouseenter', pauseAutoRotate);

    // Resume auto-rotate on mouse leave
    gallery.addEventListener('mouseleave', resumeAutoRotate);

    // Touch/swipe support - pause during touch
    let touchStartX = 0;
    let touchEndX = 0;

    gallery.addEventListener('touchstart', function(e) {
      pauseAutoRotate();
      touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    gallery.addEventListener('touchend', function(e) {
      touchEndX = e.changedTouches[0].screenX;
      handleSwipe();
      resumeAutoRotate();
    }, { passive: true });

    function handleSwipe() {
      const swipeThreshold = 50;
      const diff = touchStartX - touchEndX;

      if (Math.abs(diff) > swipeThreshold) {
        if (diff > 0) {
          // Swiped left - next image
          nextImage();
        } else {
          // Swiped right - previous image
          prevImage();
        }
      }
    }

    // Add navigation controls if enabled
    if (showNavigation && items.length > 1) {
      const navContainer = document.createElement('div');
      navContainer.className = 'gallery-nav';

      const prevButton = document.createElement('button');
      prevButton.className = 'gallery-nav-btn gallery-nav-prev';
      prevButton.innerHTML = '&#8249;'; // Left arrow
      prevButton.setAttribute('aria-label', 'Previous image');
      prevButton.addEventListener('click', function() {
        pauseAutoRotate();
        prevImage();
        setTimeout(resumeAutoRotate, 3000); // Resume after 3s of inactivity
      });

      const nextButton = document.createElement('button');
      nextButton.className = 'gallery-nav-btn gallery-nav-next';
      nextButton.innerHTML = '&#8250;'; // Right arrow
      nextButton.setAttribute('aria-label', 'Next image');
      nextButton.addEventListener('click', function() {
        pauseAutoRotate();
        nextImage();
        setTimeout(resumeAutoRotate, 3000); // Resume after 3s of inactivity
      });

      navContainer.appendChild(prevButton);
      navContainer.appendChild(nextButton);
      figure.appendChild(navContainer);
    }

    // Start auto-rotate if enabled
    if (autorotateEnabled) {
      startAutoRotate();
    }
  });
});
