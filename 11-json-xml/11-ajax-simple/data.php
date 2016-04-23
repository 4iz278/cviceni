<?php

    if (!empty($_REQUEST['odkaz'])){

        echo 'Obsah pro položku: <strong>'.htmlspecialchars($_REQUEST['odkaz']).'</strong>';

        //TODO proč tu používáme funkci htmlspecialchars?

    }else{

        echo 'Nebyl požadován žádný obsah.';

    }