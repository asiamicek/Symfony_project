<?php
/**
 * Task type.
 */

namespace App\Form;

use App\Entity\Register;
use App\Entity\Task;
use App\Entity\User;
use App\Repository\RegisterRepository;
use App\Service\RegisterService;
use App\Service\TaskService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class TaskType.
 */
class TaskType extends AbstractType
{
    private RegisterService $registerService;
    private TaskService $taskService;
    private UserInterface $user;

    /**
     * TaskType constructor.
     */
    public function __construct(RegisterService $registerService, TaskService $taskService)
    {
        $this->registerService = $registerService;
        $this->taskService = $taskService;
    }

    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @see FormTypeExtensionInterface::buildForm()
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder The form builder
     * @param array                                        $options The options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->user = $options['user'];
        $builder->add(
            'register',
            EntityType::class,
            [
                'class' => Register::class,
                'choices' => $this->registerService->TitleByAuthor($options['user']),
                'label' => 'label_register',
                'placeholder' => 'label_none',
                'required' => true,
            ]
        );


//                'query_builder' => function (RegisterRepository $registerRepository, $options){
//                    return $registerRepository->createQueryBuilder('gv')
//                        ->select(['register.title'])
//                        ->from(Register::class, 'register')
//                        ->andWhere('register.author == :user')
//                        ->setParameter('user', $options['user']);
//                },
////                'choices' => $options,
//                'choice_label' => function ($register) {
//                    return $register->getTitle();
//                },
//                    function ($registerService, $user) {
//                    $queryBuilder = $this->createQueryBuilder();
//                    $queryBuilder
//                        ->select(['register.title'])
//                        ->from(Register::class, 'register')
//                        ->andWhere($queryBuilder->expr()->like('register.author', ':user'))
//                        ->setParameter('user', $user);
//
//                    $result = $queryBuilder->getQuery()->getResult();
//
//                    return $result;
////
///                     if('register.author = :user')
////                        ->setParameter('author', $user);
//                    return $registerService->TitleByAuthor($user);



        $builder->add(
            'content',
            TextType::class,
            [
                'label' => 'label_content',
                'required' => true,
                'attr' => ['max_length' => 70],
            ]
        );

        $builder->add(
            'priority',
            NumberType::class,
            [
                'label' => 'label_priority',
                'required' => true,
            ]
        );

        $builder->add(
            'deadline',
            DateTimeType::class,
            [
                'label' => 'label_date',
                'required' => true,
            ]
        );
    }

    /**
     * Configures the options for this type.
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => Task::class,
                'user' => null,
            ]
        );
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'task';
    }
}
