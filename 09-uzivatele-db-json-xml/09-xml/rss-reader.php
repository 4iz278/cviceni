<!DOCTYPE html>
<html lang="cs">
    <head>
        <title>Jednoduchá RSS čtečka</title>
        <meta charset="utf-8"/>
    </head>
    <body>
        <h1>Jednoduchá RSS čtečka</h1>
        <?php
            $file = 'https://www.vse.cz/feed/';

            //následující kód je ukázkou jednoduchého zpracování RSS zdroje - pozor, RSS zdroje mohou být ve větším množství formátů, které se liší svojí strukturou!

            echo '<p>Soubor: <a href="'.htmlspecialchars($file).'">'.htmlspecialchars($file).'</a></p>';

            $xml=simplexml_load_file($file);//načteme soubor ze vzdáleného zdroje (za využití fopen wrapperu)
            if (!empty($xml->channel)){//zjistíme, jestli v kořenovém elementu existují podelementy "channel"; na elementy v hlavním jmenném prostoru se ptáme jednoduše bez jmenného prostoru...
                foreach ($xml->channel as $channel){
                    echo '<h2>'.htmlspecialchars((string)$channel->title).'</h2>';
                    if (!empty($channel->link)){
                        echo '<a href="'.htmlspecialchars((string)$channel->link).'">'.htmlspecialchars((string)$channel->link).'</a>';
                    }

                    if (!empty($channel->item)){
                        echo '<ul>';
                        foreach ($channel->item as $item){
                            echo '<li>';
                            if (!empty($item->link)){
                                echo '<a href="'.htmlspecialchars((string)$item->link).'">';
                            }
                            echo htmlspecialchars((string)$item->title);
                            if (!empty($item->link)) {
                                echo '</a>';
                            }
                            echo '</li>';
                            //TODO Zvládli byste upravit výpis tak, aby obsahoval také úryvky článků?
                        }
                        echo '</ul>';
                    }
                }
            }

        ?>
    </body>
</html>
