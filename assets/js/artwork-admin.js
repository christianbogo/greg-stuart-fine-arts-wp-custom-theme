/**
 * Custom JavaScript for the Artwork CPT admin edit screen.
 *
 * Disables the title field and adds an informational message,
 * as the title is auto-populated from the featured image.
 */
(function ($) {
  $(document).ready(function () {
    if ($("body.post-type-artwork").length) {
      var $titleField = $("#title");
      var $titleWrap = $("#titlewrap");

      if ($titleField.length && $titleWrap.length) {
        $titleField.prop("disabled", true);

        var $message = $('<p class="description"></p>')
          .css({
            "font-style": "italic",
            "margin-top": "5px",
            color: "#555",
          })
          .text(
            "The artwork title is automatically set from the title of the Featured Image upon saving."
          );

        $titleWrap.after($message);
      }
    }
  });
})(jQuery);
