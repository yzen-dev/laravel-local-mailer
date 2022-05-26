<?php

namespace LocalMailer\Http\Controllers;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
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
    )
    {
        $this->localMailerService = $localMailerService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws FileNotFoundException
     */
    public function index()
    {
        return view('local-mailer::dashboard', ['files' => $this->localMailerService->getAll()]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showByDate(Request $request)
    {
        try{
            return view('local-mailer::mails', [
                'date' => $request->route('date'),
                'mails' => $this->localMailerService->getLog($request->route('date')),
            ]);
        } catch (FileNotFoundException $exception){
            return view('local-mailer::not-found', [
                'date' => $request->route('date')
            ]);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadLog(Request $request)
    {
        try{
            return response()->download($this->localMailerService->getPathByDate($request->route('date')));
        } catch (FileNotFoundException $exception){
            return view('local-mailer::not-found', [
                'date' => $request->route('date')
            ]);
        }
        
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function deleteLog(Request $request)
    {
        try{
            $this->localMailerService->delete($request->route('date'));
            return view('local-mailer::dashboard', ['files' => $this->localMailerService->getAll()]);
        } catch (FileNotFoundException $exception){
            return view('local-mailer::not-found', [
                'date' => $request->route('date')
            ]);
        }
    }

}
