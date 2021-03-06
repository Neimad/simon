<?php

declare(strict_types=1);

namespace App\Controller;

use App\Document\Page;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Handles the pages.
 */
final class PagesController extends Controller
{
    /**
     * Shows the home page.
     */
    public function home(): Response
    {
        return $this->render('page.html.twig', [
            'page' => [
                'title' => 'Home',
                'content' => 'Proident deserunt eu ullamco laboris amet commodo exercitation culpa sunt nulla duis id. Irure proident proident Lorem incididunt nostrud adipisicing proident deserunt elit aute ut esse non ut. Ullamco Lorem deserunt amet aliqua dolore do aute ad cupidatat exercitation eu. Consequat sit sunt commodo anim nostrud incididunt culpa commodo veniam laboris mollit ipsum enim elit. Proident aliquip veniam ad ad proident est tempor ea nisi velit. Consectetur enim deserunt duis nulla nulla ex. Exercitation eu in id fugiat nostrud sit.',
            ],
        ]);
    }

    /**
     * Shows the given page.
     */
    public function view(Page $contentDocument): Response
    {
        return $this->render('page.html.twig', [
            'page' => $contentDocument,
        ]);
    }
}
