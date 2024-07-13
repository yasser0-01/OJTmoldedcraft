<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;

class BotManController extends AbstractController
{
    #[Route('/message', name: 'message_bot', methods: ['POST'])]
    public function messageAction(Request $request): Response
    {
        $botman = app('botman');
        $botman->hears('{message}', function($botman, $message){
            if ($message == 'hi'){
                $this->askName($botman);
            }
            else{
                $botman->reply("Start a conversation by saying hi.");
            }
        });
        $botman->listen();
    }

    #[Route('/chatframe', name: 'chatframe')]
    public function askName($botman)
    {
        $botman->ask('Hello! What is your Name?', function(Answer $answer) {
   
            $name = $answer->getText();
   
            $this->say('Nice to meet you '.$name);
            {
                return $this->render('bot_man/chatframe.html.twig');
            }
        });
    }

    #[Route('/chatframe', name: 'chatframe')]
    public function chatframeAction(): Response
    {
        return $this->render('bot_man/chatframe.html.twig');
    }
}