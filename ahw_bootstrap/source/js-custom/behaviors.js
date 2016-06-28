/**
 * @file
 * Provides jQuery behaviors.
 */

(function ($) {
  /**
   * Test jQuery by adding a test="test" attribute to all anchor tags.
   */
  Drupal.behaviors.testLinks = {
    attach: function (context, settings) {

      /* header feature */
      feature_rotate_interval = setInterval(home_feature_next, 6000); // auto rotates the images
      var feature_items_count = $('.featureImages img').size();
      $('.featureImages ul li:first').addClass('active').show();
      var last_slide = '';
      for (i = 1; i <= feature_items_count; i++) {
          if (i == feature_items_count) {
              var last_slide = ' last-slide';
          }
          $('#feature-nav').append('<a href="javascript:void(0);" class="slide' +
              last_slide + '" title="Slide ' + i + '" id="button-' + i +
              '"></a>');
      }
      $('#feature-nav a:first').addClass('on');
      $('#feature, #feature-nav').delay(550).fadeIn('slow');
      $('#feature-nav a.slide').click(function() {
          clearInterval(feature_rotate_interval);
          $('#feature-nav a.slide').removeClass('on');
          $(this).addClass('on');
          position = $('#feature-nav a.slide').index(this) + 1; // plus one as its a 0 is the first one
          home_feature_transition(position);
      });

      function home_feature_next() {
          $('#feature-nav a.slide').each(function() {
              if ($(this).hasClass('on')) {
                  $(this).removeClass('on');
                  if ($(this).is('.last-slide')) {
                      $('#feature-nav a.slide:first').addClass('on');
                      position = 1;
                      home_feature_transition(position);
                      return false;
                  } else {
                      $(this).next('a.slide').addClass('on');
                      position = $('#feature-nav a.slide').index(this) +
                          2; // plus 2 as we want to move to the next one and the 0 offset
                      home_feature_transition(position);
                      return false;
                  }
              }
          });
      }
      var feature_currently_moving = false; // prevents slides meshing into each other
      function home_feature_transition(position) {
          if (feature_currently_moving == false) {
              feature_currently_moving = true;
              $('.featureImages ul li.active').fadeOut('slow').removeClass(
                  'active');
              $('.featureImages ul li:nth-child(' + position + ')').addClass(
                  'active').fadeIn('slow', function() {
                  feature_currently_moving = false;
              });
          }
          return false;
      };
    }
  };

})(jQuery);
