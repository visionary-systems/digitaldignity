<?php
/**
 * Founders
 */

require_once 'config/supabase.php';
require_once 'config/auth.php';
$pageTitle = "Founders - Digital Dignity";
$pageClass = "founders";
$modules = [
    'navigation',
    'header-1',
    'footer-1'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <meta name="description" content="Digital Dignity - Your data is your intellectual property">
    <link rel="stylesheet" href="/assets/css/main.css">
    <?php if(file_exists("assets/css/pages/{$pageClass}.css")): ?>
        <link rel="stylesheet" href="/assets/css/pages/<?php echo $pageClass; ?>.css">
    <?php endif; ?>
</head>
<body class="<?php echo $pageClass; ?>">
    <?php
    foreach($modules as $module) {
        $modulePath = "modules/{$module}.php";
        if (file_exists($modulePath)) {
            include $modulePath;
        } else {
            echo "<!-- Module not found: {$module} -->";
        }
    }
    ?>
    
  <!-- Module JavaScript files -->
  <script src="/assets/js/modules/intro-animation.js"></script>
  <script src="/assets/js/modules/navigation.js"></script>
  
  <!-- Main JavaScript -->
  <script src="/assets/js/main.js"></script>
  
  <?php if(file_exists("assets/js/pages/{$pageClass}.js")): ?>
    <script src="/assets/js/pages/<?php echo $pageClass; ?>.js"></script>
  <?php endif; ?>
</body>
</html>