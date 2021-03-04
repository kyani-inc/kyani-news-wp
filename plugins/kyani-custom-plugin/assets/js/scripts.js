(function ($) {

  $(document).ready(function () {

    $('input:radio[name="backoffice_published"]').change(function () {
      if ($(this).val() === "yes") {
        $('.reveal-if-active').addClass('reveal');
      } else {
        $('.reveal-if-active').removeClass('reveal');

        $('input:radio[name="backoffice_widget_published"]').val() === "no";
      }
    })
  });

})(jQuery);
