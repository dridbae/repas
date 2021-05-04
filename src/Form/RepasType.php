<?php

namespace App\Form;

use App\Entity\Aliment;
use App\Entity\Groupe;
use App\Entity\Repas;
use App\Entity\SousGroupe;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RepasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $groupe = $options['groupe'] ?? null;
        $sousGroupe = $options['sousGroupe'] ?? null;
        $builder
            ->add('groupe', EntityType::class, [
                'mapped' => false,
                'choice_label' => 'code',
                'choice_value' => 'id',
                'class' => Groupe::class
            ])
            ->add('name')
        ;

        if (null !== $sousGroupe) {
            $builder->remove('groupe');
            $builder->remove('sousGroupe');
            $builder
                ->add('groupe', EntityType::class, [
                    'mapped' => false,
                    'choice_label' => 'code',
                    'choice_value' => 'id',
                    'class' => Groupe::class,
                    'query_builder' => function (EntityRepository $r) use ($groupe) {
                        $qb = $r->createQueryBuilder('r');
                        $qb->where('r.id = :groupe')
                            ->setParameter('groupe', $groupe);


                        return $qb;
                    },
                ]);
            $builder
                ->add('sousGroupe', EntityType::class, [
                    'mapped' => false,
                    'choice_label' => 'code',
                    'choice_value' => 'id',
                    'class' => SousGroupe::class,
                    'query_builder' => function (EntityRepository $r) use ($sousGroupe) {
                        $qb = $r->createQueryBuilder('r');
                        $qb->where('r.id = :groupe')
                            ->setParameter('groupe', $sousGroupe);


                        return $qb;
                    },
                ]);

            $builder
                ->add('aliments', EntityType::class, [
                    'expanded' => true,
                    'multiple' => true,
                    'choice_label' => 'code',
                    'choice_value' => 'id',
                    'by_reference' => false,
                    'class' => Aliment::class,
                    'query_builder' => function (EntityRepository $r) use ($sousGroupe) {
                        $qb = $r->createQueryBuilder('r');
                        $qb->where('r.sousGroupe = :groupe')
                            ->setParameter('groupe', $sousGroupe);


                        return $qb;
                    },
                ]);
        } else if (null !== $groupe) {
            $builder->remove('groupe');
            $builder
                ->add('groupe', EntityType::class, [
                    'mapped' => false,
                    'choice_label' => 'code',
                    'choice_value' => 'id',
                    'class' => Groupe::class,
                    'query_builder' => function (EntityRepository $r) use ($groupe) {
                        $qb = $r->createQueryBuilder('r');
                        $qb->where('r.id = :groupe')
                            ->setParameter('groupe', $groupe);


                        return $qb;
                    },
                ]);
            $builder
                ->add('sousGroupe', EntityType::class, [
                    'mapped' => false,
                    'choice_label' => 'code',
                    'choice_value' => 'id',
                    'class' => SousGroupe::class,
                    'query_builder' => function (EntityRepository $r) use ($groupe) {
                        $qb = $r->createQueryBuilder('r');
                        $qb->where('r.groupe = :groupe')
                            ->setParameter('groupe', $groupe);


                        return $qb;
                    },
                ]);
        }
        $builder->add('submit', SubmitType::class, []);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Repas::class,
            'allow_extra_fields' => true,
            'groupe' => null,
            'sousGroupe' => null,
        ]);
    }
}
