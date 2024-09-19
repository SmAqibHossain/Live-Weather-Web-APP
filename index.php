<?php


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&display=swap" rel="stylesheet"> -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="indexStyle.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body class="container">

    <header>
        <h1>Welcome to weather app</h1>


        <form action="" method="post">
            <div class="container text-center">

                <div class="row">

                    <div class="col-xxxl-8">
                        <input type="text" id="cityInput" name="city" placeholder="Type city name here" style="text-align: center;">
                    </div>
                    <div class="col-xxxl-3" id="radio_choice">

                        <input type="radio" id="imperial" name="unit" value="imperial">
                        <label for="imperial">Imperial</label>

                        <input type="radio" id="metric" name="unit" value="metric">
                        <label for="metric">Metric</label>

                        <input type="radio" id="standard" name="unit" value="standard">
                        <label for="standard">Standard</label>
                    </div>
                    <div class="col-xxxl-1">
                        <!-- <button type="submit" value="submit" class="btn btn-light btn-lg btn-block"> Submit </button> -->
                        <button class="btn btn-light" type="submit" value="submit" id="button">Get info!</button>
                    </div>


                </div>
            </div>
        </form>



        <?php
        if (isset($_POST['unit'])) {
            $chosenUnit = $_POST['unit'];
        }
        // } else {
        //     $chosenUnit = 'standard';
        // }


        if (isset($_POST['city'])) {
            $chosenCity = $_POST['city'];
        }
        $url = "https://api.openweathermap.org/data/2.5/forecast?q=" . $chosenCity . "&appid=e3bc9d1e92afe12accae799af3de8496&units=" . $chosenUnit . "";


        $contents = file_get_contents($url);
        $clima = json_decode($contents);
        $city_name = $clima->city->name;




        // function convert_time($dt_str)
        // {
        //   $dt = datetime::createFromFormat('Y-m-d H:i:s', $dt_str);
        //   return $dt->format('Y-m-d g:i A');
        // }
        function convertDateAndTime($dtStr)
        {
            $dateTime = new DateTime($dtStr);
            $dayName = $dateTime->format('l');
            $convertedTime = $dateTime->format('Y-m-d g:i A');
            return array($convertedTime, $dayName);
        }




        ?>

        <h2>Details for <?= $city_name ?> in <?= $chosenUnit ?> unit </h2>
    </header>

    <main>
        <table class="table">
            <thead>
                <tr>
                    <!-- <th scope="col">Number</th> -->
                    <!-- <th scope="col">Cloud-ALL</th> -->
                    <th scope="col">Index</th>
                    <th scope="col">Time</th>
                    <th scope="col">
                        <?php if ($chosenUnit == "metric") {
                        ?>temperature(°C)<?php } ?>
                        <?php if ($chosenUnit == "imperial") {
                        ?>temperature(°F)<?php } ?>
                        <?php if ($chosenUnit == "standard") {
                        ?>temperature(K)<?php } ?>
                    </th>
                    <th scope="col">Feels like</th>
                    <th scope="col">Temp-min</th>
                    <th scope="col">Temp-max</th>
                    <th scope="col">Weather Condition</th>
                    <th scope="col">Weather Description</th>

                </tr>
            </thead>
            <tbody>

                <?php
                $i = 1;
                foreach ($clima->list as $list) {
                    list($convertedTime, $dayName) = convertDateAndTime($list->dt_txt);
                    // $tempIcon = "https://openweathermap.org/img/w/{$data['weather'][0]['icon']}.png"; 
                ?>
                    <tr>

                        <th><?= $i++ ?></th>
                        <td><?= $dayName . " " . $convertedTime  ?></td>
                        <td><?= $list->main->temp ?></td>
                        <td><?= $list->main->feels_like ?></td>
                        <td><?= $list->main->temp_min ?></td>
                        <td><?= $list->main->temp_max ?></td>

                        <?php foreach ($list->weather as $weather) { ?>

                            <td><?= $weather->main ?></td>
                            <td> <img class="weather-icon" src="https://openweathermap.org/img/w/<?= $weather->icon ?>.png" alt="Temperature Icon"><?= $weather->description ?> </td>

                        <?php } ?>

                    </tr>
                <?php } ?>
                <!-- <tr>
        <th scope="row">1</th>
        <td>Mark</td>
        <td>Otto</td>
        <td>@mdo</td>
      </tr> -->

            </tbody>



        </table>
    </main>
    <footer>
        <p> <a style="text-decoration: none; color: black;"> Designed </a> by <span id="name">SM
                Aqib
                Hossain</span></p>

    </footer>
</body>

</html>