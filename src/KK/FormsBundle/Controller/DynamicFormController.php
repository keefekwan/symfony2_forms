<?php

namespace KK\FormsBundle\Controller;

use KK\FormsBundle\Entity\Account;
use KK\FormsBundle\Form\Type\AccountType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


;class DynamicFormController extends Controller
{
    /**
     * @Route("/province/ajax", name="province_ajax_call")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxAction(Request $request) {
        if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }

        // Get the province ID
        $id = $request->query->get('province_id');

        $result = array();

        // Return a list of cities, based on the selected province
        $repo = $this->getDoctrine()->getManager()->getRepository('KKFormsBundle:City');

        $cities = $repo->findByProvince($id, array(
            'name' => 'asc'
        ));

        foreach ($cities as $city) {
            $result[$city->getName()] = $city->getId();
        }

        return new JsonResponse($result);
    }

    /**
     * @Route("/province/", name="province")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $account = new Account();

        // You probably want to use a service and inject it automatically. For simplicity,
        // I'm just adding it to the constructor.
        $form = $this->createForm(new AccountType($this->getDoctrine()->getManager()), $account);

        $form->handleRequest($request);

        if ($form->isValid()) {
            /* Do your stuff here */

            $this->getDoctrine()->getManager()->persist($account);
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('DynamicForm/index.html.twig', array(
            'form' => $form->createView()
        ));
    }
}