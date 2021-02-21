<?php
namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class UsuariType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('id', HiddenType::class)
        ->add('login', TextType::class, array('label' => 'Login'))
        ->add('password', PasswordType::class, array('label' => 'Contrasenya','empty_data' => ''))
        ->add('email', EmailType::class, array('label' => 'Correu Electrònic'))
        ->add('rol', HiddenType::class, array('label' => 'Rol','empty_data' => 'ROLE_USER'))
        ->add('save', SubmitType::class, array('label' => 'Enviar'));
    }
}
?>