<?php

namespace App\Controller;

use App\Entity\BackendUser;
use App\Form\BackendUserType;
use App\Repository\BackendUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * @Route("/backenduser")
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
class BackendUserController extends AbstractController
{
    /**
     * @Route("/", name="backend_user_index", methods={"GET"})
     */
    public function index(BackendUserRepository $backendUserRepository): Response
    {
        return $this->render('backend_user/index.html.twig', [
            'backend_users' => $backendUserRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="backend_user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $backendUser = new BackendUser();
        $form = $this->createForm(BackendUserType::class, $backendUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($backendUser);
            $entityManager->flush();

            return $this->redirectToRoute('backend_user_index');
        }

        return $this->render('backend_user/new.html.twig', [
            'backend_user' => $backendUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backend_user_show", methods={"GET"})
     */
    public function show(BackendUser $backendUser): Response
    {
        return $this->render('backend_user/show.html.twig', [
            'backend_user' => $backendUser,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="backend_user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BackendUser $backendUser): Response
    {
        $form = $this->createForm(BackendUserType::class, $backendUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_user_index');
        }

        return $this->render('backend_user/edit.html.twig', [
            'backend_user' => $backendUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backend_user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, BackendUser $backendUser): Response
    {
        if ($this->isCsrfTokenValid('delete'.$backendUser->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($backendUser);
            $entityManager->flush();
        }

        return $this->redirectToRoute('backend_user_index');
    }
}
