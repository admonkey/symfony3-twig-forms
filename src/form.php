<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Form\Forms;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Translation\Translator;

// the Twig file that holds all the default markup for rendering forms
// this file comes with TwigBridge
$defaultFormTheme = 'form_div_layout.html.twig';

$vendorDir = realpath(__DIR__.'/../vendor');
// the path to TwigBridge library so Twig can locate the
// form_div_layout.html.twig file
$appVariableReflection = new \ReflectionClass('\Symfony\Bridge\Twig\AppVariable');
$vendorTwigBridgeDir = dirname($appVariableReflection->getFileName());
// the path to your other templates
$viewsDir = realpath(__DIR__.'/../views');

$twig = new Twig_Environment(new Twig_Loader_Filesystem(array(
    $viewsDir,
    $vendorTwigBridgeDir.'/Resources/views/Form',
)));
$formEngine = new TwigRendererEngine(array($defaultFormTheme));

$twig->addExtension(
    new FormExtension(new TwigRenderer($formEngine))
);

$twig->addExtension(
    new TranslationExtension(new Translator('en'))
);

$formEngine->setEnvironment($twig);



// create your form factory as normal
$formFactory = Forms::createFormFactoryBuilder()
    ->getFormFactory();

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

$form = $formFactory->createBuilder()
    ->add('task', TextType::class)
    ->add('dueDate', DateType::class)
    ->getForm();



var_dump($twig->render('new.html.twig', array(
    'form' => $form->createView(),
)));
