<?php

namespace App\Controller;

use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RecipeController extends AbstractController
{
    #[Route('/recipes', name: 'app_recipe')]
    public function recipes(RecipeRepository $recipeRepository): Response
    {

        $recipes = $recipeRepository->findAll();

        // dd($recipes);
        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }


    #[Route('/recipes/{id}', name: 'app_description')]
    public function show(int $id, RecipeRepository $recipeRepository): Response
    {


        $recipe = $recipeRepository->find($id);

        return $this->render('recipe/description.html.twig', [
            'recipe' => $recipe
        ]);
    }


    #[Route('/recipes/{name}', name: 'app_recipe_name')]
    public function showByName(string $name, RecipeRepository $recipeRepository): Response
    {


        $recipe = $recipeRepository->findOneBy(['name' => $name]);

        return $this->render('recipe/description.html.twig', [
            'recipe' => $recipe
        ]);
    }


    #[Route('/recipes/{id}/delete', name: 'app_recipe_delete')]
    public function delete(int $id, RecipeRepository $recipeRepository, EntityManagerInterface $entityManager): Response
    {


        $recipe = $recipeRepository->find($id);

        $entityManager->remove($recipe);
        $entityManager->flush();

        return $this->redirectToRoute('app_recipe');
    }
}
