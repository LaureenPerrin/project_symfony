<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_sortie', TextType::class, [
                "label_format" => "Nom de la sortie :",
            ])
            ->add('dateDebut', DateTimeType::class, [
                "label_format" => "Date et heure de la sortie :",
            ])
            ->add('dateCloture', DateTimeType::class, [
                "label_format" => "Date limite d'inscription :",
            ])
            ->add('nbinscriptionsmax', NumberType::class, [
                "label_format" => "Nombre de places :",
            ])
            ->add('duree', NumberType::class, [
                "label_format" => "Durée :",
            ])
            ->add('descriptioninfos', TextareaType::class)
           // ->add('etatSortie', Integer::class)
            //->add('urlPhoto', TextType::class)
            /*->add('etat', EntityType::class, [
                    "class" => Etat::class,
                    "choice_label" => "libelle",
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('e')
                        ->orderBy('e.libelle', 'ASC');
                        }
            ])*/
            /*->add('siteOrganisateur', EntityType::class, [
                "class" => Campus::class,
                "choice_label" => "nom_campus",
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.nom_campus', 'ASC');

                }
            ])*/
            /*->add('villes', EntityType::class, [
                "class" => Ville::class,
                "choice_label" => "nom_ville",
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('v')
                        ->orderBy('v.nom_ville', 'ASC');
                }
            ])*/
            /*->add('lieu', EntityType::class, [
                "class" => Lieu::class,
                "choice_label" => "nom_lieu",
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l')
                        ->orderBy('l.nom_lieu', 'ASC');
            }
            ])*/
            /*->add('participantsInscrits', EntityType::class, [
                "class" => Participant::class,
                 "choice_label" => "pseudo",
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.pseudo', 'ASC');
            }
            ])*/
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
