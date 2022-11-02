<?php
    $page_title = "weather detection" ; 
    include_once "init.php" ;   
    function fetch_user_city($user_ip){
        $settings = [
            "apiKey" => "fe91a376c7844ad3829f92b4940d7f86",
            "ip" => $user_ip,
            "lang" => "en",
            "fields" => "*"
        ];
        $url = "https://api.ipgeolocation.io/ipgeo?";
        foreach ($settings as $k=>$v) { $url .= urlencode($k)."=".urlencode($v)."&"; }
        $url = substr($url, 0, -1);
        
        // (B) INIT CURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // (C) CURL FETCH
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, 1);
        $city_name = $result['city']; 
        echo $city_name ; 
    }
?>




<div class="container-fluid">
    <div class="row justify-content-center struc">
        <div class="col-8">
            <h2 class="sentence text-center bg-info text-dark">
                Enter your city name to know weather state
            </h2>
            <div class="row justify-content-center">
                <div class="col-12 col-sm-6">
                    
                    <form id="search_form" class="d-flex" role="search">
                        <input id="user_ip" type="text" hidden value="<?php echo $_SERVER['REMOTE_ADDR'] ; ?>">
                        <input class="form-control me-2" type="search" name="city" id="city" placeholder="City" aria-label="Search" value="<?php echo fetch_user_city($_SERVER['REMOTE_ADDR']) ; ?> ">
                        <button class="btn btn-outline-success" id="search_button" type="submit">Search</button>
                    </form>

                </div>
            </div>
        </div>
        <div class="col-12">
            <div id="response" class="row justify-content-center">

            </div>
        </div>
    </div>
</div>


<?php include_once $tmp."footer.php" ;?>

    <script> 

        $("#search_form").on("submit", function(event){
            event.preventDefault() ; 
            var city = $("#city").val();
            var user_ip = $("#user_ip").val();

            $.ajax({
                url:"./handle_files/fetch_api_data.php",
                method:"post",
                data:{user_ip:user_ip, city_name:city},
                success:function(data){
                    $("#response").html(data) ;
                }
            })
            
        }) ; 


    </script>

    </body>
</html>