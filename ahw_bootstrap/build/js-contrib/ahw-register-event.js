/**
 * @file
 * Provides javascript used on 'Register your event' webform.
 */

(function ($) {
  // Quickfix for jQuery and jQuery UI compatibility issue. See:
  // http://stackoverflow.com/questions/12048271/jquery-ui-1-8-13-sudden-error
  $.curCSS = function (element, attrib, val) {
    $(element).css(attrib, val);
  };

  Drupal.behaviors.ahwRegisterEvent = {
    attach: function (context, settings) {

      $(document).ready(function () {
        var $form = $('#webform-client-form-6761', context);
        var $mapWrapper = $('#ahw-event-registration-map', $form);
        var apiKey = Drupal.settings.googleApiKey;
        var $streetField = $('#edit-submitted-when-and-where-street-address', $form);
        var $suburbField = $('#edit-submitted-when-and-where-suburb-town', $form);
        var $postcodeField = $('#edit-submitted-when-and-where-postcode', $form);
        var $stateField = $('#edit-submitted-when-and-where-state', $form);
        var timer;

        /*
         * Updates google map based on location related field values.
         */
        var updateMap = function () {
          // Get values of location relevant fields.
          var formValues = $form.formFieldValues();
          var locationFields = [
            'submitted[when_and_where][street_address]',
            'submitted[when_and_where][suburb_town]',
            'submitted[when_and_where][state]',
            'submitted[when_and_where][postcode]'
          ];
          var locationTerms = [];

          $.each(locationFields, function(index, field) {
            var value = formValues[field][0];
            if (value.trim() !== '') {
              locationTerms.push(value);
            }
          });

          // Display updated map.
          $mapWrapper.html('<iframe width="250" height="270" frameborder="0" style="border:0" src="https:\/\/www.google.com\/maps\/embed\/v1\/place?key=' + apiKey + '&q=' + locationTerms.join('+') + '" allowfullscreen><\/iframe>');
        };

        /*
         * Init function.
         */
        (function () {
          $mapWrapper.html('<iframe width="250" height="270" frameborder="0" style="border:0" src="https:\/\/www.google.com\/maps\/embed\/v1\/place?key=' + apiKey + '&q=Australia" allowfullscreen><\/iframe>');

          // Set listeners on text based location fields.
          var textFields = [
            $streetField,
            $suburbField,
            $postcodeField
          ];
          $.each(textFields, function (index, $textField) {
            $textField.keyup(function (event) {
              // Delay keyup event to prevent firing on every keystroke.
              timer && clearTimeout(timer);
              timer = setTimeout(updateMap, 600);
            });
          });

          // Set listeners on select based location fields.
          var selectFields = [
            $stateField
          ];
          $.each(selectFields, function (index, $selectField) {
            $selectField.change(function (event) {
              updateMap();
            });
          });

        })();
      });
    }
  };

})(jQuery);
