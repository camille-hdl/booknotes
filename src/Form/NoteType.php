<?php

namespace App\Form;

use App\Entity\Note;
use App\Entity\Book;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class NoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options["user"];
        if (!$user instanceof User) {
            throw new \LogicException("No user");
        }
        $builder
            ->add('content')
            ->add('book', EntityType::class, [
                'class' => Book::class,
                'choices' => $user->getBooks(),
                'placeholder' => '(not attached to any book)',
                'choice_label' => static function (Book $book) {
                    return $book->getTitle();
                },
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
            'user' => null
        ]);
    }
}
