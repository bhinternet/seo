<?php

namespace BH\SeoBundle\Controller;

use BH\SeoBundle\Entity\Seo;
use BH\SeoBundle\Form\SeoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class SeoController extends Controller {

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('ROLE_SEO')")
     */
    public function readAllAction() {
        $repository = $this->getDoctrine()->getRepository('BHSeoBundle:Seo');
        $seos = $repository->findAll();

        return $this->render('@BHSeo/seo/read_all.html.twig',array(
                'seos' => $seos
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('ROLE_SEO')")
     */
    public function addAction(Request $request) {
        $seo = new Seo();

        $form = $this->createForm(SeoType::class, $seo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($seo);
            $em->flush();

            $this->addFlash('success', 'L\'URL a bien été ajoutée');
            return $this->redirectToRoute('admin_seo');
        }
        return $this->render('@BHSeo/seo/add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Request $request
     * @param Seo $seo
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('ROLE_SEO')")
     */
    public function editAction(Request $request, Seo $seo) {
        $form = $this->createForm(SeoType::class, $seo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $seo->setUpdatedAt(new \Datetime('now',new \DateTimeZone('Europe/Paris')));
            $em->persist($seo);
            $em->flush();

            $this->addFlash('success', 'L\'URL a bien été modifiée');
            return $this->redirectToRoute('admin_seo');
        }
        return $this->render('@BHSeo/seo/edit.html.twig', array(
            'form' => $form->createView(),
            'seo' => $seo
        ));
    }

    /**
     * @param Seo $seo
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Security("is_granted('ROLE_SEO')")
     */
    public function deleteAction(Seo $seo) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($seo);
        $em->flush();

        $this->addFlash('success', 'L\'URL a bien été supprimée');
        return $this->redirectToRoute('admin_seo');
    }

    public function getSeoAction($url)
    {
        $em = $this->getDoctrine()->getManager();
        $seo = $em->getRepository('BHSeoBundle:Seo')->findOneBy(array('url'=>$url));

        return $this->render('@BHSeo/seo/seo.html.twig', array(
            'seo' => $seo
        ));
    }

}
