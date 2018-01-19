<?php

namespace Neimad\SimonBundle\Controller;

use Neimad\SimonBundle\Document\Page;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Handles the pages
 */
final class PagesController extends Controller
{
    /**
     * Shows the given page.
     */
    public function view(Page $contentDocument): Response
    {
        return $this->render('page.html.twig', [
            'page' => $contentDocument
        ]);
    }
}
