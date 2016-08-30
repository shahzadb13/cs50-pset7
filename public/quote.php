<?php
    // configuration
    require("../includes/config.php"); 
    // if form was submitted
    if ($_POST)
    {
        // lookup stock info
        $stock = lookup($_POST["symbol"]);
        if ($stock === false)
        {
            apologize("Invalid stock symbol");
        }
        
        // else render quote_price
            render("quote_price.php", ["symbol" => $stock["symbol"], "name" => $stock["name"], "price" => $stock["price"]]);
    }
      else
    {
        // else render quote_form
        render("quote_form.php", ["title" => "Quote"]);
    }

  
?>