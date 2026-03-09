<?php

// Chceme vypnout reportování všech chyb
error_reporting(0);

// nastavení úrovně reportování chyb
// reportovat pouze závažnější chyby
error_reporting(E_ERROR | E_WARNING | E_PARSE);