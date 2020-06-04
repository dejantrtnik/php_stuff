// insert
$sql = "SELECT * FROM ip_visitors_all ";
$result = mysqli_query($conn, $sql);
$array = mysqli_fetch_all($result);

  if (isset($_GET['db_push_blacklist']) == true)
  {
    $id = $_GET['id'];
    $ip = $_GET['ip'];
    $date =  $_GET['date'];
    $query="INSERT INTO ip_visitors_blacklist (id, ip_visitor, date_time) VALUES('$id', '$ip', '$date')";
    $result=mysqli_query($conn, $query);
    echo "Vnos vnešen";
  }

  if (isset($_GET['db_push_whitelist']) == true)
  {
    $id = $_GET['id'];
    $ip = $_GET['ip'];
    $date =  $_GET['date'];
    $query="INSERT INTO ip_visitors_whitelist (id, ip_visitor, date_time) VALUES('$id', '$ip', '$date')";
    $result=mysqli_query($conn, $query);
    echo "Vnos vnešen";
  }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <style media="screen">
    body{
      width: 1280px;
      height: 1024px;
      margin: 0 auto !important;
    }
    table.blueTable {
      border: 1px solid #1C6EA4;
      background-color: #EEEEEE;
      width: 40%;
      text-align: left;
      border-collapse: collapse;
    }
    table.blueTable td, table.blueTable th {
      border: 1px solid #AAAAAA;
      padding: 0px 4px;
    }
    table.blueTable tbody td {
      font-size: 13px;
    }
    table.blueTable tr:nth-child(even) {
      background: #D0E4F5;
    }
    table.blueTable thead {
      background: #1C6EA4;
      background: -moz-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
      background: -webkit-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
      background: linear-gradient(to bottom, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
      border-bottom: 2px solid #444444;
    }
    table.blueTable thead th {
      font-size: 15px;
      font-weight: bold;
      color: #FFFFFF;
      border-left: 2px solid #D0E4F5;
    }
    table.blueTable thead th:first-child {
      border-left: none;
    }
    input[type=text] {
      width: 10%;
      padding: 8px 10px;
      margin: 10px 10px;
      box-sizing: border-box;
    }
    </style>
    <script>
      function goBack()
      {
        window.history.back()
      }
    </script>
  </head>
  <body>
    <?php if(isset($_GET['vec']) && $_GET['vec'] >= 0):?>
      <?php
                                                      // select , če ip že obstaja
      //echo $visitorIP;
      //print_r($array[$_GET['vec']]['1']);
      $ip_visitor_pre = $array[$_GET['vec']]['1'];
      $sql_2 = "SELECT * FROM ip_visitors_blacklist WHERE ip_visitor = '$ip_visitor_pre'";
      $result_2 = mysqli_query($conn, $sql_2);
      $array_2 = mysqli_fetch_all($result_2);
      //print_r($array_2['0']['1']);
      if ($array_2['0']['1'] == true)
      {
        echo '<br>';
        echo '<span style="font-size:25px ;color:black">Zapisan v "blacklist" db: ' . $ip_visitor_pre  . '</span>';
      }
      else
      {
        echo '<br>';
        echo '<span style="font-size:25px; color:red">NI zapisa v "blacklist" db: </span>';
      }

      echo '<br>';

      $ip_visitor_pre_white = $array[$_GET['vec']]['1'];
      $sql_2 = "SELECT * FROM ip_visitors_whitelist WHERE ip_visitor = '$ip_visitor_pre_white'";
      $result_2 = mysqli_query($conn, $sql_2);
      $array_2 = mysqli_fetch_all($result_2);
      //print_r($array_2['0']['1']);
      if ($array_2['0']['1'] == true)
      {
        echo '<br>';
        echo '<span style="font-size:25px; color:blue">Zapisan v "whitelist" db: ' . $ip_visitor_pre_white  . '</span>';
      }
      else
      {
        echo '<br>';
        echo '<span style="font-size:25px; color:red">NI zapisa v "whitelist" db: </span>';
      }
?>
  <div class="">
    <h1>Vnos v podatkovno bazo</h1>
      <h2>BLACKLIST - zapis "sumljivih IP naslovov" v bazo podatkov</h2>
    <form class="" action="" method="GET">
      <label for="">id</label>
      <input type="text" name="id" value="<?= $array[$_GET['vec']]['0']; ?>">
      <label for="">ip naslov</label>
      <input type="text" name="ip" value="<?= $array[$_GET['vec']]['1']; ?>">
      <label for="">Datum in čas</label>
      <input type="text" name="date" value="<?= $array[$_GET['vec']]['2']; ?>"><br>
      <input type="submit" name="db_push_blacklist" value="Potrdi vnos - blacklist"></input>
    </form>
    <form class="" action="" method="GET">
      <h2>WHITELIST - zapis "znanih IP naslovov" v bazo podatkov</h2>
      <label for="">id</label>
      <input type="text" name="id" value="<?= $array[$_GET['vec']]['0']; ?>">
      <label for="">ip naslov</label>
      <input type="text" name="ip" value="<?= $array[$_GET['vec']]['1']; ?>">
      <label for="">Datum in čas</label>
      <input type="text" name="date" value="<?= $array[$_GET['vec']]['2']; ?>"><br>
      <input type="submit" name="db_push_whitelist" value="Potrdi vnos - whitelist"></input>
    </form><br>
    <p><button onclick="goBack()">Go Back</button> <span>Vrni se na izpis BLACKLIST-e</span></p>
    <p>Podrobni podatki o IP naslovu:</p>
    <?php
    $ip_vec = $array[$_GET['vec']]['1'];
    //print_r($ip_vec);
    $geoPlugin_array = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $ip_vec) );
    echo '<pre>';
    echo 'IP naslov                : ' . $geoPlugin_array['geoplugin_request'] .  '<br>';
    echo 'pcntl_wexitstatus        : ' . $geoPlugin_array['geoplugin_status'] .  '<br>';
    echo 'Delay                    : ' . $geoPlugin_array['geoplugin_delay'] .  '<br>';
    //echo 'Credit                   : ' . $geoPlugin_array['geoplugin_credit'] .  '<br>';
    echo 'City                     : ' . $geoPlugin_array['geoplugin_city'] .  '<br>';
    echo 'Region Code              : ' . $geoPlugin_array['geoplugin_regionCode'] .  '<br>';
    echo 'Region Name              : ' . $geoPlugin_array['geoplugin_regionName'] .  '<br>';
    echo 'Area Code                : ' . $geoPlugin_array['geoplugin_areaCode'] .  '<br>';
    echo 'DMA Code                 : ' . $geoPlugin_array['geoplugin_dmaCode'] .  '<br>';
    echo 'Country Code             : ' . $geoPlugin_array['geoplugin_countryCode'] .  '<br>';
    echo 'Country Name             : ' . $geoPlugin_array['geoplugin_countryName'] .  '<br>';
    echo 'In EU                    : ' . $geoPlugin_array['geoplugin_inEU'] .  '<br>';
    echo 'eu VAT rate              : ' . $geoPlugin_array['geoplugin_euVATrate'] .  '<br>';
    echo 'Continent Code           : ' . $geoPlugin_array['geoplugin_continentCode'] .  '<br>';
    echo 'Continent Name           : ' . $geoPlugin_array['geoplugin_continentName'] .  '<br>';
    echo 'latitude                 : ' . $geoPlugin_array['geoplugin_latitude'] .  '<br>';
    echo 'longitude                : ' . $geoPlugin_array['geoplugin_longitude'] .  '<br>';
    echo 'location Accuracy Radius : ' . $geoPlugin_array['geoplugin_locationAccuracyRadius'] .  '<br>';
    echo 'Timezone                 : ' . $geoPlugin_array['geoplugin_timezone'] .  '<br>';
    echo 'Currency Code            : ' . $geoPlugin_array['geoplugin_currencyCode'] .  '<br>';
    echo 'Currency Symbol          : ' . $geoPlugin_array['geoplugin_currencySymbol'] .  '<br>';
    echo 'Currency Symbol_UTF8     : ' . $geoPlugin_array['geoplugin_currencySymbol_UTF8'] .  '<br>';
    echo 'Currency Converter       : ' . $geoPlugin_array['geoplugin_currencyConverter'] .  '<br>';

    ?>
    <?php else :?>
    <h2>Obiski</h2>
    <pre> <a href="http://193.77.83.59/">Spletni projekti</a></pre>
    <table class="blueTable">
      <thead class="blueTable">
        <tr>
          <th>zap.št.</th>
          <th>Id</th>
          <th>IP naslov</th>
          <th>Datum - Čas</th>
        </tr>
      </thead>
    <?php foreach ($array as $index => $var):?>
        <tr>
          <th><?= $index + 1;?></th>
          <th><font color=""><?= $var['0']; ?></font></th>
          <?php if ($var['1'] == $visitor_IP):
          {?>
            <th><a class="button_red" href="add_ip.php?vec=<?= $index; ?>"><font color="red"><?= $var['1']; ?></a></th>
    <?php } ?>
    <?php else: ?>
          <th><a class="button_red" href="add_ip.php?vec=<?= $index; ?>"><font color=""><?= $var['1']; ?></a></th>
    <?php endif; ?>
          <th><?= $var['2'];?></th>
        </tr>
    <?php endforeach; ?>
    <?php endif; ?>
    </div>
  </body>
</html>
