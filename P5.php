<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Adam Lewandowski">
    <title>Przeliczanie walut po aktualnym kursie NBP</title>

    <style>
        a{
            color:green;
            text-decoration:underline;
        }
        img{
            float:left;
        }
        form{
            width:350px;
		    height:200px;
            text-align:center;
		    margin:0px auto;
		    border:2px solid black;
	    }
        table{
		    margin:0px auto;
	}
        h1{
            text-align:center;
            color:navy;
            background-color: #FFFF00;
        }
        label {
            text-align: right;
            margin-right: 15px;
            width: 100px;
        }
        hr.linia{
            border: 2px solid red;
        }
        iframe{
            top:0px;
        }
        a{
            float:left;
            vertical-align:top;
        }
    </style>
</head>
<body>
    
    <a href="https://mybank.pl/kursy-walut/"> Kursy walut dostępne na <strong> mybank.pl </strong> </a> <br>
   
    <iframe marginwidth="0" marginheight="0" frameborder="0" id="currencyArkis" scrolling="no" width="220" height="190" border="0" src="http://waluty.arkis.pl/kursy_webmaster.php?flag=1?">
    </iframe>

    <h1>Przeliczanie walut </h1>
    <form action="" method="post">
    <table>
	<tr>
	<td>
        <label for="wartosc">Podaj kwotę jaką chcesz przeliczyć: </label>
        <input type="number" min="1" name="wartosc" required>

        </td>
    </tr>
    <tr>
    <td>
    <label for="waluta1">Wybierz walutę z której chcesz przeliczyć: </label>
    <select name='waluta1'>
    <option value="">--Wybierz walutę--</option>
        <option value="z1">Złoty</option>
        <option value="d1">Dolar</option>
        <option value="e1">Euro</option>
        <option value="fr1">Frank</option>
        <option value="f1">Funt</option>
    </select>
    </td>
    </tr>
    <tr>
	<td>
    <label for="waluta2">Wybierz walutę na którą chcesz przeliczyć: </label>
    <select name='waluta2'>
    <option value="">--Wybierz walutę--</option>
        <option value="z2">Złoty</option>
        <option value="d2">Dolar</option>
        <option value="e2">Euro</option>
        <option value="fr2">Frank</option>
        <option value="f2">Funt</option>
    </select>
    </td>
    </tr>
    <tr>
    <td><center><br>

    <input type='submit' name='submit' value="Przelicz walutę">
    </td>
    </tr>
    </table>        
    </form>
        <hr class="linia">

        <?php
            

             $curl = curl_init();
             curl_setopt($curl, CURLOPT_URL, 'https://www.nbp.pl/kursy/xml/LastA.xml');
             curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
             $dane = curl_exec($curl);
             curl_close($curl);
          
             $tabela_kursow = new SimpleXMLElement($dane);
        
          
             //pobranie poszczególnych walut do zmiennych, czyli w tym wypadku pozycja z pliku XML kursow NBP //
             $usdS = $tabela_kursow->pozycja[1];
             $usd= $usdS->kurs_sredni;
             settype($usd, 'string');
             $usdF = str_replace(',', '.', $usd);

             $eurS = $tabela_kursow->pozycja[7];
             $eur= $eurS->kurs_sredni;
             settype($eur, 'string');
             $eurF = str_replace(',', '.', $eur);

             $chfS = $tabela_kursow->pozycja[9];
             $chf= $chfS->kurs_sredni;
             settype($chf, 'string');
             $chfF = str_replace(',', '.', $chf);

             $gbpS = $tabela_kursow->pozycja[10];
             $gbp= $gbpS->kurs_sredni;
             settype($gbp, 'string');
             $gbpF = str_replace(',', '.', $gbp);
            
            @$waluta1=$_POST['waluta1'];
            @$waluta2=$_POST['waluta2'];
            @$wartosc=$_POST['wartosc'];

            if(isset($_POST['wartosc'])){
                if(!empty($waluta1) && !empty($waluta2)){
            
            //Przeliczanie na złotówki
            if($waluta1=="z1" AND $waluta2=="z2"){
            $kwota= $wartosc; 
            echo "$wartosc zł to: "; echo round($kwota, 2); echo " złotych";
            }
            
    
            if($waluta1=="d1" AND $waluta2=="z2"){
                settype($usdF, 'float');
            $kwota=round($wartosc * $usdF, 2);
            echo "$wartosc dolarów to: $kwota złotych";
            }
            
            if($waluta1=="e1" AND $waluta2=="z2"){
                settype($eurF, 'float');
            $kwota=round($wartosc * $eurF, 2);
            echo "$wartosc euro to: $kwota złotych";
            }
            
            if($waluta1=="fr1" AND $waluta2=="z2"){
                settype($chfF, 'float');
            $kwota=round($wartosc * $chfF, 2);
            echo "$wartosc franków to: $kwota złotych";
            }
            
            if($waluta1=="f1" AND $waluta2=="z2"){
                settype($gbpF, 'float');
            $kwota=round($wartosc * $gbpF, 2);
            echo "$wartosc funtów to: $kwota złotych";
            }

            //Przeliczanie na dolary
            if($waluta1=="z1" AND $waluta2=="d2"){
                settype($usdF, 'float');
            $kwota=round($wartosc / $usdF, 2);
            echo "$wartosc zł to: $kwota dolarów";
            }
    
            if($waluta1=="d1" AND $waluta2=="d2"){
            $kwota= $wartosc;
            echo "$wartosc dolarów to: $kwota dolarów";
            }
            
            if($waluta1=="e1" AND $waluta2=="d2"){
                settype($usdF, 'float');
            $kwota=round($wartosc *$eurF / $usdF, 2);
            echo "$wartosc euro to: $kwota dolarów";
            }
            
            if($waluta1=="fr1" AND $waluta2=="d2"){
                settype($usdF, 'float');
            $kwota=round($wartosc *$chfF / $usdF, 2);
            echo "$wartosc franków to: $kwota dolarów";
            }
            
            if($waluta1=="f1" AND $waluta2=="d2"){
                settype($usdF, 'float');
            $kwota=round($wartosc *$gbpF / $usdF, 2);
            echo "$wartosc funtów to: $kwota dolarów";
            }

            //Przeliczanie na euro
            if($waluta1=="z1" AND $waluta2=="e2"){
            settype($eurF, 'float');
            $kwota=round($wartosc / $eurF, 2);
            echo "$wartosc zł to: $kwota euro";
            }
    
            if($waluta1=="d1" AND $waluta2=="e2"){
            settype($eurF, 'float');
            $kwota=round($wartosc *$usdF / $eurF, 2);
            echo "$wartosc dolarów to: $kwota euro";
            }
            
            if($waluta1=="e1" AND $waluta2=="e2"){
            $kwota= $wartosc;
            echo "$wartosc euro to: $kwota euro";
            }
            
            if($waluta1=="fr1" AND $waluta2=="e2"){
            settype($eurF, 'float');
            $kwota=round($wartosc *$chfF / $eurF, 2);
            echo "$wartosc franków to: $kwota euro";
            }
            
            if($waluta1=="f1" AND $waluta2=="e2"){
            settype($eurF, 'float');
            $kwota=round($wartosc *$gbpF / $eurF, 2);
            echo "$wartosc funtów to: $kwota euro";
            }

            //Przeliczanie na franki
            if($waluta1=="z1" AND $waluta2=="fr2"){
            settype($chfF, 'float');
            $kwota=round($wartosc / $chfF, 2);
            echo "$wartosc zł to: $kwota franków";
            }
    
            if($waluta1=="d1" AND $waluta2=="fr2"){
            settype($chfF, 'float');
            $kwota=round($wartosc *$usdF / $chfF, 2);
            echo "$wartosc dolarów to: $kwota franków";
            }
            
            if($waluta1=="e1" AND $waluta2=="fr2"){
            settype($chfF, 'float');
            $kwota=round($wartosc *$eurF / $chfF, 2);
            echo "$wartosc euro to: $kwota franków";
            }
            
            if($waluta1=="fr1" AND $waluta2=="fr2"){
            $kwota= $wartosc;
            echo "$wartosc franków to: $kwota franków";
            }
            
            if($waluta1=="f1" AND $waluta2=="fr2"){
            settype($chfF, 'float');
            $kwota=round($wartosc *$gbpF / $chfF, 2);
            echo "$wartosc funtów to: $kwota franków";
            }

            //Przeliczanie na funty
            if($waluta1=="z1" AND $waluta2=="f2"){
            settype($gbpF, 'float');
            $kwota=round($wartosc / $gbpF, 2);
            echo "$wartosc zł to: $kwota funtów";
            }
    
            if($waluta1=="d1" AND $waluta2=="f2"){
            settype($gbpF, 'float');
            $kwota=round($wartosc *$usdF / $gbpF, 2);
            echo "$wartosc dolarów to: $kwota funtów";
            }
            
            if($waluta1=="e1" AND $waluta2=="f2"){
            settype($gbpF, 'float');
            $kwota=round($wartosc *$eurF / $gbpF, 2);
            echo "$wartosc euro to: $kwota funtów";
            }
            
            if($waluta1=="fr1" AND $waluta2=="f2"){
            settype($gbpF, 'float');
            $kwota=round($wartosc *$chfF / $gbpF, 2);
            echo "$wartosc franków to: $kwota funtów";
            }
            
            if($waluta1=="f1" AND $waluta2=="f2"){
            $kwota= $wartosc;
            echo "$wartosc funtów to: $kwota funtów";
            }
            
            }
            else echo "Nie wybrałeś walut!";
        }
    ?>


</body>
</html>