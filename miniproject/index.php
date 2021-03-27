<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-light bg-info justify-content-between ps-4 pe-4">
            <a class="navbar-brand" href="index.php">AB6IX ALBUM</a>
            <div>
                <a href="index.php">Home</a>|
                <a href="#">Favorites</a>
            </div>
        </nav>

        <div class="row mt-5 justify-content-center">
            <div class="col-md-5">
                <form action="index.php" method="get">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search for beers..." name="searchtext">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>
            <p class="text-center" id="found-info"></p>
        </div>

        <div class="row mt-2 ms-4 me-4">

            <?php

            $url = "./products.json";
            $response = file_get_contents($url);
            $result = json_decode($response);
            $found = 0;

            if (!empty($_GET['searchtext'])) {
                $searchtext = $_GET['searchtext'];
                foreach ($result->products as $item){
                    $albumImg = $item->img;
                    $albumName = $item->name;
                    $des = $item->des;
                    $artistName = $item->artistName;
                    $price = $item->price;

                    if ((strpos($albumName, $searchtext) !== FALSE) || (strpos($des, $searchtext) !== FALSE)){
                        showalbum($albumImg, $albumName, $des, $artistName, $price);
                        $found++;
                    }
                }
            }
            else {
                //first time web load or doesn't enter word to find
                foreach ($result->products as $item){
                    $albumImg = $item->img;
                    $albumName = $item->name;
                    $des = $item->des;
                    $artistName = $item->artistName;
                    $price = $item->price;

                    showalbum($albumImg, $albumName, $des, $artistName, $price);
                }
            }

            if ($found > 0){
                echo "<script>document.getElementById('found-info').innerHTML = 'ค้นพบทั้งหมด: " . $found . " รายการ';</script>";
            }
            else if (!empty($_GET['searchtext']) && !$found) {
                echo "<script>document.getElementById('found-info').innerHTML = 'Not Found...';</script>";
            }

            function showalbum($img, $albumName, $des, $artistName, $price){
                echo '
                    <div class="col-lg-4 col-md-6 mt-3 ">
                        <div class="card h-100">
                            <div class="row g-0">
                                <div class="col-md-4 d-flex align-items-center">
                                    <img class="img-fluid" src="' . $img . '">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">' . $albumName . '</h5>
                                        <p><b>Des:</b> ' . $des . '</p>
                                        <p><b>Artist:</b> ' . $artistName . '</p>
                                        <p><b>Price:</b> ' . $price . '</p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';
            }
            
        ?>
        </div>
    </div>

</body>

</html>