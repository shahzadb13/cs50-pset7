<?php
    // configuration
    require("../includes/config.php");  
    
    // if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        // set transaction type
        $transaction = 'SELL';
        // lookup stock
        $stock = lookup($_POST["symbol"]);
        
        // lookup user's shares of stock being sold
        $shares = CS50::query("SELECT shares FROM portfolio WHERE user_id = ? AND symbol = ?", $_SESSION["id"], $_POST["symbol"]);
        
        // calculate total sale value (stock's price * shares)
        $value = $stock["price"] * $shares[0]["shares"];
        
        // add the sale value to cash
        CS50::query("UPDATE users SET cash = cash + ? WHERE id = ?", $value, $_SESSION["id"]);
        // delete the stock from their portfolio 
        CS50::query("DELETE FROM portfolio WHERE user_id = ? AND symbol = ?", $_SESSION["id"], $_POST["symbol"]);        
        
        // update history
        CS50::query("INSERT INTO history (user_id, transaction, symbol, shares, price) VALUES (?, ?, ?, ?, ?)", $_SESSION["id"], $transaction, $_POST["symbol"], $shares[0]["shares"], $stock["price"]);
        // redirect to portfolio 
        redirect("/");
    }
    
    // if form hasn't been submitted
    else
    {
        // query user's portfolio
        $rows =	CS50::query("SELECT * FROM portfolio WHERE user_id = ?", $_SESSION["id"]);	
        // create new array to store stock symbols
        $stocks = [];
        // for each of user's stocks
        foreach ($rows as $row)	
        {   
            // save stock symbol
            $stock = $row["symbol"];
            
            // add stock symbol to the new array
            $stocks[] = $stock;       
        }    
        // render sell form
        render("sell_form.php", ["title" => "Sell Form", "stocks" => $stocks]);
    }
      
?>