<?php

declare(strict_types=1);

namespace LocalMailer\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use LocalMailer\Parser\Mail;

/**
 * Class MailResources
 *
 * @mixin Mail
 * @package App\Http\Resources\API
 * @author yzen.dev
 */
class MailResources extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array<mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'subject' => $this->subject,
            'from' => $this->from,
            'to' => $this->to,
            'date' => $this->date,
            'body' => $this->body,
            'attachment' => $this->attachment
        ];
    }
}
