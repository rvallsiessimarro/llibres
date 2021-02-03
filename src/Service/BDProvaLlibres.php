<?php
namespace App\Service;
class BDProvaLlibres
{
    private $llibres = array( 
        array("isbn" => "A111B3",
        "titol" => "El joc d'Ender",
        "autor" =>"Orson Scott Card",
        "pagines" => 350),
        array("isbn" => "A2021C",
        "titol" => "Walden o la vida en els boscos",
        "autor" =>"Henry David Thoreau",
        "pagines" => 352),
        array("isbn" => "I324X2",
        "titol" => "L'Anticrist",
        "autor" =>"Joseph Roth",
        "pagines" => 190),
        array("isbn" => "J91F56",
        "titol" => "Un dinar un dia qualsevol",
        "autor" =>"Ferran Torrent",
        "pagines" => 304),
        array("isbn" => "KL982W",
        "titol" => "Vides Desafinades",
        "autor" =>"Xavier Aliaga",
        "pagines" => 292)
        );
    public function get()
    {
        return $this->llibres;
    }
}
?>