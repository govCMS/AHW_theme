<?php
/**
 * @file
 * The primary PHP file for this theme.
 */

/**
 * Implements theme_preprocess_html().
 */
function peqa_bootstrap_preprocess_html(&$variables) {
  // Add legacy classes.
  $variables['classes_array'][] = drupal_html_class('page-template-default');
  $variables['classes_array'][] = drupal_html_class('searchPos');
  if (drupal_is_front_page()) {
    $variables['classes_array'][] = drupal_html_class('home');
  }
}



// Add scripts.min.js at end of body tag.
$theme_path = drupal_get_path('theme', 'ahw_bootstrap');
// Add jQuery.browser library to fix 'Cannot read property 'msie' of undefined'
// issue.
drupal_add_js(
  $theme_path . '/build/js-contrib/jquery.browser.min.js',
  [
    'type' => 'file',
    'scope' => 'footer',
  ]
);
// Add stock bootstrap library.
drupal_add_js(
  $theme_path . '/build/js-contrib/bootstrap.min.js',
  [
    'type' => 'file',
    'scope' => 'footer',
  ]
);
drupal_add_js(
  $theme_path . '/build/js-custom/ahw-scripts.min.js',
  [
    'type' => 'file',
    'scope' => 'footer',
  ]
);

/**
 * Implements hook_form_alter().
 */
function ahw_bootstrap_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id === 'search_api_page_search_form_default_search') {
    // Modify placeholder text in search field.
    $form['keys_1']['#title'] = t('Search');
    $form['keys_1']['#attributes']['placeholder'] = t('Search...');
  }

  // Modify exposed filters form for filter events block.
  if ($form_id === 'views_exposed_form' && $form['#id'] === 'views-exposed-form-ahw-events-filter-ahw-view--ahw-events-filter--page') {
    // Add placeholder text to 'Keyword search' filter.
    $form['combine']['#attributes'] = [
      'placeholder' => t('Keyword search'),
    ];
    // Add labels to start and end date filters.
    $form['field_start_date_value']['value']['#attributes'] = [
      'placeholder' => t('dd/mm/yyyy'),
    ];
    $form['field_end_date_value']['value']['#attributes'] = [
      'placeholder' => t('dd/mm/yyyy'),
    ];
  }
}

/**
 * Implements hook_js_alter().
 */
function ahw_bootstrap_js_alter(&$javascript) {
  // Use updated jQuery library on all but some paths.
  $node_admin_paths = [
    'node/*/edit',
    'node/add',
    'node/add/*',
  ];
  $replace_jquery = TRUE;
  if (path_is_admin(current_path())) {
    $replace_jquery = FALSE;
  }
  else {
    foreach ($node_admin_paths as $node_admin_path) {
      if (drupal_match_path(current_path(), $node_admin_path)) {
        $replace_jquery = FALSE;
      }
    }
  }
  // Swap out jQuery to use an updated version of the library.
  if ($replace_jquery) {
    $javascript['misc/jquery.js']['data'] = drupal_get_path('theme', 'mtpc_bootstrap') . '/js/jquery.min.js';
  }
}

/**
 * Implements hook_preprocess_entity().
 */
function ahw_bootstrap_preprocess_entity(&$variables, $hook) {
  // Enable use of function ahw_bootstrap_preprocess_entity_[entity_type]().
  $function = __FUNCTION__ . '_' . $variables['entity_type'];
  if (function_exists($function)) {
    $function($variables, $hook);
  }
}

/**
 * Implements hook_preprocess_block().
 */
function ahw_bootstrap_preprocess_block(&$vars) {
  $block = $vars['block'];
  if ($block->module === 'webform' && $block->delta === 'client-block-6761') {
    $theme_path = drupal_get_path('theme', 'ahw_bootstrap');
    drupal_add_js($theme_path . '/build/js-contrib/jquery.form-field-values.min.js', ['type' => 'file', 'scope' => 'footer']);
    drupal_add_js(['googleApiKey' => variable_get('ahw_google_api_key')], 'setting');
    drupal_add_js($theme_path . '/build/js-contrib/ahw-register-event.js', ['type' => 'file', 'scope' => 'footer']);
  }

  // Change title of ahw_events_filter view's exposed filter block on home page.
  if ($vars['is_front'] && !empty($vars['elements']['#block']) && $vars['elements']['#block']->info === 'Exposed form: ahw_events_filter-ahw_view__ahw_events_filter__page') {
    $vars['elements']['#block']->subject = t('LOOKING FOR AN EVENT?');
    $vars['classes_array'][] = 'homeFilter';
  }
}

/**
 * Implements template_preprocess_views_view_fields().
 */
function ahw_bootstrap_preprocess_views_view_fields(&$vars) {
  $view = $vars['view'];
  if ($view->name === 'ahw_event_location' && $view->current_display === 'ahw_view__ahw_event_location__block') {
    $row = $vars['row'];
    $api_key = variable_get('ahw_google_api_key');
    $latitude = $row->field_field_latitude[0]['rendered']['#markup'];
    $longitude = $row->field_field_longitude[0]['rendered']['#markup'];
    $vars['custom'] = [
      'api_key' => $api_key,
      'gmap_search_terms' => $latitude . ',' . $longitude,
    ];
  }

  if ($view->name === 'ahw_events_filter') {
    // Confirm if is past event.
    $end_date = $vars['row']->field_field_end_date[0]['raw']['value'];
    if ($end_date < time()) {
      $vars['custom']['past_event'] = TRUE;
      $vars['custom']['past_event_text'] = t('PAST EVENT');
    }
  }
}
