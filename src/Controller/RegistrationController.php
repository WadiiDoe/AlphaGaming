<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ContactType;
use App\Form\RegistrationFormType;
use App\Security\UsersAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\File;
use App\Entity\Appointments;

// Include paginator interface
use Knp\Component\Pager\PaginatorInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder,\Swift_Mailer $mailer, GuardAuthenticatorHandler $guardHandler, UsersAuthenticator $authenticator): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setRoles(["ROLE_ADMIN"]);
            $random = random_int(2, 10000);
            $user->code = $random;
            $message = (new \Swift_Message('Activation du compte'))
                // On attribue l'expéditeur
                ->setFrom('sanadfaleh@gmail.com')
                // On attribue le destinataire
                ->setTo($user->getEmail())
                // On crée le texte avec la vue
                ->setBody(
                    $this->renderView(
                        'registration/activation.html.twig', ['code' => $user->code]
                    ),
                    'text/html'
                )
            ;
            $mailer->send($message);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
            $contact = $form->getData();



            $this->addFlash('message', 'Votre message a été transmis, nous vous répondrons dans les meilleurs délais.');

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );



        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    /**
     * @param UserRepository $repository
     * @return Response
     * @Route ("/afficheU",name="afficheU")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function afficheUser(UserRepository $repository,Request $request, PaginatorInterface $paginator){

        $user=$repository->findAll();

        $user = $paginator->paginate(
        // Doctrine Query, not results
            $user,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            10
        );


        return $this->render('utilis/afficheU.html.twig',['user'=>$user]);
    }

    /**
     * @param UserRepository $repository
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("user/updateUser.twig.html/{id}", name="updateU")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function modifier( UserRepository $repository,$id,Request $request){
        $user=$repository->find($id);
        $form=$this->createForm(RegistrationFormType::class,$user);
        $form->add('Update',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('afficheU');
        }
        return $this->render('utilis/updateUser.html.twig',['form'=>$form->createView()

        ]);



    }
    /**
     * @param UserRepository $repository
     * @return Response
     * @Route ("/profile",name="profile")
     */
    public function affichetheUser(UserRepository $repository)
    {

        $user =$this->getUser();
        return $this->render('utilis/mycompt.html.twig', ['user' => $user]);
    }
    /**
     * @param UserRepository $repository
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("user/update.twig.html/{id}", name="updateprofile")
     */
    public function modifierProfil(UserRepository $repository, $id, Request $request,UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $repository->find($id);
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->add('Update', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('profile');
        }
        return $this->render('utilis/updateUser.html.twig', ['form' => $form->createView()

        ]);


    }
    /**
     * @param UserRepository $repository
     * @return Response
     * @Route ("/trie",name="trie")
     */
    public function TRie(UserRepository $repository){

        $user=$repository->findEntitiesorder1();
        return $this->render('utilis/afficheU.html.twig',['user'=>$user]);
    }

    /**
     * @param $id
     * @param UserRepository $repository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *  @Route ("/suppU/{id}",name="dU")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function deleteEvent(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $event = $entityManager->getRepository(User::class)->find($id);
        $entityManager->remove($event);
        $entityManager->flush();
        return $this->redirectToRoute('afficheU');
    }

    /**
     * @param UserRepository $repository
     * @param Request $request
     * @return Response
     * @Route ("/search_ajax",name="search_ajax")
     */
    public function searchAction(Request $request,UserRepository $repository)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
         //var_dump(strlen($requestString));
        $entities =  $em->getRepository(User::class)->findEntitiesByString($requestString);

        if(!$entities)
        {
            $result['entities']['error'] = "there is no demande with this titre";

        }
        if(strlen($requestString)==1)
        {

            $entities=$repository->findAll();
            $result['entities']=$this->getRealEntities($entities);
        }
        else
        {

            $result['entities'] = $this->getRealEntities($entities);
        }

        return new JsonResponse($result, 200);
    }


    public function getRealEntities($entities){


        foreach ($entities as $entity)
        {
            $realEntities[$entity->getId()] = [$entity->getEmail(),$entity->getId(),$entity->getPassword(),$entity->getNom(),$entity->getPrenom(),$entity->getAdresse()];
        }


        return $realEntities;
    }
    }




