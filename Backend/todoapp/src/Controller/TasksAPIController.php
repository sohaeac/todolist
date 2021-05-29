<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\Category;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TasksAPIController extends AbstractController
{
    
    /**
     * @Route("/api/tasks", name="api_tasks", methods={"GET"})
     */
    public function getTasks(SerializerInterface $serializer)
    {
        $repo=$this->getDoctrine()->getRepository(Task::class); //Repository
        $tasks = $repo->findAll();

        $repo2 = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repo2->findAll();
        
        $response = $serializer->serialize($tasks,'json',['groups' => "tasks"]);
        //$this->json($tasks, 200, [], ['groups' => 'tasks','Access-Control-Allow-Origin' => '*']);
        return $this->json($tasks, 200, ["Access-Control-Allow-Origin" => "*"], ["groups"=>["tasks"]]);
       
       //$cat= $this->json($categories, 200, [], ['groups' => 'category','Access-Control-Allow-Origin' => '*']);
       
    }

    /**
     * @Route("/api/create/task", name="api_create", methods={"POST", "OPTIONS"})
     */

    public function create(Request $request,EntityManagerInterface $em, DenormalizerInterface $denormalizer, ValidatorInterface $validator):Response
    {

        if ($request->isMethod('OPTIONS')) {
            return $this->json([], 200, ["Access-Control-Allow-Origin" => "*", "Access-Control-Allow-Headers" => "*", "Access-Control-Allow-Methods" => "*"]);
        }
        $data = json_decode($request->getContent(), true);
        
        try{
            $task = $denormalizer->denormalize($data, Task::class);
            $category = $this->getDoctrine()
                                ->getRepository(Category::class)
                                ->findOneBy([
                                    'title' => $data["category"]
                                ]);
            $task->setCategory($category);
            $task->setCreatedAt(new \DateTime());
            

            $em->persist($task);
            $em->flush();


            return $this->json($task, 201, ["Access-Control-Allow-Origin" => "*", "Access-Control-Allow-Headers" => "*"], ["groups"=>["tasks"]]);
            }catch(\Exception $e){
                return $this->json([
                    'status'=>400,
                    'message'=> $e -> getMessage()
                ]);
            }
    }

    /**
     * @Route("/api/edit/{id}", name="api_edit", methods={"PUT", "OPTIONS"})
     */

    public function edit($id,Request $request,EntityManagerInterface $em, DenormalizerInterface $denormalizer, ValidatorInterface $validator):Response
    {

        if ($request->isMethod('OPTIONS')) {
            return $this->json([], 200, ["Access-Control-Allow-Origin" => "*", "Access-Control-Allow-Headers" => "*", "Access-Control-Allow-Methods" => "*"]);
        }
        $data = json_decode($request->getContent(), true);
        
        if($id!=null){

            try{
                $task = $this->getDoctrine()
                                 ->getRepository(Task::class)
                                 ->find($id);;
                
                $category = $this->getDoctrine()
                                    ->getRepository(Category::class)
                                    ->findOneBy([
                                        'title' => $data["category"]
                                    ]);
                $task->setTitle($data["title"]);
                $task->setStatus($data["status"]);  
                $task->setPriority($data["priority"]);                     
                $task->setTaskDate(new \DateTime($data["task_date"]));
                $task->setCategory($category);
                $task->setCreatedAt(new \DateTime());
                
    
                $em->persist($task);
                $em->flush();
    
    
                return $this->json($task, 201, ["Access-Control-Allow-Origin" => "*", "Access-Control-Allow-Headers" => "*"], ["groups"=>["tasks"]]);
                }catch(\Exception $e){
                    return $this->json([
                        'status'=>400,
                        'message'=> $e -> getMessage()
                    ]);
                }

        }
    
    }

    /**
     * @Route("/api/task/{id}", name="api_task", methods={"GET", "OPTIONS"})
     */

    public function getSingleTask($id,Request $request,EntityManagerInterface $em, DenormalizerInterface $denormalizer, ValidatorInterface $validator):Response
    {

        if ($request->isMethod('OPTIONS')) {
            return $this->json([], 200, ["Access-Control-Allow-Origin" => "*", "Access-Control-Allow-Headers" => "*", "Access-Control-Allow-Methods" => "*"]);
        }
        
        if($id!=null){

            try{
                $task = $this->getDoctrine()
                                 ->getRepository(Task::class)
                                 ->find($id);;
                

                $task2 = [
                'id'=>$task->getId(),
                'title'=>$task->getTitle(),
                'status'=>$task->getStatus(),
                'priority'=>$task->getPriority(),
                'task_date'=>$task->getTaskDate(),
                'createdAt'=>$task->getCreatedAt(),
                'category'=>$task->getCategory()->getTitle()

                ];


                return $this->json($task2, 200, ["Access-Control-Allow-Origin" => "*", "Access-Control-Allow-Headers" => "*"], ["groups"=>["tasks"]]);
                }catch(\Exception $e){
                    return $this->json([
                        'status'=>400,
                        'message'=> $e -> getMessage()
                    ]);
                }

        }

        
        
    }

    /**
     * @Route("/api/delete/{id}", name="api_delete_task", methods={"DELETE", "OPTIONS"})
     * 
     */
    public function delete($id,Request $request, DenormalizerInterface $denormalizer, ValidatorInterface $validator):Response {



        if ($request->isMethod('OPTIONS')) {
            return $this->json([], 200, ["Access-Control-Allow-Origin" => "*", "Access-Control-Allow-Headers" => "*", "Access-Control-Allow-Methods" => "*"]);
        }
        
        if($id!=null){

            try{
                $em = $this->getDoctrine()->getManager();
            $task = $this->getDoctrine()->getRepository(Task::class)->find($id);
            //dd($task);
            $em->remove($task);
            $em->flush();
            
            
            return $this->json([
                'status'=> 200,
                'task_deleted'=> $task->getTitle()

            ], 200, ["Access-Control-Allow-Origin" => "*", "Access-Control-Allow-Headers" => "*"],["groups"=>["tasks"]]);
            }catch(\Exception $e){
                return $this->json([
                    'status'=> 400,
                    'erreur' => $e->getMessage()
                ], 400);
            }
            
    


        }
    }
    
}
