<?php

namespace LocalMailer\Http\Controllers;

use Illuminate\Http\Request;
use LocalMailer\LocalMailerService;

/**
 *
 */
class LocalMailerController
{
    /**
     * @var LocalMailerService
     */
    private LocalMailerService $localMailerService;
    
    /**
     * @param LocalMailerService $localMailerService
     */
    public function __construct(
        LocalMailerService $localMailerService
    ) {
        $this->localMailerService = $localMailerService;
    }
    
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('local-mailer::dashboard', ['files' => $this->localMailerService->getAll()]);
    }
    
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showByDate(Request $request)
    {
        return view('local-mailer::mails', [
            'date' => $request->route('date'),
            'mails' => $this->localMailerService->getLog($request->route('date')),
        ]);
    }
    
}
