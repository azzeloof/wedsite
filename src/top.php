<!doctype html>

<?php 
  $pages = array(
    'who' => "Who",
    '' => "What",
    'where' => "Where",
    'when' => "When",
    'why' => "Why",
    'how' => "How"
  );
?>

<html lang="en" class="h-100" data-bs-theme="auto">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Adam & Sara's Wedsite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script type="text/javascript">
      // https://stackoverflow.com/questions/47391462/how-to-do-transition-effects-between-two-html-pages
      window.transitionToPage = function(href) {
        if (href != '/') {
          href += '.php';
        }
        document.querySelector('body').style.opacity = 0;
        setTimeout(function() {
          window.location.href = href;
        }, 500);
      }

      window.onpageshow = function(event) {
        document.querySelector('body').style.opacity = 1;
      }
    </script>
    <link rel="stylesheet" href="mtg/css/mtg_custom.css" type="text/css">
    <link href="mtg/css/mana.css" rel="stylesheet" type="text/css" />
    <link href="mtg/css/keyrune.css" rel="stylesheet" type="text/css" />
  </head>
