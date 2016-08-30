
<h1 style="text-aligned:center;color:#3399ff;"><u>CHOOSE THE $TOCK TO SELL</u></h1>
<form action="sell.php" method="post">
    <fieldset>
        <div class="control-group">
            <select name="symbol">
                <option value='Choose Below'></option>
                <?php               
	                foreach ($stocks as $symbol)	
                    {   
                        echo("<option value='$symbol'>" . $symbol . "</option>");
                    }
                ?>
            </select>
        </div>
        <div class="control-group">
            <button style="color:white;background-color:green;" type="submit" class="btn btn-default">Sell</button>
        </div>
    </fieldset>
</form>