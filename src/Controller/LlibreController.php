<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\BDProvaLlibres;  //importem servei creat per a les dades dels llibres en array
use App\Entity\Llibre;
use App\Entity\Editorial;
use App\Form\LlibreType;
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
    * @Route("/llibre/nou", name="nou_llibre")
    */
    public function nou(Request $request)
    {
    $llibre = new Llibre();
    $formulari = $this->createForm(LlibreType::class, $llibre);

    //enviament
    $formulari->handleRequest($request);
    if ($formulari->isSubmitted() && $formulari->isValid())
    {
        $llibre = $formulari->getData();
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($llibre);
        try{
            $entityManager->flush(); 
            return $this->redirectToRoute('inici');
        }catch(\Exception $e){
            return $this->Response('Error inserint llibre');
        }
        
    }

    return $this->render('nou.html.twig',
                    array('formulari' => $formulari->createView()));
    }

    /**
    * @Route("/llibre/editar/{isbn}", name="editar_llibre")
    */
    public function editar(Request $request, $isbn)
    {
    $repositori = $this->getDoctrine()->getRepository(Llibre::class);
    $llibre = $repositori->find($isbn);
    $formulari = $this->createForm(LlibreType::class, $llibre);

    $formulari->handleRequest($request);
    if ($formulari->isSubmitted() && $formulari->isValid())
    {
        $llibre = $formulari->getData();
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($llibre);
        $entityManager->flush(); 
        return $this->redirectToRoute('inici');
    }

    return $this->render('nou.html.twig',
                    array('formulari' => $formulari->createView()));
    }



    /**
    * @Route("/llibre/pagines/{pagines}", name="filtar_pagines")
    */
    public function filtrarpagines($pagines)
    {
        $repositori = $this->getDoctrine()->getRepository(Llibre::class);
        $resultat = $repositori->filtraPerPagines($pagines);
        return $this->render('inici.html.twig', array(
        'llibres' => $resultat
        ));
        
    }

    /**
    * @Route("/llibre/inserir", name="inserir_llibre")
    */
    public function inserir()
    {
        /*$entityManager = $this->getDoctrine()->getManager();
        $llibre = new Llibre();
        $llibre->setIsbn("7777SSSS");
        $llibre->setTitol("Noruega");
        $llibre->setAutor("Rafa Lahuerta");
        $llibre->setPagines(387);
        $entityManager->persist($llibre);
        try{
            $entityManager->flush();
            return new Response("Llibre inserit amb isbn " . $llibre->getIsbn());
        } catch (\Exception $e){
            return new Response("Error inserint el llibre amb isbn " . $llibre->getIsbn());
        }   */   
        $entityManager = $this->getDoctrine()->getManager();
        $llibre1 = new Llibre();
        $llibre1->setIsbn("6666FFFF");
        $llibre1->setTitol("Walden o la videa en els Boscos");
        $llibre1->setAutor("Henry David Thoreau");
        $llibre1->setPagines(352);
        $entityManager->persist($llibre1);
        $llibre2 = new Llibre();
        $llibre2->setIsbn("5555GGGG");
        $llibre2->setTitol("Un dinar un dia qualsevol");
        $llibre2->setAutor("Ferran Torrent");
        $llibre2->setPagines(304);
        $entityManager->persist($llibre2);
        $llibre3 = new Llibre();
        $llibre3->setIsbn("4444HHHH");
        $llibre3->setTitol("Vides Desafinades");
        $llibre3->setAutor("Xavier Aliaga");
        $llibre3->setPagines(292);
        $entityManager->persist($llibre3);

        try{
            $entityManager->flush();
            return new Response("Nous Llibres inserits amb isbn: " . $llibre1->getIsbn().
            " ". $llibre2->getIsbn().
            " ". $llibre3->getIsbn());
        } catch (\Exception $e){
            return new Response("Error inserint els llibres amb isbn " . $llibre1->getIsbn().
            " ". $llibre2->getIsbn().
            " ". $llibre3->getIsbn());
        } 
        
    }

    /**
    * @Route("/llibre/inserirAmbEditorial", name="inserir_llibre_editorial")
    */
    public function inserirambeditorial()
    {
        $entityManager = $this->getDoctrine()->getManager();

        //comprovem si l'editorial ja existeix
        $repositori = $this->getDoctrine()->getRepository(Editorial::class);
        $nomEditorial ="Bromera";
        //busquem editorial amb nom Bromera
        $editorial = $repositori->findOneBy(["nom" => $nomEditorial]);
        //si no existeix creem un nou objecte amb la informació
        if (!($editorial)){
            $editorial = new Editorial();
            $editorial->setNom("Bromera");
        }        
        $editorial->setNom("Bromera");
        $llibre = new Llibre();
        $llibre->setIsbn("8888RRRR");
        $llibre->setTitol("El teu gust");
        $llibre->setAutor("Isabel Clara Simó");
        $llibre->setPagines(208);
        $llibre->setEditorial($editorial);
        // persistim els objectes
        $entityManager->persist($editorial);
        $entityManager->persist($llibre);
        // ho fixem en la base de dades
        try{
            $entityManager->flush();
            return new Response("Llibre amb Editorial inserit amb isbn " . $llibre->getIsbn());
        } catch (\Exception $e){
            return new Response("Error inserint el llibre amb Editorial amb isbn " . $llibre->getIsbn());
        }        
    }


    /**
    * @Route("/llibre/{isbn}", name="fitxa_llibre")
    */
    public function fitxa($isbn)
    {
        $repositori = $this->getDoctrine()->getRepository(Llibre::class);
        $llibre = $repositori->find($isbn);
        if ($llibre)
            return $this->render('fitxa_llibre.html.twig',
                    array('llibre' => $llibre));
        else
            return $this->render('fitxa_llibre.html.twig',
                    array('llibre' => NULL));   
    /*$resultat = array_filter($this->llibres,
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
                            array('llibre' => NULL));*/

    }

}
?>