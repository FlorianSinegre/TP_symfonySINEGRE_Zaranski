<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Doctrine\ORM\Mapping\Id;
use http\Env\Response;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    /**
     * @Route("/categories", name="categories")
     */
    public function index()
    {
        $repository=$this->getDoctrine()->getRepository(Categorie::class);

        $categories=$repository->findAll();




        return $this->render('categories/index.html.twig', [
            "categories"=>$categories,
        ]);
    }

    /**
     * @Route("/categories/ajouter", name="ajouter_categories")
     */
    public function ajouter(Request $request)
    {
        $categorie=new Categorie();

        // $categorie->setTitre("titreghfdskmhsdhgfb,");  pour donner valeur par défaut
        //creation du formulaire
        $formulaire=$this->createForm(CategorieType::class, $categorie);

        $formulaire->handleRequest($request);

        if($formulaire->isSubmitted() && $formulaire->isValid())
        {
            //récupérer l'entity manager (sorte de connexion à la BDD)
            $em=$this->getDoctrine()->getManager();

            //je dis au manager que je veux ajouter la catégorie dans la BDD
            $em->persist($categorie);

            $em->flush();

            return $this->redirectToRoute("categories");
        }
        return $this->render('categories/formulaire.html.twig', [
            "formulaire"=>$formulaire->createView(),
            "h1"=>"Ajouter une catégorie"
        ]);
    }
    /**
     * @Route("/categories/modifier/{id}", name="modifier_categories")
     */
    public function modifier(int $id, \Symfony\Component\HttpFoundation\Request $request)
    {

        $repository=$this->getDoctrine()->getRepository(Categorie::class);
        $categorie=$repository->find($id);

        //création du formulaire
        $formulaire=$this->createForm(CategorieType::class, $categorie);

        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid())
        {
            //récupérer l'entity manager (sorte de connexion à la BDD)
            $em=$this->getDoctrine()->getManager();

            //je dis au manager que je veux ajouter la catégorie dans la BDD
            $em->persist($categorie);

            $em->flush();

            return $this->redirectToRoute("categories");
        }

        return $this->render('categories/formulaire.html.twig', [
            "formulaire"=>$formulaire->createView(),
            "h1"=>"Modification de la catégorie <i>".$categorie->GetTitre()."</i>",
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_categories")
     *
     *
     *
     *
     *
     */
    public function delete(int $id, \Symfony\Component\HttpFoundation\Request $request)
    {

        $rep = $this->getDoctrine()->getRepository(Categorie::class);
        $cate = $rep->find($id);

        //création du formulaire
        //$formulaire1 = $this->createForm(CategorieType::class, $cate);


        $formulaire1 = $this->createFormBuilder()->add("submit",SubmitType::class,["label" => "OK", "attr"=>["class"=>"btn btn-success"]])->getForm();

        $formulaire1->handleRequest($request);

        if ($formulaire1->isSubmitted() && $formulaire1->isValid()) {
            //récupérer l'entity manager (sorte de connexion à la BDD)
            $em = $this->getDoctrine()->getManager();

            //je dis au manager que je veux supprimer la categorie de la BDD
            $em->remove($cate);

            $em->flush();

            return $this->redirectToRoute("categories");
        }


        return $this->render('categories/formulaire.html.twig', [
            "formulaire"=>$formulaire1->createView(),
            "h1"=>"Suppression de la catégorie <i>".$cate->GetTitre()."</i>",
        ]);

    }
    /*public function delete(int $id)
        {
            $repository = $this->getDoctrine()->getRepository(Categorie::class);
            $em = $this->getDoctrine()->getManager();
            $categorie=$em->find($id);
            $em->remove($categorie);
            $em->flush();


            return $this->redirectToRoute("categories");

        }*/
}
