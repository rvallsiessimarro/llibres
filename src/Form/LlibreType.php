<?php
namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Editorial;
class LlibreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('isbn', TextType::class, array('label' => 'ISBN'))
        ->add('titol', TextType::class, array('label' => 'Títol'))
        ->add('autor', TextType::class, array('label' => 'Autor'))
        ->add('pagines', IntegerType::class, array('label' => 'Pàgines'))
        ->add('editorial', EntityType::class, array('class' => Editorial::class,
                            'choice_label' => 'nom',))
        ->add('save', SubmitType::class, array('label' => 'Enviar'));
    }
}
?>