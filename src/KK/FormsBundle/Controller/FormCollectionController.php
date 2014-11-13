<?php
// src/KK/FormsBundle/Controller/ConfController.php

namespace KK\FormsBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use KK\FormsBundle\Entity\Conference;
use KK\FormsBundle\Entity\Speaker;
use KK\FormsBundle\Form\Type\ConferenceType;


class FormCollectionController extends Controller
{
    /**
     * @Route("/conference", name="conference")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $conference = $em->getRepository('KKFormsBundle:Conference')
            ->findAll();

        return $this->render('FormCollection/index.html.twig', array(
            'conference' => $conference,
        ));
    }

    /**
     * @Route("/conference/add", name="conference_add")
     */
    public function collectionAction(Request $request)
    {
        $conference = new Conference();

        $form = $this->createForm(new ConferenceType(), $conference, array(
            'action' => $this->generateUrl('conference_add'),
            'method' => 'POST'
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            ## Inserting form into database
            $em = $this->getDoctrine()->getManager();

            $em->persist($conference);
            $em->flush();

            $session = $request->getSession();
            $session->getFlashBag()->add('success', 'Conference saved to database');

            $em->persist($conference);
            $em->flush();

            return $this->redirect($this->generateUrl('conference'));
        }

        return $this->render('FormCollection/conference.html.twig', array(
            'conference' => $conference,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/conference/update/{id}", name="conference_update")
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var  $conference Conference */
        $conference = $em->getRepository('KKFormsBundle:Conference')
            ->find($id);

        $form = $this->createForm(new ConferenceType(), $conference, array(
            'action' => $this->generateUrl('conference_update', array(
                'id' => $id
            )),
            'method' => 'POST'
        ));

        $originalSpeakers = new ArrayCollection();

        foreach ($conference->getSpeakers() as $speaker) {
            $originalSpeakers->add($speaker);
        }

        $form->handleRequest($request);

        if ($form->isValid()) {

            foreach ($originalSpeakers as $originalSpeaker) { /** @var $originalSpeaker Speaker */

                if ($conference->getSpeakers()->contains($originalSpeaker) === false) {
                    $conference->removeSpeaker($originalSpeaker);
                    $originalSpeaker->setConference(null);

                    $em->remove($originalSpeaker);
                }
            }

            $em->persist($conference);
            $em->flush();

            return $this->redirect($this->generateUrl('conference', array(
                'id' => $id
            )));
        }

        return $this->render('FormCollection/conference.html.twig', array(
            'conference' => $conference,
            'form' => $form->createView(),
        ));
    }
}
