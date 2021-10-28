<?php

namespace App\Commands\Images;

use App\Commands\LinodeCommand;
use SamuelMwangiW\Linode\DTO\ImageDTO;
use SamuelMwangiW\Linode\Linode;

class ListCommand extends LinodeCommand
{
    protected $signature = 'image:list';

    protected $description = 'View available Linode images';

    public function handle(): int
    {
        $list = $this->request(fn() => Linode::images()->list());

        $this->table(
            ['id', 'label', 'created by', 'created', 'is public', 'status', 'eol'],
            $list->map(
                fn(ImageDTO $image) => [
                    $image->id,
                    $image->label,
                    $image->created_by,
                    $image->created->diffForHumans(),
                    $image->isPublic(),
                    $image->status,
                    $image->eol->diffForHumans()
                ]
            )
        );

        return self::SUCCESS;
    }
}
