<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentFormType;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    // #[Route('/student', name: 'app_student')]
    // #[Route('/student/view/{id}', name: 'app_student_view')]

//    #[Route('/student/edit/{id}', name: 'app_student_edit')]
    // #[Route('/student/delete/{id}', name: 'app_student_delete')]


//    public function index(): Response
//    {
//        return $this->render('student/index.html.twig', [
//            'controller_name' => 'StudentController',
//        ]);
//    }
    #[Route('/student/add', name: 'app_student_add')]
    public function addStudent(EntityManagerInterface $entityManager , Request $request): Response
    {
        $student = new Student();
        $form = $this->createForm(StudentFormType::class, $student);

        $form->handleRequest($request);
        if (!($form->isSubmitted() && $form->isValid())) {
            return $this->render('student/add_student.html.twig', [
                'student_form' => $form,
            ]);
        }
        $student = $form->getData();
        $entityManager->persist($student);
        $entityManager->flush();


        return $this->redirectToRoute('app_student_add');
    }

    //edit student
    #[Route('/student/edit/{id}', name: 'app_student_edit')]
    public function editStudent(Student $student): Response
    {
        $form = $this->createForm(StudentFormType::class, $student);
        return $this->render('student/edit_student.html.twig', [
            'student_form' => $form,
        ]);
    }
}
