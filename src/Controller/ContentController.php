<?php

namespace App\Controller;

use App\Entity\Content;
use App\Form\ContentType;
use App\Repository\ContentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContentController extends AbstractController
{
	private $em;
	private $content;
	public function __construct(EntityManagerInterface $em, ContentRepository $contentRepository)
	{
		$this->em = $em;
		$this->content = $contentRepository;
	}

    public function index()
    {

        return $this->render('content/list.html.twig', [
            'controller_name' => 'ContentController',
        ]);
    }

	/**
	 * @Route("/Mylist", name="my_list")
	 */
	public function myList()
	{
		$contents = $this->content->findBy(['author' => $this->getUser()]);

		return $this->render('content/index.html.twig', [
			'contents' => $contents,
		]);
	}

	/**
	 * @Route("/", name="add")
	 * @Route("/edit/{id}", name="edit")
	 * @ParamConverter("content", options={"id"="id"})
	 * @param Request $request
	 * @param Content|null $content
	 *
	 * @return RedirectResponse|Response
	 */
	public function form(Request $request, Content $content = null)
	{
		if ($content === null) {
			$content = new Content();
			$content->setIduser($this->getUser());
		}

		$form = $this->createForm(ContentType::class, $content);
		$form->handleRequest($request);
		$content->setState("false");

		if ($form->isSubmitted() && $form->isValid()) {
			$this->em->persist($content);
			$this->em->flush();
			$this->addFlash('success', 'Your content has been send successfully.');
			return $this->redirectToRoute('content_list');
		}

		return $this->render('content/ContentForm.html.twig', [
			'form' => $form->createView(),
		]);
	}


}
