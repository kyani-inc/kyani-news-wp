(function ($) {

  $(document).ready(function () {

    // if backoffice_published, display other options for back office
    $('input:radio[name="backoffice_published"]').change(function () {
      if ($(this).val() === "yes") {
        $('.reveal-if-active').addClass('reveal');
      } else {
        $('.reveal-if-active').removeClass('reveal');

        $('#backoffice_widget_published_yes').prop("checked", false);
        $('#backoffice_widget_published_no').prop("checked", true);

        $('#backoffice_featured_published_yes').prop("checked", false);
        $('#backoffice_featured_published_no').prop("checked", true);

        $('#backoffice_only_published_yes').prop("checked", false);
        $('#backoffice_only_published_no').prop("checked", true);
      }
    })
  });

})(jQuery);
