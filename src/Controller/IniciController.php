<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\BDProvaLlibres;  //importem servei creat per a les dades dels llibres en array
class IniciController extends AbstractController
{
	private $llibres;
	// constructor per obtenir el servei de  BDProvaLlibres
	// i carregar l'array de llibres
	/*public function __construct(BDProvaLlibres $dades)
    {
	    $this->llibres = $dades->get();
    }*/
	// Utilitzant l'associació per nom creada en services.yaml
	public function __construct($bdProva)
    {
	    $this->llibres = $bdProva->get();
    }
	/**
	* @Route("/", name="inici")
	*/
	public function inici()
	{
		return $this->render('inici.html.twig',
				array('llibres' => $this->llibres)); //li passem tots els llibres a la plantilla
	}
}
?>