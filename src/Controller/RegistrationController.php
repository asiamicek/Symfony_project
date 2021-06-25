<?php
/**
 * Registration Controller.
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class RegistrationController.
 */
class RegistrationController extends AbstractController
{
    /**
     * Registration.
     *
     * @param Request                      $request         HTTP request
     * @param UserPasswordEncoderInterface $passwordEncoder
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @throws \Symfony\Component\Form\Exception\LogicException
     *
     * @Route(
     *     "/signup",
     *     methods={"GET", "POST"},
     *     name="registration_signup"
     * )
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'message_registered_successfully');

            return $this->redirectToRoute('index');
        }

        return $this->render(
            'registration/signup.html.twig',
            ['form' => $form->createView()]
        );
    }
}
