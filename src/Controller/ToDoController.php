<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ToDoController extends AbstractController
{
    /**
     * @Route("/tasks", name="tasks")
     */
    public function tasks(): Response
    {
        $repo=$this->getDoctrine()->getRepository(Task::class); //Repository
        $tasks = $repo->findAll();

        $repo2 = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repo2->findAll();

        return $this->render('to_do/tasks.html.twig', [
            'controller_name' => 'ToDoController',
            'tasks'=> $tasks,
            'categories'=> $categories
        ]);
    }
    /**
     * @Route("/", name="home")
     */
    public function home() {
        return $this->render('to_do/home.html.twig');
    }

    
    /**
     * @Route("/task/new", name="addTask")
     * @Route("/task/{id}/edit", name="editTask")
     */
    public function form(Task $task = null, Request $request, EntityManagerInterface $manager) {
        if($task == null){
            $task = new Task();
        }
        $form = $this->createFormBuilder($task)
                    ->add('title', TextType::class,[
                        'attr'=> [
                            'placeholder'=> "Titre de la tâche",
                            'class'=> 'form-control'
                        ]
                    ])
                    ->add('category',EntityType::class,[
                        'class'=> Category::class,
                        'choice_label'=> 'title',
                        'attr'=>['class' => 'form-control']])
                           
                    ->add('priority', ChoiceType::class,[
                        'attr'=>[
                        'class' => 'form-control'
                    ],
                        'choices'=> [
                            'Haute' => 'high',
                            'Moyenne'=> 'normal',
                            'Basse'=> 'low'
                        ],
                    ])
                    
                    ->add('status', ChoiceType::class, [
                        'attr'=>[
                            'class' => 'form-control'
                        ],
                        'choices'=> [
                            'Fini' => True,
                            'Pas fini'=> null
                            
                        ],
                    ])
                    ->add('task_date', DateType::class, [
                        'attr'=>[
                            'class' => 'form-control'
                        ],
                    ])
                    ->getForm();

        $form-> handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid() ){

            if(!$task -> getId()){ // Si pas de id (=pas d'article dans la BDD) 
                $task->setCreatedAt(new \DateTime());
            }
            
            $manager->persist($task);
            $manager->flush();

            return $this->redirectToRoute('tasks');

        }

        return $this->render('to_do/form.html.twig',[
            'formTask'=> $form->createView(),
            'EditMode'=> $task->getId() != null // True si tache existe (mode update) sinon mode Create
        ]);
    }

    /**
     * @Route("/task/delete_task/{id}", name="deleteTask")
     */
    public function delete_task(Task $id) {

        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->remove($id);

        $entityManager->flush();

        return $this->redirectToRoute('tasks');
    }
}
