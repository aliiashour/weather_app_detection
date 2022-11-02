<?php
    // echo '<div class="response col-12">good</div>' ; 

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        if(isset($_REQUEST['city_name']) && !empty($_REQUEST['city_name'])){


            // here i should use api to get the data
            $city_name = htmlspecialchars(strip_tags($_REQUEST['city_name'])) ; 
            $user_ip = htmlspecialchars(strip_tags($_REQUEST['user_ip'])) ; 
            $url = "https://api.openweathermap.org/data/2.5/weather?q=" . $city_name . "&appid=5479b525d0c9cbf27819af76396bbdf4" ; 

            $ch = curl_init() ; 
            curl_setopt($ch, CURLOPT_URL, $url) ; 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; 
            $res  = curl_exec($ch) ; 
            curl_close($ch) ; 
        
            
            $data = json_decode($res, true) ; 

            if(isset($data['weather'])){
            
                // first i should structure the design of result
                $country_name = $data['sys']['country'] ; 
                $temp = $data['main']['temp'] -273.15; 
                $min_temp = $data['main']['temp_min'] -273.15; 
                $max_temp = $data['main']['temp_max'] -273.15 ; 
                $wind_speed = $data['wind']['speed'] . "Km/h" ; 
                $weather_desc = $data['weather'][0]['description'] ; 
                $cloud = $data['clouds']['all'] ; 
                
                $res = '
                <div class="response col-8">
                    <div class="row justify-content-space-between">
                        <div class="col-6">
                            <h3>' . $country_name . ", " . $city_name . '</h3>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-12 text-end">
                                    <i class="fa-solid fa-arrow-down"></i>
                                    ' . $min_temp . '&deg; | <i class="fa-solid fa-arrow-up"></i>
                                    ' . $max_temp .'&deg;
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-space-between">

                        <div class="col-6">
                            <h6>' . date('l') . '</h6>
                            <p>' . date('m/d/Y') . '</p>
                            <p> ' . $weather_desc . '</p>
                            <p>Wind ' . $wind_speed . '</p>
                        </div>
                        <div class="col-6 text-end">
                            <h5>Current Tempreature ' . $temp . '&deg;</h5>
                            <p>Cloud Rate '. $cloud .'</p>
                        </div>

                    </div>
                </div>' ; 
            }else{
                $res ='<div class="col-12">this city is not defined</div>' ; 
            }

            echo $res ;    
        }

    }else{
        echo '<div class="response alert alert-danger col-12">you are\'t allowed to be here</div>' ; 
    }
