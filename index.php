<?php

include_once 'vendor/autoload.php';

use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;

function countries_select() {
    global $countries_srz;

    $ip = get_ip_address();
    $html = '';
    $countries = unserialize($countries_srz);

    try {
        $geoip_reader = new Reader("country.mmdb");
        $geoip_record = $geoip_reader->country($ip);

        $country = $geoip_record->country->isoCode;

    } catch (\MaxMind\Db\Reader\InvalidDatabaseException $e) {
        $country = 'RU';
    } catch (AddressNotFoundException $e) {
        $country = 'RU';
    } catch(InvalidArgumentException $e) {
        $country = 'RU';
    }

    foreach($countries as $country_lt) {
        $selected = $country == $country_lt['country'] ? ' selected' : '';

        $html .= "<option{$selected} value=\"{$country_lt['aim_n']}\">{$country_lt['name']}</option>";
    }

    return $html;
}

function get_ip_address() {
    return preg_replace("|[^0-9.]|", "", get_ip());
}

function get_ip() {
    if (!empty($_SERVER['HTTP_X_PARKING']) && validate_ip($_SERVER['HTTP_X_PARKING'])) {
        return $_SERVER['HTTP_X_PARKING'];
    }

    // check for shared internet/ISP IP
    if (!empty($_SERVER['HTTP_CLIENT_IP']) && validate_ip($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }

    // check for IPs passing through proxies
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // check if multiple ips exist in var
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
            $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($iplist as $ip) {
                $ip = trim($ip);
                if (validate_ip($ip))
                    return $ip;
            }
        } else {
            if (validate_ip($_SERVER['HTTP_X_FORWARDED_FOR']))
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED']) && validate_ip($_SERVER['HTTP_X_FORWARDED']))
        return $_SERVER['HTTP_X_FORWARDED'];
    if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
        return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && validate_ip($_SERVER['HTTP_FORWARDED_FOR']))
        return $_SERVER['HTTP_FORWARDED_FOR'];
    if (!empty($_SERVER['HTTP_FORWARDED']) && validate_ip($_SERVER['HTTP_FORWARDED']))
        return $_SERVER['HTTP_FORWARDED'];

    // return unreliable ip since all else failed
    return $_SERVER['REMOTE_ADDR'];
}

/**
 * Ensures an ip address is both a valid IP and does not fall within
 * a private network range.
 */
function validate_ip($ip) {
    if (strtolower($ip) === 'unknown')
        return false;

    // generate ipv4 network address
    $ip = ip2long($ip);

    // if the ip is set and not equivalent to 255.255.255.255
    if ($ip !== false && $ip !== -1) {
        // make sure to get unsigned long representation of ip
        // due to discrepancies between 32 and 64 bit OSes and
        // signed numbers (ints default to signed in PHP)
        $ip = sprintf('%u', $ip);
        // do private network range checking
        if ($ip >= 167772160 && $ip <= 184549375) return false;
        if ($ip >= 2130706432 && $ip <= 2147483647) return false;
        if ($ip >= 2851995648 && $ip <= 2852061183) return false;
        if ($ip >= 2886729728 && $ip <= 2887778303) return false;
        if ($ip >= 3221225984 && $ip <= 3221226239) return false;
        if ($ip >= 3232235520 && $ip <= 3232301055) return false;
        if ($ip >= 4294967040) return false;
    }
    return true;
}
$countries_srz = 'a:1:{i:0;a:3:{s:5:"aim_n";i:1;s:7:"country";s:2:"RU";s:4:"name";s:12:"Россия";}}';
?>

<!-- Подключеие к офферу -->

<!DOCTYPE html>
<html lang="ru-RU">
  <head>
    <meta charset="utf-8" />

    <title>Женские платья больших размеров</title>
    <meta name="description" content="Женские платья больших размеров" />

    <meta name="viewport" content="width=device-width" />
    <link rel="icon" type="image/png" href="favicon.html" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- <script src="../cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous"></script> -->
    <!-- <link rel="stylesheet" href="assets_pages/land/js/slider/owlCarousel-2.2.1/owl.carousel.min.js" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous" />
    <link rel="stylesheet" href="assets_pages/land/js/slider/owlCarousel-2.2.1/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous" />
    <link rel="stylesheet" href="assets_pages/land/js/slider/owlCarousel-2.2.1/assets/owl.theme.default.css" integrity="sha512-OTcub78R3msOCtY3Tc6FzeDJ8N9qvQn1Ph49ou13xgA9VsH9+LRxoFU6EqLhW4+PKRfU+/HReXmSZXHEkpYoOA==" crossorigin="anonymous" /> -->
    <!-- <link rel="stylesheet" href="assets_pages/land/fonts/MuseoSans/MuseoSans.css"> -->
    <link rel="stylesheet" href="css/owl.carousel.min.css" />
    <link rel="stylesheet" href="css/jquery.fancybox.min.css" />
    <link rel="stylesheet" href="css/fonts.css" />
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" href="css/media.css" />

    <script type="text/javascript" src="js/landing_valid_form.js"></script>
    <script type="text/javascript" src="js/landing_script.js"></script>
    <script type="text/javascript">
      $jsonData = {"1":{"currency":" \u0440\u0443\u0431.","productsum":"1390.00","oldproductsum":"3980.00","delivery":0,"totalsum":"1390.00"}}
    </script>

    <style>
      .ajax_loader {
        display: none;
      }
    </style>
  
</head>

  <body class="main-body">
    <section class="main-section">
      <div class="container">
        <header>
          <div class="logo">
            <a href="#"><img src="img/logo.png" alt="" /></a>
          </div>
          <div class="header-wrapper">
            <ul class="header-menu">
              <li><a class="ollia1 js-scroll" href="#can">Описание</a></li>
              <li>
                <a class="ollia2 js-scroll" href="#advantages"
                  >Характеристики</a
                >
              </li>
              <li><a class="ollia3 js-scroll" href="#warranty">Гарантия</a></li>
              <li><a class="ollia4 js-scroll" href="#reviews">Отзывы</a></li>
            </ul>
          </div>
        </header>
        <div class="main-content">
          <div class="main-title">
            <h1>Эксклюзивные вещи <br />от лучших европейских брендов!</h1>
          </div>
          <div class="main-subtitle">Суперраспродажа остатков!</div>
          <div class="main-oldprices">
            <div class="main-old oldproductsum"></div>
            <div class="main-new productsum"></div>
            <div class="main-btn">
              <a href="#catalog" class="popup-link_ js-scroll"
                >Смотреть каталог</a
              >
            </div>
          </div>
        </div>
      </div>
    </section>

    <div class="wrapper" id="catalog">
      <section class="catalog_section">
        <div class="container">
          <script src="js/date.min.js" crossorigin="anonymous"></script>
          <script>
            $(document).ready(function () {
              date = Date.today().addDays(-7);
              date_2 = Date.today();

              date = date.toString("dd.MM.yyyy");
              date_2 = date_2.toString("dd.MM.yyyy");

              $(".date_1").html(date);
              $(".date_2").html(date_2);
            });
          </script>
          <div class="catalog-subtitle">
            АКЦИЯ! СКИДКИ ДО 65% <span class="date_1">03.12.2020</span> -
            <span class="date_2">10.12.2020</span>! <br />
            Эксклюзивная коллекция женских платьев «Осень-зима 2021»
          </div>
          <div class="products_list clearfix">
            <script>
              $(document).ready(function () {
                $(".item_slider").owlCarousel({
                  loop: true,
                  margin: 10,
                  nav: true,
                  responsive: {
                    0: {
                      items: 1,
                    },
                    600: {
                      items: 1,
                    },
                    1000: {
                      items: 1,
                    },
                  },
                });
                $(".art_button").click(function () {
                  var art = $(this).parent().find('.vendor_code').find(".art").text();
                  $(".descr").val(art);
                });
              });
            </script>
            <style>
              .ajax_loader {
                display: none;
              }
              .product_item .owl-carousel .owl-nav .owl-next {
                position: absolute;
                right: 0;
                top: 40%;
                outline: none;
                background: url("next.svg") center center / contain no-repeat !important;
                padding: 15px !important;
                color: transparent;
              }
              .product_item .owl-carousel .owl-nav .owl-next span {
                display: none;
              }
              .product_item .owl-carousel .owl-nav .owl-prev {
                position: absolute;
                color: transparent;
                left: 0;
                outline: none;
                top: 40%;
                transform: rotate(180deg);
                background: url("next.svg") center center / contain no-repeat !important;
                padding: 15px !important;
              }
              .product_item .owl-carousel .owl-nav .owl-prev span {
                display: none;
              }
            </style>

            <div class="product_item">
              <div class="img">
                <div class="item_slider owl-carousel owl-theme">
                  <a href="catalog/1.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/1.jpg"
                      src="./catalog/1.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>

                  <a href="catalog/1_2.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/1_2.jpg"
                      src="./catalog/1_2.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                </div>
              </div>
              <div class="content">
                <div class="name">Платье</div>
                <div class="vendor_code">
                  <b>Артикул</b>: <span class="art">3105</span>
                </div>

                <p class="pm vendor_code material" style="display: none; color: #222">
                  <b>Материал</b>: 65% вискоза 30% п-р 5% лайкра
                </p>

                <!-- <p class="pm vendor_code color" style="color: #222;" >
                                    <b style="margin-bottom: 5px; display: inline-block;">Цвета:</b><br> Омбре(какао), <br />Блэк(темно-бирюзовый)
                                </p> -->

                <div style="color: #222" class="vendor_code">
                  <b>Доставка без предоплаты</b>
                </div>
                <div style="color: #222" class="vendor_code">
                  <b>Обмен / возврат</b>: 14 дней
                </div>

                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3780</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>
                <div class="button art_button" art="2101">Заказать</div>
              </div>
              <div class="hidden">
                <div class="close"></div>
                <div class="action">
                  <span>Оставьте заявку</span>
                  <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                </div>
                <div class="name">Платье</div>
                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3780</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>

                <form class="lt-form main-order-form order_form" action="/success/" method="post">
                  <select style="display: none;" name="aim" class="countryselect"><option value='1'>Россия</option></select>
                  <input type="text" name="name" class="field input" placeholder="Ваше Имя" value="">
                  <input type="text" name="phone" class="field input" placeholder="Ваш телефон" value="">
                  <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="delivery" value="0 руб." />
                  <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="user" value="1" />
                  <input type="hidden" name="address" value="Уточнить у покупателя" /> 
                  <input type="hidden" name="description" class="descr" value=""/>

                  <div class="reolader">
                    <button class="button mm_button" >Заказать</button>
                    <div class="ajax_loader_block">
                      <img class="ajax_loader" src="img/ajax-loader.gif" alt="Идет отправка данных"/>
                      <span class="ajax_loader">Идет отправка данных</span>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="product_item">
              <div class="img">
                <div class="item_slider owl-carousel owl-theme">
                  <a href="catalog/2.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/2.jpg"
                      src="images/prev.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>

                  <a href="catalog/2_2.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/2_2.jpg"
                      src="images/prev.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                </div>
              </div>
              <div class="content">
                <div class="name">Платье</div>
                <div class="vendor_code">
                  <b>Артикул</b>: <span class="art">3106</span>
                </div>
                <p class="pm vendor_code material" style="display: none; color: #222">
                  <b>Материал</b>: 65% вискоза 30% полиэстер 5% лайкра
                </p>
                <!-- <p class="pm vendor_code color" style="color: #222;" >
                   <b style="margin-bottom: 5px; display: inline-block;">Цвета:</b><br>Пастелевый (золотисто-черный),<br />
                    (темно-синий)
                  </p> -->

                <div style="color: #222" class="vendor_code">
                  <b>Доставка без предоплаты</b>
                </div>
                <div style="color: #222" class="vendor_code">
                  <b>Обмен / возврат</b>: 14 дней
                </div>

                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3290</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>
                <div class="button art_button" art="2102">Заказать</div>
              </div>
              <div class="hidden">
                <div class="close"></div>
                <div class="action">
                  <span>Оставьте заявку</span>
                  <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                </div>
                <div class="name">Платье</div>
                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3290</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>

                <form class="lt-form main-order-form order_form" action="/success/" method="post">
                  <select style="display: none;" name="aim" class="countryselect"><option value='1'>Россия</option></select>
                  <input type="text" name="name" class="field input" placeholder="Ваше Имя" value="">
                  <input type="text" name="phone" class="field input" placeholder="Ваш телефон" value="">
                  <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="delivery" value="0 руб." />
                  <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="user" value="1" />
                  <input type="hidden" name="address" value="Уточнить у покупателя" /> 
                  <input type="hidden" name="description" class="descr" value=""/>

                  <div class="reolader">
                    <button class="button mm_button" >Заказать</button>
                    <div class="ajax_loader_block">
                      <img class="ajax_loader" src="img/ajax-loader.gif" alt="Идет отправка данных"/>
                      <span class="ajax_loader">Идет отправка данных</span>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="product_item">
              <div class="img">
                <div class="item_slider owl-carousel owl-theme">
                  <a href="catalog/3.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/3.jpg"
                      src="images/prev.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                  <a href="catalog/3_2.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/3_2.jpg"
                      src="images/prev.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                </div>
              </div>
              <div class="content">
                <div class="name">Платье</div>
                <div class="vendor_code">
                  <b>Артикул</b>: <span class="art">3107</span>
                </div>
                <p class="pm vendor_code material" style="display: none; color: #222">
                  <b>Материал</b>: 60% вискоза 40% полиэстер
                </p>
                <!-- <p class="pm vendor_code color" style="color: #222;" >
                   <b style="margin-bottom: 5px; display: inline-block;">Цвета:</b><br>Аврора(серо-белый),<br />
                    Графит(шоколадный)
                  </p> -->

                <div style="color: #222" class="vendor_code">
                  <b>Доставка без предоплаты</b>
                </div>
                <div style="color: #222" class="vendor_code">
                  <b>Обмен / возврат</b>: 14 дней
                </div>

                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3780</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>
                <div class="button art_button" art="2103">Заказать</div>
              </div>
              <div class="hidden">
                <div class="close"></div>
                <div class="action">
                  <span>Оставьте заявку</span>
                  <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                </div>
                <div class="name">Платье</div>
                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3780</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>

                <form class="lt-form main-order-form order_form" action="/success/" method="post">
                  <select style="display: none;" name="aim" class="countryselect"><option value='1'>Россия</option></select>
                  <input type="text" name="name" class="field input" placeholder="Ваше Имя" value="">
                  <input type="text" name="phone" class="field input" placeholder="Ваш телефон" value="">
                  <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="delivery" value="0 руб." />
                  <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="user" value="1" />
                  <input type="hidden" name="address" value="Уточнить у покупателя" /> 
                  <input type="hidden" name="description" class="descr" value=""/>

                  <div class="reolader">
                    <button class="button mm_button" >Заказать</button>
                    <div class="ajax_loader_block">
                      <img class="ajax_loader" src="img/ajax-loader.gif" alt="Идет отправка данных"/>
                      <span class="ajax_loader">Идет отправка данных</span>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="product_item">
              <div class="img">
                <div class="item_slider owl-carousel owl-theme">
                  <a href="catalog/4.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/4.jpg"
                      src="./catalog/4.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                  <a href="catalog/4_2.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/4_2.jpg"
                      src="images/prev.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                </div>
              </div>
              <div class="content">
                <div class="name">Платье</div>
                <div class="vendor_code">
                  <b>Артикул</b>: <span class="art">3108</span>
                </div>

                <p class="pm vendor_code material" style="display: none; color: #222">
                  <b>Материал</b>: 65% вискоза 30% полиэстер 5% лайкра
                </p>

                <!-- <p class="pm vendor_code color" style="color: #222;" >
                                      <b style="margin-bottom: 5px; display: inline-block;">Цвета:</b><br> Омбре(какао), <br />Блэк(темно-бирюзовый)
                                  </p> -->

                
                <div style="color: #222" class="vendor_code">
                  <b>Доставка без предоплаты</b>
                </div>
                <div style="color: #222" class="vendor_code">
                  <b>Обмен / возврат</b>: 14 дней
                </div>

                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3450</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>
                <div class="button art_button" art="2101">Заказать</div>
              </div>
              <div class="hidden">
                <div class="close"></div>
                <div class="action">
                  <span>Оставьте заявку</span>
                  <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                </div>
                <div class="name">Платье</div>
                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3450</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>

                <form class="lt-form main-order-form order_form" action="/success/" method="post">
                  <select style="display: none;" name="aim" class="countryselect"><option value='1'>Россия</option></select>
                  <input type="text" name="name" class="field input" placeholder="Ваше Имя" value="">
                  <input type="text" name="phone" class="field input" placeholder="Ваш телефон" value="">
                  <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="delivery" value="0 руб." />
                  <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="user" value="1" />
                  <input type="hidden" name="address" value="Уточнить у покупателя" /> 
                  <input type="hidden" name="description" class="descr" value=""/>

                  <div class="reolader">
                    <button class="button mm_button" >Заказать</button>
                    <div class="ajax_loader_block">
                      <img class="ajax_loader" src="img/ajax-loader.gif" alt="Идет отправка данных"/>
                      <span class="ajax_loader">Идет отправка данных</span>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="product_item">
              <div class="img">
                <div class="item_slider owl-carousel owl-theme">
                  <a href="catalog/5.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/5.jpg"
                      src="./catalog/5.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                  <a href="catalog/5_2.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/5_2.jpg"
                      src="images/prev.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                </div>
              </div>
              <div class="content">
                <div class="name">Платье</div>
                <div class="vendor_code">
                  <b>Артикул</b>: <span class="art">3109</span>
                </div>

                <p class="pm vendor_code material" style="display: none; color: #222">
                  <b>Материал</b>: 60% вискоза 35% полиэстер 5% лайкра
                </p>

                <!-- <p class="pm vendor_code color" style="color: #222;" >
                                      <b style="margin-bottom: 5px; display: inline-block;">Цвета:</b><br> Омбре(какао), <br />Блэк(темно-бирюзовый)
                                  </p> -->

                
                <div style="color: #222" class="vendor_code">
                  <b>Доставка без предоплаты</b>
                </div>
                <div style="color: #222" class="vendor_code">
                  <b>Обмен / возврат</b>: 14 дней
                </div>

                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3290</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>
                <div class="button art_button" art="2101">Заказать</div>
              </div>
              <div class="hidden">
                <div class="close"></div>
                <div class="action">
                  <span>Оставьте заявку</span>
                  <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                </div>
                <div class="name">Платье</div>
                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3290</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>

                <form class="lt-form main-order-form order_form" action="/success/" method="post">
                  <select style="display: none;" name="aim" class="countryselect"><option value='1'>Россия</option></select>
                  <input type="text" name="name" class="field input" placeholder="Ваше Имя" value="">
                  <input type="text" name="phone" class="field input" placeholder="Ваш телефон" value="">
                  <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="delivery" value="0 руб." />
                  <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="user" value="1" />
                  <input type="hidden" name="address" value="Уточнить у покупателя" /> 
                  <input type="hidden" name="description" class="descr" value=""/>

                  <div class="reolader">
                    <button class="button mm_button" >Заказать</button>
                    <div class="ajax_loader_block">
                      <img class="ajax_loader" src="img/ajax-loader.gif" alt="Идет отправка данных"/>
                      <span class="ajax_loader">Идет отправка данных</span>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="product_item">
              <div class="img">
                <div class="item_slider owl-carousel owl-theme">
                  <a href="catalog/6.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/6.jpg"
                      src="./catalog/6.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                  <a href="catalog/6_2.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/6_2.jpg"
                      src="images/prev.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                </div>
              </div>
              <div class="content">
                <div class="name">Платье</div>
                <div class="vendor_code">
                  <b>Артикул</b>: <span class="art">3110</span>
                </div>

                <p class="pm vendor_code material" style="display: none; color: #222">
                  <b>Материал</b>: 100% хлопок
                </p>

                <!-- <p class="pm vendor_code color" style="color: #222;" >
                                      <b style="margin-bottom: 5px; display: inline-block;">Цвета:</b><br> Омбре(какао), <br />Блэк(темно-бирюзовый)
                                  </p> -->

                
                <div style="color: #222" class="vendor_code">
                  <b>Доставка без предоплаты</b>
                </div>
                <div style="color: #222" class="vendor_code">
                  <b>Обмен / возврат</b>: 14 дней
                </div>

                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3780</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>
                <div class="button art_button" art="2101">Заказать</div>
              </div>
              <div class="hidden">
                <div class="close"></div>
                <div class="action">
                  <span>Оставьте заявку</span>
                  <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                </div>
                <div class="name">Платье</div>
                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3780</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>

                <form class="lt-form main-order-form order_form" action="/success/" method="post">
                  <select style="display: none;" name="aim" class="countryselect"><option value='1'>Россия</option></select>
                  <input type="text" name="name" class="field input" placeholder="Ваше Имя" value="">
                  <input type="text" name="phone" class="field input" placeholder="Ваш телефон" value="">
                  <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="delivery" value="0 руб." />
                  <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="user" value="1" />
                  <input type="hidden" name="address" value="Уточнить у покупателя" /> 
                  <input type="hidden" name="description" class="descr" value=""/>

                  <div class="reolader">
                    <button class="button mm_button" >Заказать</button>
                    <div class="ajax_loader_block">
                      <img class="ajax_loader" src="img/ajax-loader.gif" alt="Идет отправка данных"/>
                      <span class="ajax_loader">Идет отправка данных</span>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="product_item">
              <div class="img">
                <div class="item_slider owl-carousel owl-theme">
                  <a href="catalog/7.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/7.jpg"
                      src="./catalog/7.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                  <a href="catalog/7_2.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/7_2.jpg"
                      src="images/prev.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                </div>
              </div>
              <div class="content">
                <div class="name">Платье</div>
                <div class="vendor_code">
                  <b>Артикул</b>: <span class="art">3111</span>
                </div>

                <p class="pm vendor_code material" style="display: none; color: #222">
                  <b>Материал</b>: 70% полиэстер 30% вискоза
                </p>

                <!-- <p class="pm vendor_code color" style="color: #222;" >
                                      <b style="margin-bottom: 5px; display: inline-block;">Цвета:</b><br> Омбре(какао), <br />Блэк(темно-бирюзовый)
                                  </p> -->

                
                <div style="color: #222" class="vendor_code">
                  <b>Доставка без предоплаты</b>
                </div>
                <div style="color: #222" class="vendor_code">
                  <b>Обмен / возврат</b>: 14 дней
                </div>

                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3450</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>
                <div class="button art_button" art="2101">Заказать</div>
              </div>
              <div class="hidden">
                <div class="close"></div>
                <div class="action">
                  <span>Оставьте заявку</span>
                  <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                </div>
                <div class="name">Платье</div>
                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3450</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>

                <form class="lt-form main-order-form order_form" action="/success/" method="post">
                  <select style="display: none;" name="aim" class="countryselect"><option value='1'>Россия</option></select>
                  <input type="text" name="name" class="field input" placeholder="Ваше Имя" value="">
                  <input type="text" name="phone" class="field input" placeholder="Ваш телефон" value="">
                  <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="delivery" value="0 руб." />
                  <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="user" value="1" />
                  <input type="hidden" name="address" value="Уточнить у покупателя" /> 
                  <input type="hidden" name="description" class="descr" value=""/>

                  <div class="reolader">
                    <button class="button mm_button" >Заказать</button>
                    <div class="ajax_loader_block">
                      <img class="ajax_loader" src="img/ajax-loader.gif" alt="Идет отправка данных"/>
                      <span class="ajax_loader">Идет отправка данных</span>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="product_item">
              <div class="img">
                <div class="item_slider owl-carousel owl-theme">
                  <a href="catalog/8.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/8.jpg"
                      src="./catalog/8.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                  <a href="catalog/8_2.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/8_2.jpg"
                      src="images/prev.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                </div>
              </div>
              <div class="content">
                <div class="name">Платье</div>
                <div class="vendor_code">
                  <b>Артикул</b>: <span class="art">3112</span>
                </div>

                <p class="pm vendor_code material" style="display: none; color: #222">
                  <b>Материал</b>: 70% полиэстер 30% вискоза
                </p>

                <!-- <p class="pm vendor_code color" style="color: #222;" >
                                      <b style="margin-bottom: 5px; display: inline-block;">Цвета:</b><br> Омбре(какао), <br />Блэк(темно-бирюзовый)
                                  </p> -->

                
                <div style="color: #222" class="vendor_code">
                  <b>Доставка без предоплаты</b>
                </div>
                <div style="color: #222" class="vendor_code">
                  <b>Обмен / возврат</b>: 14 дней
                </div>

                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3450</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>
                <div class="button art_button" art="2101">Заказать</div>
              </div>
              <div class="hidden">
                <div class="close"></div>
                <div class="action">
                  <span>Оставьте заявку</span>
                  <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                </div>
                <div class="name">Платье</div>
                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3450</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>

                <form class="lt-form main-order-form order_form" action="/success/" method="post">
                  <select style="display: none;" name="aim" class="countryselect"><option value='1'>Россия</option></select>
                  <input type="text" name="name" class="field input" placeholder="Ваше Имя" value="">
                  <input type="text" name="phone" class="field input" placeholder="Ваш телефон" value="">
                  <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="delivery" value="0 руб." />
                  <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="user" value="1" />
                  <input type="hidden" name="address" value="Уточнить у покупателя" /> 
                  <input type="hidden" name="description" class="descr" value=""/>

                  <div class="reolader">
                    <button class="button mm_button" >Заказать</button>
                    <div class="ajax_loader_block">
                      <img class="ajax_loader" src="img/ajax-loader.gif" alt="Идет отправка данных"/>
                      <span class="ajax_loader">Идет отправка данных</span>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="product_item">
              <div class="img">
                <div class="item_slider owl-carousel owl-theme">
                  <a href="catalog/9.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/9.jpg"
                      src="./catalog/9.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                  <a href="catalog/9_2.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/9_2.jpg"
                      src="images/prev.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                </div>
              </div>
              <div class="content">
                <div class="name">Платье</div>
                <div class="vendor_code">
                  <b>Артикул</b>: <span class="art">3113</span>
                </div>

                <p class="pm vendor_code material" style="display: none; color: #222">
                  <b>Материал</b>: 70% полиэстер 25% вискоза 5% лайкра
                </p>

                <!-- <p class="pm vendor_code color" style="color: #222;" >
                                      <b style="margin-bottom: 5px; display: inline-block;">Цвета:</b><br> Омбре(какао), <br />Блэк(темно-бирюзовый)
                                  </p> -->

                
                <div style="color: #222" class="vendor_code">
                  <b>Доставка без предоплаты</b>
                </div>
                <div style="color: #222" class="vendor_code">
                  <b>Обмен / возврат</b>: 14 дней
                </div>

                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3780</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>
                <div class="button art_button" art="2101">Заказать</div>
              </div>
              <div class="hidden">
                <div class="close"></div>
                <div class="action">
                  <span>Оставьте заявку</span>
                  <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                </div>
                <div class="name">Платье</div>
                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3780</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>

                <form class="lt-form main-order-form order_form" action="/success/" method="post">
                  <select style="display: none;" name="aim" class="countryselect"><option value='1'>Россия</option></select>
                  <input type="text" name="name" class="field input" placeholder="Ваше Имя" value="">
                  <input type="text" name="phone" class="field input" placeholder="Ваш телефон" value="">
                  <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="delivery" value="0 руб." />
                  <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="user" value="1" />
                  <input type="hidden" name="address" value="Уточнить у покупателя" /> 
                  <input type="hidden" name="description" class="descr" value=""/>

                  <div class="reolader">
                    <button class="button mm_button" >Заказать</button>
                    <div class="ajax_loader_block">
                      <img class="ajax_loader" src="img/ajax-loader.gif" alt="Идет отправка данных"/>
                      <span class="ajax_loader">Идет отправка данных</span>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="product_item">
              <div class="img">
                <div class="item_slider owl-carousel owl-theme">
                  <a href="catalog/10.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/10.jpg"
                      src="./catalog/10.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                  <a href="catalog/10_2.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/10_2.jpg"
                      src="images/prev.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                </div>
              </div>
              <div class="content">
                <div class="name">Платье</div>
                <div class="vendor_code">
                  <b>Артикул</b>: <span class="art">3114</span>
                </div>

                <p class="pm vendor_code material" style="display: none; color: #222">
                  <b>Материал</b>: 60% вискоза 40% полиэстер
                </p>

                <!-- <p class="pm vendor_code color" style="color: #222;" >
                                      <b style="margin-bottom: 5px; display: inline-block;">Цвета:</b><br> Омбре(какао), <br />Блэк(темно-бирюзовый)
                                  </p> -->

                
                <div style="color: #222" class="vendor_code">
                  <b>Доставка без предоплаты</b>
                </div>
                <div style="color: #222" class="vendor_code">
                  <b>Обмен / возврат</b>: 14 дней
                </div>

                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3290</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>
                <div class="button art_button" art="2101">Заказать</div>
              </div>
              <div class="hidden">
                <div class="close"></div>
                <div class="action">
                  <span>Оставьте заявку</span>
                  <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                </div>
                <div class="name">Платье</div>
                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3290</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>

                <form class="lt-form main-order-form order_form" action="/success/" method="post">
                  <select style="display: none;" name="aim" class="countryselect"><option value='1'>Россия</option></select>
                  <input type="text" name="name" class="field input" placeholder="Ваше Имя" value="">
                  <input type="text" name="phone" class="field input" placeholder="Ваш телефон" value="">
                  <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="delivery" value="0 руб." />
                  <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="user" value="1" />
                  <input type="hidden" name="address" value="Уточнить у покупателя" /> 
                  <input type="hidden" name="description" class="descr" value=""/>

                  <div class="reolader">
                    <button class="button mm_button" >Заказать</button>
                    <div class="ajax_loader_block">
                      <img class="ajax_loader" src="img/ajax-loader.gif" alt="Идет отправка данных"/>
                      <span class="ajax_loader">Идет отправка данных</span>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="product_item">
              <div class="img">
                <div class="item_slider owl-carousel owl-theme">
                  <a href="catalog/11.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/11.jpg"
                      src="./catalog/11.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                  <a href="catalog/11_2.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/11_2.jpg"
                      src="images/prev.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                </div>
              </div>
              <div class="content">
                <div class="name">Платье</div>
                <div class="vendor_code">
                  <b>Артикул</b>: <span class="art">3115</span>
                </div>

                <p class="pm vendor_code material" style="display: none; color: #222">
                  <b>Материал</b>: 65% вискоза 30% полиэстер 5% лайкра
                </p>

                <!-- <p class="pm vendor_code color" style="color: #222;" >
                                      <b style="margin-bottom: 5px; display: inline-block;">Цвета:</b><br> Омбре(какао), <br />Блэк(темно-бирюзовый)
                                  </p> -->

                
                <div style="color: #222" class="vendor_code">
                  <b>Доставка без предоплаты</b>
                </div>
                <div style="color: #222" class="vendor_code">
                  <b>Обмен / возврат</b>: 14 дней
                </div>

                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3290</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>
                <div class="button art_button" art="2101">Заказать</div>
              </div>
              <div class="hidden">
                <div class="close"></div>
                <div class="action">
                  <span>Оставьте заявку</span>
                  <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                </div>
                <div class="name">Платье</div>
                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3290</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>

                <form class="lt-form main-order-form order_form" action="/success/" method="post">
                  <select style="display: none;" name="aim" class="countryselect"><option value='1'>Россия</option></select>
                  <input type="text" name="name" class="field input" placeholder="Ваше Имя" value="">
                  <input type="text" name="phone" class="field input" placeholder="Ваш телефон" value="">
                  <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="delivery" value="0 руб." />
                  <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="user" value="1" />
                  <input type="hidden" name="address" value="Уточнить у покупателя" /> 
                  <input type="hidden" name="description" class="descr" value=""/>

                  <div class="reolader">
                    <button class="button mm_button" >Заказать</button>
                    <div class="ajax_loader_block">
                      <img class="ajax_loader" src="img/ajax-loader.gif" alt="Идет отправка данных"/>
                      <span class="ajax_loader">Идет отправка данных</span>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="product_item">
              <div class="img">
                <div class="item_slider owl-carousel owl-theme">
                  <a href="catalog/12.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/12.jpg"
                      src="./catalog/12.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                  <a href="catalog/12_2.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/12_2.jpg"
                      src="images/prev.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                </div>
              </div>
              <div class="content">
                <div class="name">Платье</div>
                <div class="vendor_code">
                  <b>Артикул</b>: <span class="art">3116</span>
                </div>

                <p class="pm vendor_code material" style="display: none; color: #222">
                  <b>Материал</b>: 65% вискоза 30% полиэстер 5% лайкра
                </p>

                <!-- <p class="pm vendor_code color" style="color: #222;" >
                                      <b style="margin-bottom: 5px; display: inline-block;">Цвета:</b><br> Омбре(какао), <br />Блэк(темно-бирюзовый)
                                  </p> -->

                
                <div style="color: #222" class="vendor_code">
                  <b>Доставка без предоплаты</b>
                </div>
                <div style="color: #222" class="vendor_code">
                  <b>Обмен / возврат</b>: 14 дней
                </div>

                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3450</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>
                <div class="button art_button" art="2101">Заказать</div>
              </div>
              <div class="hidden">
                <div class="close"></div>
                <div class="action">
                  <span>Оставьте заявку</span>
                  <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                </div>
                <div class="name">Платье</div>
                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3980</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>

                <form class="lt-form main-order-form order_form" action="/success/" method="post">
                  <select style="display: none;" name="aim" class="countryselect"><option value='1'>Россия</option></select>
                  <input type="text" name="name" class="field input" placeholder="Ваше Имя" value="">
                  <input type="text" name="phone" class="field input" placeholder="Ваш телефон" value="">
                  <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="delivery" value="0 руб." />
                  <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="user" value="1" />
                  <input type="hidden" name="address" value="Уточнить у покупателя" /> 
                  <input type="hidden" name="description" class="descr" value=""/>

                  <div class="reolader">
                    <button class="button mm_button" >Заказать</button>
                    <div class="ajax_loader_block">
                      <img class="ajax_loader" src="img/ajax-loader.gif" alt="Идет отправка данных"/>
                      <span class="ajax_loader">Идет отправка данных</span>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="product_item">
              <div class="img">
                <div class="item_slider owl-carousel owl-theme">
                  <a href="catalog/13.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/13.jpg"
                      src="./catalog/13.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                  <a href="catalog/13_2.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/13_2.jpg"
                      src="images/prev.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                </div>
              </div>
              <div class="content">
                <div class="name">Платье</div>
                <div class="vendor_code">
                  <b>Артикул</b>: <span class="art">3117</span>
                </div>

                <p class="pm vendor_code material" style="display: none; color: #222">
                  <b>Материал</b>: 65% вискоза 30% полиэстер 5% лайкра
                </p>

                <!-- <p class="pm vendor_code color" style="color: #222;" >
                                      <b style="margin-bottom: 5px; display: inline-block;">Цвета:</b><br> Омбре(какао), <br />Блэк(темно-бирюзовый)
                                  </p> -->

                
                <div style="color: #222" class="vendor_code">
                  <b>Доставка без предоплаты</b>
                </div>
                <div style="color: #222" class="vendor_code">
                  <b>Обмен / возврат</b>: 14 дней
                </div>

                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3780</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>
                <div class="button art_button" art="2101">Заказать</div>
              </div>
              <div class="hidden">
                <div class="close"></div>
                <div class="action">
                  <span>Оставьте заявку</span>
                  <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                </div>
                <div class="name">Платье</div>
                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3780</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>

                <form class="lt-form main-order-form order_form" action="/success/" method="post">
                  <select style="display: none;" name="aim" class="countryselect"><option value='1'>Россия</option></select>
                  <input type="text" name="name" class="field input" placeholder="Ваше Имя" value="">
                  <input type="text" name="phone" class="field input" placeholder="Ваш телефон" value="">
                  <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="delivery" value="0 руб." />
                  <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="user" value="1" />
                  <input type="hidden" name="address" value="Уточнить у покупателя" /> 
                  <input type="hidden" name="description" class="descr" value=""/>

                  <div class="reolader">
                    <button class="button mm_button" >Заказать</button>
                    <div class="ajax_loader_block">
                      <img class="ajax_loader" src="img/ajax-loader.gif" alt="Идет отправка данных"/>
                      <span class="ajax_loader">Идет отправка данных</span>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="product_item">
              <div class="img">
                <div class="item_slider owl-carousel owl-theme">
                  <a href="catalog/14.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/14.jpg"
                      src="./catalog/14.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                  <a href="catalog/14_2.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/14_2.jpg"
                      src="images/prev.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                </div>
              </div>
              <div class="content">
                <div class="name">Платье</div>
                <div class="vendor_code">
                  <b>Артикул</b>: <span class="art">3118</span>
                </div>

                <p class="pm vendor_code material" style="display: none; color: #222">
                  <b>Материал</b>: 70% полиэстер 25% вискоза 5% лайкра
                </p>

                <!-- <p class="pm vendor_code color" style="color: #222;" >
                                      <b style="margin-bottom: 5px; display: inline-block;">Цвета:</b><br> Омбре(какао), <br />Блэк(темно-бирюзовый)
                                  </p> -->

                
                <div style="color: #222" class="vendor_code">
                  <b>Доставка без предоплаты</b>
                </div>
                <div style="color: #222" class="vendor_code">
                  <b>Обмен / возврат</b>: 14 дней
                </div>

                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3980</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>
                <div class="button art_button" art="2101">Заказать</div>
              </div>
              <div class="hidden">
                <div class="close"></div>
                <div class="action">
                  <span>Оставьте заявку</span>
                  <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                </div>
                <div class="name">Платье</div>
                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3980</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>

                <form class="lt-form main-order-form order_form" action="/success/" method="post">
                  <select style="display: none;" name="aim" class="countryselect"><option value='1'>Россия</option></select>
                  <input type="text" name="name" class="field input" placeholder="Ваше Имя" value="">
                  <input type="text" name="phone" class="field input" placeholder="Ваш телефон" value="">
                  <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="delivery" value="0 руб." />
                  <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="user" value="1" />
                  <input type="hidden" name="address" value="Уточнить у покупателя" /> 
                  <input type="hidden" name="description" class="descr" value=""/>

                  <div class="reolader">
                    <button class="button mm_button" >Заказать</button>
                    <div class="ajax_loader_block">
                      <img class="ajax_loader" src="img/ajax-loader.gif" alt="Идет отправка данных"/>
                      <span class="ajax_loader">Идет отправка данных</span>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="product_item">
              <div class="img">
                <div class="item_slider owl-carousel owl-theme">
                  <a href="catalog/15.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/15.jpg"
                      src="./catalog/15.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                  <a href="catalog/15_2.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/15_2.jpg"
                      src="images/prev.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                </div>
              </div>
              <div class="content">
                <div class="name">Платье</div>
                <div class="vendor_code">
                  <b>Артикул</b>: <span class="art">3119</span>
                </div>

                <p class="pm vendor_code material" style="display: none; color: #222">
                  <b>Материал</b>: 95% хлопок 5% лайкра
                </p>

                <!-- <p class="pm vendor_code color" style="color: #222;" >
                                      <b style="margin-bottom: 5px; display: inline-block;">Цвета:</b><br> Омбре(какао), <br />Блэк(темно-бирюзовый)
                                  </p> -->

                
                <div style="color: #222" class="vendor_code">
                  <b>Доставка без предоплаты</b>
                </div>
                <div style="color: #222" class="vendor_code">
                  <b>Обмен / возврат</b>: 14 дней
                </div>

                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3290</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>
                <div class="button art_button" art="2101">Заказать</div>
              </div>
              <div class="hidden">
                <div class="close"></div>
                <div class="action">
                  <span>Оставьте заявку</span>
                  <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                </div>
                <div class="name">Платье</div>
                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3290</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>

                <form class="lt-form main-order-form order_form" action="/success/" method="post">
                  <select style="display: none;" name="aim" class="countryselect"><option value='1'>Россия</option></select>
                  <input type="text" name="name" class="field input" placeholder="Ваше Имя" value="">
                  <input type="text" name="phone" class="field input" placeholder="Ваш телефон" value="">
                  <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="delivery" value="0 руб." />
                  <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="user" value="1" />
                  <input type="hidden" name="address" value="Уточнить у покупателя" /> 
                  <input type="hidden" name="description" class="descr" value=""/>

                  <div class="reolader">
                    <button class="button mm_button" >Заказать</button>
                    <div class="ajax_loader_block">
                      <img class="ajax_loader" src="img/ajax-loader.gif" alt="Идет отправка данных"/>
                      <span class="ajax_loader">Идет отправка данных</span>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="product_item">
              <div class="img">
                <div class="item_slider owl-carousel owl-theme">
                  <a href="catalog/16.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/16.jpg"
                      src="./catalog/16.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                  <a href="catalog/16_2.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/16_2.jpg"
                      src="images/prev.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                </div>
              </div>
              <div class="content">
                <div class="name">Платье</div>
                <div class="vendor_code">
                  <b>Артикул</b>: <span class="art">3120</span>
                </div>

                <p class="pm vendor_code material" style="display: none; color: #222">
                  <b>Материал</b>: 100% хлопок
                </p>

                <!-- <p class="pm vendor_code color" style="color: #222;" >
                                      <b style="margin-bottom: 5px; display: inline-block;">Цвета:</b><br> Омбре(какао), <br />Блэк(темно-бирюзовый)
                                  </p> -->

                
                <div style="color: #222" class="vendor_code">
                  <b>Доставка без предоплаты</b>
                </div>
                <div style="color: #222" class="vendor_code">
                  <b>Обмен / возврат</b>: 14 дней
                </div>

                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3980</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>
                <div class="button art_button" art="2101">Заказать</div>
              </div>
              <div class="hidden">
                <div class="close"></div>
                <div class="action">
                  <span>Оставьте заявку</span>
                  <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                </div>
                <div class="name">Платье</div>
                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3980</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>

                <form class="lt-form main-order-form order_form" action="/success/" method="post">
                  <select style="display: none;" name="aim" class="countryselect"><option value='1'>Россия</option></select>
                  <input type="text" name="name" class="field input" placeholder="Ваше Имя" value="">
                  <input type="text" name="phone" class="field input" placeholder="Ваш телефон" value="">
                  <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="delivery" value="0 руб." />
                  <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="user" value="1" />
                  <input type="hidden" name="address" value="Уточнить у покупателя" /> 
                  <input type="hidden" name="description" class="descr" value=""/>

                  <div class="reolader">
                    <button class="button mm_button" >Заказать</button>
                    <div class="ajax_loader_block">
                      <img class="ajax_loader" src="img/ajax-loader.gif" alt="Идет отправка данных"/>
                      <span class="ajax_loader">Идет отправка данных</span>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="product_item">
              <div class="img">
                <div class="item_slider owl-carousel owl-theme">
                  <a href="catalog/17.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/17.jpg"
                      src="./catalog/17.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                  <a href="catalog/17_2.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/17_2.jpg"
                      src="images/prev.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                </div>
              </div>
              <div class="content">
                <div class="name">Платье</div>
                <div class="vendor_code">
                  <b>Артикул</b>: <span class="art">3121</span>
                </div>

                <p class="pm vendor_code material" style="display: none; color: #222">
                  <b>Материал</b>: 65% вискоза 30% полиэстер 5% лайкра
                </p>

                <!-- <p class="pm vendor_code color" style="color: #222;" >
                                      <b style="margin-bottom: 5px; display: inline-block;">Цвета:</b><br> Омбре(какао), <br />Блэк(темно-бирюзовый)
                                  </p> -->

                
                <div style="color: #222" class="vendor_code">
                  <b>Доставка без предоплаты</b>
                </div>
                <div style="color: #222" class="vendor_code">
                  <b>Обмен / возврат</b>: 14 дней
                </div>

                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3780</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>
                <div class="button art_button" art="2101">Заказать</div>
              </div>
              <div class="hidden">
                <div class="close"></div>
                <div class="action">
                  <span>Оставьте заявку</span>
                  <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                </div>
                <div class="name">Платье</div>
                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3780</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>

                <form class="lt-form main-order-form order_form" action="/success/" method="post">
                  <select style="display: none;" name="aim" class="countryselect"><option value='1'>Россия</option></select>
                  <input type="text" name="name" class="field input" placeholder="Ваше Имя" value="">
                  <input type="text" name="phone" class="field input" placeholder="Ваш телефон" value="">
                  <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="delivery" value="0 руб." />
                  <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="user" value="1" />
                  <input type="hidden" name="address" value="Уточнить у покупателя" /> 
                  <input type="hidden" name="description" class="descr" value=""/>

                  <div class="reolader">
                    <button class="button mm_button" >Заказать</button>
                    <div class="ajax_loader_block">
                      <img class="ajax_loader" src="img/ajax-loader.gif" alt="Идет отправка данных"/>
                      <span class="ajax_loader">Идет отправка данных</span>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="product_item">
              <div class="img">
                <div class="item_slider owl-carousel owl-theme">
                  <a href="catalog/18.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/18.jpg"
                      src="./catalog/18.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                  <a href="catalog/18_2.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/18_2.jpg"
                      src="images/prev.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                </div>
              </div>
              <div class="content">
                <div class="name">Платье</div>
                <div class="vendor_code">
                  <b>Артикул</b>: <span class="art">3122</span>
                </div>

                <p class="pm vendor_code material" style="display: none; color: #222">
                  <b>Материал</b>: 95% вискоза 5% лайкра
                </p>

                <!-- <p class="pm vendor_code color" style="color: #222;" >
                                      <b style="margin-bottom: 5px; display: inline-block;">Цвета:</b><br> Омбре(какао), <br />Блэк(темно-бирюзовый)
                                  </p> -->

                
                <div style="color: #222" class="vendor_code">
                  <b>Доставка без предоплаты</b>
                </div>
                <div style="color: #222" class="vendor_code">
                  <b>Обмен / возврат</b>: 14 дней
                </div>

                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3290</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>
                <div class="button art_button" art="2101">Заказать</div>
              </div>
              <div class="hidden">
                <div class="close"></div>
                <div class="action">
                  <span>Оставьте заявку</span>
                  <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                </div>
                <div class="name">Платье</div>
                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3290</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>

                <form class="lt-form main-order-form order_form" action="/success/" method="post">
                  <select style="display: none;" name="aim" class="countryselect"><option value='1'>Россия</option></select>
                  <input type="text" name="name" class="field input" placeholder="Ваше Имя" value="">
                  <input type="text" name="phone" class="field input" placeholder="Ваш телефон" value="">
                  <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="delivery" value="0 руб." />
                  <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="user" value="1" />
                  <input type="hidden" name="address" value="Уточнить у покупателя" /> 
                  <input type="hidden" name="description" class="descr" value=""/>

                  <div class="reolader">
                    <button class="button mm_button" >Заказать</button>
                    <div class="ajax_loader_block">
                      <img class="ajax_loader" src="img/ajax-loader.gif" alt="Идет отправка данных"/>
                      <span class="ajax_loader">Идет отправка данных</span>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="product_item">
              <div class="img">
                <div class="item_slider owl-carousel owl-theme">
                  <a href="catalog/19.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/19.jpg"
                      src="./catalog/19.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                  <a href="catalog/19_2.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/19_2.jpg"
                      src="images/prev.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                </div>
              </div>
              <div class="content">
                <div class="name">Платье</div>
                <div class="vendor_code">
                  <b>Артикул</b>: <span class="art">3123</span>
                </div>

                <p class="pm vendor_code material" style="display: none; color: #222">
                  <b>Материал</b>: 100% хлопок
                </p>

                <!-- <p class="pm vendor_code color" style="color: #222;" >
                                      <b style="margin-bottom: 5px; display: inline-block;">Цвета:</b><br> Омбре(какао), <br />Блэк(темно-бирюзовый)
                                  </p> -->

                
                <div style="color: #222" class="vendor_code">
                  <b>Доставка без предоплаты</b>
                </div>
                <div style="color: #222" class="vendor_code">
                  <b>Обмен / возврат</b>: 14 дней
                </div>

                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3290</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>
                <div class="button art_button" art="2101">Заказать</div>
              </div>
              <div class="hidden">
                <div class="close"></div>
                <div class="action">
                  <span>Оставьте заявку</span>
                  <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                </div>
                <div class="name">Платье</div>
                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3290</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>

                <form class="lt-form main-order-form order_form" action="/success/" method="post">
                  <select style="display: none;" name="aim" class="countryselect"><option value='1'>Россия</option></select>
                  <input type="text" name="name" class="field input" placeholder="Ваше Имя" value="">
                  <input type="text" name="phone" class="field input" placeholder="Ваш телефон" value="">
                  <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="delivery" value="0 руб." />
                  <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="user" value="1" />
                  <input type="hidden" name="address" value="Уточнить у покупателя" /> 
                  <input type="hidden" name="description" class="descr" value=""/>

                  <div class="reolader">
                    <button class="button mm_button" >Заказать</button>
                    <div class="ajax_loader_block">
                      <img class="ajax_loader" src="img/ajax-loader.gif" alt="Идет отправка данных"/>
                      <span class="ajax_loader">Идет отправка данных</span>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="product_item">
              <div class="img">
                <div class="item_slider owl-carousel owl-theme">
                  <a href="catalog/20.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/20.jpg"
                      src="./catalog/20.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                  <a href="catalog/20_2.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/20_2.jpg"
                      src="images/prev.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                </div>
              </div>
              <div class="content">
                <div class="name">Платье</div>
                <div class="vendor_code">
                  <b>Артикул</b>: <span class="art">3124</span>
                </div>

                <p class="pm vendor_code material" style="display: none; color: #222">
                  <b>Материал</b>: 100% хлопок
                </p>

                <!-- <p class="pm vendor_code color" style="color: #222;" >
                                      <b style="margin-bottom: 5px; display: inline-block;">Цвета:</b><br> Омбре(какао), <br />Блэк(темно-бирюзовый)
                                  </p> -->

                
                <div style="color: #222" class="vendor_code">
                  <b>Доставка без предоплаты</b>
                </div>
                <div style="color: #222" class="vendor_code">
                  <b>Обмен / возврат</b>: 14 дней
                </div>

                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3450</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>
                <div class="button art_button" art="2101">Заказать</div>
              </div>
              <div class="hidden">
                <div class="close"></div>
                <div class="action">
                  <span>Оставьте заявку</span>
                  <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                </div>
                <div class="name">Платье</div>
                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3450</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>

                <form class="lt-form main-order-form order_form" action="/success/" method="post">
                  <select style="display: none;" name="aim" class="countryselect"><option value='1'>Россия</option></select>
                  <input type="text" name="name" class="field input" placeholder="Ваше Имя" value="">
                  <input type="text" name="phone" class="field input" placeholder="Ваш телефон" value="">
                  <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="delivery" value="0 руб." />
                  <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="user" value="1" />
                  <input type="hidden" name="address" value="Уточнить у покупателя" /> 
                  <input type="hidden" name="description" class="descr" value=""/>

                  <div class="reolader">
                    <button class="button mm_button" >Заказать</button>
                    <div class="ajax_loader_block">
                      <img class="ajax_loader" src="img/ajax-loader.gif" alt="Идет отправка данных"/>
                      <span class="ajax_loader">Идет отправка данных</span>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="product_item">
              <div class="img">
                <div class="item_slider owl-carousel owl-theme">
                  <a href="catalog/21.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/21.jpg"
                      src="./catalog/21.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                  <a href="catalog/21_2.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/21_2.jpg"
                      src="images/prev.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                </div>
              </div>
              <div class="content">
                <div class="name">Платье</div>
                <div class="vendor_code">
                  <b>Артикул</b>: <span class="art">3125</span>
                </div>

                <p class="pm vendor_code material" style="display: none; color: #222">
                  <b>Материал</b>: 70% полиэстер 30% вискоза
                </p>

                <!-- <p class="pm vendor_code color" style="color: #222;" >
                                      <b style="margin-bottom: 5px; display: inline-block;">Цвета:</b><br> Омбре(какао), <br />Блэк(темно-бирюзовый)
                                  </p> -->

                
                <div style="color: #222" class="vendor_code">
                  <b>Доставка без предоплаты</b>
                </div>
                <div style="color: #222" class="vendor_code">
                  <b>Обмен / возврат</b>: 14 дней
                </div>

                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3450</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>
                <div class="button art_button" art="2101">Заказать</div>
              </div>
              <div class="hidden">
                <div class="close"></div>
                <div class="action">
                  <span>Оставьте заявку</span>
                  <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                </div>
                <div class="name">Платье</div>
                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3450</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>

                <form class="lt-form main-order-form order_form" action="/success/" method="post">
                  <select style="display: none;" name="aim" class="countryselect"><option value='1'>Россия</option></select>
                  <input type="text" name="name" class="field input" placeholder="Ваше Имя" value="">
                  <input type="text" name="phone" class="field input" placeholder="Ваш телефон" value="">
                  <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="delivery" value="0 руб." />
                  <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="user" value="1" />
                  <input type="hidden" name="address" value="Уточнить у покупателя" /> 
                  <input type="hidden" name="description" class="descr" value=""/>

                  <div class="reolader">
                    <button class="button mm_button" >Заказать</button>
                    <div class="ajax_loader_block">
                      <img class="ajax_loader" src="img/ajax-loader.gif" alt="Идет отправка данных"/>
                      <span class="ajax_loader">Идет отправка данных</span>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="product_item">
              <div class="img">
                <div class="item_slider owl-carousel owl-theme">
                  <a href="catalog/22.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/22.jpg"
                      src="./catalog/22.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                  <a href="catalog/22_2.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/22_2.jpg"
                      src="images/prev.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                </div>
              </div>
              <div class="content">
                <div class="name">Платье</div>
                <div class="vendor_code">
                  <b>Артикул</b>: <span class="art">3126</span>
                </div>

                <p class="pm vendor_code material" style="display: none; color: #222">
                  <b>Материал</b>: 70% полиэстер 30% вискоза
                </p>

                <!-- <p class="pm vendor_code color" style="color: #222;" >
                                      <b style="margin-bottom: 5px; display: inline-block;">Цвета:</b><br> Омбре(какао), <br />Блэк(темно-бирюзовый)
                                  </p> -->

                
                <div style="color: #222" class="vendor_code">
                  <b>Доставка без предоплаты</b>
                </div>
                <div style="color: #222" class="vendor_code">
                  <b>Обмен / возврат</b>: 14 дней
                </div>

                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3290</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>
                <div class="button art_button" art="2101">Заказать</div>
              </div>
              <div class="hidden">
                <div class="close"></div>
                <div class="action">
                  <span>Оставьте заявку</span>
                  <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                </div>
                <div class="name">Платье</div>
                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3290</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>

                <form class="lt-form main-order-form order_form" action="/success/" method="post">
                  <select style="display: none;" name="aim" class="countryselect"><option value='1'>Россия</option></select>
                  <input type="text" name="name" class="field input" placeholder="Ваше Имя" value="">
                  <input type="text" name="phone" class="field input" placeholder="Ваш телефон" value="">
                  <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="delivery" value="0 руб." />
                  <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="user" value="1" />
                  <input type="hidden" name="address" value="Уточнить у покупателя" /> 
                  <input type="hidden" name="description" class="descr" value=""/>

                  <div class="reolader">
                    <button class="button mm_button" >Заказать</button>
                    <div class="ajax_loader_block">
                      <img class="ajax_loader" src="img/ajax-loader.gif" alt="Идет отправка данных"/>
                      <span class="ajax_loader">Идет отправка данных</span>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="product_item">
              <div class="img">
                <div class="item_slider owl-carousel owl-theme">
                  <a href="catalog/23.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/23.jpg"
                      src="./catalog/23.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                  <a href="catalog/23_2.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/23_2.jpg"
                      src="images/prev.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                </div>
              </div>
              <div class="content">
                <div class="name">Платье</div>
                <div class="vendor_code">
                  <b>Артикул</b>: <span class="art">3127</span>
                </div>

                <p class="pm vendor_code material" style="display: none; color: #222">
                  <b>Материал</b>: 70% полиэстер 30% вискоза
                </p>

                <!-- <p class="pm vendor_code color" style="color: #222;" >
                                      <b style="margin-bottom: 5px; display: inline-block;">Цвета:</b><br> Омбре(какао), <br />Блэк(темно-бирюзовый)
                                  </p> -->

                
                <div style="color: #222" class="vendor_code">
                  <b>Доставка без предоплаты</b>
                </div>
                <div style="color: #222" class="vendor_code">
                  <b>Обмен / возврат</b>: 14 дней
                </div>

                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3780</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>
                <div class="button art_button" art="2101">Заказать</div>
              </div>
              <div class="hidden">
                <div class="close"></div>
                <div class="action">
                  <span>Оставьте заявку</span>
                  <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                </div>
                <div class="name">Платье</div>
                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3780</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>

                <form class="lt-form main-order-form order_form" action="/success/" method="post">
                  <select style="display: none;" name="aim" class="countryselect"><option value='1'>Россия</option></select>
                  <input type="text" name="name" class="field input" placeholder="Ваше Имя" value="">
                  <input type="text" name="phone" class="field input" placeholder="Ваш телефон" value="">
                  <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="delivery" value="0 руб." />
                  <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="user" value="1" />
                  <input type="hidden" name="address" value="Уточнить у покупателя" /> 
                  <input type="hidden" name="description" class="descr" value=""/>

                  <div class="reolader">
                    <button class="button mm_button" >Заказать</button>
                    <div class="ajax_loader_block">
                      <img class="ajax_loader" src="img/ajax-loader.gif" alt="Идет отправка данных"/>
                      <span class="ajax_loader">Идет отправка данных</span>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="product_item">
              <div class="img">
                <div class="item_slider owl-carousel owl-theme">
                  <a href="catalog/24.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/24.jpg"
                      src="./catalog/24.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                  <a href="catalog/24_2.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/24_2.jpg"
                      src="images/prev.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                </div>
              </div>
              <div class="content">
                <div class="name">Платье</div>
                <div class="vendor_code">
                  <b>Артикул</b>: <span class="art">3128</span>
                </div>

                <p class="pm vendor_code material" style="display: none; color: #222">
                  <b>Материал</b>: 70% полиэстер 30% вискоза
                </p>

                <!-- <p class="pm vendor_code color" style="color: #222;" >
                                      <b style="margin-bottom: 5px; display: inline-block;">Цвета:</b><br> Омбре(какао), <br />Блэк(темно-бирюзовый)
                                  </p> -->

                
                <div style="color: #222" class="vendor_code">
                  <b>Доставка без предоплаты</b>
                </div>
                <div style="color: #222" class="vendor_code">
                  <b>Обмен / возврат</b>: 14 дней
                </div>

                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3290</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>
                <div class="button art_button" art="2101">Заказать</div>
              </div>
              <div class="hidden">
                <div class="close"></div>
                <div class="action">
                  <span>Оставьте заявку</span>
                  <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                </div>
                <div class="name">Платье</div>
                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3290</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>

                <form class="lt-form main-order-form order_form" action="/success/" method="post">
                  <select style="display: none;" name="aim" class="countryselect"><option value='1'>Россия</option></select>
                  <input type="text" name="name" class="field input" placeholder="Ваше Имя" value="">
                  <input type="text" name="phone" class="field input" placeholder="Ваш телефон" value="">
                  <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="delivery" value="0 руб." />
                  <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="user" value="1" />
                  <input type="hidden" name="address" value="Уточнить у покупателя" /> 
                  <input type="hidden" name="description" class="descr" value=""/>

                  <div class="reolader">
                    <button class="button mm_button" >Заказать</button>
                    <div class="ajax_loader_block">
                      <img class="ajax_loader" src="img/ajax-loader.gif" alt="Идет отправка данных"/>
                      <span class="ajax_loader">Идет отправка данных</span>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="product_item">
              <div class="img">
                <div class="item_slider owl-carousel owl-theme">
                  <a href="catalog/25.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/25.jpg"
                      src="./catalog/25.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                  <a href="catalog/25_2.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/25_2.jpg"
                      src="images/prev.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                </div>
              </div>
              <div class="content">
                <div class="name">Платье</div>
                <div class="vendor_code">
                  <b>Артикул</b>: <span class="art">3129</span>
                </div>

                <p class="pm vendor_code material" style="display: none; color: #222">
                  <b>Материал</b>: 70% полиэстер 30% вискоза
                </p>

                <!-- <p class="pm vendor_code color" style="color: #222;" >
                                      <b style="margin-bottom: 5px; display: inline-block;">Цвета:</b><br> Омбре(какао), <br />Блэк(темно-бирюзовый)
                                  </p> -->

                
                <div style="color: #222" class="vendor_code">
                  <b>Доставка без предоплаты</b>
                </div>
                <div style="color: #222" class="vendor_code">
                  <b>Обмен / возврат</b>: 14 дней
                </div>

                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3780</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>
                <div class="button art_button" art="2101">Заказать</div>
              </div>
              <div class="hidden">
                <div class="close"></div>
                <div class="action">
                  <span>Оставьте заявку</span>
                  <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                </div>
                <div class="name">Платье</div>
                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3780</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>

                <form class="lt-form main-order-form order_form" action="/success/" method="post">
                  <select style="display: none;" name="aim" class="countryselect"><option value='1'>Россия</option></select>
                  <input type="text" name="name" class="field input" placeholder="Ваше Имя" value="">
                  <input type="text" name="phone" class="field input" placeholder="Ваш телефон" value="">
                  <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="delivery" value="0 руб." />
                  <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="user" value="1" />
                  <input type="hidden" name="address" value="Уточнить у покупателя" /> 
                  <input type="hidden" name="description" class="descr" value=""/>

                  <div class="reolader">
                    <button class="button mm_button" >Заказать</button>
                    <div class="ajax_loader_block">
                      <img class="ajax_loader" src="img/ajax-loader.gif" alt="Идет отправка данных"/>
                      <span class="ajax_loader">Идет отправка данных</span>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="product_item">
              <div class="img">
                <div class="item_slider owl-carousel owl-theme">
                  <a href="catalog/26.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/26.jpg"
                      src="./catalog/26.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                  <a href="catalog/26_2.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/26_2.jpg"
                      src="images/prev.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                </div>
              </div>
              <div class="content">
                <div class="name">Платье</div>
                <div class="vendor_code">
                  <b>Артикул</b>: <span class="art">3130</span>
                </div>

                <p class="pm vendor_code material" style="display: none; color: #222">
                  <b>Материал</b>: 70% полиэстер 30% вискоза
                </p>

                <!-- <p class="pm vendor_code color" style="color: #222;" >
                                      <b style="margin-bottom: 5px; display: inline-block;">Цвета:</b><br> Омбре(какао), <br />Блэк(темно-бирюзовый)
                                  </p> -->

                
                <div style="color: #222" class="vendor_code">
                  <b>Доставка без предоплаты</b>
                </div>
                <div style="color: #222" class="vendor_code">
                  <b>Обмен / возврат</b>: 14 дней
                </div>

                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3980</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>
                <div class="button art_button" art="2101">Заказать</div>
              </div>
              <div class="hidden">
                <div class="close"></div>
                <div class="action">
                  <span>Оставьте заявку</span>
                  <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                </div>
                <div class="name">Платье</div>
                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3980</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>

                <form class="lt-form main-order-form order_form" action="/success/" method="post">
                  <select style="display: none;" name="aim" class="countryselect"><option value='1'>Россия</option></select>
                  <input type="text" name="name" class="field input" placeholder="Ваше Имя" value="">
                  <input type="text" name="phone" class="field input" placeholder="Ваш телефон" value="">
                  <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="delivery" value="0 руб." />
                  <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="user" value="1" />
                  <input type="hidden" name="address" value="Уточнить у покупателя" /> 
                  <input type="hidden" name="description" class="descr" value=""/>

                  <div class="reolader">
                    <button class="button mm_button" >Заказать</button>
                    <div class="ajax_loader_block">
                      <img class="ajax_loader" src="img/ajax-loader.gif" alt="Идет отправка данных"/>
                      <span class="ajax_loader">Идет отправка данных</span>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="product_item">
              <div class="img">
                <div class="item_slider owl-carousel owl-theme">
                  <a href="catalog/27.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/27.jpg"
                      src="./catalog/27.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                  <a href="catalog/27_2.jpg" data-fancybox="gallery">
                    <img
                      data-src="catalog/27_2.jpg"
                      src="images/prev.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                </div>
              </div>
              <div class="content">
                <div class="name">Платье</div>
                <div class="vendor_code">
                  <b>Артикул</b>: <span class="art">3131</span>
                </div>

                <p class="pm vendor_code material" style="display: none; color: #222">
                  <b>Материал</b>: 70% полиэстер 30% вискоза
                </p>

                <!-- <p class="pm vendor_code color" style="color: #222;" >
                                      <b style="margin-bottom: 5px; display: inline-block;">Цвета:</b><br> Омбре(какао), <br />Блэк(темно-бирюзовый)
                                  </p> -->

                
                <div style="color: #222" class="vendor_code">
                  <b>Доставка без предоплаты</b>
                </div>
                <div style="color: #222" class="vendor_code">
                  <b>Обмен / возврат</b>: 14 дней
                </div>

                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3780</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>
                <div class="button art_button" art="2101">Заказать</div>
              </div>
              <div class="hidden">
                <div class="close"></div>
                <div class="action">
                  <span>Оставьте заявку</span>
                  <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                </div>
                <div class="name">Платье</div>
                <div class="price_block clearfix">
                  <div class="price_item old">
                    <x-oldprice>3780</x-oldprice>
                    <x-currency>руб</x-currency>
                  </div>
                  <div class="price_item new">
                    <x-newprice class="productsum">1390 руб.</x-newprice>
                  </div>
                </div>

                <form class="lt-form main-order-form order_form" action="/success/" method="post">
                  <select style="display: none;" name="aim" class="countryselect"><option value='1'>Россия</option></select>
                  <input type="text" name="name" class="field input" placeholder="Ваше Имя" value="">
                  <input type="text" name="phone" class="field input" placeholder="Ваш телефон" value="">
                  <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="delivery" value="0 руб." />
                  <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                  <input type="hidden" name="user" value="1" />
                  <input type="hidden" name="address" value="Уточнить у покупателя" /> 
                  <input type="hidden" name="description" class="descr" value=""/>

                  <div class="reolader">
                    <button class="button mm_button" >Заказать</button>
                    <div class="ajax_loader_block">
                      <img class="ajax_loader" src="img/ajax-loader.gif" alt="Идет отправка данных"/>
                      <span class="ajax_loader">Идет отправка данных</span>
                    </div>
                  </div>
                </form>
              </div>
            </div>






            <div class="product_item">
              <div class="img">
                <div class="item_slider owl-carousel owl-theme">
                  <a href="catalog_2/1.jpg" data-fancybox="gallery">
                    <img
                      src="./catalog_2/1.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>

                        <a href="catalog_2/1_2.jpg" data-fancybox="gallery">
                    <img
                      src="./catalog_2/1_2.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                    </div>
                </div>
                <div class="content">
                    <div class="name">Платье Грация Стиля</div>
                    <div class="vendor_code">
                        <b>Артикул</b>: <span class="art">343</span>
                    </div>

                    <p class="pm vendor_code material" style="display: none; color: #222">
                        <b>Материал</b>: 65% вискоза 30% п-р 5% лайкра
                    </p>

                    <div style="color: #222" class="vendor_code">
                        <b>Доставка без предоплаты</b>
                    </div>
                    <div style="color: #222" class="vendor_code">
                        <b>Обмен / возврат</b>: 14 дней
                    </div>

                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3980 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>
                    <div class="button art_button" art="343">Заказать</div>
                </div>
                <div class="hidden">
                    <div class="close"></div>
                    <div class="action">
                        <span>Оставьте заявку</span>
                        <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                    </div>
                    <div class="name">Платье Грация Стиля</div>
                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3980 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>

                    <form class="lt-form main-order-form order_form" action="/success/" method="post">
<select name="aim" class="countryselect" style="display:none"><option value='1'>Россия</option></select>
                        
                        <input type="text" name="name" class="field input" placeholder="Ваше Имя" required value="">
                        <input type="text" name="phone" class="field input" placeholder="Ваш телефон" required value="">
                        <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="delivery" value="0 руб." />
                        <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="user" value="1" />
                        <input type="hidden" name="address" value="Уточнить у покупателя" />
                        <input type="hidden" name="description" class="descr" value="" />

                        <div class="reolader">
                            <button class="button mm_button" type="submit" >
                      Заказать
                    </button>
                            <div class="ajax_loader_block">
                                <img class="ajax_loader" src="./img/ajax-loader.gif" alt="Идет отправка данных"> <br>
                                <span class="ajax_loader">Идет отправка данных</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="product_item">
                <div class="img">
                    <div class="item_slider owl-carousel owl-theme">
                        <a href="catalog_2/2.jpg" data-fancybox="gallery">
                    <img
                     src="catalog_2/2.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>

                        <a href="catalog_2/2_2.jpg" data-fancybox="gallery">
                    <img
                     src="catalog_2/2_2.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                    </div>
                </div>
                <div class="content">
                    <div class="name">Платье Грация Стиля</div>
                    <div class="vendor_code">
                        <b>Артикул</b>: <span class="art">344</span>
                    </div>
                    <p class="pm vendor_code material" style="display: none; color: #222">
                        <b>Материал</b>: 65% вискоза 30% полиэстер 5% лайкра
                    </p>

                    <div style="color: #222" class="vendor_code">
                        <b>Доставка без предоплаты</b>
                    </div>
                    <div style="color: #222" class="vendor_code">
                        <b>Обмен / возврат</b>: 14 дней
                    </div>

                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3290 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>
                    <div class="button art_button" art="2102">Заказать</div>
                </div>
                <div class="hidden">
                    <div class="close"></div>
                    <div class="action">
                        <span>Оставьте заявку</span>
                        <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                    </div>
                    <div class="name">Платье Грация Стиля</div>
                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3290 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>

                    <form class="lt-form main-order-form order_form" action="/success/" method="post">
<select name="aim" class="countryselect" style="display:none"><option value='1'>Россия</option></select>
                        <input type="text" name="name" class="field input" placeholder="Ваше Имя" required value="">
                        <input type="text" name="phone" class="field input" placeholder="Ваш телефон" required value="">
                        <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="delivery" value="0 руб." />
                        <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="user" value="1" />
                        <input type="hidden" name="address" value="Уточнить у покупателя" />
                        <input type="hidden" name="description" class="descr" value="" />

                        <div class="reolader">
                            <button class="button mm_button" type="submit" >
                      Заказать
                    </button>
                            <div class="ajax_loader_block">
                                <img class="ajax_loader" src="./img/ajax-loader.gif" alt="Идет отправка данных"> <br>
                                <span class="ajax_loader">Идет отправка данных</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="product_item">
                <div class="img">
                    <div class="item_slider owl-carousel owl-theme">
                        <a href="catalog_2/3.jpg" data-fancybox="gallery">
                    <img
                     src="catalog_2/3.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                        <a href="catalog_2/3_2.jpg" data-fancybox="gallery">
                    <img
                     src="catalog_2/3_2.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                    </div>
                </div>
                <div class="content">
                    <div class="name">Платье Грация Стиля</div>
                    <div class="vendor_code">
                        <b>Артикул</b>: <span class="art">345</span>
                    </div>
                    <p class="pm vendor_code material" style="display: none; color: #222">
                        <b>Материал</b>: 60% вискоза 40% полиэстер
                    </p>

                    <div style="color: #222" class="vendor_code">
                        <b>Доставка без предоплаты</b>
                    </div>
                    <div style="color: #222" class="vendor_code">
                        <b>Обмен / возврат</b>: 14 дней
                    </div>

                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3450 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>
                    <div class="button art_button" art="2103">Заказать</div>
                </div>
                <div class="hidden">
                    <div class="close"></div>
                    <div class="action">
                        <span>Оставьте заявку</span>
                        <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                    </div>
                    <div class="name">Платье Грация Стиля</div>
                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3450 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>

                    <form class="lt-form main-order-form order_form" action="/success/" method="post">
<select name="aim" class="countryselect" style="display:none"><option value='1'>Россия</option></select>
                        <input type="text" name="name" class="field input" placeholder="Ваше Имя" required value="">
                        <input type="text" name="phone" class="field input" placeholder="Ваш телефон" required value="">
                        <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="delivery" value="0 руб." />
                        <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="user" value="1" />
                        <input type="hidden" name="address" value="Уточнить у покупателя" />
                        <input type="hidden" name="description" class="descr" value="" />

                        <div class="reolader">
                            <button class="button mm_button" type="submit" >
                      Заказать
                    </button>
                            <div class="ajax_loader_block">
                                <img class="ajax_loader" src="./img/ajax-loader.gif" alt="Идет отправка данных"> <br>
                                <span class="ajax_loader">Идет отправка данных</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="product_item">
                <div class="img">
                    <div class="item_slider owl-carousel owl-theme">
                        <a href="catalog_2/4.jpg" data-fancybox="gallery">
                    <img
                      src="./catalog_2/4.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                        <a href="catalog_2/4_2.jpg" data-fancybox="gallery">
                    <img
                     src="catalog_2/4_2.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                    </div>
                </div>
                <div class="content">
                    <div class="name">Платье Грация Стиля</div>
                    <div class="vendor_code">
                        <b>Артикул</b>: <span class="art">346</span>
                    </div>

                    <p class="pm vendor_code material" style="display: none; color: #222">
                        <b>Материал</b>: 65% вискоза 30% полиэстер 5% лайкра
                    </p>

                    
                    <div style="color: #222" class="vendor_code">
                        <b>Доставка без предоплаты</b>
                    </div>
                    <div style="color: #222" class="vendor_code">
                        <b>Обмен / возврат</b>: 14 дней
                    </div>

                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3450 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>
                    <div class="button art_button" art="2101">Заказать</div>
                </div>
                <div class="hidden">
                    <div class="close"></div>
                    <div class="action">
                        <span>Оставьте заявку</span>
                        <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                    </div>
                    <div class="name">Платье Грация Стиля</div>
                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3450 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>

                    <form class="lt-form main-order-form order_form" action="/success/" method="post">
<select name="aim" class="countryselect" style="display:none"><option value='1'>Россия</option></select>
                        
                        <input type="text" name="name" class="field input" placeholder="Ваше Имя" required value="">
                        <input type="text" name="phone" class="field input" placeholder="Ваш телефон" required value="">
                        <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="delivery" value="0 руб." />
                        <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="user" value="1" />
                        <input type="hidden" name="address" value="Уточнить у покупателя" />
                        <input type="hidden" name="description" class="descr" value="" />

                        <div class="reolader">
                            <button class="button mm_button" type="submit" >
                      Заказать
                    </button>
                            <div class="ajax_loader_block">
                                <img class="ajax_loader" src="./img/ajax-loader.gif" alt="Идет отправка данных"> <br>
                                <span class="ajax_loader">Идет отправка данных</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="product_item">
                <div class="img">
                    <div class="item_slider owl-carousel owl-theme">
                        <a href="catalog_2/5.jpg" data-fancybox="gallery">
                    <img
                      src="./catalog_2/5.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                        <a href="catalog_2/5_2.jpg" data-fancybox="gallery">
                    <img
                     src="catalog_2/5_2.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                    </div>
                </div>
                <div class="content">
                    <div class="name">Платье Грация Стиля</div>
                    <div class="vendor_code">
                        <b>Артикул</b>: <span class="art">347</span>
                    </div>

                    <p class="pm vendor_code material" style="display: none; color: #222">
                        <b>Материал</b>: 60% вискоза 35% полиэстер 5% лайкра
                    </p>

                    
                    <div style="color: #222" class="vendor_code">
                        <b>Доставка без предоплаты</b>
                    </div>
                    <div style="color: #222" class="vendor_code">
                        <b>Обмен / возврат</b>: 14 дней
                    </div>

                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3980 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>
                    <div class="button art_button" art="2101">Заказать</div>
                </div>
                <div class="hidden">
                    <div class="close"></div>
                    <div class="action">
                        <span>Оставьте заявку</span>
                        <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                    </div>
                    <div class="name">Платье Грация Стиля</div>
                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3980 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>

                    <form class="lt-form main-order-form order_form" action="/success/" method="post">
<select name="aim" class="countryselect" style="display:none"><option value='1'>Россия</option></select>
                        
                        <input type="text" name="name" class="field input" placeholder="Ваше Имя" required value="">
                        <input type="text" name="phone" class="field input" placeholder="Ваш телефон" required value="">
                        <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="delivery" value="0 руб." />
                        <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="user" value="1" />
                        <input type="hidden" name="address" value="Уточнить у покупателя" />
                        <input type="hidden" name="description" class="descr" value="" />

                        <div class="reolader">
                            <button class="button mm_button" type="submit" >
                      Заказать
                    </button>
                            <div class="ajax_loader_block">
                                <img class="ajax_loader" src="./img/ajax-loader.gif" alt="Идет отправка данных"> <br>
                                <span class="ajax_loader">Идет отправка данных</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="product_item">
                <div class="img">
                    <div class="item_slider owl-carousel owl-theme">
                        <a href="catalog_2/6.jpg" data-fancybox="gallery">
                    <img
                      src="./catalog_2/6.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                        <a href="catalog_2/6_2.jpg" data-fancybox="gallery">
                    <img
                     src="catalog_2/6_2.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                    </div>
                </div>
                <div class="content">
                    <div class="name">Платье Грация Стиля</div>
                    <div class="vendor_code">
                        <b>Артикул</b>: <span class="art">348</span>
                    </div>

                    <p class="pm vendor_code material" style="display: none; color: #222">
                        <b>Материал</b>: 100% хлопок
                    </p>

                    
                    <div style="color: #222" class="vendor_code">
                        <b>Доставка без предоплаты</b>
                    </div>
                    <div style="color: #222" class="vendor_code">
                        <b>Обмен / возврат</b>: 14 дней
                    </div>

                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3290 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>
                    <div class="button art_button" art="2101">Заказать</div>
                </div>
                <div class="hidden">
                    <div class="close"></div>
                    <div class="action">
                        <span>Оставьте заявку</span>
                        <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                    </div>
                    <div class="name">Платье Грация Стиля</div>
                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3290 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>

                    <form class="lt-form main-order-form order_form" action="/success/" method="post">
<select name="aim" class="countryselect" style="display:none"><option value='1'>Россия</option></select>
                        
                        <input type="text" name="name" class="field input" placeholder="Ваше Имя" required value="">
                        <input type="text" name="phone" class="field input" placeholder="Ваш телефон" required value="">
                        <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="delivery" value="0 руб." />
                        <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="user" value="1" />
                        <input type="hidden" name="address" value="Уточнить у покупателя" />
                        <input type="hidden" name="description" class="descr" value="" />

                        <div class="reolader">
                            <button class="button mm_button" type="submit" >
                      Заказать
                    </button>
                            <div class="ajax_loader_block">
                                <img class="ajax_loader" src="./img/ajax-loader.gif" alt="Идет отправка данных"> <br>
                                <span class="ajax_loader">Идет отправка данных</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="product_item">
                <div class="img">
                    <div class="item_slider owl-carousel owl-theme">
                        <a href="catalog_2/7.jpg" data-fancybox="gallery">
                    <img
                      src="./catalog_2/7.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                        <a href="catalog_2/7_2.jpg" data-fancybox="gallery">
                    <img
                     src="catalog_2/7_2.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                    </div>
                </div>
                <div class="content">
                    <div class="name">Платье Грация Стиля</div>
                    <div class="vendor_code">
                        <b>Артикул</b>: <span class="art">349</span>
                    </div>

                    <p class="pm vendor_code material" style="display: none; color: #222">
                        <b>Материал</b>: 70% полиэстер 30% вискоза
                    </p>

                    
                    <div style="color: #222" class="vendor_code">
                        <b>Доставка без предоплаты</b>
                    </div>
                    <div style="color: #222" class="vendor_code">
                        <b>Обмен / возврат</b>: 14 дней
                    </div>

                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3980 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>
                    <div class="button art_button" art="2101">Заказать</div>
                </div>
                <div class="hidden">
                    <div class="close"></div>
                    <div class="action">
                        <span>Оставьте заявку</span>
                        <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                    </div>
                    <div class="name">Платье Грация Стиля</div>
                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3980 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>

                    <form class="lt-form main-order-form order_form" action="/success/" method="post">
<select name="aim" class="countryselect" style="display:none"><option value='1'>Россия</option></select>
                        
                        <input type="text" name="name" class="field input" placeholder="Ваше Имя" required value="">
                        <input type="text" name="phone" class="field input" placeholder="Ваш телефон" required value="">
                        <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="delivery" value="0 руб." />
                        <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="user" value="1" />
                        <input type="hidden" name="address" value="Уточнить у покупателя" />
                        <input type="hidden" name="description" class="descr" value="" />

                        <div class="reolader">
                            <button class="button mm_button" type="submit" >
                      Заказать
                    </button>
                            <div class="ajax_loader_block">
                                <img class="ajax_loader" src="./img/ajax-loader.gif" alt="Идет отправка данных"> <br>
                                <span class="ajax_loader">Идет отправка данных</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="product_item">
                <div class="img">
                    <div class="item_slider owl-carousel owl-theme">
                        <a href="catalog_2/8.jpg" data-fancybox="gallery">
                    <img
                      src="./catalog_2/8.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                        <a href="catalog_2/8_2.jpg" data-fancybox="gallery">
                    <img
                     src="catalog_2/8_2.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                    </div>
                </div>
                <div class="content">
                    <div class="name">Платье Грация Стиля</div>
                    <div class="vendor_code">
                        <b>Артикул</b>: <span class="art">350</span>
                    </div>

                    <p class="pm vendor_code material" style="display: none; color: #222">
                        <b>Материал</b>: 70% полиэстер 30% вискоза
                    </p>

                    
                    <div style="color: #222" class="vendor_code">
                        <b>Доставка без предоплаты</b>
                    </div>
                    <div style="color: #222" class="vendor_code">
                        <b>Обмен / возврат</b>: 14 дней
                    </div>

                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3980 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>
                    <div class="button art_button" art="2101">Заказать</div>
                </div>
                <div class="hidden">
                    <div class="close"></div>
                    <div class="action">
                        <span>Оставьте заявку</span>
                        <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                    </div>
                    <div class="name">Платье Грация Стиля</div>
                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3980 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>

                    <form class="lt-form main-order-form order_form" action="/success/" method="post">
<select name="aim" class="countryselect" style="display:none"><option value='1'>Россия</option></select>
                        
                        <input type="text" name="name" class="field input" placeholder="Ваше Имя" required value="">
                        <input type="text" name="phone" class="field input" placeholder="Ваш телефон" required value="">
                        <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="delivery" value="0 руб." />
                        <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="user" value="1" />
                        <input type="hidden" name="address" value="Уточнить у покупателя" />
                        <input type="hidden" name="description" class="descr" value="" />

                        <div class="reolader">
                            <button class="button mm_button" type="submit" >
                      Заказать
                    </button>
                            <div class="ajax_loader_block">
                                <img class="ajax_loader" src="./img/ajax-loader.gif" alt="Идет отправка данных"> <br>
                                <span class="ajax_loader">Идет отправка данных</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="product_item">
                <div class="img">
                    <div class="item_slider owl-carousel owl-theme">
                        <a href="catalog_2/9.jpg" data-fancybox="gallery">
                    <img
                      src="./catalog_2/9.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                        <a href="catalog_2/9_2.jpg" data-fancybox="gallery">
                    <img
                     src="catalog_2/9_2.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                    </div>
                </div>
                <div class="content">
                    <div class="name">Платье Грация Стиля</div>
                    <div class="vendor_code">
                        <b>Артикул</b>: <span class="art">351</span>
                    </div>

                    <p class="pm vendor_code material" style="display: none; color: #222">
                        <b>Материал</b>: 70% полиэстер 25% вискоза 5% лайкра
                    </p>

                    
                    <div style="color: #222" class="vendor_code">
                        <b>Доставка без предоплаты</b>
                    </div>
                    <div style="color: #222" class="vendor_code">
                        <b>Обмен / возврат</b>: 14 дней
                    </div>

                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3290 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>
                    <div class="button art_button" art="2101">Заказать</div>
                </div>
                <div class="hidden">
                    <div class="close"></div>
                    <div class="action">
                        <span>Оставьте заявку</span>
                        <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                    </div>
                    <div class="name">Платье Грация Стиля</div>
                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3290 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>

                    <form class="lt-form main-order-form order_form" action="/success/" method="post">
<select name="aim" class="countryselect" style="display:none"><option value='1'>Россия</option></select>
                        
                        <input type="text" name="name" class="field input" placeholder="Ваше Имя" required value="">
                        <input type="text" name="phone" class="field input" placeholder="Ваш телефон" required value="">
                        <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="delivery" value="0 руб." />
                        <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="user" value="1" />
                        <input type="hidden" name="address" value="Уточнить у покупателя" />
                        <input type="hidden" name="description" class="descr" value="" />

                        <div class="reolader">
                            <button class="button mm_button" type="submit" >
                      Заказать
                    </button>
                            <div class="ajax_loader_block">
                                <img class="ajax_loader" src="./img/ajax-loader.gif" alt="Идет отправка данных"> <br>
                                <span class="ajax_loader">Идет отправка данных</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="product_item">
                <div class="img">
                    <div class="item_slider owl-carousel owl-theme">
                        <a href="catalog_2/10.jpg" data-fancybox="gallery">
                    <img
                      src="./catalog_2/10.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                        <a href="catalog_2/10_2.jpg" data-fancybox="gallery">
                    <img
                     src="catalog_2/10_2.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                    </div>
                </div>
                <div class="content">
                    <div class="name">Платье Грация Стиля</div>
                    <div class="vendor_code">
                        <b>Артикул</b>: <span class="art">352</span>
                    </div>

                    <p class="pm vendor_code material" style="display: none; color: #222">
                        <b>Материал</b>: 60% вискоза 40% полиэстер
                    </p>

                    
                    <div style="color: #222" class="vendor_code">
                        <b>Доставка без предоплаты</b>
                    </div>
                    <div style="color: #222" class="vendor_code">
                        <b>Обмен / возврат</b>: 14 дней
                    </div>

                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3980 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>
                    <div class="button art_button" art="2101">Заказать</div>
                </div>
                <div class="hidden">
                    <div class="close"></div>
                    <div class="action">
                        <span>Оставьте заявку</span>
                        <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                    </div>
                    <div class="name">Платье Грация Стиля</div>
                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3980 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>

                    <form class="lt-form main-order-form order_form" action="/success/" method="post">
<select name="aim" class="countryselect" style="display:none"><option value='1'>Россия</option></select>
                        
                        <input type="text" name="name" class="field input" placeholder="Ваше Имя" required value="">
                        <input type="text" name="phone" class="field input" placeholder="Ваш телефон" required value="">
                        <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="delivery" value="0 руб." />
                        <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="user" value="1" />
                        <input type="hidden" name="address" value="Уточнить у покупателя" />
                        <input type="hidden" name="description" class="descr" value="" />

                        <div class="reolader">
                            <button class="button mm_button" type="submit" >
                      Заказать
                    </button>
                            <div class="ajax_loader_block">
                                <img class="ajax_loader" src="./img/ajax-loader.gif" alt="Идет отправка данных"> <br>
                                <span class="ajax_loader">Идет отправка данных</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="product_item">
                <div class="img">
                    <div class="item_slider owl-carousel owl-theme">
                        <a href="catalog_2/11.jpg" data-fancybox="gallery">
                    <img
                      src="./catalog_2/11.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                        <a href="catalog_2/11_2.jpg" data-fancybox="gallery">
                    <img
                     src="catalog_2/11_2.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                    </div>
                </div>
                <div class="content">
                    <div class="name">Платье Грация Стиля</div>
                    <div class="vendor_code">
                        <b>Артикул</b>: <span class="art">353</span>
                    </div>

                    <p class="pm vendor_code material" style="display: none; color: #222">
                        <b>Материал</b>: 65% вискоза 30% полиэстер 5% лайкра
                    </p>

                    
                    <div style="color: #222" class="vendor_code">
                        <b>Доставка без предоплаты</b>
                    </div>
                    <div style="color: #222" class="vendor_code">
                        <b>Обмен / возврат</b>: 14 дней
                    </div>

                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3450 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>
                    <div class="button art_button" art="2101">Заказать</div>
                </div>
                <div class="hidden">
                    <div class="close"></div>
                    <div class="action">
                        <span>Оставьте заявку</span>
                        <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                    </div>
                    <div class="name">Платье Грация Стиля</div>
                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3450 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>

                    <form class="lt-form main-order-form order_form" action="/success/" method="post">
<select name="aim" class="countryselect" style="display:none"><option value='1'>Россия</option></select>
                        
                        <input type="text" name="name" class="field input" placeholder="Ваше Имя" required value="">
                        <input type="text" name="phone" class="field input" placeholder="Ваш телефон" required value="">
                        <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="delivery" value="0 руб." />
                        <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="user" value="1" />
                        <input type="hidden" name="address" value="Уточнить у покупателя" />
                        <input type="hidden" name="description" class="descr" value="" />

                        <div class="reolader">
                            <button class="button mm_button" type="submit" >
                      Заказать
                    </button>
                            <div class="ajax_loader_block">
                                <img class="ajax_loader" src="./img/ajax-loader.gif" alt="Идет отправка данных"> <br>
                                <span class="ajax_loader">Идет отправка данных</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="product_item">
                <div class="img">
                    <div class="item_slider owl-carousel owl-theme">
                        <a href="catalog_2/12.jpg" data-fancybox="gallery">
                    <img
                      src="./catalog_2/12.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                        <a href="catalog_2/12_2.jpg" data-fancybox="gallery">
                    <img
                     src="catalog_2/12_2.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                    </div>
                </div>
                <div class="content">
                    <div class="name">Платье Грация Стиля</div>
                    <div class="vendor_code">
                        <b>Артикул</b>: <span class="art">354</span>
                    </div>

                    <p class="pm vendor_code material" style="display: none; color: #222">
                        <b>Материал</b>: 65% вискоза 30% полиэстер 5% лайкра
                    </p>

                    
                    <div style="color: #222" class="vendor_code">
                        <b>Доставка без предоплаты</b>
                    </div>
                    <div style="color: #222" class="vendor_code">
                        <b>Обмен / возврат</b>: 14 дней
                    </div>

                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3290 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>
                    <div class="button art_button" art="2101">Заказать</div>
                </div>
                <div class="hidden">
                    <div class="close"></div>
                    <div class="action">
                        <span>Оставьте заявку</span>
                        <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                    </div>
                    <div class="name">Платье Грация Стиля</div>
                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3290 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>

                    <form class="lt-form main-order-form order_form" action="/success/" method="post">
<select name="aim" class="countryselect" style="display:none"><option value='1'>Россия</option></select>
                        
                        <input type="text" name="name" class="field input" placeholder="Ваше Имя" required value="">
                        <input type="text" name="phone" class="field input" placeholder="Ваш телефон" required value="">
                        <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="delivery" value="0 руб." />
                        <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="user" value="1" />
                        <input type="hidden" name="address" value="Уточнить у покупателя" />
                        <input type="hidden" name="description" class="descr" value="" />

                        <div class="reolader">
                            <button class="button mm_button" type="submit" >
                      Заказать
                    </button>
                            <div class="ajax_loader_block">
                                <img class="ajax_loader" src="./img/ajax-loader.gif" alt="Идет отправка данных"> <br>
                                <span class="ajax_loader">Идет отправка данных</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="product_item">
                <div class="img">
                    <div class="item_slider owl-carousel owl-theme">
                        <a href="catalog_2/13.jpg" data-fancybox="gallery">
                    <img
                      src="./catalog_2/13.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                        <a href="catalog_2/13_2.jpg" data-fancybox="gallery">
                    <img
                     src="catalog_2/13_2.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                    </div>
                </div>
                <div class="content">
                    <div class="name">Платье Грация Стиля</div>
                    <div class="vendor_code">
                        <b>Артикул</b>: <span class="art">355</span>
                    </div>

                    <p class="pm vendor_code material" style="display: none; color: #222">
                        <b>Материал</b>: 65% вискоза 30% полиэстер 5% лайкра
                    </p>

                    
                    <div style="color: #222" class="vendor_code">
                        <b>Доставка без предоплаты</b>
                    </div>
                    <div style="color: #222" class="vendor_code">
                        <b>Обмен / возврат</b>: 14 дней
                    </div>

                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3290 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>
                    <div class="button art_button" art="2101">Заказать</div>
                </div>
                <div class="hidden">
                    <div class="close"></div>
                    <div class="action">
                        <span>Оставьте заявку</span>
                        <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                    </div>
                    <div class="name">Платье Грация Стиля</div>
                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3290 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>

                    <form class="lt-form main-order-form order_form" action="/success/" method="post">
<select name="aim" class="countryselect" style="display:none"><option value='1'>Россия</option></select>
                        
                        <input type="text" name="name" class="field input" placeholder="Ваше Имя" required value="">
                        <input type="text" name="phone" class="field input" placeholder="Ваш телефон" required value="">
                        <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="delivery" value="0 руб." />
                        <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="user" value="1" />
                        <input type="hidden" name="address" value="Уточнить у покупателя" />
                        <input type="hidden" name="description" class="descr" value="" />

                        <div class="reolader">
                            <button class="button mm_button" type="submit" >
                      Заказать
                    </button>
                            <div class="ajax_loader_block">
                                <img class="ajax_loader" src="./img/ajax-loader.gif" alt="Идет отправка данных"> <br>
                                <span class="ajax_loader">Идет отправка данных</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="product_item">
                <div class="img">
                    <div class="item_slider owl-carousel owl-theme">
                        <a href="catalog_2/14.jpg" data-fancybox="gallery">
                    <img
                      src="./catalog_2/14.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                        <a href="catalog_2/14_2.jpg" data-fancybox="gallery">
                    <img
                     src="catalog_2/14_2.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                    </div>
                </div>
                <div class="content">
                    <div class="name">Платье Грация Стиля</div>
                    <div class="vendor_code">
                        <b>Артикул</b>: <span class="art">356</span>
                    </div>

                    <p class="pm vendor_code material" style="display: none; color: #222">
                        <b>Материал</b>: 70% полиэстер 25% вискоза 5% лайкра
                    </p>

                    
                    <div style="color: #222" class="vendor_code">
                        <b>Доставка без предоплаты</b>
                    </div>
                    <div style="color: #222" class="vendor_code">
                        <b>Обмен / возврат</b>: 14 дней
                    </div>

                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3780 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>
                    <div class="button art_button" art="2101">Заказать</div>
                </div>
                <div class="hidden">
                    <div class="close"></div>
                    <div class="action">
                        <span>Оставьте заявку</span>
                        <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                    </div>
                    <div class="name">Платье Грация Стиля</div>
                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3780 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>

                    <form class="lt-form main-order-form order_form" action="/success/" method="post">
<select name="aim" class="countryselect" style="display:none"><option value='1'>Россия</option></select>
                        
                        <input type="text" name="name" class="field input" placeholder="Ваше Имя" required value="">
                        <input type="text" name="phone" class="field input" placeholder="Ваш телефон" required value="">
                        <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="delivery" value="0 руб." />
                        <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="user" value="1" />
                        <input type="hidden" name="address" value="Уточнить у покупателя" />
                        <input type="hidden" name="description" class="descr" value="" />

                        <div class="reolader">
                            <button class="button mm_button" type="submit" >
                      Заказать
                    </button>
                            <div class="ajax_loader_block">
                                <img class="ajax_loader" src="./img/ajax-loader.gif" alt="Идет отправка данных"> <br>
                                <span class="ajax_loader">Идет отправка данных</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="product_item">
                <div class="img">
                    <div class="item_slider owl-carousel owl-theme">
                        <a href="catalog_2/15.jpg" data-fancybox="gallery">
                    <img
                      src="./catalog_2/15.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                        <a href="catalog_2/15_2.jpg" data-fancybox="gallery">
                    <img
                     src="catalog_2/15_2.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                    </div>
                </div>
                <div class="content">
                    <div class="name">Платье Грация Стиля</div>
                    <div class="vendor_code">
                        <b>Артикул</b>: <span class="art">357</span>
                    </div>

                    <p class="pm vendor_code material" style="display: none; color: #222">
                        <b>Материал</b>: 95% хлопок 5% лайкра
                    </p>

                    
                    <div style="color: #222" class="vendor_code">
                        <b>Доставка без предоплаты</b>
                    </div>
                    <div style="color: #222" class="vendor_code">
                        <b>Обмен / возврат</b>: 14 дней
                    </div>

                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3780 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>
                    <div class="button art_button" art="2101">Заказать</div>
                </div>
                <div class="hidden">
                    <div class="close"></div>
                    <div class="action">
                        <span>Оставьте заявку</span>
                        <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                    </div>
                    <div class="name">Платье Грация Стиля</div>
                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3780 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>

                    <form class="lt-form main-order-form order_form" action="/success/" method="post">
<select name="aim" class="countryselect" style="display:none"><option value='1'>Россия</option></select>
                        
                        <input type="text" name="name" class="field input" placeholder="Ваше Имя" required value="">
                        <input type="text" name="phone" class="field input" placeholder="Ваш телефон" required value="">
                        <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="delivery" value="0 руб." />
                        <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="user" value="1" />
                        <input type="hidden" name="address" value="Уточнить у покупателя" />
                        <input type="hidden" name="description" class="descr" value="" />

                        <div class="reolader">
                            <button class="button mm_button" type="submit" >
                      Заказать
                    </button>
                            <div class="ajax_loader_block">
                                <img class="ajax_loader" src="./img/ajax-loader.gif" alt="Идет отправка данных"> <br>
                                <span class="ajax_loader">Идет отправка данных</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="product_item">
                <div class="img">
                    <div class="item_slider owl-carousel owl-theme">
                        <a href="catalog_2/16.jpg" data-fancybox="gallery">
                    <img
                      src="./catalog_2/16.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                        <a href="catalog_2/16_2.jpg" data-fancybox="gallery">
                    <img
                     src="catalog_2/16_2.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                    </div>
                </div>
                <div class="content">
                    <div class="name">Платье Грация Стиля</div>
                    <div class="vendor_code">
                        <b>Артикул</b>: <span class="art">358</span>
                    </div>

                    <p class="pm vendor_code material" style="display: none; color: #222">
                        <b>Материал</b>: 100% хлопок
                    </p>

                    
                    <div style="color: #222" class="vendor_code">
                        <b>Доставка без предоплаты</b>
                    </div>
                    <div style="color: #222" class="vendor_code">
                        <b>Обмен / возврат</b>: 14 дней
                    </div>

                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3980 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>
                    <div class="button art_button" art="2101">Заказать</div>
                </div>
                <div class="hidden">
                    <div class="close"></div>
                    <div class="action">
                        <span>Оставьте заявку</span>
                        <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                    </div>
                    <div class="name">Платье Грация Стиля</div>
                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3980 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>

                    <form class="lt-form main-order-form order_form" action="/success/" method="post">
<select name="aim" class="countryselect" style="display:none"><option value='1'>Россия</option></select>
                        
                        <input type="text" name="name" class="field input" placeholder="Ваше Имя" required value="">
                        <input type="text" name="phone" class="field input" placeholder="Ваш телефон" required value="">
                        <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="delivery" value="0 руб." />
                        <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="user" value="1" />
                        <input type="hidden" name="address" value="Уточнить у покупателя" />
                        <input type="hidden" name="description" class="descr" value="" />

                        <div class="reolader">
                            <button class="button mm_button" type="submit" >
                      Заказать
                    </button>
                            <div class="ajax_loader_block">
                                <img class="ajax_loader" src="./img/ajax-loader.gif" alt="Идет отправка данных"> <br>
                                <span class="ajax_loader">Идет отправка данных</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="product_item">
                <div class="img">
                    <div class="item_slider owl-carousel owl-theme">
                        <a href="catalog_2/17.jpg" data-fancybox="gallery">
                    <img
                      src="./catalog_2/17.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                        <a href="catalog_2/17_2.jpg" data-fancybox="gallery">
                    <img
                     src="catalog_2/17_2.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                    </div>
                </div>
                <div class="content">
                    <div class="name">Платье Грация Стиля</div>
                    <div class="vendor_code">
                        <b>Артикул</b>: <span class="art">359</span>
                    </div>

                    <p class="pm vendor_code material" style="display: none; color: #222">
                        <b>Материал</b>: 65% вискоза 30% полиэстер 5% лайкра
                    </p>

                    
                    <div style="color: #222" class="vendor_code">
                        <b>Доставка без предоплаты</b>
                    </div>
                    <div style="color: #222" class="vendor_code">
                        <b>Обмен / возврат</b>: 14 дней
                    </div>

                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3290 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>
                    <div class="button art_button" art="2101">Заказать</div>
                </div>
                <div class="hidden">
                    <div class="close"></div>
                    <div class="action">
                        <span>Оставьте заявку</span>
                        <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                    </div>
                    <div class="name">Платье Грация Стиля</div>
                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3290 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>

                    <form class="lt-form main-order-form order_form" action="/success/" method="post">
<select name="aim" class="countryselect" style="display:none"><option value='1'>Россия</option></select>
                        
                        <input type="text" name="name" class="field input" placeholder="Ваше Имя" required value="">
                        <input type="text" name="phone" class="field input" placeholder="Ваш телефон" required value="">
                        <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="delivery" value="0 руб." />
                        <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="user" value="1" />
                        <input type="hidden" name="address" value="Уточнить у покупателя" />
                        <input type="hidden" name="description" class="descr" value="" />

                        <div class="reolader">
                            <button class="button mm_button" type="submit" >
                      Заказать
                    </button>
                            <div class="ajax_loader_block">
                                <img class="ajax_loader" src="./img/ajax-loader.gif" alt="Идет отправка данных"> <br>
                                <span class="ajax_loader">Идет отправка данных</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="product_item">
                <div class="img">
                    <div class="item_slider owl-carousel owl-theme">
                        <a href="catalog_2/18.jpg" data-fancybox="gallery">
                    <img
                      src="./catalog_2/18.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                        <a href="catalog_2/18_2.jpg" data-fancybox="gallery">
                    <img
                     src="catalog_2/18_2.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                    </div>
                </div>
                <div class="content">
                    <div class="name">Платье Грация Стиля</div>
                    <div class="vendor_code">
                        <b>Артикул</b>: <span class="art">360</span>
                    </div>

                    <p class="pm vendor_code material" style="display: none; color: #222">
                        <b>Материал</b>: 95% вискоза 5% лайкра
                    </p>

                    
                    <div style="color: #222" class="vendor_code">
                        <b>Доставка без предоплаты</b>
                    </div>
                    <div style="color: #222" class="vendor_code">
                        <b>Обмен / возврат</b>: 14 дней
                    </div>

                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3450 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>
                    <div class="button art_button" art="2101">Заказать</div>
                </div>
                <div class="hidden">
                    <div class="close"></div>
                    <div class="action">
                        <span>Оставьте заявку</span>
                        <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                    </div>
                    <div class="name">Платье Грация Стиля</div>
                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3450 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>

                    <form class="lt-form main-order-form order_form" action="/success/" method="post">
<select name="aim" class="countryselect" style="display:none"><option value='1'>Россия</option></select>
                        
                        <input type="text" name="name" class="field input" placeholder="Ваше Имя" required value="">
                        <input type="text" name="phone" class="field input" placeholder="Ваш телефон" required value="">
                        <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="delivery" value="0 руб." />
                        <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="user" value="1" />
                        <input type="hidden" name="address" value="Уточнить у покупателя" />
                        <input type="hidden" name="description" class="descr" value="" />

                        <div class="reolader">
                            <button class="button mm_button" type="submit" >
                      Заказать
                    </button>
                            <div class="ajax_loader_block">
                                <img class="ajax_loader" src="./img/ajax-loader.gif" alt="Идет отправка данных"> <br>
                                <span class="ajax_loader">Идет отправка данных</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="product_item">
                <div class="img">
                    <div class="item_slider owl-carousel owl-theme">
                        <a href="catalog_2/19.jpg" data-fancybox="gallery">
                    <img
                      src="./catalog_2/19.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                        <a href="catalog_2/19_2.jpg" data-fancybox="gallery">
                    <img
                     src="catalog_2/19_2.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                    </div>
                </div>
                <div class="content">
                    <div class="name">Платье Грация Стиля</div>
                    <div class="vendor_code">
                        <b>Артикул</b>: <span class="art">361</span>
                    </div>

                    <p class="pm vendor_code material" style="display: none; color: #222">
                        <b>Материал</b>: 100% хлопок
                    </p>

                    
                    <div style="color: #222" class="vendor_code">
                        <b>Доставка без предоплаты</b>
                    </div>
                    <div style="color: #222" class="vendor_code">
                        <b>Обмен / возврат</b>: 14 дней
                    </div>

                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3450 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>
                    <div class="button art_button" art="2101">Заказать</div>
                </div>
                <div class="hidden">
                    <div class="close"></div>
                    <div class="action">
                        <span>Оставьте заявку</span>
                        <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                    </div>
                    <div class="name">Платье Грация Стиля</div>
                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3450 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>

                    <form class="lt-form main-order-form order_form" action="/success/" method="post">
<select name="aim" class="countryselect" style="display:none"><option value='1'>Россия</option></select>
                        
                        <input type="text" name="name" class="field input" placeholder="Ваше Имя" required value="">
                        <input type="text" name="phone" class="field input" placeholder="Ваш телефон" required value="">
                        <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="delivery" value="0 руб." />
                        <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="user" value="1" />
                        <input type="hidden" name="address" value="Уточнить у покупателя" />
                        <input type="hidden" name="description" class="descr" value="" />

                        <div class="reolader">
                            <button class="button mm_button" type="submit" >
                      Заказать
                    </button>
                            <div class="ajax_loader_block">
                                <img class="ajax_loader" src="./img/ajax-loader.gif" alt="Идет отправка данных"> <br>
                                <span class="ajax_loader">Идет отправка данных</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="product_item">
                <div class="img">
                    <div class="item_slider owl-carousel owl-theme">
                        <a href="catalog_2/20.jpg" data-fancybox="gallery">
                    <img
                      src="./catalog_2/20.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                        <a href="catalog_2/20_2.jpg" data-fancybox="gallery">
                    <img
                     src="catalog_2/20_2.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                    </div>
                </div>
                <div class="content">
                    <div class="name">Платье Грация Стиля</div>
                    <div class="vendor_code">
                        <b>Артикул</b>: <span class="art">362</span>
                    </div>

                    <p class="pm vendor_code material" style="display: none; color: #222">
                        <b>Материал</b>: 100% хлопок
                    </p>

                    
                    <div style="color: #222" class="vendor_code">
                        <b>Доставка без предоплаты</b>
                    </div>
                    <div style="color: #222" class="vendor_code">
                        <b>Обмен / возврат</b>: 14 дней
                    </div>

                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3290 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>
                    <div class="button art_button" art="2101">Заказать</div>
                </div>
                <div class="hidden">
                    <div class="close"></div>
                    <div class="action">
                        <span>Оставьте заявку</span>
                        <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                    </div>
                    <div class="name">Платье Грация Стиля</div>
                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3290 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>

                    <form class="lt-form main-order-form order_form" action="/success/" method="post">
<select name="aim" class="countryselect" style="display:none"><option value='1'>Россия</option></select>
                        
                        <input type="text" name="name" class="field input" placeholder="Ваше Имя" required value="">
                        <input type="text" name="phone" class="field input" placeholder="Ваш телефон" required value="">
                        <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="delivery" value="0 руб." />
                        <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="user" value="1" />
                        <input type="hidden" name="address" value="Уточнить у покупателя" />
                        <input type="hidden" name="description" class="descr" value="" />

                        <div class="reolader">
                            <button class="button mm_button" type="submit" >
                      Заказать
                    </button>
                            <div class="ajax_loader_block">
                                <img class="ajax_loader" src="./img/ajax-loader.gif" alt="Идет отправка данных"> <br>
                                <span class="ajax_loader">Идет отправка данных</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="product_item">
                <div class="img">
                    <div class="item_slider owl-carousel owl-theme">
                        <a href="catalog_2/21.jpg" data-fancybox="gallery">
                    <img
                      src="./catalog_2/21.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                        <a href="catalog_2/21_2.jpg" data-fancybox="gallery">
                    <img
                     src="catalog_2/21_2.jpg"
                      class="b-lazy"
                      alt=""
                    />
                  </a>
                    </div>
                </div>
                <div class="content">
                    <div class="name">Платье Грация Стиля</div>
                    <div class="vendor_code">
                        <b>Артикул</b>: <span class="art">363</span>
                    </div>

                    <p class="pm vendor_code material" style="display: none; color: #222">
                        <b>Материал</b>: 70% полиэстер 30% вискоза
                    </p>

                    
                    <div style="color: #222" class="vendor_code">
                        <b>Доставка без предоплаты</b>
                    </div>
                    <div style="color: #222" class="vendor_code">
                        <b>Обмен / возврат</b>: 14 дней
                    </div>

                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3290 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>
                    <div class="button art_button" art="2101">Заказать</div>
                </div>
                <div class="hidden">
                    <div class="close"></div>
                    <div class="action">
                        <span>Оставьте заявку</span>
                        <p>Мы перезвоним вам и поможем правильно подобрать размер</p>
                    </div>
                    <div class="name">Платье Грация Стиля</div>
                    <div class="price_block clearfix">
                        <div class="price_item old">
                            <x-oldprice>3290 руб.</x-oldprice>
                        </div>
                        <div class="price_item new">
                            <x-newprice class="productsum"></x-newprice>
                        </div>
                    </div>

                    <form class="lt-form main-order-form order_form" action="/success/" method="post">
<select name="aim" class="countryselect" style="display:none"><option value='1'>Россия</option></select>

                        <input type="text" name="name" class="field input" placeholder="Ваше Имя" required value="">
                        <input type="text" name="phone" class="field input" placeholder="Ваш телефон" required value="">
                        <input type="hidden" name="productsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="delivery" value="0 руб." />
                        <input type="hidden" name="totalsum" class="productsum" value="1 руб." />
                        <input type="hidden" name="user" value="1" />
                        <input type="hidden" name="address" value="Уточнить у покупателя" />
                        <input type="hidden" name="description" class="descr" value="" />

                        <div class="reolader">
                            <button class="button mm_button" type="submit" >
                      Заказать
                    </button>
                            <div class="ajax_loader_block">
                                <img class="ajax_loader" src="./img/ajax-loader.gif" alt="Идет отправка данных"> <br>
                                <span class="ajax_loader">Идет отправка данных</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>




          </div>
        </div>
      </section>

      <section class="can-section" id="product">
        <div class="container">
          <div class="can-title title">
            <h1>
              Платья, о которых мечтает весь мир. Теперь вы можете себе их
              позволить!
            </h1>
          </div>
          <div class="can-box">
            <div class="can-item">
              <div class="can-item_icon">
                <img src="img/can-icon.png" />
              </div>
              <div class="can-item_name">
                В эксклюзивном платье <br />- ты прекрасна!
              </div>
              <div class="can-item_text">
                Мужчины будут с восхищением смотреть вам вслед, вспоминая и
                напевая песню: <br /><span>«Ах, какая женщина!»</span>
              </div>
            </div>

            <div class="can-item">
              <div class="can-item_icon">
                <img src="img/can-icon.png" />
              </div>
              <div class="can-item_name">
                В эксклюзивном платье <br />- ты шикарна!
              </div>
              <div class="can-item_text">
                Высочайшее качество платьев из нашего магазина сразу же
                бросается в глаза и подчеркивает
                <span>ваш высокий статус.</span>
              </div>
            </div>

            <div class="can-item">
              <div class="can-item_icon">
                <img src="img/can-icon.png" />
              </div>
              <div class="can-item_name">
                В эксклюзивном платье <br />- ты уникальна!
              </div>
              <div class="can-item_text">
                Платье для Paris Fashion Week
                <span>выпускаются ограниченным тиражом,</span> вы никогда не
                встретите другую женщину в таком же платье, как у вас.
              </div>
            </div>

            <div class="can-item">
              <div class="can-item_icon">
                <img src="img/can-icon.png" />
              </div>
              <div class="can-item_name">
                В эксклюзивном платье - <br />ты уверена в себе!
              </div>
              <div class="can-item_text">
                Окружающие увидят тебя новую —
                <span>красивую, сильную и уверенную в себе женщину,</span>
                которой любые свершения даются легко и беззаботно!
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="uniq-section" id="advantages">
        <div class="container">
          <div class="uniq-title title">
            <h1>
              Воспользуйтесь уникальной возможностью, <br />которую дарит вам
              наш магазин!
            </h1>
          </div>

          <div class="uniq-content_wrapper">
            <div class="uniq-item">
              <div class="uniq-item_img">
                <img src="img/uniq1.png" alt />
              </div>
              <div class="uniq-item_title">
                Событие, которое случается <br />
                крайне редко!
              </div>
              <div class="uniq-item_text">
                В этом году нашему интернет-магазину удалось <br />
                закупить эксклюзивную коллекцию платьев <br />
                «Осень-зима 2021» от известных европейских брендов, <br />
                которая была представлена на
                <span>Paris Fashion Week 2020!</span>
              </div>
            </div>

            <div class="uniq-item">
              <div class="uniq-item_img">
                <img src="img/uniq2.png" alt />
              </div>
              <div class="uniq-item_title">
                новинки, выпущенные <br />
                ограниченным тиражом
              </div>
              <div class="uniq-item_text">
                В обычных магазинах эти платья не появятся <br />
                никогда! В дорогих эксклюзивных бутиках эти <br />
                платья возможно будут в продаже, а может быть и
                <br />
                нет. Вы можете быть уверены, что
                <span
                  >получаете <br />
                  эксклюзивную вещь, уникальность которой <br />
                  подтверждена!</span
                >
              </div>
            </div>

            <div class="uniq-item">
              <div class="uniq-item_img">
                <img src="img/uniq3.png" alt />
              </div>
              <div class="uniq-item_title">
                Европейское высшее качество, <br />
                российские цены!
              </div>
              <div class="uniq-item_text">
                Мы получаем платья напрямую от производителей <br />
                — европейских фабрик, которые шьют одежду <br />
                всемирно известных брендов. Каждая партия <br />
                товара
                <span
                  >сопровождается сертификатами, <br />
                  подтверждающими подлинность изделия.</span
                >
              </div>
            </div>
          </div>

          <div class="uniq-under_wrapper">
            <div class="uniq-under_title">
              Подарите себе праздник! <br />
              Станьте самой модной, красивой, стильной и элегантной!
            </div>
            <div class="uniq-under_price-wrap">
              <div class="uniq-old-price">3780 руб.</div>
              <div class="uniq-new-price">1390 руб.</div>
            </div>

            <div class="uniq-under_catalog js-scroll">
              <a href="#catalog">Смотреть каталог</a>
            </div>
          </div>
        </div>
      </section>

      <section class="quality-section" id="warranty">
        <div class="container">
          <div class="qual-title title">
            <h1>
              Наш интернет-магазин - ваш надёжный поставщик модных<br />европейских
              вещей от известных брендов!
            </h1>
          </div>
          <div class="qual-undertitle">Работаем уже более 10 лет!</div>

          <div class="qual-content_wrapper">
            <div class="qual_item">
              <div class="qual_item">
                <img src="img/qual1.png" alt />
              </div>
              <div class="qual-item_title">Гарантия — <br />100% оригинал!</div>
              <div class="qual-item_text">
                Вы получаете точно такой же костюм от известных брендов, как и
                женщины в Европе и США!
              </div>
            </div>

            <div class="qual_item">
              <div class="qual_item">
                <img src="img/qual2.png" alt />
              </div>
              <div class="qual-item_title">
                Гарантия — <br />высшее качество!
              </div>
              <div class="qual-item_text">
                Вся продукция, реализуемая на нашем сайте, имеет сертификаты
                соответствия!
              </div>
            </div>

            <div class="qual_item">
              <div class="qual_item">
                <img src="img/qual3.png" alt />
              </div>
              <div class="qual-item_title">
                Гарантия -<br />
                эксклюзивность!
              </div>
              <div class="qual-item_text">
                Мы единственный поставщик в РФ женской одежды многих популярных
                европейских брендов!
              </div>
            </div>
          </div>
        </div>
      </section>


      <section class="section23">
      <div class="container">
        <style>
          div.sc-intro {
            border: 2px solid #ED008C;
            border-radius: 6px;
            position: relative;
            padding: 20px 220px 16px 22px;
          }

          div.sc-intro div.body {
            background: url(intro_body.png) no-repeat 2px 0;
          }

          div.sc-intro>div {
            padding-left: 60px;
            margin-bottom: 4px;
          }

          div.sc-intro p {
            margin: 2px 0;
          }

          .bold15 {
            font-size: 15px;
            font-weight: bold;
          }

          div.sc-intro div.tape {
            background: url(intro_tape.png) no-repeat;
          }

          div.sc-intro div.dress {
            background: url(intro_dress.png) no-repeat 3px 0;
          }

          div.sc-intro:after {
            content: "";
            background: url(intro_icon.png) center center / contain no-repeat;
            display: block;
            position: absolute;
            top: 25px;
            right: 0;
            padding: 70px;
          }

          div.sc-page-wrapper {
            border: 1px solid #EDEDED;
            border-radius: 3px;
            margin: 16px 0;
          }

          div.sc-menu-wrapper {
            display: table;
            width: 100%;
          }

          div.sc-menu {
            display: table-row;
          }

          .bold21 {
            font-size: 21px;
            font-weight: bold;
          }

          div.sc-menu>div.active {
            background: white;
            border-bottom: 0;
          }

          div.sc-menu>div:nth-child(1) {
            border-right: 1px solid #EDEDED;
          }

          div.sc-menu>div {
            background: #F5F5F5;
            border-bottom: 1px solid #EDEDED;
            cursor: pointer;
            display: table-cell;
            padding: 20px 10px;
            width: 33.33%;
            text-align: center;
          }

          div.sc-page {
            padding: 20px;
            overflow: hidden;
          }

          span.sc-num {
            border: 1px solid #ED008C;
            border-radius: 50%;
            box-sizing: content-box !important;
            color: #ED008C;
            display: inline-block;
            font-weight: bold;
            font-size: 18px;
            line-height: 1;
            height: 18px;
            width: 18px;
            padding: 8px;
            margin-right: 10px;
            text-align: center;
          }

          span.title {
            display: inline-block;
            line-height: 1;
            vertical-align: top;
            padding-top: 7px;
            width: calc(100% - 46px);
          }

          div.sc-page-dress div.img {
            background: url(dress_body.png) no-repeat 0 -20px;
            height: 228px;
            width: 156px;
            float: left;
            margin-right: 30px;
          }

          div.sc-page div.line {
            background: #ED008C;
            height: 3px;
            position: relative;
          }

          div.sc-page div.line1:after {
            background: #ED008C;
            border-radius: 50%;
            content: "";
            display: block;
            position: absolute;
            height: 13px;
            width: 13px;
            right: -1px;
            top: -5px;
          }

          div.sc-page div.line {
            background: #ED008C;
            height: 3px;
            position: relative;
          }

          div.img-info {
            position: relative;
          }

          div.sc-page-dress div.img-info1 {
            margin-top: 30px;
          }

          .bold15 {
            font-size: 15px;
            font-weight: bold;
          }

          div.sc-page-dress div.img-info2 {
            margin-top: 54px;
          }

          div.sc-page table {
            margin-top: 20px;
            width: 100%;
            font-size: 16px;
          }

          div.sc-page table th,
          div.sc-page table td {
            padding: 8px 12px;
          }

          div.sc-page table .border-first {
            border-left: 2px solid #ED008C;
            border-top: 2px solid #ED008C;
            border-right: 2px solid #ED008C;
            color: #ED008C;
          }

          div.sc-page {
            padding: 20px;
            overflow: hidden;
          }

          div.sc-page table .border-n {
            border-left: 2px solid #ED008C;
            border-right: 2px solid #ED008C;
            color: #ED008C;
          }

          div.sc-page table .border-last {
            border-left: 2px solid #ED008C;
            border-bottom: 2px solid #ED008C;
            border-right: 2px solid #ED008C;
            color: #ED008C;
          }

          span.sc-num {
            border: 1px solid #ED008C;
            border-radius: 50%;
            box-sizing: content-box !important;
            color: #ED008C;
            display: inline-block;
            font-weight: bold;
            font-size: 18px;
            line-height: 1;
            height: 18px;
            width: 18px;
            padding: 8px;
            margin-right: 10px;
            text-align: center;
          }

          div.sc-page-swimwear div.img-info1 {
            margin-top: 50px;
          }

          @media (max-width: 786px) {
            div.sc-intro {
              padding: 20px;
            }
          }
        </style>

        <div class="wrapper" style="margin: 20px auto;">

          <h2 style="text-align: center; margin: 30px 0; font-size: 36px;">РАЗМЕРНАЯ СЕТКА</h2>
          <div class="sc-intro">
            <div class="body">
              <p class="bold15">Все измерения лучше производить, находясь в одном нижнем белье</p>
              <p>В этом случае они будут точнее. Мерки можно снять и самостоятельно, но для Вашего удобства и верности
                измерений воспользуйтесь помощью подруги.</p>
            </div>

            <div class="tape">
              <p class="bold15">Располагайте измерительную ленту как можно ближе к телу, но она не должна Вас утягивать
              </p>
              <p>Также при снятии мерок необходимо, чтобы измерительная лента проходила горизонтально полу.</p>
            </div>

            <div class="dress">
              <p class="bold15">Полученные измерения не являются точными при определении размера</p>
              <p>Нужно ориентироваться, в первую очередь, на тот российский размер, который Вы обычно носите.</p>
            </div>
          </div>
          <div class="sc-page-wrapper" style="background: #fff;">
            <div class="sc-menu-wrapper">
              <div class="sc-menu bold21">
                <div class="active" onclick="showVariant(1)">Женская одежда</div>
              </div>
            </div>

            <div class="sc-page sc-page-dress" style="display: block;">
              <p>Для определения размера нужно выполнить несколько шагов:</p>

              <p style="margin-top: 20px;"><span class="sc-num">1</span><span class="title bold21">Измерьте объем груди
                  и объем бедер</span></p>
              <div class="img">
                <div class="line line1" style="left: 42px; top:  38px; width: 130px"></div>
                <div class="line line1" style="left: 32px; top: 140px; width: 140px"></div>
              </div>
              <div class="img-info">
                <div class="img-info1">
                  <p class="bold15">Объем груди</p>
                  <p>Измеряется горизонтально на уровне подмышечных впадин по линии самых высоких точек груди.</p>
                </div>
                <div class="img-info2">
                  <p class="bold15">Объем бедер</p>
                  <p>Измеряется горизонтально и проходит через выступающие точки ягодиц.</p>
                </div>
              </div>
              <div style="clear: both"></div>

              <p><span class="sc-num">2</span><span class="title bold21">Определите ваш размер, подставив
                  соответствующие значения</span>
                <br><span style="margin-left: 50px; opacity: 0.8">* Доступные цвета и размеры уточняйте у менеджера</span></p>
                  
              <table>
                <thead>
                  <tr>
                    <th class="bold17">Объем груди в см.</th>
                    <th class="bold17">Объем бедер в см.</th>
                    <th class="bold17 border-first">Размер для заказа</th>
                  </tr>
                </thead>
                <tbody>

                  <tr>
                    <td>80</td>
                    <td>88</td>
                    <td class="border-n">40</td>
                  </tr>
                  <tr>
                    <td>84</td>
                    <td>92</td>
                    <td class="border-n">42</td>
                  </tr>
                  <tr>
                    <td>88</td>
                    <td>96</td>
                    <td class="border-n">44</td>
                  </tr>
                  <tr>
                    <td>92</td>
                    <td>100</td>
                    <td class="border-n">46</td>
                  </tr>
                  <tr>
                    <td>96</td>
                    <td>104</td>
                    <td class="border-n">48</td>
                  </tr>
                  <tr>
                    <td>100</td>
                    <td>108</td>
                    <td class="border-n">50</td>
                  </tr>
                  <tr>
                    <td>104</td>
                    <td>112</td>
                    <td class="border-n">52</td>
                  </tr>
                  <tr>
                    <td>108</td>
                    <td>116</td>
                    <td class="border-n">54</td>
                  </tr>
                  <tr>
                    <td>112</td>
                    <td>120</td>
                    <td class="border-n">56</td>
                  </tr>
                  <tr>
                    <td>116</td>
                    <td>124</td>
                    <td class="border-n">58</td>
                  </tr>
                  <tr>
                    <td>120</td>
                    <td>128</td>
                    <td class="border-n">60</td>
                  </tr>
                  <tr>
                    <td>124</td>
                    <td>132</td>
                    <td class="border-n">62</td>
                  </tr>
                  <tr>
                    <td>128</td>
                    <td>136</td>
                    <td class="border-n">64</td>
                  </tr>
                  <tr>
                    <td>132</td>
                    <td>140</td>
                    <td class="border-n">66</td>
                  </tr>
                  <tr>
                    <td>136</td>
                    <td>144</td>
                    <td class="border-n">68</td>
                  </tr>
                  <tr>
                    <td>140</td>
                    <td>148</td>
                    <td class="border-n">70</td>
                  </tr>
                  <tr>
                    <td>144</td>
                    <td>152</td>
                    <td class="border-n">72</td>
                  </tr>
                  <tr>
                    <td>148</td>
                    <td>156</td>
                    <td class="border-n">74</td>
                  </tr>
                  <tr>
                    <td>152</td>
                    <td>160</td>
                    <td class="border-n">76</td>
                  </tr>
                  <tr>
                    <td>156</td>
                    <td>164</td>
                    <td class="border-n">78</td>
                  </tr>
                  <tr>
                    <td>160</td>
                    <td>168</td>
                    <td class="border-last">80</td>
                  </tr>

                </tbody>
              </table>
            </div>

          </div>
          <center style="background: #d682f9;
              font-weight: bold;
              color: #fff;
              margin: 0 20px;
              padding: 20px 0;
              box-shadow: 3px 3px 11px 0px #0000002e;">* Доступные цвета и размеры уточняйте у менеджера</center>
        </div>
      </div>
    </section>


      <section class="about-section">
        <div class="container">
          <div class="about-content_wrapper">
            <div class="about-text1">
              Уникальное предложение для новых клиентов! <br />
              Хватит переживать, что полученное платье вам не подойдет!
            </div>
            <div class="about-text2">Примеряй без риска!</div>
            <div class="about-similar-text">
              Мы приготовили для вас специальное уникальное предложение:
            </div>
            <div class="about-similar-text">
              закажите одно или несколько платьев, примерьте их дома, оцените
              качество, и как они на вас <br />сидят, спросите мнение у людей,
              которым вы доверяете, и только после этого принимайте
              <br />окончательное решение.
            </div>
            <div class="about-similar-text">
              Если вас что-то не устроит, то в течение 14 дней с момента
              получения вышлите платье нам <br />
              обратно, и мы заменим его на другую модель по вашему желанию!
            </div>
            <div class="about-text6">
              Получи идеальное платье благодаря примерке!
            </div>
          </div>
        </div>
      </section>

      <section class="comment-section" id="reviews">
        <div class="container">
          <div class="comment-title title">
            <h1>Отзывы наших клиентов</h1>
          </div>
          <div class="comment-content_wrapper">
            <div class="comment_item">
              <div class="comment-item_img">
                <img src="img/comment1.png" alt />
              </div>
              <div class="comment-item_text-wrap">
                <div class="comment-text-wrap_text">
                  Настоящая семейная вещь для дома. На прикосновение мягкая ткань .Не в
                  обтяжку - скрывает недостатки и особенности фигуры. <br />
                </div>
                <div class="comment-text-wrap_text">
                  Получила от вас платье, все просто <br />
                  превосходно! Жаль только одно не совсем <br />
                  по цвету подошло к моим глазам, поэтому <br />
                  пришлось вернуть.
                  <span
                    >Замену получила, <br />
                    спасибо!</span
                  >
                </div>
              </div>
              <div class="comment-item_subtitle">Ольга, Москва</div>
            </div>

            <div class="comment_item">
              <div class="comment-item_img">
                <img src="img/comment2.png" alt />
              </div>
              <div class="comment-item_text-wrap">
                <div class="comment-text-wrap_text">
                  Получила платье. Качество — высший <br />
                  сорт. Выравнивает фигуру, придавая стройность. Мягкая ткань -
                  хорошо носить без белья. Элегантная кружевная отделка. Уютно.
                  Прекрасный домашний вариант.
                  <span
                    >качественная вещь, пошитая в <br />
                    Европе.</span
                  >
                </div>
                <div class="comment-text-wrap_text">
                  Сделала повторный заказ.
                </div>
                <div class="comment-text-wrap_text">Спасибо!</div>
              </div>
              <div
                class="comment-item_subtitle comment-item_subtitle2 comment-item_subtitle22"
              >
                Татьяна, Санкт-Петербург
              </div>
            </div>

            <div class="comment_item">
              <div class="comment-item_img">
                <img src="img/comment3.png" alt />
              </div>
              <div class="comment-item_text-wrap">
                <div class="comment-text-wrap_text">
                  Я — ваш постоянный клиент. Очень мне <br />
                  импонирует ваш подход к подбору <br />
                  товаров. А в этом году вы, конечно же, <br />
                  превзошли сами себя, когда привезли <br />
                  <span>Платья Грация Стиля</span> в нашу страну.
                </div>
                <div class="comment-text-wrap_text">
                  Сама ношу вещи из вашего магазина и <br />
                  всем рекомендую!
                </div>
              </div>
              <div class="comment-item_subtitle comment-item_subtitle2">
                Александра, Краснодар
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="supersell-section">
        <div class="container">
          <div class="ss-content_wrapper">
            <div class="ss-content_title title">
              <h1>
                Эксклюзивные вещи <br />
                от лучших европейских брендов!
              </h1>
            </div>
            <div class="ss-content_subtitle">
              Суперраспродажа <br />остатков!
            </div>
            <div class="ss-content-old_price">3980 руб.</div>
            <div class="ss-content-new_price">1390 руб.</div>
            <div class="ss-catalog">
              <a href="#catalog">Смотреть каталог</a>
            </div>
          </div>
        </div>
      </section>

      <footer>
        <div class="container">
          <div class="footer-content">
            <div class="footer-logo_img">
              <img src="img/footer-logo.png" alt />
            </div>
            <div class="footer-menu">
              <div class="footer-menu_link">
                <a class="ollia66 js-scroll" href="#catalog">Каталог</a>
              </div>
              <div class="footer-menu_link">
                <a class="ollia1 js-scroll" href="#product">О продукции</a>
              </div>
              <div class="footer-menu_link">
                <a class="ollia4 js-scroll" href="#reviews">Отзывы</a>
              </div>
              <div class="footer-menu_link">
                <a class="ollia2 js-scroll" href="#advantages">Преимущества</a>
              </div>
            </div>
          </div>
          <div class="footer-anograph">2020. Все права защищены.</div>
          <div class="footer-anograph">
          <p>ООО "СТАРШОП" ИНН/КПП: 2801219599/280101001 ОГРН: 1162801054811. Юр. адрес: 675000 г. Благовещенск ул. 50 лет октября 28</p>
          </div>
          <div class="footer-anograph">
            <a href="politika.html" target="_blank">Политика&nbsp;конфиденциальности</a>
            <a href="agreement.html" target="_blank">Пользовательское&nbsp;соглашение</a>
          </div>
        </div>
      </footer>

      <!-- <div class="hidden">
		<div class="popup-wrapper" id="popup-wrapper">
			<div class="popup-left">
				<div class="popup-img">
					<img src="img/popup-img.jpg">
				</div>
			</div>
			<div class="popup-right">
				<p class="hpop popup-title">
					Название модели
				</p>
				<div class="popup-prices">
					<div class="popup-notoday">
						<p>3980 руб.</p>
					</div>
					<div class="popup-today">
						<div>Цена сегодня:</div>
						<span>1390</span>
						<p>руб.</p>
					</div>
				</div>
				<form class="lt-form popup-form" action="/success.php" method="post" id="lv-formLanding1">
					<div class="popup-phone">
						<input type="hidden" class="bistro" name="bistro" value>
								<input type="hidden" class="web_master" name="web_master" value>
								<input type="hidden" class="bistro_price" name="bistro_price" value>
								<input type="hidden" name="utm_source" value>
								<input type="hidden" name="utm_medium" value>
								<input type="hidden" name="utm_campaign" value>
								<input type="hidden" name="utm_content" value>
								<input type="hidden" name="utm_term" value>
								<input type="hidden" name="name" class="fio" value="Быстрый заказ">
								<input type="hidden" name="comment" class="comment" value>
						<span>Введите Ваш номер телефона:</span>
						
						<input type="text" class="phone tel" autocomplete="off" name="phone" value placeholder="+7(___)__-__-___" maxlength="16"> 
						<input type="submit" class="btn popzakbtn buttons22 commentButton" nomer="1" value="Быстрый заказ">
					</div>
				</form>
				<div class="bzakaz">
							
				</div>
				<a href="#" id_product class="btn popzakbtnbig">добавить в корзину и продолжить покупки</a>
			</div>
		</div>	
	</div> -->
    </div>

    <script src="js/blazy.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.fancybox.min.js"></script>
    <script src="js/jquery.panorama.js"></script>
    <script src="js/scripts.js"></script>
  
    <script type="text/javascript">
        var hash = "82PL5";
        var lt_landing_id = 0;
        var success_page = "success/success.php";
        var failure_page = "success/failure.php";
        
    </script>
    <script type="text/javascript" src="js/send.min.js" charset='UTF-8'></script>
    </body>
</html>
