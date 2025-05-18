/**
 * GLightbox Initializer
 *
 * This script initializes GLightbox on elements with the 'glightbox' class.
 * It ensures GLightbox is loaded before trying to use it.
 */
document.addEventListener("DOMContentLoaded", function () {
  // Check if the GLightbox object exists (meaning the script has loaded)
  if (typeof GLightbox === "function") {
    // GLightbox is a function constructor
    const lightbox = GLightbox({
      // selector: '.glightbox', // This is the default selector, targets elements with class="glightbox"
      // You can change this if you use a different class on your links.
      touchNavigation: true, // Enable touch navigation for mobile
      loop: true, // Loop through slides when reaching the end
      autoplayVideos: true, // If you plan to use it for videos
      // You can add more GLightbox options here as needed.
      // See GLightbox documentation for all available options:
      // https://github.com/biati-digital/glightbox#available-options
    });
  } else {
    // Optional: Log an error if GLightbox didn't load, for debugging.
    console.error("GLightbox library not found or not loaded correctly.");
  }
});
