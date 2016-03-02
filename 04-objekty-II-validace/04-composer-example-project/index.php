<?php

  require_once __DIR__.'/vendor/autoload.php';

  $htmlContent='<!DOCTYPE html><html><head><title>UKAZKA</title></head><body><h1>Ukázka</h1><p>Ukázka jednoduchého pdf výstupu</p></body></html>';


  $pdf = new mPDF('c','A4'); //využíváme třídu mPDF bez série requirů :)
  $pdf->WriteHTML($htmlContent);
  $pdf->Output('file.pdf');


  /*
   *  Upozornění:
   *  Tento projekt slouží pro demonstraci možností composeru, nikoliv možností knihovny mPDF.
   *  S ohledem na velikost podkladových materiálů ke cvičením byly z mPDF knihovny odstraněna písma a barevné profily.
   *  Pokud je chcete dostáhnout, stačí spustit composer s parametrem update.
   */