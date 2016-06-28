<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $options['type'] will either be ul or ol.
 * @ingroup views_templates
 */
?>





    <div class="featureImages container">
        <div class="featureItem">
            <ul>
    <?php foreach ($rows as $id => $row): ?>
            <li style="display: none;" <?php if ($classes_array[$id]) { print ' class="' . $classes_array[$id] .'"';  } ?>>
            <?php print $row; ?>

            </li>
            <?php endforeach; ?>
  </ul>

            <a href="#">
            <div class="featureText">
                <h2>Australian <strong>Heritage</strong> Week</h2>
                <p>Your heritage... pass it on!</p>
            </div></a>
            <div id="feature-nav" style="display: block;">


            </div>
        </div>
    </div>






