<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhotoAssignType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('assignedRetoucher', EntityType::class, [
            'label' => false,
            'class' => User::class,
            'query_builder' => function (UserRepository $er)
            {
                return $er->createQueryBuilder('u')
                    ->where('u.roles LIKE :user')
                    ->setParameter('user', '%"'.'ROLE_RETOUCHER'.'"%')
                    ->orderBy('u.username', 'ASC');
            },
            'choice_label' => function (User $user)
            {
                if ( strlen($user->getLastName()) > 0 or strlen($user->getFirstName()) > 0 )
                {
                    return $user->getFirstName().' '.$user->getLastName();

                }
                else {
                    return $user->getUsername();
                }
            }
        ])
        ->add('assignedWebmaster', EntityType::class, [
            'label' => false,
            'class' => User::class,
            'query_builder' => function (UserRepository $er)
            {
                return $er->createQueryBuilder('u')
                    ->where('u.roles LIKE :user')
                    ->setParameter('user', '%"'.'ROLE_WEBMASTER'.'"%')
                    ->orderBy('u.username', 'ASC');
            },
            'choice_label' => function (User $user)
            {
                if ( strlen($user->getLastName()) > 0 )
                {
                    return $user->getFirstName().' '.$user->getLastName();

                }
                else {
                    return $user->getUsername();
                }
            }
        ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Photo'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_photo';
    }


}
