<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Web\WebDriver;
use BotMan\BotMan\Messages\Incoming\Answer;

class BotManController extends AbstractController
{
    #[Route('/botman', name: 'botman_handle', methods: ['GET', 'POST'])]
    public function handle(Request $request)
    {
        DriverManager::loadDriver(WebDriver::class);

        $config = [
            'web' => [
                'matchingData' => [
                    'driver' => 'web',
                ],
            ],
        ];

        $botman = BotManFactory::create($config);

        $botman->hears('hi', function($bot) {
            $bot->reply('Hello!');
            $bot->ask('Whats your name?', function($answer, $bot) {
                $bot->say('Welcome '.$answer->getText());
            });
        });
    }

    #[Route('/chatframe', name: 'chatframe')]
    public function chatframeAction(Request $request)
    {
        return $this->render('bot_man/chatframe.html.twig');
    }
}