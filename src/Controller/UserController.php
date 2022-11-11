<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{

    /**
     * Cette fonction affiche tout les utilisateurs
     *
     * @param UserRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/user', name: 'app_user', methods: 'GET')]
    public function index(UserRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $users = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            10
        );
    
        // dd($users);
        return $this->render('pages/user/index.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * cette controlleur montre la creation d'utilisateur
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/user/nouveau', 'user.new', methods:['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $manager) : Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
     
        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
           
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'L\'utilisateur a bien été ajouté'
            );

            return $this->redirectToRoute('app_user');
        }

        

        return $this->render('pages/user/new.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * Cette fonction montre la modificattion d'utilisateur
     *
     * @return Response
     */
    #[Route('/user/edition/{id}', 'user.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
     
        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
           
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'L\'utilisateur a bien été modifié'
            );

            return $this->redirectToRoute('app_user');
        }

       return $this->render('pages/user/edit.html.twig', [
        'form' => $form->createView()
       ]);
    }

    #[Route('/user/suppression/{id}', name: 'user.delete', methods: ['GET'])]
    public function delete(Request $request, User $user, UserRepository $UserRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $UserRepository->remove($user, true);
        }

        $this->addFlash(
            'success',
            'L\'utilisateur a bien été supprimé'
        );
        return $this->redirectToRoute('app_user', [], Response::HTTP_SEE_OTHER);
    }
}
