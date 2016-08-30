

<table class="table table-striped" style="text-align:left;">

    <thead>
        <tr>
            <th>Symbol</th>
            <th>Name</th>
            <th>Shares</th>
            <th>Price</th>
            <th>TOTAL</th>
        </tr>
    </thead>

    <tbody>
    <?php
	    foreach ($portfolio as $row)	
        {   
            echo("<tr>");
            echo("<td>".$row["symbol"] . "</td>");
            echo("<td>".$row["name"] . "</td>");
            echo("<td>".$row["shares"] . "</td>");
            echo("<td>$".number_format($row["price"], 2) . "</td>");
            echo("<td>$".number_format($row["total"], 2) . "</td>");
            echo("</tr>");
        }
    ?>

  
    </tbody>

</table>


