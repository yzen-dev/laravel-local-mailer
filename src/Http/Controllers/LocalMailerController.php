<?php

namespace LocalMailer\Http\Controllers;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use LocalMailer\LocalMailerService;
use LocalMailer\Http\Resources\MailResources;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
     * @return Application|Factory|View
     * @throws FileNotFoundException
     */
    public function index()
    {
        return view('local-mailer::dashboard', ['files' => $this->localMailerService->getAll()]);
    }

    /**
     * @param Request $request
     *
     * @return Application|Factory|View
     */
    public function showByDate(Request $request)
    {
        try {
            $date = (string)$request->route('date');
            $mails = $this->localMailerService->getLog($date);
            return view('local-mailer::mails', [
                'date' => $request->route('date'),
                'mails' => MailResources::collection($mails),
            ]);
        } catch (FileNotFoundException $exception) {
            return view('local-mailer::not-found', [
                'date' => $request->route('date')
            ]);
        }
    }

    /**
     * @param Request $request
     *
     * @return Application|Factory|View|BinaryFileResponse
     */
    public function downloadLog(Request $request)
    {
        try {
            $date = (string)$request->route('date');
            /** @phpstan-ignore-next-line */
            return response()->download($this->localMailerService->getPathByDate($date));
        } catch (FileNotFoundException $exception) {
            return view('local-mailer::not-found', [
                'date' => $request->route('date')
            ]);
        }
    }

    /**
     * @param Request $request
     *
     * @return Application|Factory|View
     */
    public function removeLog(Request $request)
    {
        try {
            $date = (string)$request->route('date');
            $this->localMailerService->delete($date);
            return view('local-mailer::dashboard', ['files' => $this->localMailerService->getAll()]);
        } catch (FileNotFoundException $exception) {
            return view('local-mailer::not-found', [
                'date' => $request->route('date')
            ]);
        }
    }
}
