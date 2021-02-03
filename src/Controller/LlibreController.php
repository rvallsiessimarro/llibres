<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\BDProvaLlibres;  //importem servei creat per a les dades dels llibres en array
class LlibreController extends AbstractController
{
private $llibres;
// constructor per obtenir el servei de  BDProvaLlibres
// i carregar l'array de llibres
public function __construct(BDProvaLlibres $dades)
    {
	    $this->llibres = $dades->get();
    }
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
    return $this->render('fitxa_llibre.html.twig',
                        array('llibre' => array_shift($resultat)));
}
else
    return $this->render('fitxa_llibre.html.twig',
                        array('llibre' => NULL));
}

}
?>