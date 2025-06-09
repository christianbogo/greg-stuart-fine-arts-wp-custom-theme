/**
 * Custom JavaScript for the Artwork CPT admin edit screen.
 *
 * Hides the title field and adds helpful messaging to guide Greg
 * through the simplified artwork creation process.
 */
(function ($) {
  $(document).ready(function () {
    if ($("body.post-type-artwork").length) {
      // Hide the title wrapper completely since title is auto-populated
      $("#titlewrap").hide();

      // Add helpful messaging about the workflow
      var $postBody = $("#poststuff");
      if ($postBody.length) {
        var $helpMessage = $(
          '<div class="notice notice-info" style="margin: 20px 0; padding: 15px; border-left: 4px solid #0073aa;">' +
            '<h3 style="margin-top: 0;">✨ Simplified Artwork Creation</h3>' +
            "<p><strong>Step 1:</strong> Set the Featured Image below (this will be your artwork)</p>" +
            "<p><strong>Step 2:</strong> Select the Artwork Type (Gallery Piece or Sketch)</p>" +
            "<p><strong>Step 3:</strong> Click Publish!</p>" +
            '<p style="margin-bottom: 0;"><em>💡 The artwork title will automatically be taken from your image\'s title in the Media Library.</em></p>' +
            "</div>"
        );
        $postBody.prepend($helpMessage);
      }

      // Improve the page title for new artwork posts
      if ($("h1.wp-heading-inline").length) {
        var $pageTitle = $("h1.wp-heading-inline");
        if ($pageTitle.text().includes("Add New")) {
          $pageTitle.text("Add New Artwork");
        }
      }

      // Add messaging to the featured image meta box
      $(document).on("DOMNodeInserted", function (e) {
        if (
          $(e.target).find("#postimagediv").length ||
          $(e.target).is("#postimagediv")
        ) {
          var $featuredImageDiv = $("#postimagediv");
          if (
            $featuredImageDiv.length &&
            !$featuredImageDiv.find(".artwork-featured-image-help").length
          ) {
            var $imageHelp = $(
              '<p class="artwork-featured-image-help" style="font-style: italic; color: #666; margin-top: 10px;">' +
                "🎨 This image will be your artwork. Make sure it has a good title in the Media Library!" +
                "</p>"
            );
            $featuredImageDiv.find(".inside").append($imageHelp);
          }
        }
      });

      // If there's already a featured image section, add the help immediately
      setTimeout(function () {
        var $featuredImageDiv = $("#postimagediv");
        if (
          $featuredImageDiv.length &&
          !$featuredImageDiv.find(".artwork-featured-image-help").length
        ) {
          var $imageHelp = $(
            '<p class="artwork-featured-image-help" style="font-style: italic; color: #666; margin-top: 10px;">' +
              "🎨 This image will be your artwork. Make sure it has a good title in the Media Library!" +
              "</p>"
          );
          $featuredImageDiv.find(".inside").append($imageHelp);
        }
      }, 500);
    }
  });
})(jQuery);
