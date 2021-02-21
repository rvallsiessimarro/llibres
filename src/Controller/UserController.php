<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Usuari;
use App\Form\UsuariType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class UserController extends AbstractController
{
private $usuaris;
// constructor per obtenir el servei de  BDProvaLlibres
// i carregar l'array de llibres
/*public function __construct(BDProvaLlibres $dades)
    {
	    $this->llibres = $dades->get();
    }*/

    /**
    * @Route("/usuari/nou", name="nou_usuari")
    */
    public function nou(Request $request,UserPasswordEncoderInterface $encoder)
    {
    $usuari = new Usuari();
    $formulari = $this->createForm(UsuariType::class, $usuari);

    //enviament
    $formulari->handleRequest($request);
    if ($formulari->isSubmitted() && $formulari->isValid())
    {
        $usuari = $formulari->getData();
        //xifrem la contrasenya:
        $password = $usuari->getPassword();
        $passwordCodificat = $encoder->encodePassword($usuari, $password);
        $usuari->setPassword($passwordCodificat);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($usuari);
        try{
            $entityManager->flush(); 
            return $this->redirectToRoute('usuari');
        }catch(\Exception $e){
            return $this->Response('Error inserint usuari');
        }
    }

    return $this->render('nouusuari.html.twig',
                    array('formulari' => $formulari->createView()));
    }

    /**
    * @Route("/usuari/editar/{id}", name="editar_usuari")
    */
    public function editar(Request $request, $id,UserPasswordEncoderInterface $encoder)
    {
    $repositori = $this->getDoctrine()->getRepository(Usuari::class);
    $usuari = $repositori->find($id);
    $formulari = $this->createForm(UsuariType::class, $usuari);
    $contrasenya_antiga= $usuari->getPassword();
    $formulari->handleRequest($request);
    if ($formulari->isSubmitted() && $formulari->isValid())
    {
        $usuari = $formulari->getData();
        if ($usuari->getPassword()==''){
            $usuari->setPassword($contrasenya_antiga);
        } else {
            $contrasenya_nova = $usuari->getPassword();
            $passwordCodificat = $encoder->encodePassword($usuari, $contrasenya_nova);
            $usuari->setPassword($passwordCodificat);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($usuari);
        try{
            $entityManager->flush(); 
            return $this->redirectToRoute('usuari');
        }catch(\Exception $e){
            return $this->Response('Error modificant usuari');
        }
    }

    return $this->render('editarusuari.html.twig',
                    array('formulari' => $formulari->createView()));
    }

    /**
    * @Route("/usuari/eliminar/{id}", name="eliminar_usuari")
    */
    public function eliminar(Request $request, $id)
    {
        $repositori = $this->getDoctrine()->getRepository(Usuari::class);
        $usuari = $repositori->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($usuari);
        try{
            $entityManager->flush(); 
            return $this->redirectToRoute('usuari');
        }catch(\Exception $e){
            return $this->Response('Error modificant usuari');
        }
    }

    /**
	* @Route("/usuari", name="usuari")
	*/
	public function usuari()
	{
		$repositori = $this->getDoctrine()->getRepository(Usuari::class);
	  	$this->usuaris = $repositori->findAll();
		return $this->render('usuari.html.twig',
				array('usuaris' => $this->usuaris)); //li passem tots els usuaris a la plantilla
	}

}
?>