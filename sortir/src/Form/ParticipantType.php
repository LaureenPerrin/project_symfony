<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participant;
use App\Entity\Sortie;
use Doctrine\DBAL\Types\BooleanType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class, array(
                "label_format" => "Pseudo : ",
            ))
            ->add('nom_participant', TextType::class, array(
                "label_format" => "Nom : ",
            ))
            ->add('prenom', TextType::class, array(
                "label_format" => "Prénom : ",
            ))
            ->add('telephone', TextType::class, array(
                "label_format" => "Téléphone : ",
            ))
            ->add('mail', EmailType::class, array(
                "label_format" => "Email : ",
            ))
            ->add('mot_de_passe', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label_format' => 'Mot de passe :'),
                'second_options' => array('label_format' => 'Confirmation :'),
                'invalid_message' => 'Votre mot de passe ne correspond pas !!'))

            ->add('actif')
            ->add('campus', EntityType::class, [
                "label_format" => "Ville de rattachement : ",
                "class" => Campus::class,
                "choice_label" => "nom_campus",
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.nom_campus', 'ASC');
                }
            ])
            ->add("fileTemp", FileType::class, [
                "label_format" => "Ma photo : ",
                "required" => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
