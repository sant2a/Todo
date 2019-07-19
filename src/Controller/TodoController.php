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
     * @Route("/own", name="own_todos")
     * @return Response
     */
    public function ownTodo()
    {
        $repository = $this
            ->getDoctrine()
            ->getRepository(Todo1::class);
        $todo = $repository->findBy(["author" => $this->getUser()]);
        return $this->render(
            'todo/todolist.html.twig',
            ['todos' => $todo]
        );
    }

    /**
     * @Route("/new", name="todo_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
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

            return $this->redirectToRoute('own_todos');
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

            return $this->redirectToRoute('own_todos', [
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
     * @param Request $request
     * @param Todo1 $todo
     * @return Response
     */
    public function deleteTodo(Request $request, Todo1 $todo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$todo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($todo);
            $entityManager->flush();


        return $this->redirectToRoute('own_todos');
    }
}}
