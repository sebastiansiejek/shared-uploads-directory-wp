<?php

namespace SharedUploadsDirectoryPlugin\src\admin\settings;

class SettingsPage
{

  function add()
  {
    add_menu_page(
      'Shared Uploads Directory',
      'Shared Uploads Directory Options',
      'manage_options',
      Settings::slug,
      function () {
?>
      <form action="options.php" method="post">
        <?php
        settings_fields(Settings::slug . "_options");
        do_settings_sections(Settings::slug);
        submit_button(__('Save'));
        ?>
      </form>
<?php
      }
    );
  }

  function isCurrentPage()
  {
    return is_admin() && isset($_GET['page']) && $_GET['page'] == Settings::slug;
  }
}
