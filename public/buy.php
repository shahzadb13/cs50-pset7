<?php
    
    // configuration 
    require("../includes/config.php");   
    
    // if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // if symbol or shares empty
        if (empty($_POST["symbol"]) || empty($_POST["shares"]))
        {
            // apologize
            apologize("You must enter a stock symbol and quantity of shares to buy.");
        }
        
        // if symbol is invalid
        if (lookup($_POST["symbol"]) === false)
        {
            // apologize
            apologize("You might want to try another one!");
        }
        
        // if shares is invalid (not a whole positive integer)
        if (preg_match("/^\d+$/", $_POST["shares"]) == false)
        {
            // apologize
            apologize("You must enter a whole, positive integer.");
        }
        
        // set transaction type
        $transaction = 'BUY';
        
        // look up stock's price
        $stock = lookup($_POST["symbol"]);
        
        // calculate total cost (stock's price * shares)
        $cost = $stock["price"] * $_POST["shares"];
        
        // query to check how much cash user has
        $cash =	CS50::query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);	
        //dump($cash);
        // if user's cash < total cost (user can't afford purchase)
        if ($cash < $cost)
        {
            // apologize
            apologize("You can't afford this purchase.");
        }         
        
        // else if user's cash >= total price (user can afford purchase)
        else
        {
            // capitalize symbol (works)
            $_POST["symbol"] = strtoupper($_POST["symbol"]);
                         
            // add stock to their portfolio or update shares
           CS50:: query("INSERT INTO portfolio (user_id, symbol, shares) VALUES(?, ?, ?) 
                ON DUPLICATE KEY UPDATE shares = shares + VALUES(shares)", $_SESSION["id"], $_POST["symbol"], $_POST["shares"]);
            
            // subtract total price from their cash
            CS50::query("UPDATE users SET cash = cash - ? WHERE id = ?", $cost, $_SESSION["id"]);
            
            // update history
          CS50::query("INSERT INTO history (user_id, transaction, symbol, shares, price) VALUES (?, ?, ?, ?, ?)", $_SESSION["id"], $transaction, $_POST["symbol"], $_POST["shares"], $stock["price"]);
            //redirect to portfolio
            redirect("/");    
        }
    }
    
    // if form hasn't been submitted
    else
    {
        // render buy form
        render("buy_form.php", ["title" => "Buy Form"]);
    }
    
?>