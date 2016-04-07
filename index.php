<?php

$events = array("tiger", "car", "bus"); //List of values to search
$url = "http://localhost:5000/image/";  //Api for image library
$procurl = "http://localhost:5000/procid/";

$email = $_POST['email'];

function httpGet($url)
{
    $ch = curl_init();  
 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
//  curl_setopt($ch,CURLOPT_HEADER, false); 
 
    $output=curl_exec($ch); // the json response
 
    curl_close($ch);
    return $output;
}
function httpGetWithErros($url) //handle errors
{
    $ch = curl_init();  
 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
 
    $output=curl_exec($ch);
 
    if($output === false)
    {
        echo "Error Number:".curl_errno($ch)."<br>";
        echo "Error String:".curl_error($ch);
    }
    curl_close($ch);
    return $output;
}

$k = array_rand($events);   //pick up a random event
$v = $events[$k];

//echo httpGetWithErros($url.$v);
$result = json_decode(httpGet($url.$v));    //get a random image from library
//var_dump(json_decode($result, true));
$sz = array_rand($result->res); //pick a random image from a random 'event' of image array
$uri = $result->res[$sz]->url;  //grab the image url
$processid = $result->res[$sz]->id;
$ans = $result->res[$sz]->name; //Selected item
//echo $uri;

$procimg = json_decode(httpGet($procurl.$processid));
$urii = $procimg->res[0]->url;
//echo $result;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sign up</title>
        <script type="text/javascript">
         <!--
            // Form validation code will come here. -->
        function validate()
        {              
             if( document.myForm.select.value == "<?php echo $ans ?>" )
             {  //alert( "Correct captcha entered" );
                return true;
             }
             else{
                alert( "Incorrect captcha entered" );
             }
             return( false );
        }
        </script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <style>
        .rcaptcha {
            margin-bottom: 10px;
        }
        </style>
        </head>
        <body>                  
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h3>Sign up</h3>
                    <hr>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="you@domain.com">
                        </div> 
                        <div class="rcaptcha">
                            <img src="<?php echo $urii ?>" margin=30 > 
                        </div>
                        <br>
                        <div>
                        <form name="myForm" action="welcome.php" onsubmit="return(validate());">
                           <select name="select" >
                              <option value="car">Car</option>
                              <option value="bus">Bus</option>
                              <option value="tiger">Tiger</option>
                              <option value="truck">Truck</option>
                              <option value="mountain">Mountain</option>
                              <option value="lion">lion</option>
                              <option value="laptop">Laptop</option>
                              <option value="book">Book</option>
                              <option value="bottle">Bottle</option>
                            </select>
                                <input type="submit" value="submit">
                            </form>
                        </div>
                        <br>
                </div>
            </div>
        </div>
    </body>
</html>
