<?php

namespace view;
class LayoutView {
  
  public function render($loginViewHTML, DateTimeView $dateTimeView) {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>

          <div class="container">
              ' . $loginViewHTML . '
              
              ' . $dateTimeView->renderDateTimeString() . '
          </div>
         </body>
      </html>
    ';
  }
}
