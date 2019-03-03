<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\Resource;
class ArticleResource extends Resource
{
    /**
     * Преобразование ресурса в массив.
     *
     * @param  \Illuminate\Http\Request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'type'          => 'links',
            'id'            => (string)$this->id,
            'attributes'    => [
                'url' => $this->url,
            ],
        ];
    }
}