<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class LlibreController
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
/**
* @Route("/llibre/{isbn}", name="fitxa_llibre")
*/
public function fitxa($isbn)
{
$resultat = array_filter($this->llibres,
function($llibre) use ($isbn)
{
return $llibre["isbn"] == $isbn;
});
if (count($resultat) > 0)
{
$resposta = "";
$resultat = array_shift($resultat);
$resposta .= "<ul><li>" . $resultat["titol"] . "</li>" .
"<li>" . $resultat["autor"] . "</li>" .
"<li>" . $resultat["pagines"] . "</li></ul>";
return new Response("<html><body>$resposta</body></html>");
}
else
return new Response("Llibre no trobat");
}

}
?>