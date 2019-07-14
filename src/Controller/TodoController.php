<?php

namespace App\Controller;

use App\Entity\Todo1;
use App\Form\Todo1Type;
use App\Repository\TodoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/todo")
 */
class TodoController extends AbstractController
{
    /**
     * @Route("/", name="todo_index", methods={"GET"})
     * @param TodoRepository $todoRepository
     * @return Response
     */
    public function index(TodoRepository $todoRepository): Response
    {
        return $this->render('todo/index.html.twig', [
            'todos' => $todoRepository->findAll(),
        ]);
    }
    /**
     * @Route("/own", name="own_todo")
     */
    public function ownBooks()
    {
        $repository = $this
            ->getDoctrine()
            ->getRepository(Todo1::class);
        $todos = $repository->findBy(["name" => $this->getUser()]);
        return $this->render(
            'todo/fullHome.html.twig',
            ['todos' => $todos]
        );
    }


    /**
     * @Route("/new", name="todo_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $todo = new Todo1();
        $form = $this->createForm(Todo1Type::class, $todo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($todo);
            $entityManager->flush();

            return $this->redirectToRoute('own_todo');
        }

        return $this->render('todo/new.html.twig', [
            'todo' => $todo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="todo_show", methods={"GET"})
     * @param Todo1 $todo
     * @return Response
     */
    public function show(Todo1 $todo): Response
    {
        return $this->render('todo/show.html.twig', [
            'todo' => $todo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="todo_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Todo1 $todo): Response
    {
        $form = $this->createForm(Todo1Type::class, $todo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('todo_index', [
                'id' => $todo->getId(),
            ]);
        }

        return $this->render('todo/edit.html.twig', [
            'todo' => $todo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="todo_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Todo1 $todo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$todo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($todo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('todo_index');
    }
}
