<!DOCTYPE html>
<html>
    <head>
        <title>Jednoduchá RSS čtečka</title>
        <meta charset="utf-8"/>
    </head>
    <body>
        <h1>Jednoduchá RSS čtečka</h1>
        <?php
            $file = 'http://akce.vse.cz/rss/zabava/';

            //následující kód je ukázkou jednoduchého zpracování RSS zdroje - pozor, RSS zdroje mohou být ve větším množství formátů, které se liší svojí strukturou!

            echo '<p>Soubor: <a href="'.htmlspecialchars($file).'">'.htmlspecialchars($file).'</a></p>';

            $xml=simplexml_load_file($file);//načteme soubor ze vzdáleného zdroje (za využití fopen wrapperu)
            if (!empty($xml->channel)){//zjistíme, jestli v kořenovém elementu existují podelementy "channel"; na elementy v hlavním jmenném prostoru se ptáme jednoduše bez jmenného prostoru...
                foreach ($xml->channel as $channel){
                    echo '<h2>'.(string)$channel->title.'</h2>';
                    if (!empty($channel->link)){
                        echo '<a href="'.$channel->link.'">'.$channel->link.'</a>';
                    }

                    if (!empty($channel->item)){
                        echo '<ul>';
                        foreach ($channel->item as $item){
                            echo '<li>';
                            if (!empty($item->link)){
                                echo '<a href="'.$item->link.'">';
                            }
                            echo $item->title;
                            if (!empty($item->link)) {
                                echo '</a>';
                            }
                            echo '</li>';
                            //TODO : upravte výpis tak, aby obsahoval také popisky jednotlivých položek...
                        }
                        echo '</ul>';
                    }
                }
            }


        ?>
    </body>
</html>