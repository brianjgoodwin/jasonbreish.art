/**
 * Simple lightbox for images
 * Makes images in .text blocks clickable and viewable full size
 */

(function() {
  // Wait for DOM to be ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLightbox);
  } else {
    initLightbox();
  }

  function initLightbox() {
    // Make images in text blocks clickable
    document.querySelectorAll('.text img').forEach(img => {
      // Skip if already wrapped in a link
      if (img.parentElement.tagName === 'A') return;

      // Skip if parent has no-lightbox class
      if (img.closest('.no-lightbox')) return;

      // Make cursor indicate clickability
      img.style.cursor = 'zoom-in';

      // Add click handler to open image in overlay
      img.addEventListener('click', () => {
        openImageLightbox(img);
      });
    });
  }

  function openImageLightbox(img) {
    // Create overlay
    const overlay = document.createElement('div');
    overlay.className = 'image-lightbox';
    overlay.innerHTML = `
      <div class="image-lightbox-content">
        <img src="${img.src}" alt="${img.alt || ''}" />
        <button class="image-lightbox-close" aria-label="Close">&times;</button>
      </div>
    `;

    document.body.appendChild(overlay);
    document.body.style.overflow = 'hidden';

    // Trigger reflow to enable transition
    overlay.offsetHeight;
    overlay.classList.add('active');

    // Close handlers
    const close = () => {
      overlay.classList.remove('active');
      document.body.style.overflow = '';
      setTimeout(() => overlay.remove(), 300);
    };

    overlay.querySelector('.image-lightbox-close').addEventListener('click', close);
    overlay.addEventListener('click', (e) => {
      if (e.target === overlay) close();
    });
    document.addEventListener('keydown', function escHandler(e) {
      if (e.key === 'Escape') {
        close();
        document.removeEventListener('keydown', escHandler);
      }
    });
  }
})();
